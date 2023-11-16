<?php
require_once("../controllers/permissaoacessocontroller.php");
$ctr = new PermissaoAcessoController();
?>

<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script>
            function limparUsuarioDe(){
                $("#txtCodUsuarioDe").val("");
                $("#txtDescUsuarioDe").val("");
            }

            function limparUsuarioPara(){
                $("#txtCodUsuarioPara").val("");
                $("#txtDescUsuarioPara").val("");
            }
        </script>
    </head>
    <body>
        <div class="container-fluid">
            <nav class="navbar navbar-extends-lg navbar-dark bg-primary">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">Clonar Permissão de Tela</a>                    
                </div>
            </nav>

            <br />

            <form name="frmClonagemPermissaoTela" id="frmClonagemPermissaoTela" method="POST" action="index.php?pag=<?php echo @$_GET["pag"] ?>">
                <div class="row">
                    <label for="txtCodUsuarioDe" class="col-sm-2 col-form-label">Usuário Clonado:</label>
                    <div class="col-sm-2">
                        <div class="input-group">
                            <input type="text" id="txtCodUsuarioDe" name="txtCodUsuarioDe" class="form-control form-control-sm" aria-label="" aria-describedby="btnUsuarioDe" readonly="readonly" style="text-align: right;" required>
                            <button class="btn btn-outline-secondary btn-sm" type="button" id="btnUsuarioDe" onclick="window.open('busca.php?tipo=13&campocodigo=txtCodUsuarioDe&campodescricao=txtDescUsuarioDe&title=Pesquisar Usuário','','width=900, height=500')">...</button>
                        </div>
                    </div>
                    <div class="col-sm-7">
                        <input type="text" id="txtDescUsuarioDe" name="txtDescUsuarioDe" class="form-control form-control-sm" readonly="readonly"/>
                    </div>
                    <div class="col-sm-1">
                        <button type="button" class="btn btn-primary btn-sm" id="btnLimparUsuarioDe" name="btnLimparUsuarioDe" onclick="limparUsuarioDe()">Limpar</button>
                    </div>
                </div>
                <div class="row">
                    <label for="txtCodUsuarioPara" class="col-sm-2 col-form-label">Usuário Clonador:</label>
                    <div class="col-sm-2">
                        <div class="input-group">
                            <input type="text" id="txtCodUsuarioPara" name="txtCodUsuarioPara" class="form-control form-control-sm" aria-label="" aria-describedby="btnUsuarioPara" readonly="readonly" style="text-align: right;" required>
                            <button class="btn btn-outline-secondary btn-sm" type="button" id="btnUsuarioPara" onclick="window.open('busca.php?tipo=13&campocodigo=txtCodUsuarioPara&campodescricao=txtDescUsuarioPara&title=Pesquisar Usuário','','width=900, height=500')">...</button>
                        </div>
                    </div>
                    <div class="col-sm-7">
                        <input type="text" id="txtDescUsuarioPara" name="txtDescUsuarioPara" class="form-control form-control-sm" readonly="readonly"/>
                    </div>
                    <div class="col-sm-1">
                        <button type="button" class="btn btn-primary btn-sm" id="btnLimparUsuarioPara" name="btnLimparUsuarioPara" onclick="limparUsuarioPara()">Limpar</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2">
                        <button type="submit" class="btn btn-primary btn-sm" id="btnPesquisar" name="btnPesquisar"><i class="fa fa-search" aria-hidden="true"></i>Realizar Clonagem</button>
                    </div>
                </div>

                <?php
                if (isset($_POST["btnPesquisar"])) {
                    try{
                        $ctr->clonarPermissaoTelas($_POST["txtCodUsuarioDe"], $_POST["txtCodUsuarioPara"]);
                        echo "<script>alert('Permissões clonadas com sucesso.');</script>";
                    } catch(Exception $e){
                        echo "<script>alert('Erro ao clonar as permissões. Erro: " . $e->getMessage() . "');</script>";
                    }
                }
                ?>
            </form>
        </div>
    </body>
</html>