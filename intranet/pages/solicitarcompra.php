<?php
require_once("../helpers/contantes.php");
require_once("../controllers/comprascontroller.php");
$listaStatus = Constantes::$arrStatusSolicitacaoCompra;
$listaUrgencia = Constantes::$arrUrgenciaSolicitacaoCompra;
$ctrCompra = new ComprasController();
?>
<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script>
            function limparMatMed(){
                document.getElementById("txtCodMatMedPesq").value = "";
                document.getElementById("txtDescMatMedPesq").value = "";
            }
            function limparMatMedCad(){
                document.getElementById("txtCodMatMedCad").value = "";
                document.getElementById("txtDescMatMedCad").value = "";
            }
            function limparFornecedor(){
                document.getElementById("txtCodFornecedorPesq").value = "";
                document.getElementById("txtDescFornecedorPesq").value = "";
            }
            $("#txtHoraNecessidadeCad").mask("AB:CD", {
                translation: {
                "A": { pattern: /[0-2]/, optional: false},
                "B": { pattern: /[0-3]/, optional: false},
                "C": { pattern: /[0-5]/, optional: false},
                "D": { pattern: /[0-9]/, optional: false}
                }
            });
            var filtroTeclas = function(event) {
                return ((event.charCode >= 48 && event.charCode <= 57) || (event.keyCode == 45 || event.charCode == 46))
            }
        </script>
        <style>
            .corVermelho{
                background: red;
                color: white;
            }
        </style>        
    </head>
    <body>
        <div class="container-fluid">
            <nav class="navbar navbar-extends-lg navbar-dark bg-primary">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">Solicitação de Compras</a>
                    <div class="btn-group dropstart">
                        <button type="button" class="btn btn-success btn-sm" onclick="abrirSolicitacaoCompra()">Adicionar</button>
                    </div>
                </div>
            </nav>

            <br/>

            <form name="frmSolicitarCompra" id="frmSolicitarCompra" method="POST" action="index.php?pag=5">
                <div class="row">
                    <label for="txtDataInicioPesq" class="col-sm-2 col-form-label">Período:</label>
                    <div class="col-sm-2">
                        <input type="text" id="txtDataInicioPesq" name="txtDataInicioPesq" class="form-control form-control-sm" value="<?php echo @$_POST["txtDataInicioPesq"] ?>" placeholder="dd/mm/yyyy" onkeypress="mascaraData(this)" required/>
                    </div>
                    <div class="col-sm-2">
                        <input type="text" id="txtDataFimPesq" name="txtDataFimPesq" class="form-control form-control-sm" value="<?php echo @$_POST["txtDataFimPesq"] ?>" placeholder="dd/mm/yyyy" onkeypress="mascaraData(this)" required/>
                    </div>
                </div>
                <div class="row">
                    <label for="txtCodMatMedPesq" class="col-sm-2 col-form-label">Material/Medicamento:</label>
                    <div class="col-sm-2">
                        <div class="input-group">
                            <input type="text" id="txtCodMatMedPesq" name="txtCodMatMedPesq" class="form-control form-control-sm" aria-label="" aria-describedby="btnPesqMatMedPesq" readonly="readonly" value="<?php echo @$_POST["txtCodMatMedPesq"] ?>" style="text-align: right;" required>
                            <button class="btn btn-outline-secondary btn-sm" type="button" id="btnPesqMatMedPesq" onclick="window.open('busca.php?tipo=10&campocodigo=txtCodMatMedPesq&campodescricao=txtDescMatMedPesq&title=Pesquisar Material/Medicamento','','width=900, height=500')">...</button>
                        </div>
                    </div>
                    <div class="col-sm-7">
                        <input type="text" id="txtDescMatMedPesq" name="txtDescMatMedPesq" class="form-control form-control-sm" value="<?php echo @$_POST["txtDescMatMedPesq"] ?>" readonly="readonly"/>
                    </div>
                    <div class="col-sm-1">
                        <button type="button" class="btn btn-primary btn-sm" id="btnLimparMatMedPesq" name="btnLimparMatMedPesq" onclick="limparMatMed()">Limpar</button>
                    </div>
                </div>
                <div class="row">
                    <label for="txtCodFornecedorPesq" class="col-sm-2 col-form-label">Fornecedor:</label>
                    <div class="col-sm-2">
                        <div class="input-group">
                            <input type="text" id="txtCodFornecedorPesq" name="txtCodFornecedorPesq" class="form-control form-control-sm" aria-label="" aria-describedby="btnPesqFornecedorPesq" readonly="readonly" value="<?php echo @$_POST["txtCodFornecedorPesq"] ?>" style="text-align: right;" required>
                            <button class="btn btn-outline-secondary btn-sm" type="button" id="btnPesqFornecedorPesq" onclick="window.open('busca.php?tipo=11&campocodigo=txtCodFornecedorPesq&campodescricao=txtDescFornecedorPesq&title=Pesquisar Fornecedor','','width=900, height=500')">...</button>
                        </div>
                    </div>
                    <div class="col-sm-7">
                        <input type="text" id="txtDescFornecedorPesq" name="txtDescFornecedorPesq" class="form-control form-control-sm" value="<?php echo @$_POST["txtDescFornecedorPesq"] ?>" readonly="readonly"/>
                    </div>
                    <div class="col-sm-1">
                        <button type="button" class="btn btn-primary btn-sm" id="btnLimparFornecedor" name="btnLimparFornecedor" onclick="limparFornecedor()">Limpar</button>
                    </div>
                </div>
                <div class="row">
                    <label for="cmbStatusPesq" class="col-sm-2 col-form-label">Status:</label>
                    <div class="col-sm-4">
                        <select class="form-select form-select-sm" id="cmbStatusPesq" name="cmbStatusPesq">
                            <?php
                            for($s = 0; $s < count($listaStatus); $s++){
                                if ($_POST["cmbStatusPesq"] == $listaStatus[$s]["ID"]){ $selected = "selected"; } else { $selected = ""; }
                                ?>
                                <option <?php echo $selected ?> value="<?php echo $listaStatus[$s]["ID"] ?>"><?php echo $listaStatus[$s]["NOME"] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2">
                        <button type="submit" class="btn btn-primary btn-sm" id="btnPesquisar" name="btnPesquisar">Pesquisar</button>
                    </div>
                </div>

                <?php
                if (isset($_POST["btnPesquisar"])){
                    $lista = $ctrCompra->listarCompras($_POST["txtDataInicioPesq"], $_POST["txtDataFimPesq"], $_POST["txtCodMatMedPesq"], $_POST["txtCodFornecedorPesq"], $_POST["cmbStatusPesq"]);
                    $qtd = count($lista);
                    if ($qtd > 0){
                        ?>
                        <br>
                        <table class="table table-bordered table-sm">
                            <thead>
                                <tr>
                                    <th scope="col">Cód. Material</th>
                                    <th scope="col">Desc. Material</th>
                                    <th scope="col">Qtde. Solic.</th>
                                    <th scope="col">Qtde. Comprada</th>
                                    <th scope="col">Qtde. Recebida</th>
                                    <th scope="col">Vr. Unit.</th>
                                    <th scope="col">Parcelas</th>
                                    <th scope="col">Data Pedido</th>
                                    <th scope="col">Data Prev. Chegada</th>
                                    <th scope="col">Data Necessidade</th>
                                    <th scope="col">Data Recebimento</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Nota Fiscal</th>
                                    <th scope="col" style="display: none;">Valor Produto</th>
                                    <th scope="col" style="display: none;">Cód. Fornecedor</th>
                                    <th scope="col" style="display: none;">Desc. Fornecedor</th>
                                    <th scope="col" style="display: none;">ID</th>
                                    <th scope="col">Ações</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $dataped = "";
                                $fornecedor = "";
                                for ($i = 0; $i < $qtd; $i++){
                                    if ($dataped != $lista[$i]["DATA_SOLICITACAO"]){
                                        ?>
                                        <tr class="table-primary align-middle">
                                            <th colspan="15" scope="col">Data do Pedido: <?php echo $lista[$i]["DATA_SOLICITACAO"] ?></th>
                                        </tr>
                                        <?php
                                    }

                                    if ($fornecedor != $lista[$i]["NMFORNECEDOR"]){
                                        ?>
                                        <tr class="table-success align-middle">
                                            <th colspan="15" scope="col">Fornecedor: <?php echo $lista[$i]["NMFORNECEDOR"] ?></th>
                                        </tr>
                                        <?php
                                    }

                                    if(($lista[$i]["QTD_RECEBIDA"] < $lista[$i]["QTD_COMPRADA"]) && ($lista[$i]["NOTAFISCAL"] != "")){
                                        ?>
                                        <tr class="corVermelho align-middle">
                                        <?php
                                    } else {
                                        ?>
                                        <tr class="table-info align-middle">
                                        <?php
                                    }

                                    ?>
                                        <td><?php echo $lista[$i]["COD_MATERIAL"] ?></td>
                                        <td><?php echo $lista[$i]["NOME_COMERCIAL"] ?></td>
                                        <td style="text-align: center;"><?php echo $lista[$i]["QTD_SOLICITADA"] ?></td>
                                        <td style="text-align: center;"><?php echo $lista[$i]["QTD_COMPRADA"] ?></td>
                                        <td style="text-align: center;"><?php echo $lista[$i]["QTD_RECEBIDA"] ?></td>
                                        <td style="text-align: right;"><?php echo  number_format($lista[$i]["VRUNITARIO"], 2, ",", ".") ?></td>
                                        <td style="text-align: center;">
                                            <?php 
                                            $contador = 0;
                                            for ($v = 0; $v < 6; $v++){
                                                if ($lista[$i]["VCT00" . $v+1] != ""){
                                                    if ($contador > 0){ echo ", ";}
                                                    echo $lista[$i]["VCT00" . $v+1] . " - " . number_format($lista[$i]["VAL00" . $v+1], 2, ",", ".");
                                                    $contador++;
                                                }
                                            }
                                            ?>
                                        </td>
                                        <td style="text-align: center;"><?php echo $lista[$i]["DATA_SOLICITACAO"] ?></td>
                                        <td style="text-align: center;"><?php echo $lista[$i]["DATA_PREVISAOCHEGADA"] ?></td>
                                        <td style="text-align: center;"><?php echo $lista[$i]["DATA_NECESSIDADE"] ?></td>
                                        <td style="text-align: center;"><?php echo $lista[$i]["DATA_CHEGADA"] ?></td>
                                        <td style="text-align: center;"><?php echo $lista[$i]["STATUS"] ?></td>
                                        <td style="text-align: center;"><?php echo $lista[$i]["NOTAFISCAL"] ?></td>
                                        <td style="text-align: center; display: none;"><?php echo number_format($lista[$i]["VALOR_PRODUTO"], 2, ',', '.') ?></td>
                                        <td style="text-align: center; display: none;"><?php echo $lista[$i]["IDFORNECEDOR"] ?></td>
                                        <td style="text-align: center; display: none;"><?php echo $lista[$i]["NMFORNECEDOR"] ?></td>
                                        <td style="text-align: center; display: none;"><?php echo $lista[$i]["ID"] ?></td>
                                        <td style="text-align: center;">
                                            <?php 
                                            if($lista[$i]["STATUS"] == "COMPRADO"){
                                                ?>
                                                <a href="#" class="btn btn-primary btn-sm" onclick="abrirVerificacaoCompra(this)">Verificar Compra</a>
                                                <?php
                                            }
                                            ?>
                                        </td>
                                        
                                    </tr>
                                    <?php

                                    $fornecedor = $lista[$i]["NMFORNECEDOR"];
                                    $dataped = $lista[$i]["DATA_SOLICITACAO"];
                                }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th scope="col" colspan="14">Quantidade: <b><?php echo $qtd ?></b></th>
                                </tr>
                            </tfoot>
                        </table>
                        <?php
                    } else {
                        ?>
                        <br />
                        <div class="alert alert-danger" role="alert">
                            Nenhum registro encontrado com os parâmetros informados.
                        </div>
                        <?php
                    }
                }
                ?>
            </form>
        </div>
    </body>
</html>

<div class="modal fade" id="modalVerificarCompra" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Verificar Compra</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formVerificarCompra" method="POST">
                <input type="hidden" name="txtId" id="txtId" />
                <div class="modal-body">
                    <div class="row">
                        <label for="txtNmProduto" class="col-sm-2 col-form-label">Produto:</label>
                        <div class="col-sm-2">                            
                            <input type="text" style="text-align: right;" id="txtCodProduto" name="txtCodProduto" class="form-control form-control-sm" aria-label="" readonly="readonly" required>                            
                        </div>
                        <div class="col-sm-8">
                            <input type="text" id="txtDescProduto" name="txtDescProduto" class="form-control form-control-sm" aria-label="" readonly="readonly" required>                            
                        </div>                        
                    </div>
                    <div class="row">
                        <label for="txtQuantidadeComprada" class="col-sm-2 col-form-label">Quantidade Comprada:</label>
                        <div class="col-sm-2">                            
                            <input type="text" style="text-align: right;" id="txtQuantidadeComprada" name="txtQuantidadeComprada" class="form-control form-control-sm" aria-label="" readonly="readonly" required>                            
                        </div>
                    </div>
                    <div class="row">
                        <label for="txtValorCompra" class="col-sm-2 col-form-label">Vr. Compra:</label>
                        <div class="col-sm-2">                            
                            <input type="text" style="text-align: right;" id="txtValorCompra" name="txtValorCompra" class="form-control form-control-sm" aria-label="" readonly="readonly" required>                            
                        </div>
                    </div>
                    <div class="row">
                        <label for="txtCodFornecedor" class="col-sm-2 col-form-label">Fornecedor:</label>
                        <div class="col-sm-2">                            
                            <input type="text" style="text-align: right;" id="txtCodFornecedor" name="txtCodFornecedor" class="form-control form-control-sm" aria-label="" readonly="readonly" required>                            
                        </div>
                        <div class="col-sm-8">                            
                            <input type="text" style="text-align: left;" id="txtDescFornecedor" name="txtDescFornecedor" class="form-control form-control-sm" aria-label="" readonly="readonly" required>                            
                        </div>
                    </div>
                    <div class="row">
                        <label for="txtDataPrevisao" class="col-sm-2 col-form-label">Data Previsão:</label>
                        <div class="col-sm-2">                            
                            <input type="text" style="text-align: right;" id="txtDataPrevisao" name="txtDataPrevisao" class="form-control form-control-sm" aria-label="" readonly="readonly" required>                            
                        </div>
                    </div>
                    <div class="row">
                        <label for="txtQuantidadeSolicitada" class="col-sm-2 col-form-label">Quantidade Solicitada:</label>
                        <div class="col-sm-2">                            
                            <input type="text" style="text-align: right;" id="txtQuantidadeSolicitada" name="txtQuantidadeSolicitada" class="form-control form-control-sm" aria-label="" readonly="readonly" required>                            
                        </div>
                    </div>
                    <div class="row">
                        <label for="txtNotaFiscal" class="col-sm-2 col-form-label">Nota Fiscal:</label>
                        <div class="col-sm-2">                            
                            <input type="text" style="text-align: left;" id="txtNotaFiscal" name="txtNotaFiscal" class="form-control form-control-sm" aria-label="" required>                            
                        </div>
                    </div>
                    <div class="row">
                        <label for="cbxConsignado" class="col-sm-2 col-form-label">&nbsp;</label>
                        <div class="form-check col-sm-2">
                            <input class="form-check-input form-check-input-sm" type="checkbox" value="S" id="cbxConsignado" name="cbxConsignado">
                            <label class="form-check-label form-check-label-sm" for="cbxConsignado">
                                Consignado
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <label for="cbxRecebido" class="col-sm-2 col-form-label">&nbsp;</label>
                        <div class="form-check col-sm-2">
                            <input class="form-check-input form-check-input-sm" type="checkbox" value="S" id="cbxRecebido" name="cbxRecebido">
                            <label class="form-check-label form-check-label-sm" for="cbxRecebido">
                                Recebido
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <label for="txtObservacao" class="col-sm-2 col-form-label">Observação:</label>
                        <div class="col-sm-10">                            
                            <textarea class="form-control form-control-sm" id="txtObservacao" name="txtObservacao" style="height: 100px" maxlength="500" required></textarea>                         
                        </div>
                    </div>

                    <small>
                        <div id="mensagem-verificarcompra" align="center"></div>
                    </small>

                    
                </div>
                <div class="modal-footer">
                    <button type="button" id="btn-fechar-verificarcompra" name="btn-fechar-verificarcompra" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Sair</button>
                    <button type="submit" class="btn btn-primary btn-sm">Salvar</button>
                </div>
            </form>                               
        </div>
    </div>
</div>

<div class="modal fade" id="modalSolicitarCompra" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Solicitar Compra</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formSolicitarCompra" method="POST">
                <input type="hidden" name="txtId" id="txtId" />
                <input type="hidden" name="txtIdUsuario" id="txtIdUsuario" value="<?php echo $_SESSION["ID_USUARIO"] ?>" />
                <div class="modal-body">
                    <div class="row">
                        <label for="txtCodMatMedCad" class="col-sm-2 col-form-label">Produto:</label>
                        <div class="col-sm-2">
                            <div class="input-group">
                                <input type="text" id="txtCodMatMedCad" name="txtCodMatMedCad" class="form-control form-control-sm" aria-label="" aria-describedby="btnPesqMatMedCad" readonly="readonly" style="text-align: right;" required>
                                <button class="btn btn-outline-secondary btn-sm" type="button" id="btnPesqMatMedCad" onclick="window.open('busca.php?tipo=10&campocodigo=txtCodMatMedCad&campodescricao=txtDescMatMedCad&title=Pesquisar Material/Medicamento','','width=900, height=500')">...</button>
                            </div>
                        </div>
                        <div class="col-sm-7">
                            <input type="text" id="txtDescMatMedCad" name="txtDescMatMedCad" class="form-control form-control-sm" readonly="readonly"/>
                        </div>
                        <div class="col-sm-1">
                            <button type="button" class="btn btn-primary btn-sm" id="btnLimparMatMedCad" name="btnLimparMatMedCad" onclick="limparMatMedCad()">Limpar</button>
                        </div>
                    </div>
                    <div class="row">
                        <label for="txtQuantidadeCad" class="col-sm-2 col-form-label">Quantidade:</label>
                        <div class="col-sm-2">                            
                            <input type="text" style="text-align: right;" id="txtQuantidadeCad" name="txtQuantidadeCad" class="form-control form-control-sm" aria-label="" onkeypress="return filtroTeclas(event)" maxlength="5" required>                            
                        </div>
                    </div>
                    <div class="row">
                        <label for="CmbUrgenciaCad" class="col-sm-2 col-form-label">Urgência:</label>
                        <div class="col-sm-4">
                            <select class="form-select form-select-sm" name="CmbUrgenciaCad" id="CmbUrgenciaCad">
                                <?php
                                for ($u = 0; $u < count($listaUrgencia); $u++){
                                    ?>
                                    <option value="<?php echo $listaUrgencia[$u]["ID"] ?>"><?php echo $listaUrgencia[$u]["NOME"] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <label for="txtDataNecessidadeCad" class="col-sm-2 col-form-label">Data Necessidade:</label>
                        <div class="col-sm-2">                            
                            <input type="text" style="text-align: left;" id="txtDataNecessidadeCad" name="txtDataNecessidadeCad" class="form-control form-control-sm" aria-label="" placeholder="dd/mm/yyyy" onkeypress="mascaraData(this)" >                            
                        </div>
                        <div class="col-sm-2">                            
                            <input type="text" style="text-align: left;" id="txtHoraNecessidadeCad" name="txtHoraNecessidadeCad" class="form-control form-control-sm" aria-label="" placeholder="hh:mm" maxlength="5" >                            
                        </div>
                    </div>
                    
                    <small>
                        <div id="mensagem-solicitarcompra" align="center"></div>
                    </small>

                    
                </div>
                <div class="modal-footer">
                    <button type="button" id="btn-fechar-solicitarcompra" name="btn-fechar-solicitarcompra" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Sair</button>
                    <button type="submit" class="btn btn-primary btn-sm">Salvar</button>
                </div>
            </form>                               
        </div>
    </div>
</div>

<script>
    function abrirVerificacaoCompra(linha){
        var tableData = $(linha).closest("tr").find("td:not(:last-child)").map(function(){
            return $(this).text().trim();
        }).get();

        $("#txtCodProduto").val(tableData[0]);
        $("#txtDescProduto").val(tableData[1]);
        $("#txtQuantidadeComprada").val(tableData[3]);
        $("#txtValorCompra").val(tableData[13]);
        $("#txtCodFornecedor").val(tableData[14]);
        $("#txtDescFornecedor").val(tableData[15]);
        $("#txtDataPrevisao").val(tableData[8]);
        $("#txtQuantidadeSolicitada").val(tableData[2]);
        $("#txtId").val(tableData[16]);

        $("#txtNotaFiscal").val("");
        $("#cbxConsignado").prop("checked", false);
        $("#cbxRecebido").prop("checked", false);
        $("#txtObservacao").val("");

        $("#mensagem-verificarcompra").text("");
        $("#mensagem-verificarcompra").removeClass();

        var myModal = new bootstrap.Modal(document.getElementById("modalVerificarCompra"), {});
        myModal.show();
    }

    $("#formVerificarCompra").submit(function(){
        event.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "solicitarcompra_mov.php?tipo=A",
            type: "POST",
            data: formData, 

            success: function(mensagem){
                
                $("#mensagem-verificarcompra").text("");
                $("#mensagem-verificarcompra").removeClass();
                if (mensagem.trim() == "Incluído com sucesso."){
                    window.location.reload(true);
                    $("#btn-fechar-verificarcompra").click();                            
                } else {
                    $("#mensagem-verificarcompra").addClass("text-danger")
                    $("#mensagem-verificarcompra").text(mensagem);
                }
            },

            cache: false,
            contentType: false,
            processData: false,
        });
    });

    function abrirSolicitacaoCompra(linha){
        
        
        $("#txtCodMatMedCad").val("");
        $("#txtDescMatMedCad").val("");
        $("#txtQuantidadeCad").val("");
        $("#cmbUrgenciaCad").val("");
        $("#txtDataNecessidadeCad").val("");
        $("#txtHoraNecessidadeCad").val("");

        $("#mensagem-solicitarcompra").text("");
        $("#mensagem-solicitarcompra").removeClass();

        var myModal = new bootstrap.Modal(document.getElementById("modalSolicitarCompra"), {});
        myModal.show();
    }

    $("#formSolicitarCompra").submit(function(){
        event.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "solicitarcompra_mov.php?tipo=I",
            type: "POST",
            data: formData, 

            success: function(mensagem){
                
                $("#mensagem-verificarcompra").text("");
                $("#mensagem-verificarcompra").removeClass();
                if (mensagem.trim() == "Incluído com sucesso."){
                    window.location.reload(true);
                    $("#btn-fechar-verificarcompra").click();                            
                } else {
                    $("#mensagem-verificarcompra").addClass("text-danger")
                    $("#mensagem-verificarcompra").text(mensagem);
                }
            },

            cache: false,
            contentType: false,
            processData: false,
        });
    });
</script>