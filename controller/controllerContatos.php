<?php

/********************************************************************************************************************
*Objetivo: Responsável pela manipulação de dados de contatos.Também fará a conexão entre a View e a Model.
*Autor: lais
*Data: 04/03/22
*Versão: Herbert Richers (1.0)
*********************************************************************************************************************/
//import do arquivo de configuração do projeto
require_once(SRC.'modulo/config.php');


//fun recebe dados da View e encaminha para a model
function inserirContatos($dadosContato){
   
    //declaração de variável fora de if de validação de arquivo para que não dê erro de autenticação para o banco
   $nomeFoto=(string) null;
   
    //validação, verificando se a variavel/obj está vazia
    if (!empty($dadosContato)) {

         //Recebe o objeto imagem que foi caminhado dentro do array
         $file = $dadosContato['file'];

        //validação se não estiver vazia a caixa <txtNome> e <txtCelular> e <txtEmail>, o bloco segue rodando. Dados obrigatórios.
        if (!empty($dadosContato[0]['nome']) && !empty($dadosContato[0]['celular']) && !empty($dadosContato[0]['email']) && !empty($dadosContato[0]['estado'])) {
            
            //validação para identificar se chegou um arquivo para upload
            if ($file['foto']['name'] != null) {
                
                //import da função de upload 
                require_once (SRC.'modulo/upload.php');
                
                //chama função upload
                $nomeFoto = uploadFile($file['foto']);

                //validação de insert de arquivo
                if (is_array($nomeFoto)) {
                    
                    //Caso aconteça algum erro no processo de upload, a função irá retornar um array conforme as necessidades de manipulação do BD.
                    return $nomeFoto;
                }           
           }                     
           
            /* Criação do array de dados que será encaminhado a model para inserir no banco de dados,
                é importante criar este array conforme as necessidades de manipulação do banco de dados.
                OBS: CRIAR CHAVES-VALORES DO ARRAY CONFORME OS NOMES DOS ATRIBUTOS DO BANCO DE DADOS
                     Se não criar esse array todos os tipos de dado recebidos via post, até o valor do salvar botão, chegará no no bd  */

            $arrayDados = array(
                "nome"          => $dadosContato[0] ['nome'],
                "telefone"      => $dadosContato[0] ['telefone'],
                "celular"       => $dadosContato[0] ['celular'],
                "email"         => $dadosContato[0] ['email'],
                "observacao"    => $dadosContato[0] ['obs'],
                "foto"          => $nomeFoto, //por ser uma variavel e ñ um post, o array tem essa estrutura
                "idestado"      => $dadosContato[0] ['estado']
            );

        
            //imput do contato.php está aqui para só chamar o arquivo contato.php depois de validar
            require_once(SRC.'model/bd/contato.php');
            
            //parte01: chamando a função insertContato() que está no aquivo contato.php e passa os dados do $arrayDados para alimentar o banco de dados --> insertContato($arrayDados);
            //parte02: tratamento de erro caso dado não tenha sido inserido no banco de dados 
            if (insertContato($arrayDados)) {
                return true;
            } 
            else {
                return array('idErro' =>1,'message'=> 'NÃO FOI POSSÍVEL INSERIR OS DADOS NO BANCO DE DADOS');
           }            
        }else{//tratamento de erro para campo não preenchido
            return array('idErro' =>2,'message' => 'EXISTEM CAMPOS OBRIGATÓRIOS NÃO PREENCHIDOS.'); 
        }             
    }        
}

// fun recebe recebe dados da View e encaminha para model (ATUALIZAÇÃO)
function atualizarContatos($dadosContato){

    //varial para validação de delete da foto
    $statusUpload=(boolean)false;
    //Gambiarra para não alterrar o nome id pelo nome arrayDados. Recebe o id enviado pelo arrayDados;
    $id=$dadosContato['id'];
    //recebe a foto enviada pelo arrayDados (Nome da foto que ja existe no BD)
    $foto = $dadosContato ['foto'];
    //recebe  o obj de array referente a nova foto que poderá ser enviada ao servidor 
    $file= $dadosContato['file'];


    //validação, verificando se a variavel/obj está vazia
    if (!empty($dadosContato)) {
        //validação se não estiver vazia a caixa <txtNome> e <txtCelular> e <txtEmail>, o bloco segue rodando. Dados obrigatórios.
        if (!empty($dadosContato[0]['nome']) && !empty($dadosContato[0]['celular']) && !empty($dadosContato[0]['email'])) {
            
            //validação do id se ele for diferente de zero e diferente de vazio e tem que ser um numero 
            if(!empty($id) && $id !=0 && is_numeric($id)){

                //validação para identificar se será enviado para o servidor uma nova foto
                if ($file['foto']['name'] !=null) {
                    
                    //import da função de upload 
                    require_once (SRC.'modulo/upload.php');

                    //chama a função upload para enviar a nova foto para o servidor 
                    $novaFoto = uploadFile($file['foto']);   
                    $statusUpload=true;               

                }else{
                    //permanece a mesma foto no Banco de dado
                    $novaFoto = $foto;
                }

                /*  Criação do array de dados que será encaminhado a model para inserir no banco de dados,é importante criar este array conforme as necessidades de manipulação do banco de dados.
                    OBS: CRIAR CAHVES-VALOR DO ARRAY CONFORME OS NOMES DOS ATRIBUTOS DO BANCO DE DADOS
                    Se não criar esse array todos os tipos de dado recebidos via post, até o valor do salvar botão, chegará no no bd */
                $arrayDados = array(
                    "id"            => $id,
                    "nome"          => $dadosContato[0] ['nome'],
                    "telefone"      => $dadosContato[0] ['telefone'],
                    "celular"       => $dadosContato[0] ['celular'],
                    "email"         => $dadosContato[0] ['email'],
                    "observacao"    => $dadosContato[0]['obs'],
                    "foto"          => $novaFoto,
                    "idestado"      => $dadosContato[0] ['estado']
                );

                //imput do contato.php. importa está aqui para só chamar o arquivo contato.php depois de validar
                require_once(SRC.'model/bd/contato.php');
                
                //parte01: chamando a função insertContato() que está no aquivo contato.php e passa os dados do $arrayDados para alimentar o banco de dados -> insertContato($arrayDados);
                //parte02: tratamento de erro caso dado não tenha sido inserido no banco de dados 
                if (updateContato($arrayDados)) {
                    
                    /*validação para verificar se será necessário apagar a foto antiga, esta variavel esta ativada em true, linha 76, 
                    quando realizamos o upload de uma nova foto para o servidor*/
                    if($statusUpload){
                        //apaga a foto antiga da pasta do servidor 
                        unlink(SRC.DIR_FILE_UPLOAD.$foto);
                    }
                    return true;

                }else{
                    return array('idErro' =>1,
                                'message'=> 'NÃO FOI POSSÍVEL ATUALIZAR OS DADOS NO BANCO DE DADOS');
                }
            }else{
                return array('idErro' => 4,
                                'message'=> 'Não é possível editar registro - Informar Id');
                }
            

        //tratamento de erro para campo não preenchido
        }else{
            return array('idErro' =>2,'message' => 'EXISTEM CAMPOS OBRIGATÓRIOS NÃO PREENCHIDOS.'); 
        }
    }
}

//fun para realizar eclusão de dados de contatos
function excluirContatos($arrayDados){

    //gambiarra porque não quis refatorar o nome id por arrayDados. Variavel que recebe o id do resgistro que será excluído 
    $id = $arrayDados['id'];

    //recebe o nome da foto que será excluida na pasta do servidor
    $foto= $arrayDados['foto'];

    //validação do id se ele for diferente de zero e diferente de vazio e tem que ser um numero 
    if ($id !=0 && !empty($id) && is_numeric($id)) {
        
        //import do arquivo contato
        require_once(SRC.'model/bd/contato.php');
        
        //import do arquivo de configuração do projeto
        //require_once(SRC.'modulo/config.php');
        
        //chamando fun de model e validando retorno (true ou false)
        if(deleteContato($id)){
            if ($foto !=null) {
                
                //apaga a foto fisicamanete do diretório no servidor 
              if  (@unlink(SRC.DIR_FILE_UPLOAD.$foto)){
                return true;
              }else{
                    return array ( 'idErro'     => 5,
                                    'message'   => ' O REGISTRO FOI EXCLUÍDO COM SUCESSO '
                    );
              }               

            }            
            //dentro do if
            else{
                return true;
            }
         //fora do if   
        }else{
            return array ( 'idErro'     => 3,
                            'message'   => 'Não pode excluir registro'
            );
        }

    }else{
        return array(   'isErro'    => 4,
                        'message'   => 'Não pode excluir registro - Informar Id'
        );
    }

}

//fun solicita dados de model e encaminha a lista de contatos para a View
function listarContatos(){

    //import do arquivo contatp.php para buscar os dados do banco de dados
    require_once(SRC.'model/bd/contato.php');

    //chama a função selectAllContatos(), que chamará os dados do banco de dados
    $dados= selectAllContato();

    //retorno de dados
    if (!empty($dados)) {
       return $dados;
    }else {
        return false;
    }


}

// fun solicita dados de um contato através do id do registro
function buscarcontato($id){
    
    // tem que chegar um id válido. 
    //validação do id se for diferente de zero e diferente de vazio e tem que ser um numero 
    if ($id !=0 && !empty($id) && is_numeric($id)){

        //import do arquivo contato
        require_once(SRC.'model/bd/contato.php');

        //chamada de fun na model que vai bucar no bd
        $dados=selectByIdContato($id);

        //valida se existem dados para serem devolvidos
        if(!empty($dados)){
            return $dados;
        }else{
            return false;
        }

    }else{
        return array(   'isErro'    => 4,
                        'message'   => 'Não é possível bucar um registro sem informar Id válido'
        );
    }

}


/*_________ ANOTAÇÔES __________

1. criar funções
2. passar argumentos
3. condição- if/else
4. !empty(), verificação se a variavel/obj está vazia
6. o <name> no html, serão as chaves do array do post
7. !empty(), segundo if. Tratatativa dos dados obrigatórios no banco de dados, eles não podem estar vazios
8. TODOS OS TRATAMENTOS DE ERRO DEVEM SER FEITOS NO ARQUIVO CONTROLLER

<unlink()>  função responsável por apagar a um arquivo de um diretório.
            sintaxe:  unlink (caminho + nome do arquivo);
                      
            Exemplo: unlink (DIR_FILE_UPLOAD.$foto);

*/





?>