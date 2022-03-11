<?php

/********************************************************************************************************************
*Objetivo: Arquivo responsável pela manipulação de dados dertro do banco de dados(insert, update, select e delete).
*Autor: lais
*Data: 11/03/22
*Versão: Herbert Richers (1.0)
*********************************************************************************************************************/


//import do arquivo que estabelece a conexão com o banco de dados
require_once('conexaoMysql.php');


//function para enserir no banco de dados
function insertContato($dadosContato){ //quem traz os dados do array selecionando pelo post é $dadosContato
    
    //abetura de conexão com o banco de dados
    $conexao= conexaoMysql();

    //Script para enviar ao banco de dados
    $sql="insert into tblContatos
            (nome, 
            telefone, 
            celular, 
            email, 
            obs);
        values
            ('".$dadosContato['nome']."', 
            '".$dadosContato['telefone']."', 
            '".$dadosContato['celular']."', 
            '".$dadosContato['email']."',
            '".$dadosContato['observacao']."');"
            ;
    
   //execução do script no banco de dados
    mysqli_query($conexao,$sql);

}

// function para atualizar no banco de dados
function updateContato(){
    
}

//function para excluir no banco de dado
function deleteContato(){
    
}

//functio para listar todos os contatos dos bancos de dados
function selectAllContato(){
    
}

/*

1. criação de funções
3. passar argumentos
4. import das funções ao banco de dados usando <require_once>
5.
6.
7.


sintaxe: '".$nomeDaVariavel['ChaveDoArray']."' 
            aspas simples -> aspas duplas -> ponto -> $variavel -> 
            colchete -> aspas simples -> ChaveDoArray -> aspas simples -> colchetes ->
            ponto -> aspas duplas -> aspas simples     
               

Exemplo:

//script para enviar vai banco de dados
$sql="
        insert into tblContatos
                            (nome, 
                             telefone, 
                             celular, 
                             email, 
                             obs);
        values
            ('".$dadosContato['nome']."', 
             '".$dadosContato['telefone']."', 
             '".$dadosContato['celular']."', 
             '".$dadosContato['email']."',
             '".$dadosContato['obs']."');
            
     ";







*/





?>