<?php
/* Objetivo: Arquivo de rota. Segementa as ações encaminhabadas pela View (dados de um form, listagem de dados, ação de ou atualizar)
          Também responsável por encaminhar as solicitações para o controller.
          Criando arquivo pensando em reutilizar o arquivo para diferentes ações. Ou seja, ter apenas um arquivo de rota
Autor: lais
Data: 04/03/22
Versão: Herbert Richers (1.0)
*/




//Receber dados do formulário
$action =(string)null;
$identificador= (string)null; 

//Validação para verificar se a requisição  é um post de um formulário
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    /*echo('Requesição de form');*/

    //Recebendo dados via url (get) e qual ação será realizada
    $identificador= strtoupper($_GET['identificador']);
    $action = $_GET['action']; 

    //Validação de quem esta solicitando dados para o arquivo rota
    switch ($identificador) {
        case 'CONTATOS':
            echo('chamando a controller de contatos');
            break;    
    }



}















/* ########## ANOTAÇÕES ##########


1: ESTRUTURA DE DECISÃO. PARA VERIFICAR SE O METODO QUE CHEGA AO BACK-END É POST ou GET
    *****Post*****
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    echo('Requesição de form')} 
    
    *****Get*****
     if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    echo('Requesição de form')} 

2: VARIAVEL QUE IDENTIFICA OS DADOS QUE CHEGAM
        $action =(string)null;
        $identificador= (string)null; 

3: ENVIO DE DADOS VIA POST E GET
    //get usado para pegar dados digitados pelo usuário e envia para o arquivo rota
    //post usado para pegar dados digitados pelo usuário e envia para o db

        SÓ É POSSÍVEL USAR/RECUPERAR OS DADOS DO USUÁRIO DESSA MANEIRA SE O <METHOD> FOR <POST> no <form>
        O html esta trabalhando no post e o programador esta forçando o get para os dados serem usados no arquivo rota DO JEITO QUE O PROGRAMADOR QUISER
            
        No <action> do arquivo index tem o seguinte comando: "arquivoDeRedirecionamento.php?$identificador=contatos&action=inserir" ,
        tal comando é uma maneira de forçar um get sem chamar o <GET> no <method> própriamente dito.

        O QUE ESSA LINHA FALA?
        "identificador=contatos&action=inserir" 
        A variável $identificador recebe dados do campo <contatos>  E  A variável $action recebe dados do campo <inserir>    
 
        Ex:
        <form  action="arquivoDeRedirecionamento.php$?identificador=contatos&action=inserir" name="frmCadastro" method="post" >  
        
4: RECEBENDO DADOS VIA URL (GET) E IDETIFICANDO A AÇÃO QUE SERÁ REALIZADA 
        $action = $_GET['identificador'];
        $identificador = &$_GET['action']; 

5: ESTRUTURA CONDICIONAL PARA VALIDAR QUEM A ESTA SOLICITANDO DADOS PARA O ARQUIVO ROTA
        
    switch ($identificador) {
        case 'CONTATOS':
            echo('chamando a controller de contatos')
            break;    
    }
        
*/






?>