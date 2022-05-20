<?php
     /********************************************************************************************************************
    *Objetivo: Arquivo principal da API que irá receber a URL requisitada e redirecionada para APIs (router)
    *Autor: lais
    *Data: 19/5/22
    *Versão: Herbert Richers (1.0)
    *********************************************************************************************************************/

    use Slim\Http\Response;

    //import do arquivo autoload, que fara as instancias do slim 
    require_once('vendor/autoload.php');
    
    //cria um obj do slim chamado de app, para configurar os EndPoints
    $app = new \Slim\App();


    //EndPoint : Requisição para listar ALL/TODOS os contatos 
    $app -> get('/contatos', function($request, $response, $args){
        
        //imports
        require_once('../modulo/config.php');
        require_once('../controller/controllerContatos.php');

        // solicita os dados para controller      
        if ($dados = listarContatos()) {

            //converção do array de dados em formato json
            if ($dadosJson = createJSON($dados)) {
                //status code 200, se existir dados a serem retornados 
                return $response    -> withStatus(200)
                                    -> withHeader('Content-Type', 'application/json')
                                    -> write($dadosJson);
            }else{
                //status code 404, caso a requisição seja aceita, porém sem conteúdo de retorno
                return $response    -> withStatus(404)
                                    -> withHeader('Content-Type', 'application/json')
                                    -> write('{"message: ITEM NÃO ENCONTRADO"}');
            }            
        }
    });

    //EndPoint : Requisição para listar contatos pelo ID
    $app -> get('/contatos/{id}', function($request, $response, $args){
        
        $id = $args ['id'];
        
        //imports
        require_once('../modulo/config.php');
        require_once('../controller/controllerContatos.php');

        // solicita os dados para controller      
        if ($dados = buscarcontato($id)) {

            //converção do array de dados em formato json
            if ($dadosJson = createJSON($dados)) {
                //status code 200, se existir dados a serem retornados 
                return $response    -> withStatus(200)
                                    -> withHeader('Content-Type', 'application/json')
                                    -> write($dadosJson);
            }else{
                //status code 404, caso a requisição seja aceita, porém sem conteúdo de retorno
                return $response    -> withStatus(404)
                                    -> withHeader('Content-Type', 'application/json')
                                    -> write('{"message: ITEM NÃO ENCONTRADO"}');
            }            
        }


    });

    //EndPoint : Requisição para inserir um novo contato
    $app -> post('/contatos', function($request, $response, $args){

    });









    //executa todos os endpoints
    $app -> run();









    /* __________ANOTAÇÕES__________


        App(); função
        status code api rest --> Os códigos de status das respostas HTTP indicam se uma requisição HTTP foi corretamente concluída. 

        Argumentos do callback:
            $request - recebe dados do corpo da requisição (JON, FORM/DATA, XML, etc) - entrada de dados
            $response - envia dados de retorno da api (ex: msgo u  dados) - saída de dados
            $args - permite receber dados de atributos da api. O nome que estiver no endpoint ficará no args. 

        Palavra chave: 



    */







?>