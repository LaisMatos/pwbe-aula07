<?php
    /*********************************************************************************
    *Objetivo: Arquivo responsável pela criação de variaveis e costatntes do projeto 
    *Autor: lais
    *Data: 25/04/22
    *Versão: Herbert Richers (1.0)
    **********************************************************************************/



    #__________________________VÁRIAVEIS CONSTANTES E GLOBAIS DO PROJETO___________________________

    //limitação de 5mb para upload de imagens
    const   MAX_FILE_UPLOAD = 5120; //tamanho máximo permitido de arquivo para ao usuário baixar 
    const   EXT_FILE_UPLOAD = array("image/jpg", "image/jpeg", "image/gif", "image/png"); //ext = extensão 
    const   DIR_FILE_UPLOAD ="arquivos/"; //dir = diretorio

    //rodar comando
    //trocar cominho quando estiver em outra máquina
    define('SRC', $_SERVER ['DOCUMENT_ROOT'].'/lais/marcel/backEnd/aula07/');




    #__________________________FUNÇÕES CONSTANTES E GLOBAIS DO PROJETO___________________________

    //CONVERTE um array para o formato json
    function createJSON ($arrayDados)    {

        //validação para array sem dados
        if (!empty($arrayDados)) {
                         
            //configura o padrão da conversão para o formato json
            header(('Content-Type: application/json'));
            $arrayDados=  json_encode($arrayDados);

            return $arrayDados;
        }else{
            return false;
        }
        
    }


































    /* _______ ANOTAÇÕES_______

        Só é possível saber a escrita da extensão após tester a lógica do sistema
    < image/jpg, image/peg, image/gif, image/png>

    const, usado para strings
    define, usado para comando


    Nativo PHP:
    json_encode(); --> conversor de array  para json
    json_decode(); -> converte de json para array

    */



?>