<?php
/********************************************************************************************************************
*Objetivo: Responsável pela manipulação de dados de estado.Também fará a conexão entre a View e a Model.
*Autor: lais
*Data: 10/05/22
*Versão: Herbert Richers (1.0)
*********************************************************************************************************************/

//imports
require_once('modulo/config.php');

//fun solicita dados de model e encaminha a lista de estao para a View
function listarEstados(){

    //import do arquivo estado.php para buscar os dados do banco de dados
    require_once('model/bd/estado.php');

    //chama a função selectAllEstado(), que chamará os dados do banco de dados
    $dados= selectAllEstados();

    //retorno de dados
    if (!empty($dados)) {
       return $dados;
    }else {
        return false;
    }


}






?>