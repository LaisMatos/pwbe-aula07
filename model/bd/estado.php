<?php
/********************************************************************************************************************
*Objetivo: Arquivo responsável pela manipulação de dados dertro do banco de dados(select).
*Autor: lais
*Data: 10/05/22
*Versão: Herbert Richers (1.0)
*********************************************************************************************************************/

//imports 
require_once('conexaoMysql.php');


//functio para listar todos os estados dos bancos de dados
function selectAllEstados(){
    //estabelecendo conecxão com a função conexaoMysql();
    $conexao= conexaoMysql();
    
    //criando script para listar todos os dados do banco de dados 
    $sql="select*from tblestados order by nome asc";
    $result = mysqli_query($conexao,$sql);

    //valida se o banco de dados retornou registros
    if ($result) {
        
        $cont=0;

        //armazenando array convertido (convertido usando a estrutura fetch)
        while ($rsDados = mysqli_fetch_assoc($result)) {
            
            //Extraindo os dados da estrutura <fecth_assoc> 
            //criar um array com os dados do banco de dados, array baseado em indice e com chaves
            //script do banco de dados
            $arrayDados[$cont]=array(

                "idestado"   =>$rsDados['idestado'],
                "nome"       =>$rsDados['nome'],
                "sigla"      =>$rsDados['sigla']                
            );
            $cont++;
        }

        //solicita o fechamento da conexão como bd por motivos de segurança    
        fecharConexaoMysql($conexao);
        //retornando os dados do array
        return $arrayDados;
    }
    

}



?>