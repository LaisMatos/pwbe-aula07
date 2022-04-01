<?php

    /*######  OQ ESTAMOS FAZENDO AQUI? #######*/
    
    //tratando erro de variavel não declarada. Valida se a utilização de variavel de sessão está ativa no servidor
    if(session_status()){
        if(!empty($_SESSION['dadosContato'])){
            
            $id             = $_SESSION['dadosContato']['id'];
            $nome           = $_SESSION['dadosContato']['nome'];
            $telefone       = $_SESSION['dadosContato']['telefone'];
            $celular        = $_SESSION['dadosContato']['celular'];
            $email          = $_SESSION['dadosContato']['email'];
            $obs            = $_SESSION['dadosContato']['obs'];
        }

    }


   

/*### ANOTAÇÃO ###

    //fun que diz se variavel de sessao esta ativa, por padrão ela é falsa por ñ estar ativa.
    session_status()

*/
?>




<!DOCTYPE>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title> Cadastro </title>
        <link rel="stylesheet" type="text/css" href="css/style.css">


    </head>
    <body>
       
        <div id="cadastro"> 
            <div id="cadastroTitulo"> 
                <h1> Cadastro de Contatos </h1>
            </div>
            <div id="cadastroInformacoes">
                <form  action="arquivoDeRedirecionamento.php?identificador=contatos&action=inserir" name="frmCadastro" method="post" > <!-- identificação p/ arq de rota e requisições (o que quer fazer)-->
                    
                    <div class="campos">
                        <div class="cadastroInformacoesPessoais">
                            <label> Nome: </label>
                        </div>
                        <div class="cadastroEntradaDeDados">
                            <input type="text" name="txtNome" value="<?=$nome?>" placeholder="Digite seu Nome" maxlength="100">
                        </div>
                    </div>
                                     
                    <div class="campos">
                        <div class="cadastroInformacoesPessoais">
                            <label> Telefone: </label>
                        </div>
                        <div class="cadastroEntradaDeDados">
                            <input type="tel" name="txtTelefone" value="<?=$telefone?>">
                        </div>
                    </div>
                    <div class="campos">
                        <div class="cadastroInformacoesPessoais">
                            <label> Celular: </label>
                        </div>
                        <div class="cadastroEntradaDeDados">
                            <input type="tel" name="txtCelular" value="<?=$celular?>">
                        </div>
                    </div>
                                     
                    <div class="campos">
                        <div class="cadastroInformacoesPessoais">
                            <label> Email: </label>
                        </div>
                        <div class="cadastroEntradaDeDados">
                            <input type="email" name="txtEmail" value="<?=$email?>">
                        </div>
                    </div>
                    <div class="campos">
                        <div class="cadastroInformacoesPessoais">
                            <label> Observações: </label>
                        </div>
                        <div class="cadastroEntradaDeDados">
                            <textarea name="txtObs" cols="50" rows="7"></textarea>
                        </div>
                    </div>
                    <div class="enviar">
                        <div class="enviar">
                            <input type="submit" name="btnEnviar" value="Salvar">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div id="consultaDeDados">
            <table id="tblConsulta" >
                <tr>
                    <td id="tblTitulo" colspan="6">
                        <h1> Consulta de Dados.</h1>
                    </td>
                </tr>
                <tr id="tblLinhas">
                    <td class="tblColunas destaque"> Nome </td>
                    <td class="tblColunas destaque"> Celular </td>
                    <td class="tblColunas destaque"> Email </td>
                    <td class="tblColunas destaque"> Opções </td>
                </tr>
                
               <?php
                    // conexão com o arq controllerContatos
                    require_once('controller/controllerContatos.php');
                    //chamando a fun listarcontatos
                    $listContato = listarContatos(); 
                    //estrutura de repetição para retornar os dados do array printar na tela
                    foreach ($listContato as $item) { //for para exibir listas na tela
               ?>
                <tr id="tblLinhas">

                    <td class="tblColunas registros"><?=$item['nome']?></td>
                    <td class="tblColunas registros"><?=$item['celular']?></td>
                    <td class="tblColunas registros"><?=$item['email']?></td>
                                   
                    <td class="tblColunas registros">

                            <!--icone editar-->
                            <a href="arquivoDeRedirecionamento.php?identificador=contatos&action=buscar&id=<?=$item['id']?>">
                                <img src="img/edit.png" alt="Editar" title="Editar" class="editar">
                            </a>
                            <!--icone excluir-->
                            <a onclick="return confirm('Deseja excluir este item?');" href="arquivoDeRedirecionamento.php?identificador=contatos&action=deletar&id=<?=$item['id']?>"> <!--manipulando id c/ php aqui-->
                                <img src="img/trash.png" alt="Excluir" title="Excluir" class="excluir">    
                            </a>   

                            <img src="img/search.png" alt="Visualizar" title="Visualizar" class="pesquisar">
                    </td>

                </tr>
            <?php
                //fechamento do foreach
                }
            ?> 
            </table>
        </div>
    </body>
</html>

<!--################### ANOTAÇÃO ##########################
    
    Serve para criar um alert de confirmação caso o usuário queira deletar algum dado
        onclick="return confirm('Deseja excluir este item?');"
-->