<?php
require_once("../controllers/orcamentocontroller.php");
$ctrOrcamento = new OrcamentoController();
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>
        var somenteNumero = function(event) {
            return ((event.charCode >= 48 && event.charCode <= 57) || (event.keyCode == 45 || event.charCode == 46))
        }
    </script>
</head>
    <body>
        <div class="container-fluid">
            <nav class="navbar navbar-extends-lg navbar-dark bg-primary">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">Visualizar Orçamento</a>
                </div>
            </nav>
            <br/>
            <form name="frmOrcamento" id="frmOrcamento" method="POST" action="index.php?pag=7">
                <div class="row">
                    <label for="txtDataInicioPesq" class="col-sm-2 col-form-label">Orçamento/Aditivo:</label>
                    <div class="col-sm-2">
                        <input type="text" id="txtCodOrcamento" name="txtCodOrcamento" class="form-control form-control-sm" style="text-align: right;" value="<?php echo @$_POST["txtCodOrcamento"] ?>" onkeypress="return somenteNumero(event)" required/>
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-sm-2">
                        <button type="submit" class="btn btn-primary btn-sm" id="btnPesquisar" name="btnPesquisar">Pesquisar</button>
                    </div>
                </div>                
            </form>
        </div>
    </body>
</html>