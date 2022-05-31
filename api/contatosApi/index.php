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
                //retorna um statusCode que significa que a requisição foi aceita, porém sem
                //conteudo de retorno 
                return $response    ->withStatus(204);
            }            
        }
    });

    //EndPoint : Requisição para BUSCAR contatos pelo ID
    $app -> get('/contatos/{id}', function($request, $response, $args){
        
        //$id recebe o id do registro que será retornada pela API. Esse ID está chegando pela variável criada no endpoint
        $id = $args ['id'];
        
        //imports
        require_once('../modulo/config.php');
        require_once('../controller/controllerContatos.php');

        // solicita os dados para controller      
        if ($dados = buscarcontato($id)) {
           
            //verifica se houve algum tipo de erro no retorno dos dados da controller
            if (!isset($dados['IdErro'])){

                 //converção do array de dados em formato json
                if ($dadosJson = createJSON($dados)) {
                    //status code 200, se existir dados a serem retornados 
                    return $response    -> withStatus(200)
                                        -> withHeader('Content-Type', 'application/json')
                                        -> write($dadosJson);
                }
            } else{

                //converte para json o erro, pois a controller retorna em array
                $dadosJson=createJSON($dados);

                //status code 404, erro caso o cliente passa dados errados
                return $response    -> withStatus(404)
                                    -> withHeader('Content-Type', 'application/json')
                                    -> write('{"message": "DADOS INVÁLIDOS",
                                             "ERRO": '.$dadosJson.' 
                                            }');
            }            
        }else{
            // caso a requisição seja aceita, porém sem conteúdo de retorno
            return $response -> withStatus(204);
        }   


    });

    //EndPoint : Requisição para DELETAR contatos pelo ID    
    $app -> delete('/contatos/{id}', function($request, $response, $args){

        if(is_numeric($args ['id'])){

            //$id recebe o id do registro que será retornada pela API. Esse ID está chegando pela variável criada no endpoint
            $id = $args ['id'];
        
            //imports
            require_once('../modulo/config.php');
            require_once('../controller/controllerContatos.php');

            //buca o nome da foto para ser excluída na controller
            if ($dados = buscarcontato($id)) {
                
                //recebe o nome da foto que a controller retornou 
                $foto = $dados['foto'];
                
                //cria um array com o ID e o nome da foto a ser enviada p/ cotroller excluir o registro
                $arrayDados = array(
                    "id"    => $id,
                    "foto"  => $foto
                ); 

                $resposta = excluirContatos($arrayDados);

                if (is_bool($resposta) && $resposta== true) { //chama a fução de excluir o contato, encaminhando o array com o ID e a foto
                    
                    // retorna ao cliente o sucesso da exclusão 
                    return $response    -> withStatus(200)
                                        -> withHeader('Content-Type', 'application/json')
                                        -> write('{"message": "Registro e imagem exluído com sucesso" }'
                    );
                     
                }elseif(is_array($resposta) && isset($resposta ['idErro'])){
                    
                    //Validação referente ao erro 5
                    if ($resposta['idErro'] == 5) {
                        
                        // retorna ao cliente o sucesso da exclusão E IMAGEM NÃO EXISTIA NO SERVIDOR
                        return $response    -> withStatus(200)
                                            -> withHeader('Content-Type', 'application/json')
                                            -> write('{"message": "Registro exluído com sucesso. IMAGEM COM ERRO NO SERVIDOR " }'
                        );
                        
                    }else{
                        //converte para json o erro, pois a controller retorna em array
                        $dadosJson=createJSON($dados);

                        //status code 404, erro caso o cliente passa dados errados
                        return $response    -> withStatus(404)
                                            -> withHeader('Content-Type', 'application/json')
                                            -> write('{"message": "ERRO AO EXCLUIR",
                                                    "ERRO": '.$dadosJson.' }'
                        ); 
                    }                      
                }

            }else{
                return $response    -> withStatus(404)
                                    -> withHeader('Content-Type', 'application/json')
                                    -> write('{"message": "ID INFORMADO NÃO EXISTE" }'
                );
            }

        } else{
            return $response    -> withStatus(404)
                                -> withHeader('Content-Type', 'application/json')
                                -> write('{"message": "É OBRIGATÓTO INFORMAR UM ID NO FORMATO VÁLIDO (NUMÉRICO)" }'
            );
        } 
      

    });
    
    //EndPoint: Requisição para inserir um novo contato
    $app->post('/contatos', function($request, $response, $args){

        //Recebe do header da requisição qual será o content-type
        $contentTypeHeader = $request->getHeaderLine('content-Type');

        //Cria um array pois depedendo do content-type temos mais informações separadas
        $contentType = explode(";", $contentTypeHeader);
       
        switch ($contentType[0]) {
            case 'multipart/form-data':
                
                //Recebe os dados comuns enviado pelo corpo da requisição
                $dadosBody = $request->getParsedBody();

                //Recebe uma imagem enviada pelo corpo da requisição
                $uploadFile = $request->getUploadedFiles();

                //Cria um array com todos os dados que chegaram pela requisição,dvido aos dados serem protegidos
                //Criamos um array e recuperamos os dados pelos metodos do objeto
                $arrayFoto = array(
                             "name"     =>$uploadFile['foto'] ->getClientFileName(),
                             "type"     =>$uploadFile['foto'] ->getClientMediaType(),
                             "size"     =>$uploadFile['foto'] ->getSize(),
                             "tmp_name" =>$uploadFile['foto'] ->file
                );

                //Cria uma chave chamada foto para colocar todos os dados do objeto conforme é gerado em form
                $file = array("foto"=>$arrayFoto);

                $arrayDados = array($dadosBody,
                                    "file" => $file
                );

                //imports da controller, para busca de dados
                require_once('../modulo/config.php');
                require_once('../controller/controllerContatos.php');

                $resposta = inserirContatos($arrayDados);
                if(is_bool($resposta) && $resposta == true)
                {
                    return $response  ->withStatus(200)
                                      ->withHeader('Content-Type', 'application/json')
                                      ->write("{'message': 'Inserido}"
                    );

                }elseif(is_array($resposta) && $resposta['idErro']){
                    
                    //cria o JSON dos dados do erro
                    $dadosJSON = createJSON($resposta);
                   
                    return $response    ->withStatus(400)
                                        ->withHeader('Content-Type','application/json')
                                        ->write('{"message": "houve um problema no processo de inserir",
                                        "Erro": '.$dadosJSON.'}'
                    );
                }

                return $response  ->withStatus(200)
                                  ->withHeader('Content-Type', 'application/json')
                                  ->write("{'message': 'Formato selecionado foi Formdata'}"
                );
                        
            break;

            case 'application/json':
                
                return $response  ->withStatus(200)
                                  ->withHeader('Content-Type', 'application/json')
                                  ->write("{'message': 'Formato selecionado foi JSON'}"
                );

            break;

            default:
                return $response  ->withStatus(400)
                                  ->withHeader('Content-Type', 'application/json')
                                  ->write("{'message': 'Formato do content-type não é válido para essa requisição'}"
                );

            break;
        }

    });


    //EndPoint: Requisição para inserir um novo contato
    $app->post('/contatos/{id}', function($request, $response, $args){
    
        if(is_numeric($args ['id'])){
      
        //Recebe o ID enviado no EndPoint através da variavel ID
        $id = $args['id'];
            
        //Recebe do header da requisição qual será o content-type
        $contentTypeHeader = $request->getHeaderLine('content-Type');

        //Cria um array pois depedendo do content-type temos mais informações separadas
        $contentType = explode(";", $contentTypeHeader);
        
        switch ($contentType[0]) {
            case 'multipart/form-data':

                require_once('../modulo/config.php');
                require_once('../controller/controllerContatos.php');

                //chama a fun para buscar a foto que já esta salva no bd
                if($buscarcontato = buscarcontato($id)){
                    $fotoAtual = $dadosContato['foto'];
                
                    
                    //Recebe os dados comuns enviado pelo corpo da requisição
                    $dadosBody = $request->getParsedBody();

                    //Recebe uma imagem enviada pelo corpo da requisição
                    $uploadFile = $request->getUploadedFiles();

                    //Cria um array com todos os dados que chegaram pela requisição,dvido aos dados serem protegidos
                    //Criamos um array e recuperamos os dados pelos metodos do objeto
                    $arrayFoto = array(
                                    "name"     =>$uploadFile['foto'] ->getClientFileName(),
                                    "type"     =>$uploadFile['foto'] ->getClientMediaType(),
                                    "size"     =>$uploadFile['foto'] ->getSize(),
                                    "tmp_name" =>$uploadFile['foto'] ->file
                    );

                    //Cria uma chave chamada foto para colocar todos os dados do objeto conforme é gerado em form
                    $file = array("foto"=>$arrayFoto);

                    $arrayDados = array($dadosBody,
                                        "file" => $file,
                                        "id"   => $id,
                                        "foto" => $fotoAtual
                    );
                    
                    //chama a função da controller para inserir od dados
                    $resposta = inserirContatos($arrayDados);

                    if(is_bool($resposta) && $resposta == true){
                        return $response    ->withStatus(200)
                                            ->withHeader('Content-Type', 'application/json')
                                            ->write("{'message': 'Registro atualizado com sucesso!}");

                    }elseif(is_array($resposta) && $resposta['idErro']){

                        //Cria o JSON dos dados do erro
                        $dadosJSON = createJSON($resposta);
                    
                        return $response    ->withStatus(400)
                                            ->withHeader('Content-Type','application/json')
                                            ->write('{"message": "houve um problema no processo de inserir",
                                                    "Erro": '.$dadosJSON.'}'
                        );

                    }else{
                        
                        //Retorna um erro que significa que o cliente informou um ID inválido
                        return $response    ->withStatus(404)
                                            ->withHeader('Content-Type', 'application/json')
                                            ->write('{"message": "O ID informado não existe na base de dados."}'
                        );
                    }
                }
                      
                break;

                case 'application/json':

                    return $response    ->withStatus(200)
                                        ->withHeader('Content-Type', 'application/json')
                                        ->write("{'message': 'Formato selecionado foi JSON'}"
                    );

                break;

                default:
                    return $response    ->withStatus(400)
                                        ->withHeader('Content-Type', 'application/json')
                                        ->write("{'message': 'Formato do content-type não é válido para essa requisição'}"                                    
                    );

                break;
            }

        }else{
            //status code 404, erro caso o cliente passa dados errados
            return $response    -> withStatus(404)
                                -> withHeader('Content-Type', 'application/json')
                                -> write('{"message": "ERRO AO EXCLUIR",
                                        "ERRO": '.$dadosJson.'  }'
            ); 
        } 
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
                Sintaxe: '/ palavra-chave/ {variavel}'                   
                       
                Exemplo: '/contatos/{id}'


        Postman--> Endpoint:
            Na construção da api, é necessário organizar os endpoints no postman. 
            1°: Para cada endpoint é necessário um request no Postman
            2°: Save Response-> Save as example

         Os metodos de requisição para uma API são:
     *  GET         - para buscar dados
     *  POST        - para inserir um novo dado
     *  DELETE      - para apagar dados
     *  PUT/PATCH   - para editar um dados já existente
     *          O mais utilizado é o PUT 

    */

?>