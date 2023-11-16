<?php
require_once("../controllers/financeirocontroller.php");
require_once("../helpers/funcoes.php");

$ctrFinanceiro = new FinanceiroController();
$funcao = new Funcoes();
?>

<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script>
            function limparPacientePesq(){
                document.getElementById("txtCodPacientePesq").value = "";
                document.getElementById("txtDescPacientePesq").value = "";
            }

            function limparPacienteCad(){
                document.getElementById("txtCodPaciente").value = "";
                document.getElementById("txtDescPaciente").value = "";
            }
        </script>
    </head>
    <body>
        <div class="container-fluid">
            <nav class="navbar navbar-extends-lg navbar-dark bg-primary">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">Solicitação de Notas</a>
                    <div class="btn-group dropstart">
                        <button type="button" class="btn btn-success btn-sm" onclick="abrirSolicitacaoNota()">Adicionar</button>
                    </div>
                </div>
            </nav>

            <br/>

            <form name="frmSolicitarCompra" id="frmSolicitarCompra" method="POST" action="index.php?pag=8">
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
                    <label for="txtCodPacientePesq" class="col-sm-2 col-form-label">Paciente:</label>
                    <div class="col-sm-2">
                        <div class="input-group">
                            <input type="text" id="txtCodPacientePesq" name="txtCodPacientePesq" class="form-control form-control-sm" aria-label="" aria-describedby="btnPesqMatMedPesq" readonly="readonly" value="<?php echo @$_POST["txtCodPacientePesq"] ?>" style="text-align: right;" required>
                            <button class="btn btn-outline-secondary btn-sm" type="button" id="btnPesqPacientePesq" onclick="window.open('busca.php?tipo=12&campocodigo=txtCodPacientePesq&campodescricao=txtDescPacientePesq&title=Pesquisar Paciente','','width=900, height=500')">...</button>
                        </div>
                    </div>
                    <div class="col-sm-7">
                        <input type="text" id="txtDescPacientePesq" name="txtDescPacientePesq" class="form-control form-control-sm" value="<?php echo @$_POST["txtDescPacientePesq"] ?>" readonly="readonly"/>
                    </div>
                    <div class="col-sm-1">
                        <button type="button" class="btn btn-primary btn-sm" id="btnLimparPacientePesq" name="btnLimparPacientePesq" onclick="limparPacientePesq()">Limpar</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2">
                        <button type="submit" class="btn btn-primary btn-sm" id="btnPesquisar" name="btnPesquisar">Pesquisar</button>
                    </div>
                </div>

                <?php
                if (isset($_POST["btnPesquisar"])){
                    $qry = $ctrFinanceiro->listarSolicitacaoNota('', @$_POST["txtDataInicioPesq"], @$_POST["txtDataFimPesq"], 'N', @$_POST["txtCodPacientePesq"]);

                    if (count($qry) > 0){
                        ?>
                        <br/>
                        <table class="table table-bordered table-sm" id="table">
                            <thead>
                                <tr class="align-middle">
                                    <th scope="col" style="display: none;">Código</th>   
                                    <th scope="col">Cliente</th>
                                    <th scope="col">Tipo</th>
                                    <th scope="col">Data Solic.</th>
                                    <th scope="col">Data Máxima</th>
                                    <th scope="col">Data Baixa</th>
                                    <th scope="col">Duração</th>
                                    <th scope="col">Solicitante</th>                                    
                                    <th scope="col">Observação</th>
                                    <td style="display: none;">Id Solicitante</td>  
                                    <td style="display: none;">Id Paciente</td>  
                                    <td style="display: none;">Valor</td>  
                                    <th scope="col">Ações</th>                                     
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $contador = 0;
                                foreach($qry as $lista){
                                    ?>
                                    <tr class="align-middle">
                                        <td style="display: none;"><?php echo $lista["ID"] ?></td>
                                        <td><?php echo $lista["NMPACIENTE"]?></td>
                                        <td><?php echo $lista["NMTIPO"]?></td>
                                        <td><?php echo $lista["DT_SOLIC"]?></td>
                                        <td>
                                            <?php
                                            if ($lista["TIPO"] == "N"){
                                                $dataMaxima = $funcao->retornarDataHoraUtil($lista["DT_SOLIC"], 8);
                                            } else if ($lista["TIPO"] == "C"){
                                                $dataMaxima = $funcao->retornarDataHoraUtil($lista["DT_SOLIC"], 24);
                                            } else {
                                                $dataMaxima = date("d/m/Y H:i:s"); 
                                            }
                                            echo $dataMaxima;
                                            ?>
                                        </td>
                                        <td><?php echo $lista["DT_CONF"]?></td>
                                        <td>
                                            <?php
                                            if($lista["DT_CONF"] != null){
                                                if ($lista["STATUS"] == "A"){
                                                    $xdata = date("d/m/Y H:i:s");
                                                } else {
                                                    $xdata = $lista["DT_CONF"];
                                                }
                                                $inicio = DateTime::createFromFormat('d/m/Y H:i:s', $lista["DT_SOLIC"]);
                                                $fim = DateTime::createFromFormat('d/m/Y H:i:s', $xdata);
                                                $intervaloUtil = $inicio->format('d') - $fim->format('d');
                                                if($intervaloUtil != 0){
                                                    $dataInicial = $funcao->retornarDataHoraUtil($xdata, 6);
                                                    $dataFinal = $funcao->retornarDataHoraUtil($lista["DT_SOLIC"], 6);
                                                    echo $funcao->retornarDiferencaDataHoraUtil($lista["DT_SOLIC"], $xdata);
                                                } else {
                                                    echo $funcao->retornarDiferencaDataHora($lista["DT_SOLIC"], $xdata);
                                                }
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo $lista["NMUSU_SOLIC"]?></td>
                                        <td><?php echo $lista["OBS_SOLIC"]?></td>
                                        <td style="display: none;"><?php echo $lista["IDUSU_SOLIC"] ?></td>
                                        <td style="display: none;"><?php echo $lista["IDPARTCONV"] ?></td>
                                        <td style="display: none;"><?php echo $lista["VALOR"] ?></td>
                                        <td style="text-align: center;">
                                            <?php
                                            if ($lista["STATUS"] == "A"){
                                                ?>
                                                <a href="#" class="btn btn-success btn-sm" onclick="abrirAlteracaoNota(this)">Alterar</a>
                                                <a href="#" class="btn btn-danger btn-sm" onclick="abrirExclusaoNota(this)">Excluir</a>
                                                <?php
                                            } else {
                                                echo "BAIXADO";
                                            }
                                            ?>
                                        </td>
                                        
                                    </tr>
                                    <?php
                                    $contador++;
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

        <div class="modal fade" id="modalSolicitarNota" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Solicitar Nota Fiscal</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="formAdicionarNota" method="POST">
                        <input type="hidden" id="txtIdUsuario" name="txtIdUsuario" value="<?php echo $_SESSION["ID_USUARIO"] ?>" />
                        <input type="hidden" id="txtCodigo" name="txtCodigo" value="0" />
                        <div class="modal-body">
                            <div class="row">
                                <label for="txtCodPaciente" class="col-sm-2 col-form-label">Paciente:</label>
                                <div class="col-sm-2">
                                    <div class="input-group">
                                        <input type="text" id="txtCodPaciente" name="txtCodPaciente" class="form-control form-control-sm" aria-label="" aria-describedby="btnPesqPaciente" readonly="readonly" style="text-align: right;" required>
                                        <button class="btn btn-outline-secondary btn-sm" type="button" id="btnPesqPaciente" onclick="window.open('busca.php?tipo=12&campocodigo=txtCodPaciente&campodescricao=txtDescPaciente&title=Pesquisar Paciente','','width=900, height=500')">...</button>
                                    </div>
                                </div>
                                <div class="col-sm-7">
                                    <input type="text" id="txtDescPaciente" name="txtDescPaciente" class="form-control form-control-sm" readonly="readonly"/>
                                </div>
                                <div class="col-sm-1">
                                    <button type="button" class="btn btn-primary btn-sm" id="btnLimparPaciente" name="btnLimparPaciente" onclick="limparPacienteCad()">Limpar</button>
                                </div>
                            </div>
                            <div class="row">
                                <label for="txtValorNota" class="col-sm-2 col-form-label">Valor da Nota:</label>
                                <div class="col-sm-4">
                                    <input type="number" style="text-align: right;" step="0.01" min="0.01" id="txtValor" name="txtValor" class="form-control form-control-sm" />
                                </div>                                
                            </div>
                            <div class="row">
                                <label for="txtObservacao" class="col-sm-2 col-form-label">Observação:</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control form-control-sm" id="txtObservacao" name="txtObservacao" style="height: 100px" maxlength="500" required></textarea>
                                </div>                                
                            </div>
                            <small>
                                <div id="mensagem" align="center"></div>
                            </small>                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="btn-fechar-solicitar" name="btn-fechar-solicitar" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Sair</button>
                            <button type="submit" id="btn-gravar-solicitar" name="btn-gravar-solicitar" class="btn btn-primary btn-sm">Gravar</button>
                        </div>
                    </form>                               
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalAlterarNota" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Alterar Nota Fiscal</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="formAlterarNota" method="POST">                        
                        <input type="hidden" id="txtCodigoAlt" name="txtCodigoAlt" />
                        <div class="modal-body">
                            <div class="row">
                                <label for="txtCodSolicitanteAlt" class="col-sm-2 col-form-label">Solicitante:</label>
                                <div class="col-sm-2">
                                    <input type="text" style="text-align: right;" id="txtCodSolicitanteAlt" name="txtCodSolicitanteAlt" class="form-control form-control-sm" readonly="readonly"/>
                                </div>                  
                                <div class="col-sm-8">
                                    <input type="text" id="txtDescSolicitanteAlt" name="txtDescSolicitanteAlt" class="form-control form-control-sm" readonly="readonly"/>
                                </div>
                            </div>
                            <div class="row">
                                <label for="txtCodPacienteAlt" class="col-sm-2 col-form-label">Paciente:</label>
                                <div class="col-sm-2">
                                    <div class="input-group">
                                        <input type="text" id="txtCodPacienteAlt" name="txtCodPacienteAlt" class="form-control form-control-sm" aria-label="" aria-describedby="btnPesqPacienteAlt" readonly="readonly" style="text-align: right;" required>
                                        <button class="btn btn-outline-secondary btn-sm" type="button" id="btnPesqPacienteAlt" onclick="window.open('busca.php?tipo=12&campocodigo=txtCodPacienteAlt&campodescricao=txtDescPacienteAlt&title=Pesquisar Paciente','','width=900, height=500')">...</button>
                                    </div>
                                </div>
                                <div class="col-sm-7">
                                    <input type="text" id="txtDescPacienteAlt" name="txtDescPacienteAlt" class="form-control form-control-sm" readonly="readonly"/>
                                </div>
                                <div class="col-sm-1">
                                    <button type="button" class="btn btn-primary btn-sm" id="btnLimparPacienteAlt" name="btnLimparPacienteAlt" onclick="limparPacienteAlt()">Limpar</button>
                                </div>
                            </div>
                            <div class="row">
                                <label for="txtValorNota" class="col-sm-2 col-form-label">Valor da Nota:</label>
                                <div class="col-sm-4">
                                    <input type="number" style="text-align: right;" step="0.01" min="0.01" id="txtValorAlt" name="txtValorAlt" class="form-control form-control-sm" />
                                </div>                                
                            </div>
                            <div class="row">
                                <label for="txtObservacao" class="col-sm-2 col-form-label">Observação:</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control form-control-sm" id="txtObservacaoAlt" name="txtObservacaoAlt" style="height: 100px" maxlength="500" required></textarea>
                                </div>                                
                            </div>
                            <small>
                                <div id="mensagemAlt" align="center"></div>
                            </small>                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="btn-fechar-solicitar-alt" name="btn-fechar-solicitar-alt" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Sair</button>
                            <button type="submit" id="btn-gravar-solicitar-alt" name="btn-gravar-solicitar-alt" class="btn btn-primary btn-sm">Gravar</button>
                        </div>
                    </form>                               
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalExcluirNota" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Excluir Nota Fiscal</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="formExcluirNota" method="POST">                        
                        <input type="hidden" id="txtCodigoExc" name="txtCodigoExc" />
                        <input type="hidden" id="txtIdUsuarioExc" name="txtIdUsuarioExc" value="<?php echo $_SESSION["ID_USUARIO"] ?>" />
                        <div class="modal-body">
                            <div class="row">
                                <label for="txtObservacaoExc" class="col-sm-2 col-form-label">Observação:</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control form-control-sm" id="txtObservacaoExc" name="txtObservacaoExc" style="height: 100px" maxlength="500" required></textarea>
                                </div>                                
                            </div>
                            <small>
                                <div id="mensagemExc" align="center"></div>
                            </small>                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="btn-fechar-solicitar-exc" name="btn-fechar-solicitar-exc" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Sair</button>
                            <button type="submit" id="btn-gravar-solicitar-exc" name="btn-gravar-solicitar-exc" class="btn btn-primary btn-sm">Gravar</button>
                        </div>
                    </form>                               
                </div>
            </div>
        </div>
    </body>
</html>

<script>
    function abrirSolicitacaoNota(){
        limparCamposCadastro();
        $("#mensagem").text("");
        $("#mensagem").removeClass();

        var myModal = new bootstrap.Modal(document.getElementById("modalSolicitarNota"), {});
        myModal.show();
    }

    function limparCamposCadastro(){
        document.getElementById('txtCodPaciente').value = "";
        document.getElementById('txtDescPaciente').value = "";
        document.getElementById('txtValor').value = "";
        document.getElementById('txtObservacao').value = "";
    }

    $("#formAdicionarNota").submit(function(){
        event.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "solicitacaonotafiscal_mov.php?tipo=N",
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

    function abrirAlteracaoNota(linha){
        var tableData = $(linha).closest("tr").find("td:not(:last-child)").map(function(){
            return $(this).text().trim();
        }).get();

        //console.log(tableData);
        $("#txtCodigoAlt").val(tableData[0]);
        $("#txtCodSolicitanteAlt").val(tableData[9]);
        $("#txtDescSolicitanteAlt").val(tableData[7]);
        $("#txtCodPacienteAlt").val(tableData[10]);
        $("#txtDescPacienteAlt").val(tableData[1]);
        $("#txtValorAlt").val(tableData[11]);
        $("#txtObservacaoAlt").val(tableData[8]);

        $("#mensagemAlt").text("");
        $("#mensagemAlt").removeClass();

        var myModal = new bootstrap.Modal(document.getElementById("modalAlterarNota"), {});
        myModal.show();
    }

    $("#formAlterarNota").submit(function(){
        event.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "solicitacaonotafiscal_mov.php?tipo=",
            type: "POST",
            data: formData, 

            success: function(mensagem){
                $("#mensagemAlt").text("");
                $("#mensagemAlt").removeClass();
                if (mensagem.trim() == "Incluído com sucesso."){
                    window.location.reload(true);
                    $("#btn-fechar-solicitar-alt").click();                            
                } else {
                    $("#mensagemAlt").addClass("text-danger")
                    $("#mensagemAlt").text(mensagem);
                }
            },

            cache: false,
            contentType: false,
            processData: false,
        });
    });

    function abrirExclusaoNota(linha){
        var tableData = $(linha).closest("tr").find("td:not(:last-child)").map(function(){
            return $(this).text().trim();
        }).get();

        $("#txtCodigoExc").val(tableData[0]);
        
        $("#mensagemExc").text("");
        $("#mensagemExc").removeClass();

        var myModal = new bootstrap.Modal(document.getElementById("modalExcluirNota"), {});
        myModal.show();
    }

    $("#formExcluirNota").submit(function(){
        event.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "solicitacaonotafiscal_mov.php?tipo=X",
            type: "POST",
            data: formData, 

            success: function(mensagem){
                $("#mensagemExc").text("");
                $("#mensagemExc").removeClass();
                if (mensagem.trim() == "Incluído com sucesso."){
                    window.location.reload(true);
                    $("#btn-fechar-solicitar-exc").click();                            
                } else {
                    $("#mensagemExc").addClass("text-danger")
                    $("#mensagemExc").text(mensagem);
                }
            },

            cache: false,
            contentType: false,
            processData: false,
        });
    });
</script>