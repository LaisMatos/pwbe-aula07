<?php
/********************************************************************************
*Objetivo: Arquivo responsável em realizar uploads de arquivos
*Autor: lais
*Data: 25/04/22
*Versão: Herbert Richers (1.0)
**********************************************************************************/



//função para realizar upload de imagens
function uploadFile ($arrayFile)
{
    
    require_once('modulo/config.php');

    $arquivo = $arrayFile;
    $sizeFile=(int)0; //tamanho do arquivo
    $typeFile=(string) null;
    $nameFile=(string) null;
    $tempFile= (string) null; //temp = temporario

    //limitar tamanho do arquivo 
    //validação de arquivo vazio, para identificar se existe um arquivo válido (Maior que 0 e que tenha uma extensão)
    if ($arquivo['size'] > 0 && $arquivo['type'] !="" ){

        //recupera o tamamho do arquivo
        $sizeFile= $arquivo['size']/1024; //a divisão < /1024 > serve para conversão de byte para kb, por exmplo. 
        
        //recupera o tipo de arquivo
        $typeFile=$arquivo['type'];
        
        //recupera o nome de arquivo
        $nameFile=$arquivo['name'];

        //recupera o caminho do diretório temporario onde está o arquivo. A pasta temporária está no sevidor 
        $tempFile = $arquivo['tmp_name'];

        //validação para permitir upload apenas de arquivos com tamanho de 5mb
        if ($sizeFile <= MAX_FILE_UPLOAD) {

            //verificação de extenção de arquivo permitida
            //usando um array para  fazer a verificação <in_array>
            if (in_array($typeFile, EXT_FILE_UPLOAD)) {

               //separa somente O NOME do arquivo sem a sua exntesão
               $nome = pathinfo ($nameFile, PATHINFO_FILENAME);
                
               //separa somente A EXTENSÃO do arquivo sem o seu nome
               $extensao = pathinfo ($nameFile, PATHINFO_EXTENSION);

               //md5() - gera um criptografia de dados
               //uniqid() - gera uma sequencia numerica diferente tendo como base configurações da máquina
               //time() - pega a hora:minuto:segundo que esta sendo feito o upload da foto
               $nomeCrity = md5($nome.uniqid(time())); 

               //remontagem do nome do arquivo com a extensão
               $foto= $nomeCrity.".".$extensao;


               //(1)movendo arquivo da pasta temporária do servidor para a pasta permanente <arquivos> com o nome tratado
               //(2)tratativa para caso haja erro no arquivo
               if (move_uploaded_file($tempFile, DIR_FILE_UPLOAD.$foto)) {
                  return $foto;
               } else{
                return array('idErro' => 13,
                                'message'=> 'Não foi possível realizar upload');                   
               }

            }else{
                return array('idErro' => 12,
                                'message'=> 'A extensão do arquivo selecionado não é pertmitida para upload');
            }

        }else{
            return array('idErro' => 10,
                                'message'=> 'Tamanho de arquivo invalido para upload');
        }           

    }else{
        return array('idErro' => 11,
                                'message'=> 'Não é possível realizar upload sem um arquivo selecionado');
    }







}


/*_____________________________ANOTAÇÃO_____________________________________


  #Existe diversos algoritmos para criptografia de dados, alguns deles: 
        md5()
        shal()
        hash()

    Não existe decriptação desses algoritmos acima, somente criptação.

    uniqid >> usando para gerar uma sequencia de identificação do arquivo
    time >> usado para diferenciar os arquivos
    
        Combinados geram a criptografia do sistema: 
            Ex:    $nome = md5($nome.uniqid(time())); 
*/



?>