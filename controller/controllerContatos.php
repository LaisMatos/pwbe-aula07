<?php

/********************************************************************************************************************
*Objetivo: Responsável pela manipulação de dados de contatos.Também fará a conexão entre a View e a Model.
*Autor: lais
*Data: 04/03/22
*Versão: Herbert Richers (1.0)
*********************************************************************************************************************/

//fun recebe dados da View e encaminha para a model
function inserirContatos($dadosContato){
    //validação, verificando se a variavel/obj está vazia
    if (!empty($dadosContato)) {
        //validação se não estiver vazia a caixa <txtNome> e <txtCelular> e <txtEmail>, o bloco segue rodando. Dados obrigatórios.
        if (!empty($dadosContato['txtNome']) && !empty($dadosContato['txtCelular']) && !empty($dadosContato['txtEmail'])) {
            
            /*
            Criação do array de dados que será encaminhado a model para inserir no banco de dados,
            é importante criar este array conforme as necessidades de manipulação do banco de dados.
            OBS: CRIAR CAHVES-VALOR DO ARRAY CONFORME OS NOMES DOS ATRIBUTOS DO BANCO DE DADOS

            se não criar esse array todos os tipos de dado recebidos via post, até o valor do salvar botão, chegará no no bd
            
            */
            $arrayDados = array(
                "nome"          => $dadosContato['txtNome'],
                "telefone"      => $dadosContato['txtTelefone'],
                "celular"       => $dadosContato['txtCelular'],
                "email"         => $dadosContato['txtEmail'],
                "observacao"    => $dadosContato['txtObs']   
            );

            //imput do contato.php. importa está aqui para só chamar o arquivo contato.php depois de validar
            require_once('model/bd/contato.php');
            
            //parte01: chamando a função insertContato() que está no aquivo contato.php e passa os dados do $arrayDados para alimentar o banco de dados --> insertContato($arrayDados);
            //parte02: tratamento de erro caso dado não tenha sido inserido no banco de dados 
            if (insertContato($arrayDados)) {
                return true;
            } 
            else {
                return array('idErro' =>1,'message'=> 'NÃO FOI POSSÍVEL INSERIR OS DADOS NO BANCO DE DADOS');
           }
        //tratamento de erro para campo não preenchido
        }else{
            return array('idErro' =>2,'message' => 'EXISTEM CAMPOS OBRIGATÓRIOS NÃO PREENCHIDOS.'); 
        }
    }
        
}
// fun recebe recebe dados da View e encaminha para model (ATUALIZAÇÃO)
function atualizarContatos($dadosContato, $id){


    //validação, verificando se a variavel/obj está vazia
    if (!empty($dadosContato)) {
        //validação se não estiver vazia a caixa <txtNome> e <txtCelular> e <txtEmail>, o bloco segue rodando. Dados obrigatórios.
        if (!empty($dadosContato['txtNome']) && !empty($dadosContato['txtCelular']) && !empty($dadosContato['txtEmail'])) {
            
            //validação do id se ele for diferente de zero e diferente de vazio e tem que ser um numero 
            if(!empty($id) && $id !=0 && is_numeric($id)){

                /*  Criação do array de dados que será encaminhado a model para inserir no banco de dados,é importante criar este array conforme as necessidades de manipulação do banco de dados.
                    OBS: CRIAR CAHVES-VALOR DO ARRAY CONFORME OS NOMES DOS ATRIBUTOS DO BANCO DE DADOS
                    Se não criar esse array todos os tipos de dado recebidos via post, até o valor do salvar botão, chegará no no bd */
                $arrayDados = array(
                    "id"            => $id,
                    "nome"          => $dadosContato['txtNome'],
                    "telefone"      => $dadosContato['txtTelefone'],
                    "celular"       => $dadosContato['txtCelular'],
                    "email"         => $dadosContato['txtEmail'],
                    "observacao"    => $dadosContato['txtObs']   
                );

                //imput do contato.php. importa está aqui para só chamar o arquivo contato.php depois de validar
                require_once('model/bd/contato.php');
                
                //parte01: chamando a função insertContato() que está no aquivo contato.php e passa os dados do $arrayDados para alimentar o banco de dados --> insertContato($arrayDados);
                //parte02: tratamento de erro caso dado não tenha sido inserido no banco de dados 
                if (updateContato($arrayDados)) {
                    return true;
                }else{
                    return array('idErro' =>1,
                                'message'=> 'NÃO FOI POSSÍVEL ATUALIZAR OS DADOS NO BANCO DE DADOS');
                }
            }else{
                return array('isErro' => 4,
                                'message'=> 'Não é possível editar registro - Informar Id');
                }
            

        //tratamento de erro para campo não preenchido
        }else{
            return array('idErro' =>2,'message' => 'EXISTEM CAMPOS OBRIGATÓRIOS NÃO PREENCHIDOS.'); 
        }
    }
}
//fun para realizar eclusão de dados de contatos
function excluirContatos($id){

    //validação do id se ele for diferente de zero e diferente de vazio e tem que ser um numero 
    if ($id !=0 && !empty($id) && is_numeric($id)) {
        
        //import do arquivo contato
        require_once('model/bd/contato.php');
        
        //chamando fun de model e validando retorno (true ou false)
        if(deleteContato($id)){
            return true;
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
    require_once('model/bd/contato.php');

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
        require_once('model/bd/contato.php');

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


/* ######## ANOTAÇÔES ########
1. criar funções
2. passar argumentos
3. condição- if/else
4. !empty(), verificação se a variavel/obj está vazia
6. o <name> no html, serão as chaves do array do post
7. !empty(), segundo if. Tratatativa dos dados obrigatórios no banco de dados, eles não podem estar vazios
8. TODOS OS TRATAMENTOS DE ERRO DEVEM SER FEITOS NO ARQUIVO CONTROLLER

*/





?>