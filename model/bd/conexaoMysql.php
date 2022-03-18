<?php

/******************************************** 
obj: arq para criar conexão com banco MySql
autor: lais
Data: 25.02.22
versão: 1.0
********************************************/


// const par estabelecer a conexão com o BD 
const SERVER = 'localhost'; // local do banco
const USER = 'root'; //usuário
const PASSWORD ='bcd127';  //senha
const DATABASE = 'dbContatos'; //nome do banco

//criar variavel $resultado que recebe a função conexaoMysql() para executar a função e exibir via var_dump o código
$resultado = conexaoMysql();

// fun para abertura da conexão com bd
function conexaoMysql(){
    
    //criação de array para armazenar dados do banco
    $conexao=array();
    
    //se conexão for stabelecida com o BD, retornará um array de dados sobre a conexão
    $conexao=mysqli_connect(SERVER, USER, PASSWORD, DATABASE);

    //teste lógico para validar se a conexão foi realizada com sucesso
    if ($conexao) {
        return $conexao;
    }else {
        return false;
    }

}

/*########### ANOTAÇÕES ##############

Formas de conectar-se com o BD MySql
    mysql_connet() : versão antiga do php para fazer a conexão com o BD (ñ tem performance e segurança)
    mysqli_connet() : versão mais atual do php para fazer a conexão com o BD (pode ser usada para programação estruturada e poo)
    PDO() : versão recente, mais completa e eficiente para conectar-se com o BD (indicada pela segurança e poo)

Roteiro para estabelecer conexão com banco de dados
    -criar função  
    -escolher biblioteca 
    -especificar para biblioteca local do banco, usuário, senha e nome do banco
*/

















?>