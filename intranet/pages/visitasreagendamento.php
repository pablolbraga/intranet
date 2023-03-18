<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Reagendamento de Visitas</title>
        <link href="../css/bs/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">               
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.0/jquery.mask.min.js"></script>
        <script src="../js/funcoes.js"></script>
    </head>
    <body>
        <?php
        require_once("../controllers/agendacontroller.php");
        require_once("../controllers/admissaocontroller.php");
        require_once("../controllers/basicocontroller.php");
        $ctrAgenda = new AgendaController();
        $ctrAdmissao = new AdmissaoController();
        $ctrBasico = new BasicoController();

        $listaAgenda = $ctrAgenda->listarAgendamentoPorProfissional($_REQUEST["prof"], date("d/m/Y") . " 23:59:59");
        $qtdeAgenda = count($listaAgenda);

        $dadosAdmissao = $ctrAdmissao->retornarDadosPorAdmissao($_REQUEST["adm"]);
        $dadosProfissional = $ctrBasico->retornarDadosProfissional($_REQUEST["prof"]);
        ?>

        <div class="container-fluid">
            <br>
            <nav class="navbar navbar-extends-lg navbar-dark bg-primary">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">Reagendamento de Visitas</a>
                </div>
            </nav>
            <br />

            <div class="container-fluid">
                <div class="row">
                    <label for="txtCodAdmissao" class="col-sm-2 col-form-label">Paciente:</label>
                    <div class="col-sm-2">
                        <input type="text" id="txtCodAdmissao" name="txtCodAdmissao" class="form-control form-control-sm" aria-label="" readonly="readonly" value="<?php echo @$_REQUEST["adm"] ?>" style="text-align: right;" readonly="readonly">
                    </div>
                    <div class="col-sm-8">
                        <input type="text" id="txtDescPaciente" name="txtDescPaciente" class="form-control form-control-sm" value="<?php echo @$dadosAdmissao[0]["NMPACIENTE"] ?>" readonly="readonly"/>
                    </div>
                </div>

                <div class="row">
                    <label for="txtCodProfissional" class="col-sm-2 col-form-label">Profissional:</label>
                    <div class="col-sm-2">
                        <input type="text" id="txtCodProfissional" name="txtCodProfissional" class="form-control form-control-sm" aria-label="" readonly="readonly" value="<?php echo @$_REQUEST["prof"] ?>" style="text-align: right;" readonly="readonly">
                    </div>
                    <div class="col-sm-8">
                        <input type="text" id="txtDescProfissional" name="txtDescProfissional" class="form-control form-control-sm" value="<?php echo @$dadosProfissional[0]["NMPROFESSIONAL"] ?>" readonly="readonly"/>
                    </div>
                </div>

                <br/>
                <nav class="navbar navbar-extends-lg navbar-dark bg-success">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="#">Horários Disponíveis</a>
                    </div>
                </nav>

                <br/>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Horário</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $data = "";
                        for($i = 0; $i < $qtdeAgenda; $i++){
                            if ($data != @$listaAgenda[$i]["DATA"]){
                                ?>
                                <tr>
                                    <td style="display: none;">IDPROFAGENDA</td>
                                    <td style="display: none;">IDPROFAGENDA_ANTERIOR</td>
                                    <td style="display: none;">IDADMISSION</td>
                                    <td style="display: none;">IDPROFESSIONAL</td>
                                    <td style="display: none;">DATA</td>
                                    <td style="display: none;">HORAINICIO</td>
                                    <td style="display: none;">HORAFIM</td>
                                    <td>
                                        <?php echo @$listaAgenda[$i]["DATA"] ?>
                                    </td>
                                </tr>                                
                                <?php
                            }
                            ?>
                            <tr>
                                <td style="display: none;"><?php echo $listaAgenda[$i]["ID"] ?></td>
                                <td style="display: none;"><?php echo $_REQUEST["idpa"] ?></td>
                                <td style="display: none;"><?php echo $_REQUEST["adm"] ?></td>
                                <td style="display: none;"><?php echo $_REQUEST["prof"] ?></td>
                                <td style="display: none;"><?php echo $listaAgenda[$i]["DATA"] ?></td>
                                <td style="display: none;"><?php echo $listaAgenda[$i]["HORAINI"] ?></td>
                                <td style="display: none;"><?php echo $listaAgenda[$i]["HORAFIM"] ?></td>
                                <td>
                                    <a href="#" class="btn btn-success btn-sm" onclick="abrirReagendar(this)"><?php echo @$listaAgenda[$i]["HORAINI"] . " - " . @$listaAgenda[$i]["HORAFIM"] ?></a>
                                </td>
                            </tr>
                            <?php
                            $data = $listaAgenda[$i]["DATA"];                            
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <script src="../js/bs/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>        
    </body>
</html>

<div class="modal fade" id="modalReagendar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Reagendar</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formReagendar" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="idprofagenda" id="idprofagenda" />
                    <input type="hidden" name="idprofagendaanterior" id="idprofagendaanterior" />
                    <input type="hidden" name="idadmission" id="idadmission" />
                    <input type="hidden" name="idprofessional" id="idprofessional" />
                    <input type="hidden" name="data" id="data" />
                    <input type="hidden" name="horaini" id="horaini" />
                    <input type="hidden" name="horafim" id="horafim" />

                    Confirmar Reagendamento?
                    <small>
                        <div id="mensagem-reagendar" align="center"></div>
                    </small>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" id="btn-fechar-reagendar" name="btn-fechar-reagendar" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Sair</button>
                    <button type="submit" class="btn btn-primary btn-sm">Salvar</button>
                </div>
            </form>                               
        </div>
    </div>
</div>

<script>
    function abrirReagendar(linha){
        var tableData = $(linha).closest("tr").find("td:not(:last-child)").map(function(){
            return $(this).text().trim();
        }).get();

        $("#idprofagenda").val(tableData[0]);
        $("#idprofagendaanterior").val(tableData[1]);
        $("#idadmission").val(tableData[2]);
        $("#idprofessional").val(tableData[3]);
        $("#data").val(tableData[4]);
        $("#horaini").val(tableData[5]);
        $("#horafim").val(tableData[6]);

        $("#mensagem-reagendar").text("");
        $("#mensagem-reagendar").removeClass();

        var myModal = new bootstrap.Modal(document.getElementById("modalReagendar"), {});
        myModal.show();
    }

    $("#formReagendar").submit(function(){
        event.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "visitasagendamento_mov.php?tipo=RV",
            type: "POST",
            data: formData, 

            success: function(mensagem){
                $("#mensagem-reagendar").text("");
                $("#mensagem-reagendar").removeClass();
                if (mensagem.trim() == "Incluído com sucesso."){
                    opener.location.reload();                    
                    window.close();
                    $("#btn-fechar-reagendar").click();                            
                } else {
                    $("#mensagem-reagendar").addClass("text-danger")
                    $("#mensagem-reagendar").text(mensagem);
                }
            },

            cache: false,
            contentType: false,
            processData: false,
        });
    });
</script>