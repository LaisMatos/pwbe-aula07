<?php
     /********************************************************************************************************************
    *Objetivo: Arquivo principal da API que irá receber a URL requisitada e redirecionada para APIs (router)
    *Autor: lais
    *Data: 19/5/22
    *Versão: Herbert Richers (1.0)
    *********************************************************************************************************************/

    //import do arquivo autoload, que fara as instancias do slim 
    require_once('vendor/autoload.php');
    
    //cria um obj do slim chamado de app, para configurar os EndPoints
    $app = new \Slim\App();


    //EndPoint : Requisição para listar ALL/TODOS os contatos 
    $app -> get('/contatos', function($request, $response, $args){
        $response-> write('Testando api peloo get');
    });

    //EndPoint : Requisição para listar contatos pelo ID
    $app -> get('/contatos{id}', function($request, $response, $args){

    });

    //EndPoint : Requisição para inserir um novo contato
    $app -> post('/contatos', function($request, $response, $args){

    });















    /* __________ANOTAÇÕES__________


    App(); função





    */







?>