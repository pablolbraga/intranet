<?php
require_once('../controllers/visitascontroller.php');

$ctrVisita = new VisitasController();
?>

<html>
    <head>
        <meta charset="utf-8">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>
    </head>
    <body>

        <div class="container-fluid">
            <nav class="navbar navbar-extends-lg navbar-dark bg-primary">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">Programação de Visitas</a>
                </div>
            </nav>

            <form name="frmTerapia" id="frmTerapia" method="POST" action="index.php?pag=1">

                </br>
                <div class="container-fluid">
                    <div class="row">
                        <label for="txtCodProfissional" class="col-sm-2 col-form-label">Profissional:</label>
                        <div class="col-sm-2">
                            <div class="input-group">
                                <input type="text" id="txtCodProfissional" name="txtCodProfissional" class="form-control form-control-sm" aria-label="" aria-describedby="btnPesqProfissional" readonly="readonly" value="<?php echo @$_POST["txtCodProfissional"] ?>" style="text-align: right;" required>
                                <button class="btn btn-outline-secondary btn-sm" type="button" id="btnPesqProfissional" onclick="window.open('busca.php?tipo=5&campocodigo=txtCodProfissional&campodescricao=txtDescProfissional&title=Pesquisar Profissional','','width=900, height=500')">...</button>
                            </div>
                        </div>
                        <div class="col-sm-7">
                            <input type="text" id="txtDescProfissional" name="txtDescProfissional" class="form-control form-control-sm" value="<?php echo @$_POST["txtDescProfissional"] ?>" readonly="readonly"/>
                        </div>
                        <div class="col-sm-1">
                            <button type="button" class="btn btn-primary btn-sm" id="btnLimparProfissional" name="btnLimparProfissional" onclick="limparProfissional()">Limpar</button>
                        </div>
                    </div>

                    <div class="row">
                        <label for="txtCodEspecialidade" class="col-sm-2 col-form-label">Especialidade:</label>
                        <div class="col-sm-2">
                            <div class="input-group">
                                <input type="text" id="txtCodEspecialidade" name="txtCodEspecialidade" class="form-control form-control-sm" aria-label="" aria-describedby="btnPesqEspecialidade" readonly="readonly" value="<?php echo @$_POST["txtCodEspecialidade"] ?>" style="text-align: right;" required>
                                <button class="btn btn-outline-secondary btn-sm" type="button" id="btnPesqEspecialidade" onclick="window.open('busca.php?tipo=6&campocodigo=txtCodEspecialidade&campodescricao=txtDescEspecialidade&title=Pesquisar Especialidade','','width=900, height=500')">...</button>
                            </div>
                        </div>
                        <div class="col-sm-7">
                            <input type="text" id="txtDescEspecialidade" name="txtDescEspecialidade" class="form-control form-control-sm" value="<?php echo @$_POST["txtDescEspecialidade"] ?>" readonly="readonly"/>
                        </div>
                        <div class="col-sm-1">
                            <button type="button" class="btn btn-primary btn-sm" id="btnLimparEspecialidade" name="btnLimparEspecialidade" onclick="limparEspecialidade()">Limpar</button>
                        </div>
                    </div>

                    <div class="row">
                        <label for="txtDataInicio" class="col-sm-2 col-form-label">Período:</label>
                        <div class="col-sm-2">
                            <input type="text" id="txtDataInicio" name="txtDataInicio" class="form-control form-control-sm" value="<?php echo @$_POST["txtDataInicio"] ?>" placeholder="dd/mm/yyyy" onkeypress="mascaraData(this)" required/>
                        </div>
                        <div class="col-sm-2">
                            <input type="text" id="txtDataFim" name="txtDataFim" class="form-control form-control-sm" value="<?php echo @$_POST["txtDataFim"] ?>" placeholder="dd/mm/yyyy" onkeypress="mascaraData(this)" required/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-2">
                            <button type="submit" class="btn btn-primary btn-sm" id="btnPesquisar" name="btnPesquisar">Pesquisar</button>
                        </div>
                    </div>
                </div>

                <?php
                if (isset($_POST["btnPesquisar"])){

                    $lista = $ctrVisita->listarAgendamento($_POST["txtCodProfissional"], $_POST["txtCodEspecialidade"], $_POST["txtDataInicio"], $_POST["txtDataFim"]);
                    $qtdeLista = count($lista);

                    if ($qtdeLista > 0){
                        ?>
                        <table class="table">
                            <thead>
                                <tr>                                    
                                    <th scope="col" style="display: none;">IdProfAgenda</th>
                                    <th scope="col" style="display: none;">IdEspecialidade</th>
                                    <th scope="col" style="display: none;">dataagendainicio</th>
                                    <th scope="col" style="display: none;">dataagendafim</th>
                                    <th scope="col" style="display: none;">idprofessional</th>
                                    <th scope="col" style="display: none;">nmprofessional</th>
                                    <th scope="col" style="display: none;">idcapconsult</th>
                                    <th scope="col" style="display: none;">idadmission</th>
                                    <th scope="col">Hora</th>
                                    <th scope="col">Paciente</th>                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $data = "";
                                $profissional = "";
                                for($i = 0; $i < $qtdeLista; $i++){
                                    if ($data != $lista[$i]["DATA"]){
                                        ?>
                                        <tr class="table-primary">
                                            <td colspan="3"><?php echo $lista[$i]["DATA"] ?></td>
                                        </tr>
                                        <?php
                                        $profissional = "";
                                    }
            
                                    if ($profissional != $lista[$i]["NMPROFESSIONAL"]){
                                        ?>
                                        <tr class="table-success">
                                            <td colspan="3"><?php echo $lista[$i]["NMPROFESSIONAL"] . " - " . $lista[$i]["NMESPECIALIDADE"] ?></td>
                                        </tr>
                                        <?php
                                        $profissional = "";
                                    }
                                    ?>
                                    <tr>
                                        <td style="display: none;"><?php echo $lista[$i]["ID"] ?></td>
                                        <td style="display: none;"><?php echo $lista[$i]["IDESPECIALIDADE"] ?></td>
                                        <td style="display: none;"><?php echo $lista[$i]["DATAAGENDAINICIO"] ?></td>
                                        <td style="display: none;"><?php echo $lista[$i]["DATAAGENDAFIM"] ?></td>
                                        <td style="display: none;"><?php echo $lista[$i]["IDPROFESSIONAL"] ?></td>
                                        <td style="display: none;"><?php echo $lista[$i]["NMPROFESSIONAL"] ?></td>
                                        <td style="display: none;"><?php echo $lista[$i]["IDCAPCONSULT"] ?></td>
                                        <td style="display: none;"><?php echo $lista[$i]["IDADMISSION"] ?></td>
                                        <td><?php echo $lista[$i]["HORA"] ?></td>
                                        <td>
                                            <?php
                                            if ($lista[$i]["NMPACIENTE"] != ""){
                                                if ($lista[$i]["IDEVOLUTION"] == ""){
                                                    echo $lista[$i]["NMPACIENTE"];
                                                    ?>
                                                    &nbsp;<button type="button" class="btn btn-danger btn-sm" onclick="excluir(this)">Excluir</button>
                                                    <?php
                                                } else {
                                                    echo $lista[$i]["NMPACIENTE"];
                                                }
                                            } else {
                                                if ($lista[$i]["ORDENACAODATA"] >= date("Ymd")){
                                                    ?>
                                                    <button type="button" class="btn btn-primary btn-sm" onclick="informarDados(this)">Agendar</button>
                                                    <?php
                                                }
                                            }                                
                                            ?>
                                        </td>
                                        
                                    </tr>
                                    <?php
                                    $data = $lista[$i]["DATA"];
                                    $profissional = $lista[$i]["NMPROFESSIONAL"];
                                }
                                ?>
                            </tbody>
                            
                        </table>    
                        <?php
                    } else {
                        ?>
                        <div class="alert alert-danger" role="alert">
                            Não existe registro para os critérios informados.
                        </div>
                        <?php
                    }

                }
                ?>
            </form>
        </div>
    
        <div class="modal fade" id="modalExcluir" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Exclusão</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="formExcluir" method="POST">
                        <div class="modal-body">
                            <div class="row">
                                <label for="txtCodPaciente" class="col-sm-12 col-form-label">Deseja excluir o registro?</label>
                            </div>

                            <small>
                                <div id="mensagem" align="center"></div>
                            </small>

                            <input type="hidden" name="txtIdCapConsult" id="txtIdCapConsult">
                            <input type="hidden" name="txtIdAdmission" id="txtIdAdmission">
                            <input type="hidden" name="txtDtIni" id="txtDtIni">
                            <input type="hidden" name="txtDtFim" id="txtDtFim">
                            <input type="hidden" name="txtIdProfExc" id="txtIdProfExc">
                            <input type="hidden" name="txtIdProfAgeExc" id="txtIdProfAgeExc">
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="btn-fechar-excluir" name="btn-fechar-excluir" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Sair</button>
                            <button type="submit" class="btn btn-primary btn-sm">Excluir</button>
                        </div>
                    </form>                               
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalAdicionar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Agendar Visita</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="formAdicionar" method="POST">
                        <div class="modal-body">
                            <div class="row">
                                <label for="txtCodPaciente" class="col-sm-2 col-form-label">Paciente:</label>
                                <div class="col-sm-2">
                                    <div class="input-group">
                                        <input type="text" id="txtCodPaciente" name="txtCodPaciente" class="form-control form-control-sm" aria-label="" aria-describedby="btnPesqPaciente" readonly="readonly" style="text-align: right;" required>
                                        <button class="btn btn-outline-secondary btn-sm" type="button" id="btnPesqPaciente" onclick="window.open('busca.php?tipo=3&campocodigo=txtCodPaciente&campodescricao=txtDescPaciente&title=Pesquisar Paciente','','width=900, height=500')">...</button>
                                    </div>
                                </div>
                                <div class="col-sm-7">
                                    <input type="text" id="txtDescPaciente" name="txtDescPaciente" class="form-control form-control-sm" readonly="readonly"/>
                                </div>
                                <div class="col-sm-1">
                                    <button type="button" class="btn btn-primary btn-sm" id="btnLimparPaciente" name="btnLimparPaciente" onclick="limparPaciente()">Limpar</button>
                                </div>
                            </div>

                            <input type="hidden" id="idprofagenda" name="idprofagenda" class="form-control form-control-sm" />
                            <input type="hidden" id="idespecialidade" name="idespecialidade" class="form-control form-control-sm" />
                            <input type="hidden" id="dataagendainicio" name="dataagendainicio" class="form-control form-control-sm" />
                            <input type="hidden" id="dataagendafim" name="dataagendafim" class="form-control form-control-sm" />
                            <input type="hidden" id="secuser" name="secuser" class="form-control form-control-sm" value="<?php echo $_SESSION["NMSECUSER_USUARIO"] ?>" />
                            <input type="hidden" id="idusuario" name="idusuario" class="form-control form-control-sm" value="<?php echo $_SESSION["ID_USUARIO"] ?>" />
                            <input type="hidden" id="idprofessional" name="idprofessional" class="form-control form-control-sm" />
                            <input type="hidden" id="nmprofessional" name="nmprofessional" class="form-control form-control-sm" />

                            
                            <div class="row">
                                <label for="txtProcedimento" class="col-sm-2 col-form-label">Procedimento:</label>
                                <div class="col-sm-10">
                                    <input type="text" id="txtProcedimento" name="txtProcedimento" class="form-control form-control-sm" />
                                </div>
                            </div>

                            <div class="row">
                                <label for="txtObservacao" class="col-sm-2 col-form-label">Observação:</label>
                                <div class="col-sm-10">
                                    <input type="text" id="txtObservacao" name="txtObservacao" class="form-control form-control-sm" />
                                </div>
                            </div>
                            

                            <small>
                                <div id="mensagemAdicionar" align="center"></div>
                            </small>

                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="btn-fechar-adicionar" name="btn-fechar-adicionar" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Sair</button>
                            <button type="submit" class="btn btn-primary btn-sm">Salvar</button>
                        </div>
                    </form>                               
                </div>
            </div>
        </div>

        <script>
            function limparEspecialidade(){
                document.getElementById('txtCodEspecialidade').value = "";
                document.getElementById('txtDescEspecialidade').value = "";
            }

            function limparProfissional(){
                document.getElementById('txtCodProfissional').value = "";
                document.getElementById('txtDescProfissional').value = "";
            }

            function limparPaciente(){
                document.getElementById('txtCodPaciente').value = "";
                document.getElementById('txtDescPaciente').value = "";
            }

            function informarDados(linha){
                var tableData = $(linha).closest("tr").find("td:not(:last-child)").map(function(){
                    return $(this).text().trim();
                }).get();

                console.log(tableData);

                $("#idprofagenda").val(tableData[0]);
                $("#idespecialidade").val(tableData[1]);
                $("#dataagendainicio").val(tableData[2]);
                $("#dataagendafim").val(tableData[3]);
                $("#idprofessional").val(tableData[4]);
                $("#nmprofessional").val(tableData[5]);
                $("#mensagemAdicionar").text("");
                $("#mensagemAdicionar").removeClass();

                var myModal = new bootstrap.Modal(document.getElementById("modalAdicionar"), {});
                myModal.show();
            }
            
            function excluir(linha){
                var tableData = $(linha).closest("tr").find("td:not(:last-child)").map(function(){
                    return $(this).text().trim();
                }).get();


                $("#txtIdCapConsult").val(tableData[6]);
                $("#txtIdAdmission").val(tableData[7]);
                $("#txtDtIni").val(tableData[2]);
                $("#txtDtFim").val(tableData[3]);
                $("#txtIdProfExc").val(tableData[4]);
                $("#txtIdProfAgeExc").val(tableData[0]);
                $("#mensagem").text("");
                $("#mensagem").removeClass();

                var myModal = new bootstrap.Modal(document.getElementById("modalExcluir"), {});
                myModal.show();
            }

            $("#formExcluir").submit(function(){
                event.preventDefault();
                var formData = new FormData(this);

                $.ajax({
                    url: "visitasagendamento_mov.php?tipo=E",
                    type: "POST",
                    data: formData, 

                    success: function(mensagem){
                        $("#mensagem").text("");
                        $("#mensagem").removeClass();
                        if (mensagem.trim() == "Excluído com sucesso."){
                            window.location.reload(true);
                            $("#btn-fechar-excluir").click();                            
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

            $("#formAdicionar").submit(function(){
                event.preventDefault();
                var formData = new FormData(this);

                $.ajax({
                    url: "visitasagendamento_mov.php?tipo=I",
                    type: "POST",
                    data: formData, 

                    success: function(mensagem){
                        $("#mensagemAdicionar").text("");
                        $("#mensagemAdicionar").removeClass();
                        if (mensagem.trim() == "Incluído com sucesso."){
                            window.location.reload(true);
                            $("#btn-fechar-adicionar").click();                            
                        } else {
                            $("#mensagemAdicionar").addClass("text-danger")
                            $("#mensagemAdicionar").text(mensagem);
                        }
                    },

                    cache: false,
                    contentType: false,
                    processData: false,
                });
            });
        </script>

    </body>
</html>