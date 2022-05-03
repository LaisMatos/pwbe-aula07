<?php
    //imports

    //arquivo de configurações d projeto
    require_once('modulo/config.php');


    /*######  OQ ESTAMOS FAZENDO AQUI? #######*/
    
    
    $foto= (string) null; //variavel para carregar o nome da foto no banco de dados    
    $form = (string) "arquivoDeRedirecionamento.php?identificador=contatos&action=inserir" ;//variavel foi criada para diferenciar no action do formulário qual ação deveria ser levada para a router (inserir e editar). Nas condições abaixo mudamos a action dessa variavel para a ação de editar

    //tratando erro de variavel não declarada. Valida se a utilização de variavel de sessão está ativa no servidor
    if(session_status()){
        if(!empty($_SESSION['dadosContato'])){
            
            $id             = $_SESSION['dadosContato']['id'];
            $nome           = $_SESSION['dadosContato']['nome'];
            $telefone       = $_SESSION['dadosContato']['telefone'];
            $celular        = $_SESSION['dadosContato']['celular'];
            $email          = $_SESSION['dadosContato']['email'];
            $obs            = $_SESSION['dadosContato']['obs'];
            $foto           = $_SESSION['dadosContato']['foto'];

            //mudamos a ação do dorm para editar o registro no click do botão salvar    
            $form = "arquivoDeRedirecionamento.php?identificador=contatos&action=editar&id=".$id."&foto=".$foto;       
            //destrói variavel de sessao da memoria do servidor 
            unset($_SESSION['dadosContato']);
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
                <!--enctype="multipart/form-data" Essa opção é obrigatória para enviar arquivos do formulário em html para o servidor-->
                <form  action= <?=$form?>  name="frmCadastro" method="post" enctype="multipart/form-data"> <!-- identificação p/ arq de rota e requisições (o que quer fazer)-->
                    
                    <div class="campos">
                        <div class="cadastroInformacoesPessoais">
                            <label> Nome: </label>
                        </div>
                        <div class="cadastroEntradaDeDados">
                            <input type="text" name="txtNome" value="<?=isset($nome)?$nome:null?>" placeholder="Digite seu Nome" maxlength="100">
                        </div>
                    </div>
                                     
                    <div class="campos">
                        <div class="cadastroInformacoesPessoais">
                            <label> Telefone: </label>
                        </div>
                        <div class="cadastroEntradaDeDados">
                            <input type="tel" name="txtTelefone" value="<?=isset($telefone)?$telefone:null?>">
                        </div>
                    </div>
                    <div class="campos">
                        <div class="cadastroInformacoesPessoais">
                            <label> Celular: </label>
                        </div>
                        <div class="cadastroEntradaDeDados">
                            <input type="tel" name="txtCelular" value="<?=isset($celular)?$celular:null?>">
                        </div>
                    </div>
                                     
                    <div class="campos">
                        <div class="cadastroInformacoesPessoais">
                            <label> Email: </label>
                        </div>
                        <div class="cadastroEntradaDeDados">
                            <input type="email" name="txtEmail" value="<?=isset($email)?$email:null?>">
                        </div>
                    </div>
                    <div class="campos">
                        <div class="cadastroInformacoesPessoais">
                            <label> Escolha um Arquivo: </label>
                        </div>
                        <div class="cadastroEntradaDeDados">
                        <!--accept serve para colocar as extenções que poderão aceitar quando ....................... -->
                            <input type="file" name="flefoto" accept=".jpg, .png, .jpeg, .gif">
                        </div>                        
                    </div>
                    <div class="campos">
                        <div class="cadastroInformacoesPessoais">
                            <label> Observações: </label>
                        </div>
                        <div class="cadastroEntradaDeDados">
                            <textarea name="txtObs" cols="50" rows="7"> <?=isset($obs)?$obs:null?></textarea>
                        </div>
                    </div>

                    <!---->
                    <div class="campos">
                        <img src="<?=DIR_FILE_UPLOAD.$foto?>" >
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
                    <td class="tblColunas destaque"> Foto </td>
                    <td class="tblColunas destaque"> Opções </td>
                </tr>
                
               <?php
                    // conexão com o arq controllerContatos
                    require_once('controller/controllerContatos.php');
                    //chamando a fun listarcontatos
                    $listContato = listarContatos(); 
                    //estrutura de repetição para retornar os dados do array printar na tela
                    foreach ($listContato as $item) { //for para exibir listas na tela

                        $foto=$item['foto'];
               ?>
                <tr id="tblLinhas">

                    <td class="tblColunas registros"><?=$item['nome']?></td>
                    <td class="tblColunas registros"><?=$item['celular']?></td>
                    <td class="tblColunas registros"><?=$item['email']?></td>
                    
                    <!--inserção de img-->
                    <td class="tblColunas registros"> <img src="<?=DIR_FILE_UPLOAD.$item['foto']?>" class="foto"> </td>
                                   
                    <td class="tblColunas registros">

                            <!--icone editar-->
                            <a href="arquivoDeRedirecionamento.php?identificador=contatos&action=buscar&id=<?=$item['id']?>">
                                <img src="img/edit.png" alt="Editar" title="Editar" class="editar">
                            </a>
                            <!--icone excluir-->
                            <a onclick="return confirm('Deseja excluir este item?');" href="arquivoDeRedirecionamento.php?identificador=contatos&action=deletar&id=<?=$item['id']?>&foto=<?=$foto?>"> <!--manipulando id c/ php aqui-->
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