<?php
/*******************************************************************************************************************************************
*Objetivo: Arquivo de rota (router). Segementa as ações encaminhabadas pela View (dados de um form, listagem de dados, ação de ou atualizar)
*          Também responsável por encaminhar as solicitações para o controller.
*          Criando arquivo pensando em reutilizar o arquivo para diferentes ações. Ou seja, ter apenas um arquivo de rota
*Autor: lais
*Data: 04/03/22
*Versão: Herbert Richers (1.0)
********************************************************************************************************************************************/




//Receber dados do formulário
$action =(string)null;
$identificador= (string)null; 

//Validação para verificar se a requisição  é um post de um formulário
if ($_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD']=='GET') {
    /*echo('Requesição de form');*/

    //Recebendo dados via url (get) e qual ação será realizada
    $identificador= strtoupper($_GET['identificador']);
    $action = strtoupper($_GET['action']); 

    //Validação de quem esta solicitando dados para o arquivo rota
    switch ($identificador) {
        case 'CONTATOS':
            //import da controller Contatos
            require_once('controller/controllerContatos.php');

            //identificação do tipo de ação que será realizada
            if ($action =='INSERIR') {
                
               
                if (isset($_FILES) && !empty($_FILES)) {
                    //chama função de inserir na controller
                    $resposta =inserirContatos($_POST,$_FILES);                    
                }else{
                    $resposta =inserirContatos($_POST,null);
                }

                //(1): função inserirContatos($_POST) do arq controller
                //(2): validação do tipo de dados que a controller retornou
                if (is_bool($resposta)){ //(2): se for booleano
                    
                    //verificar se o retorno foi verdadeiro
                    if ($resposta) {
                        //(1): REDIRECIONANDO PARA PÁGINA INICIAL VIA JS usando <window.location.href='index.php>
                        echo("<script>alert('REGISTRO INSERIDO COM SUCESSO');
                        window.location.href='index.php';</script>");     
                    }

                  //se retornar um array, então houve um erro de processo de inserção
                } elseif (is_array($resposta)) {
                    
                    //retorno de msg
                    echo("<script>
                        alert('".$resposta['message']."');
                        window.history.back();
                    </script>");    
                    
                }
            }elseif ($action =='DELETAR') {
                
                //recebendo id do registro que deverá ser exluido, que foi enviado pela url no link da img do excluir através da index
                $idContato = $_GET['id'];
                $foto = $_GET['foto'];

                //array para encaminhar dois dados, id e foto, para controller
                $arrayDados = array (
                    "id"    => $idContato,
                    "foto"  => $foto
                );

                //chamando fun deleteContato
                $resposta= excluirContatos($arrayDados);

              
                //saida de msg
                if (is_bool($resposta)) {
                    
                    if ($resposta) {
                        echo("<script>alert('REGISTRO EXCLUIDO COM SUCESSO');
                        window.location.href='index.php';</script>");                         
                    }

                }elseif(is_array($resposta)){
                    echo("<script>
                        alert('".$resposta['message']."');
                        window.history.back();
                    </script>");    
                }
            }elseif($action=='BUSCAR'){
                    
                //recebendo id do registro que deverá ser eDITADO, que foi enviado pela url no link da img do excluir através da index
                $idContato = $_GET['id'];

                //chamando fun de excluir na controller
                $dados= buscarContato($idContato);

                //Ativa a utilização de variaveis de sessão no servidor
                session_start();

                //gaudar em uma variavel de sessão os dados que o banco de dados retornou para buscar do id
                //obs: (essa variavel será utilizada na index.php, para colocar os dados nas caixas de texto)
                $_SESSION['dadosContato']=$dados;

                //import da index.php para ñ usar um link, onde ocorre a transição de maneira mais visivel piscando a tela
                require_once('index.php');
            }elseif($action=='EDITAR'){

                //recebe id que foi encaminhado no action do form pela url
                $idContato=$_GET['id'];
                //recebe o nome da foto que foi enviada pelo GET do form
                $foto=$_GET['foto'];

                //array para encaminhar dois dados, id e foto, para controller
                $arrayDados= array(
                    $id     => $idContato,
                    $foto   => $foto,
                    $file   => $_FILES
                );

                // chama função de editar na controller
                $resposta=atualizarContatos($_POST, $arrayDados);
            
                 //(1): função atualizarContatos($_POST) do arq controller
                 //(2): validação do tipo de dados que a controller retornou
                if (is_bool($resposta)){ //parte02: se for booleano
                     
                     //verificar se o retorno foi verdadeiro
                    if ($resposta) {
                        //parte01: REDIRECIONANDO PARA PÁGINA INICIAL VIA JS usando <window.location.href='index.php>
                        echo("<script>alert('REGISTRO ATUALIZADO COM SUCESSO');
                        window.location.href='index.php';</script>");     
                    }
 
                   //se retornar um array, então houve um erro de processo de atualização
                }elseif (is_array($resposta)) {
                     
                    //retorno de msg
                    echo("<script>
                         alert('".$resposta['message']."');
                         window.history.back();
                    </script>"); 

                }

            }

        
        break;    
    }



}

/* ###### ANOTAÇÃO ######

REDIRECIONANDO PARA PÁGINA INICIAL VIA JS
window.location.href='index.php'

Variaveis de sessão: POR QUE ESTAMOS USANDO 

        Toda vez que existe transição de telas pelo navegador, o conteúdo de uma variável passa a não existir mais, 
        por isso é necessário que esse dado seja guardado em uma "variavel global", ou seja, Variaveis de Sessão. 
        A variavel de sessão permance com seus dados (ativa) enquanto o navegador estiver aberto ou destruido pelo navegador. 
   
        session_start() --> mecanismo para ativar o tipo de variavel de sessão no servidor apache
        Ex
        
        session_start();
                
                $_SESSION['dadosContato']=$dados;
*/













/* ########## ANOTAÇÕES ##########
ATENÇÃO A ESTRUTURA <ACTION> DO HTML NÃO SE COMUNICA COM A ESTRUTURA <FUNCTION> QUE PRECISAM VALIDAR O SISTEMA

1: ESTRUTURA DE DECISÃO. PARA VERIFICAR SE O METODO QUE CHEGA AO BACK-END É POST ou GET
    *****Post*****
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    echo('Requesição de form')} 
    
    *****Get*****
     if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    echo('Requesição de form')} 

2: VARIAVEL QUE IDENTIFICA OS DADOS QUE CHEGAM
        $action =(string)null;
        $identificador= (string)null; 

3: ENVIO DE DADOS VIA POST E GET
    //get usado para pegar dados digitados pelo usuário e envia para o arquivo rota para que ele envie para controller validar
    //post usado para pegar dados digitados pelo usuário para o arquivo rota usado. Ele é um array, amarzena os dados para o get poder manipular

        SÓ É POSSÍVEL USAR/RECUPERAR OS DADOS DO USUÁRIO DESSA MANEIRA SE O <METHOD> FOR <POST> no <form>
        O html esta trabalhando no post e o programador esta forçando o get para os dados serem usados no arquivo rota DO JEITO QUE O PROGRAMADOR QUISER
            
        No <action> do arquivo index tem o seguinte comando: "arquivoDeRedirecionamento.php?$identificador=contatos&action=inserir" ,
        tal comando é uma maneira de forçar um get sem chamar o <GET> no <method> própriamente dito.

        O QUE ESSA LINHA FALA?
        "identificador=contatos&action=inserir" 
        A variável $identificador recebe dados do campo <contatos>  E  A variável $action recebe dados do campo <inserir>    
 
        Ex:
        <form  action="arquivoDeRedirecionamento.php$?identificador=contatos&action=inserir" name="frmCadastro" method="post" >  

        TODOS OS DADOS DIGITADOS PELO USUARIO CHEGAM VIA POST E SÃO VALIDADOS VIA GET  
        
4: RECEBENDO DADOS VIA URL (GET) E IDETIFICANDO A AÇÃO QUE SERÁ REALIZADA 
        $action = $_GET['identificador'];
        $identificador = &$_GET['action']; 

5: ESTRUTURA CONDICIONAL PARA VALIDAR QUEM A ESTA SOLICITANDO DADOS PARA O ARQUIVO ROTA
        
    switch ($identificador) {
        case 'CONTATOS':
            echo('chamando a controller de contatos')
            break;    
    }


    die--> para "matar" execução. Força uma parada

        
*/






?>