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
    
   //parte1: execução do script no banco de dados --> mysqli_query($conexao,$sql) //mysqli_query retorna um booleno
   //parte2: verificação se o script sql esta correto
    if (mysqli_query($conexao,$sql)){  
        //verificação se uma linha foi acrescentada no banco
        if (mysqli_affected_rows($conexao)) { //verifica se teve alguma linha no baco afetada <mysqli_affected_rows>
            return true;
        }else {
            return false;
        }
    }else{
        return false;
    } 

}

// function para atualizar no banco de dados
function updateContato(){
    
}

//function para excluir no banco de dado
function deleteContato(){
    
}

//functio para listar todos os contatos dos bancos de dados
function selectAllContato(){
    //estabelecendo conecxão com a função conexaoMysql();
    $conexao= conexaoMysql();
    
    //criando script para listar todos os dados do banco de dados 
    $sql="select*from tblContatos";
    $result = mysqli_query($conexao,$sql);

    //valida se o banco de dados retornou registros
    if ($result) {
        
        $cont=0;

        //armazenando array convertido (convertido usando a estrutura fetch)
        while ($rsDados = mysqli_fetch_assoc($result)) {
            
            //Extraindo os dados da estrutura <fecth_assoc> //criar um array com os dados do banco de dados
            //array baseado em indice e com chaves
            $arrayDados[$cont]=array(
                "nome" =>$rsDados['nome'],
                "telefone" =>$rsDados['telefone'],
                "celular" =>$rsDados['celular'],
                "email" =>$rsDados['email'],
                "obs" =>$rsDados['obs']
            );
            $cont++;
        }
        //retornando os dados do array
        return $arrayDados;
    }
    

}

/*

1. criação de funções
3. passar argumentos
4. import das funções ao banco de dados usando <require_once>



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

Ao mandar um script para o banco do tipo Delet, Update e ---- o banco não retorna os dados modificados. Só retorna se deu erro!
Só o Select que retorna dados.


<$rsDados> --> array que amarzenará os dados convertidos do banco de dados
 
estrutura <while> para gerenciar a quantidade de vezes que deverá ser feita a repetição de itens do array
while ($rsDados = mysqli_fetch_assoc($result)) {
            
        }



*/





?>