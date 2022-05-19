<?php
    /********************************************************************************************************************
    *Objetivo: Arquivo principal da API que irá receber a URL requisitada e redirecionada para APIs (router)
    *Autor: lais
    *Data: 19/5/22
    *Versão: Herbert Richers (1.0)
    *********************************************************************************************************************/
        

    //Ativa quais endereços de sites que requisitarão na API (especifica as origens da requisição da api. <*> libera p todos os sites)
    header('Access-Control-Allow-Origin:*');
    //Ativa os métodos do protocolo HTTP que requisitarão a API (especifica os métodos da api)
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');    
    //Ativa o COntent-Type das requisições (formato de dados que será utilizado- Json, XML, FORM/DATA, etc )
    header('Access-Control-Allow-Header: Content-Type');
    //Libera quais Content-Type serão utilizados na API 
    header('Content-Type: application/json');

    

    //Recebe a URL digitada na requisição 
    $urlHTTP = (string) $_GET['url'];
   
    //converte a url requisitada em um array para dividir as opções de busca, que é separada pela "/"
    $url = explode('/',$urlHTTP);

    //Verifica qual api será encaminhada a requisição (contatos, estado, etc)
    switch (strtoupper($url[0])){
        case   'CONTATOS':
        
            require_once('contatosApi/index.php');
        
        
        break;


    }

















    /* __________________ANOTAÇÃO___________________

    .htaccess é o nome padrão de um arquivo de configuração em nível de diretório que permite um gerenciamento descentralizado das configurações do servidor web

    explode(); --> função embutida que ajuda a dividir uma string em muitas strings diferentesconverte a url requisitada em um array . É separada pela barra (/)


    */




?>