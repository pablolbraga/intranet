<?php
require_once("../helpers/contantes.php");
require_once("../controllers/notafiscalcontroller.php");

$listaTipo = Constantes::$arrayTipoNotaFiscal;
$ctr = new NotaFiscalController();
?>

<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script>
            function limparPacientePesq(){
                document.getElementById("txtCodClientePesq").value = "";
                document.getElementById("txtDescClientePesq").value = "";
            }

            function limparPacienteCad(){
                document.getElementById("txtCodCliente").value = "";
                document.getElementById("txtDescCliente").value = "";
            }
        </script>
    </head>
    <body>
        <div class="container-fluid">
            <nav class="navbar navbar-extends-lg navbar-dark bg-primary">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">Notas Fiscais</a>
                    <div class="btn-group dropstart">
                        <button type="button" class="btn btn-success btn-sm" onclick="adicionarNota()">Adicionar</button>
                    </div>
                </div>
            </nav>

            <br/>

            <form name="frmNotaFiscal" id="frmNotaFiscal" method="POST" action="index.php?pag=<?php echo $_REQUEST["pag"] ?>">
                <div class="row">
                    <label for="txtCodClientePesq" class="col-sm-2 col-form-label">Cliente:</label>
                    <div class="col-sm-2">
                        <div class="input-group">
                            <input type="text" id="txtCodClientePesq" name="txtCodClientePesq" class="form-control form-control-sm" aria-label="" aria-describedby="btnPesqClientePesq" readonly="readonly" value="<?php echo @$_POST["txtCodClientePesq"] ?>" style="text-align: right;">
                            <button class="btn btn-outline-secondary btn-sm" type="button" id="btnPesqClientePesq" onclick="window.open('busca.php?tipo=12&campocodigo=txtCodClientePesq&campodescricao=txtDescClientePesq&title=Pesquisar Cliente','','width=900, height=500')">...</button>
                        </div>
                    </div>
                    <div class="col-sm-7">
                        <input type="text" id="txtDescClientePesq" name="txtDescClientePesq" class="form-control form-control-sm" value="<?php echo @$_POST["txtDescClientePesq"] ?>" readonly="readonly"/>
                    </div>
                    <div class="col-sm-1">
                        <button type="button" class="btn btn-primary btn-sm" id="btnLimparClientePesq" name="btnLimparClientePesq" onclick="limparClientePesq()">Limpar</button>
                    </div>
                </div>
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
                    <label for="cmbTipoPesq" class="col-sm-2 col-form-label">Tipo:</label>
                    <div class="col-sm-2">
                        <select class="form-select form-select-sm" id="cmbTipoPesq" name="cmbTipoPesq">
                            <?php
                            for($lt = 0; $lt < count($listaTipo); $lt++){
                                if ($listaTipo[$lt]["ID"] == $_POST["cmbTipoPesq"]){ $selTipoPesq = "selected"; } else { $selTipoPesq = ""; }
                                ?>
                                <option <?php echo $selTipoPesq ?> value="<?php echo $listaTipo[$lt]["ID"] ?>"><?php echo $listaTipo[$lt]["NOME"] ?></option>
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
                    $lista = $ctr->listarNotasFiscais($_POST["txtDescClientePesq"], $_POST["txtDataInicioPesq"], $_POST["txtDataFimPesq"], $_POST["cmbTipoPesq"]);
                    $qtde = count($lista);
                    if ($qtde > 0){
                        ?>
                        <br/>
                        <table class="table table-bordered table-sm" id="table">
                            <thead>
                                <tr class="align-middle">
                                    <th scope="col" style="display: none;">Código</th> 
                                    <th scope="col">Cliente</th> 
                                    <th scope="col" style="display: none;">Tipo</th> 
                                    <th scope="col">Desc. Tipo</th> 
                                    <th scope="col">Nota Fiscal</th> 
                                    <th scope="col">Serviço</th> 
                                    <th scope="col">Data de Emissão</th> 
                                    <th scope="col">Valor</th> 
                                    <th scope="col">IRRF</th> 
                                    <th scope="col">ISS</th> 
                                    <th scope="col">COFINS</th> 
                                    <th scope="col">PIS</th> 
                                    <th scope="col">CSLL</th> 
                                    <th scope="col">Sub-Total</th> 
                                    <th scope="col">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                for ($i = 0; $i < $qtde; $i++){
                                    $soma = $lista[$i]["VALOR"]  - $lista[$i]["IRRF"] - $lista[$i]["ISS"] - $lista[$i]["CONFINS"] - $lista[$i]["PIS"] - $lista[$i]["CSLL"];
                                    ?>
                                    <tr class="align-middle">
                                        <td style="display: none;"><?php echo $lista[$i]["ID"] ?></td>
                                        <td><?php echo $lista[$i]["CLIENTE"] ?></td>
                                        <td style="display: none;"><?php echo $lista[$i]["TIPO"] ?></td>
                                        <td><?php echo $lista[$i]["NMTIPO"] ?></td>
                                        <td><?php echo $lista[$i]["NOTAFISCAL"] ?></td>
                                        <td><?php echo $lista[$i]["SERVICO"] ?></td>
                                        <td><?php echo $lista[$i]["DATAEMISSAOFORM"] ?></td>
                                        <td style="text-align: right;"><?php echo number_format($lista[$i]["VALOR"],'2',',','.') ?></td>
                                        <td style="text-align: right;"><?php echo number_format($lista[$i]["IRRF"],'2',',','.') ?></td>
                                        <td style="text-align: right;"><?php echo number_format($lista[$i]["ISS"],'2',',','.') ?></td>
                                        <td style="text-align: right;"><?php echo number_format($lista[$i]["CONFINS"],'2',',','.') ?></td>
                                        <td style="text-align: right;"><?php echo number_format($lista[$i]["PIS"],'2',',','.') ?></td>
                                        <td style="text-align: right;"><?php echo number_format($lista[$i]["CSLL"],'2',',','.') ?></td>
                                        <td style="text-align: right;"><?php echo number_format($soma,'2',',','.') ?></td>
                                        <td style="text-align: center;">                                            
                                            <a href="#" class="btn btn-success btn-sm" onclick="abrirAlteracaoNotaFiscal(this)"><i class="fa fa-pencil" aria-hidden="true"></i> Alterar</a>
                                            <a href="#" class="btn btn-danger btn-sm" onclick="abrirExclusaoNotaFiscal(this)"><i class="fa fa-trash" aria-hidden="true"></i> Excluir</a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
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

<!-- Modal de Cadastro -->
<div class="modal fade" id="modalAdicionarNotaFiscal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Nota Fiscal</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formAdicionarUsuario" method="POST">
                <input type="hidden" id="txtCodigoNotaFiscal" name="txtCodigoNotaFiscal" value="0" />
                <input type="hidden" id="txtCodUsuario" name="txtCodUsuario" value="<?php echo $_SESSION["ID_USUARIO"] ?>" />
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="txtCliente" class="form-label form-label-sm">Cliente</label>
                            <input type="text" class="form-control form-control-sm" id="txtCliente" name="txtCliente" value="" maxlength="200" required />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label for="cmbTipo" class="form-label form-label-sm">Tipo</label>
                            <select class="form-select form-select-sm" id="cmbTipo" name="cmbTipo">
                                <?php
                                for($t = 0; $t < count($listaTipo); $t++){
                                    ?>
                                    <option value="<?php echo $listaTipo[$t]["ID"] ?>"><?php echo $listaTipo[$t]["NOME"] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="txtNotaFiscal" class="form-label form-label-sm">Nota Fiscal</label>
                            <input type="number" class="form-control form-control-sm" id="txtNotaFiscal" name="txtNotaFiscal" value="" required />
                        </div>
                        <div class="col-md-3">
                            <label for="txtServico" class="form-label form-label-sm">Serviço</label>
                            <input type="text" class="form-control form-control-sm" id="txtServico" name="txtServico" value="" required />
                        </div>
                        <div class="col-md-3">
                            <label for="txtDataEmissao" class="form-label form-label-sm">Data de Emissão</label>
                            <input type="text" class="form-control form-control-sm" id="txtDataEmissao" name="txtDataEmissao" value="" placeholder="dd/mm/yyyy" onkeypress="mascaraData(this)" required />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <label for="txtValorNota" class="form-label form-label-sm">Valor da Nota</label>
                            <input type="text" class="form-control form-control-sm" style="text-align: right;" id="txtValorNota" name="txtValorNota" value="" data-max-digits="15" maxlength="20" required />
                        </div>
                        <div class="col-md-2">
                            <label for="txtIrrf" class="form-label form-label-sm">IRRF</label>
                            <input type="text" class="form-control form-control-sm" style="text-align: right;" id="txtIrrf" name="txtIrrf" value="" data-max-digits="15" maxlength="20" required />
                        </div>
                        <div class="col-md-2">
                            <label for="txtIss" class="form-label form-label-sm">ISS</label>
                            <input type="text" class="form-control form-control-sm" style="text-align: right;" id="txtIss" name="txtIss" value="" data-max-digits="15" maxlength="20" required />
                        </div>
                        <div class="col-md-2">
                            <label for="txtCofins" class="form-label form-label-sm">COFINS</label>
                            <input type="text" class="form-control form-control-sm" style="text-align: right;" id="txtCofins" name="txtCofins" value="" data-max-digits="15" maxlength="20" required />
                        </div>
                        <div class="col-md-2">
                            <label for="txtPis" class="form-label form-label-sm">PIS</label>
                            <input type="text" class="form-control form-control-sm" style="text-align: right;" id="txtPis" name="txtPis" value="" data-max-digits="15" maxlength="20" required />
                        </div>
                        <div class="col-md-2">
                            <label for="txtCsll" class="form-label form-label-sm">CSLL</label>
                            <input type="text" class="form-control form-control-sm" style="text-align: right;" id="txtCsll" name="txtCsll" value="" data-max-digits="15" maxlength="20" required />
                        </div>
                    </div>
                    <small>
                        <div id="mensagem" align="center"></div>
                    </small>                            
                </div>
                <div class="modal-footer">
                    <button type="button" id="btn-fechar-solicitar" name="btn-fechar-solicitar" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="fa fa-sign-out" aria-hidden="true"></i> Sair</button>
                    <button type="submit" id="btn-gravar-solicitar" name="btn-gravar-solicitar" class="btn btn-primary btn-sm"><i class="fa fa-floppy-o" aria-hidden="true"></i> Gravar</button>
                </div>
            </form>                               
        </div>
    </div>
</div>

<!-- Modal de Cadastro -->
<div class="modal fade" id="modalExcluirNotaFiscal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Excluir</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formExcluirNotaFiscal" method="POST">
                <input type="hidden" id="txtCodigoNotaFiscalExc" name="txtCodigoNotaFiscalExc" value="0" />
                <input type="hidden" id="txtCodUsuarioExc" name="txtCodUsuarioExc" value="<?php echo $_SESSION["ID_USUARIO"] ?>" />
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="txtMotivoExc" class="form-label form-label-sm">Motivo da Exclusão</label>
                            <input type="text" class="form-control form-control-sm" id="txtMotivoExc" name="txtMotivoExc" value="" maxlength="500" required />
                        </div>
                    </div>
                    <small>
                        <div id="mensagemExc" align="center"></div>
                    </small>                            
                </div>
                <div class="modal-footer">
                    <button type="button" id="btn-fechar-excluir" name="btn-fechar-excluir" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="fa fa-sign-out" aria-hidden="true"></i> Sair</button>
                    <button type="submit" id="btn-gravar-excluir" name="btn-gravar-excluir" class="btn btn-primary btn-sm"><i class="fa fa-floppy-o" aria-hidden="true"></i> Gravar</button>
                </div>
            </form>                               
        </div>
    </div>
</div>

<script>
    // usa vírgula como separador decimal, ponto como separador de milhar, sempre com 2 casas decimais
    const formatter = new Intl.NumberFormat('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

    function mask(e) {
        const input = e.target;
        // elimina tudo que não é dígito
        input.value = input.value.replace(/\D+/g, '');
        if (input.value.length === 0) // se não tem nada preenchido, não tem o que fazer
            return;
        // verifica se ultrapassou a quantidade máxima de dígitos (pegar o valor no dataset)
        const maxDigits = parseInt(input.dataset.maxDigits);
        if (input.value.length > maxDigits) {
            // O que fazer nesse caso? Decidi pegar somente os primeiros dígitos
            input.value = input.value.substring(0, maxDigits);
        }
        // lembrando que o valor é a quantidade de centavos, então precisa dividir por 100
        input.value = formatter.format(parseInt(input.value) / 100);
    }

    document.querySelector('#txtValorNota').addEventListener('input', mask);
    document.querySelector('#txtIrrf').addEventListener('input', mask);
    document.querySelector('#txtIss').addEventListener('input', mask);
    document.querySelector('#txtCofins').addEventListener('input', mask);
    document.querySelector('#txtPis').addEventListener('input', mask);
    document.querySelector('#txtCsll').addEventListener('input', mask);


    function adicionarNota(){
        limparCamposCadastro();
        $("#mensagem").text("");
        $("#mensagem").removeClass();

        var myModal = new bootstrap.Modal(document.getElementById("modalAdicionarNotaFiscal"), {});
        myModal.show();
    }

    function abrirAlteracaoNotaFiscal(linha){
        var tableData = $(linha).closest("tr").find("td:not(:last-child)").map(function(){
            return $(this).text().trim();
        }).get();

        //console.log(tableData);
        $("#txtCodigo").val(tableData[0])
        $("#txtCliente").val(tableData[1]);
        $("#cmbTipo").val(tableData[2]);
        $("#txtNotaFiscal").val(tableData[4]);
        $("#txtServico").val(tableData[5]);
        $("#txtDataEmissao").val(tableData[6]);
        $("#txtValorNota").val(tableData[7]);
        $("#txtIrrf").val(tableData[8]);
        $("#txtIss").val(tableData[9]);
        $("#txtCofins").val(tableData[10]);
        $("#txtPis").val(tableData[11]);
        $("#txtCsll").val(tableData[12]);

        $("#mensagem").text("");
        $("#mensagem").removeClass();

        var myModal = new bootstrap.Modal(document.getElementById("modalAdicionarNotaFiscal"), {});
        myModal.show();
    }

    function abrirExclusaoNotaFiscal(linha){
        var tableData = $(linha).closest("tr").find("td:not(:last-child)").map(function(){
            return $(this).text().trim();
        }).get();

        $("#txtCodigoNotaFiscalExc").val(tableData[0]);

        $("#mensagemExc").text("");
        $("#mensagemExc").removeClass();

        var myModalExc = new bootstrap.Modal(document.getElementById("modalExcluirNotaFiscal"), {});
        myModalExc.show();
    }

    function limparCamposCadastro(){
        $("#txtCliente").val("");
        $("#cmbTipo").val("");
        $("#txtNotaFiscal").val("");
        $("#txtServico").val("");
        $("#txtDataEmissao").val("");
        $("#txtValorNota").val("");
        $("#txtIrrf").val("");
        $("#txtIss").val("");
        $("#txtCofins").val("");
        $("#txtPis").val("");
        $("#txtCsll").val("");
    }

    $("#formAdicionarUsuario").submit(function(){
        event.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "notafiscal_mov.php?tipo=N",
            type: "POST",
            data: formData, 

            success: function(mensagem){
                $("#mensagem").text("");
                $("#mensagem").removeClass();
                if (mensagem.trim() == "Incluído com sucesso."){
                    window.location.reload(true);
                    $("#btn-fechar-solicitar").click();                            
                } else {
                    $("#mensagem").addClass("text-danger")
                    $("#mensagem").text(mensagem);
                }
            },

            cache: false,
            contentType: false,
            processData: false,
        });
    });

    $("#formExcluirNotaFiscal").submit(function(){
        event.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "notafiscal_mov.php?tipo=X",
            type: "POST",
            data: formData, 

            success: function(mensagem){
                $("#mensagemExc").text("");
                $("#mensagemExc").removeClass();
                if (mensagem.trim() === "Excluído com sucesso."){
                    window.location.reload(true);
                    $("#btn-fechar-excluir").click(); 
                } else {
                    $("#mensagemExc").addClass("text-danger");
                    $("#mensagemExc").text(mensagem);
                }
            },

            cache: false,
            contentType: false,
            processData: false
        });
    });
</script>