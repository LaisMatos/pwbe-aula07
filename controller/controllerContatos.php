<?php

/********************************************************************************************************************
*Objetivo: Arquivo responsável pela manipulação de dados de contatos.Também fará a conexão entre a View e a Model.
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
            //chamando a função insertContato() que está no aquivo contato.php e passa os dados do $arrayDados para alimentar o banco de dados
            insertContato($arrayDados);

        }else {
            echo('problemas');
        }
    }
        
}


// fun recebe recebe dados da View e encaminha para model (ATUALIZAÇÃO)
function atualizarContatos(){
}

//fun para realizar dados de contatos
function excluirContatos(){
}

//fun solicita dados de model e encaminha a lista de contatos para a View
function listarContatos(){
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