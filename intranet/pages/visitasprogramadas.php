<?php
require_once("../controllers/visitascontroller.php");
$ctrVisita = new VisitasController();
?>
<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            function limparServico(){
                document.getElementById('txtCodServico').value = "";
                document.getElementById('txtDescServico').value = "";
            }

            $("#txtHoraInicioImportarFicha").mask("AB:CD", {
                translation: {
                "A": { pattern: /[0-2]/, optional: false},
                "B": { pattern: /[0-3]/, optional: false},
                "C": { pattern: /[0-5]/, optional: false},
                "D": { pattern: /[0-9]/, optional: false}
                }
            });

            $("#txtHoraFimImportarFicha").mask("AB:CD", {
                translation: {
                "A": { pattern: /[0-2]/, optional: false},
                "B": { pattern: /[0-3]/, optional: false},
                "C": { pattern: /[0-5]/, optional: false},
                "D": { pattern: /[0-9]/, optional: false}
                }
            });
        </script>
    </head>
    <body>
        <div class="container-fluid">
            <nav class="navbar navbar-extends-lg navbar-dark bg-primary">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">Visitas Programadas</a>
                </div>
            </nav>

            <form name="frmTerapia" id="frmTerapia" method="POST" action="index.php?pag=4">
                </br>
                <div class="container-fluid">
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
                        <label for="txtCodPaciente" class="col-sm-2 col-form-label">Paciente:</label>
                        <div class="col-sm-2">
                            <div class="input-group">
                                <input type="text" id="txtCodPaciente" name="txtCodPaciente" class="form-control form-control-sm" aria-label="" aria-describedby="btnPesqPaciente" readonly="readonly" value="<?php echo @$_POST["txtCodPaciente"] ?>" style="text-align: right;" required>
                                <button class="btn btn-outline-secondary btn-sm" type="button" id="btnPesqPaciente" onclick="window.open('busca.php?tipo=3&campocodigo=txtCodPaciente&campodescricao=txtDescPaciente&title=Pesquisar Paciente','','width=900, height=500')">...</button>
                            </div>
                        </div>
                        <div class="col-sm-7">
                            <input type="text" id="txtDescPaciente" name="txtDescPaciente" class="form-control form-control-sm" value="<?php echo @$_POST["txtDescPaciente"] ?>" readonly="readonly"/>
                        </div>
                        <div class="col-sm-1">
                            <button type="button" class="btn btn-primary btn-sm" id="btnLimparPaciente" name="btnLimparPaciente" onclick="limparPaciente()">Limpar</button>
                        </div>
                    </div>
                    <div class="row">
                        <label for="txtCodServico" class="col-sm-2 col-form-label">Serviço:</label>
                        <div class="col-sm-2">
                            <div class="input-group">
                                <input type="text" id="txtCodServico" name="txtCodServico" class="form-control form-control-sm" aria-label="" aria-describedby="btnPesqServico" readonly="readonly" value="<?php echo @$_POST["txtCodServico"] ?>" style="text-align: right;" required>
                                <button class="btn btn-outline-secondary btn-sm" type="button" id="btnPesqServico" onclick="window.open('busca.php?tipo=9&campocodigo=txtCodServico&campodescricao=txtDescServico&title=Pesquisar Serviço','','width=900, height=500')">...</button>
                            </div>
                        </div>
                        <div class="col-sm-7">
                            <input type="text" id="txtDescServico" name="txtDescServico" class="form-control form-control-sm" value="<?php echo @$_POST["txtDescServico"] ?>" readonly="readonly"/>
                        </div>
                        <div class="col-sm-1">
                            <button type="button" class="btn btn-primary btn-sm" id="btnLimparServico" name="btnLimparServico" onclick="limparServico()">Limpar</button>
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
                    $lista = $ctrVisita->listarVisitasProgramadas(
                        @$_POST["txtDataInicio"], 
                        @$_POST["txtDataFim"], 
                        @$_POST["txtCodEspecialidade"], 
                        @$_POST["txtCodProfissional"], 
                        @$_POST["txtCodPaciente"],
                        @$_POST["txtCodServico"]
                    );
                    $qtde = count($lista);
                    if ($lista > 0){
                        ?>
                        <br>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col" style="display: none;">IDADMISSION</th>
                                    <th scope="col" style="display: none;">IDPROFAGENDA</th>
                                    <th scope="col" style="display: none;">IDESPECIALIDADE</th>
                                    <th scope="col" style="display: none;">IDPROFESSIONAL</th>
                                    <th scope="col" style="display: none;">REGISTRO</th>
                                    <th scope="col" style="display: none;">APELIDO</th>
                                    <th scope="col" style="display: none;">NOMEPROFISSIONAL</th>
                                    <th scope="col" style="display: none;">NOMEESPECIALIDADE</th>
                                    <th scope="col" style="display: none;">IDCAPCONSULT</th>
                                    <th scope="col" style="display: none;">DATA</th>
                                    <th scope="col">Hora</th>
                                    <th scope="col">Paciente</th>
                                    <th scope="col">Comentário</th>
                                    <th scope="col"></th>
                                    <th scope="col" style="display: none;">DATAFIM</th>
                                    <th scope="col" style="display: none;">HORAFIM</th>
                                    <th scope="col" style="display: none;">IDEVOLUCAO</th>
                                    <th scope="col" style="display: none;">IDFICHA</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $data = "";
                                $especialidade = "";
                                $profissional = "";
                                for ($i = 0; $i < $qtde; $i++){
                                    if ($data != $lista[$i]["DATAPROG"]){
                                        ?>
                                        <tr class="table-primary">
                                            <td colspan="6">Data: <?php echo $lista[$i]["DATAPROG"] ?></td>
                                        </tr>
                                        <?php                                        
                                    }

                                    if ($especialidade != $lista[$i]["NMESPECIALIDADE"]){
                                        ?>
                                        <tr class="table-success">
                                            <td colspan="6">Especialidade: <?php echo $lista[$i]["NMESPECIALIDADE"] ?></td>
                                        </tr>
                                        <?php                                        
                                    }

                                    if ($profissional != $lista[$i]["NMPROFESSIONAL"]){
                                        ?>
                                        <tr class="table-warning">
                                            <td colspan="6">Profissional: <?php echo $lista[$i]["NMPROFESSIONAL"] ?></td>
                                        </tr>
                                        <?php                                        
                                    }

                                    ?>
                                    <tr>
                                        <td style="display: none;"><?php echo $lista[$i]["IDADMISSION"] ?></td>
                                        <td style="display: none;"><?php echo $lista[$i]["IDPROFAGENDA"] ?></td>
                                        <td style="display: none;"><?php echo $lista[$i]["IDESPECIALIDADE"] ?></td>
                                        <td style="display: none;"><?php echo $lista[$i]["IDPROFESSIONAL"] ?></td>
                                        <td style="display: none;"><?php echo $lista[$i]["REGISTROPROFISSIONAL"] ?></td>
                                        <td style="display: none;"><?php echo $lista[$i]["APELIDOPROFISSIONAL"] ?></td>
                                        <td style="display: none;"><?php echo $lista[$i]["NMPROFESSIONAL"] ?></td>
                                        <td style="display: none;"><?php echo $lista[$i]["NMESPECIALIDADE"] ?></td>
                                        <td style="display: none;"><?php echo $lista[$i]["IDCAPCONSULT"] ?></td>
                                        <td style="display: none;"><?php echo $lista[$i]["DATAPROG"] ?></td>
                                        <td><?php echo $lista[$i]["HORAPROG"] ?></td>
                                        <td><?php echo $lista[$i]["NMPACIENTE"] ?></td>
                                        <td></td>
                                        <td style="text-align: center;">
                                            <?php
                                            if ($lista[$i]["IDEVOLUTION"] != ""){
                                                ?>
                                                <a href="#" class="btn btn-primary btn-sm" onclick="javascript:window.open('visualizarficha.php?tpl=<?php echo $lista[$i]["IDTEMPLATE"] ?>&idevol=<?php echo $lista[$i]["IDEVOLUTION"] ?>&img=<?php echo $lista[$i]["IMAGEM"] ?>','','width=600, height=600');void[0];">Visualizar</a>
                                                <?php
                                                if ($lista[$i]["ASSINATURAPAC"] == ""){
                                                    ?>
                                                    <a href="#" class="btn btn-info btn-sm" onclick="abrirSubstituirFicha(this)">Substituir Ficha</a>
                                                    <?php
                                                }
                                            } else {
                                                // Verifica se a data é anterior a hoje
                                                $xhoje = date("Ymd");
                                                $xdata = $lista[$i]["ORDENACAODATA"];
                                                if ($xhoje <= $xdata){
                                                    ?>
                                                    <a href="javascript:window.open('visitasreagendamento.php?prof=<?php echo $lista[$i]["IDPROFESSIONAL"] ?>&adm=<?php echo $lista[$i]["IDADMISSION"] ?>&idpa=<?php echo $lista[$i]["IDPROFAGENDA"] ?>','','width=900, height=600');void[0];" class="btn btn-success btn-sm">Reagendar</a>
                                                    <?php
                                                } else {
                                                    if ($lista[$i]["DATACANC"] != ""){
                                                        ?>
                                                        <div class="text-danger">Agendamento Cancelado</div>                                                        
                                                        <div class="text-danger">Motivo: <?php echo $lista[$i]["MOTIVOCANC"] ?></div>
                                                        <div class="text-danger">Data do Cancelamento: <?php echo $lista[$i]["DATACANC"] ?></div>
                                                        <div class="text-danger">Justificativa: <?php echo $lista[$i]["JUSTCANC"] ?></div>
                                                        <?php
                                                    } else {
                                                        $xdataini = $lista[$i]["DATAPROG"] . " " . $lista[$i]["HORAPROG"];
                                                        $xdatafim = $lista[$i]["DATAPROGFIM"] . " " . $lista[$i]["HORAPROGFIM"];
                                                        $ctrVisita->validaCancelamentoVisitaProg(
                                                            $lista[$i]["IDADMISSION"], 
                                                            $lista[$i]["IDPROFAGENDA"], 
                                                            $xdataini,
                                                            $xdatafim,
                                                            $lista[$i]["IDPROFESSIONAL"], 
                                                            $_SESSION["ID_USUARIO"]
                                                        );
                                                        ?>
                                                        <div class="text-danger">Agendamento Cancelado</div>                                                        
                                                        <div class="text-danger">Motivo: NAO REGISTRADA</div>
                                                        <div class="text-danger">Data do Cancelamento: <?php echo date("d/m/Y H:i:s") ?></div>
                                                        <div class="text-danger">Justificativa: VISITA NÃO REGISTRADA NO SISTEMA</div>
                                                        <?php
                                                    }
                                                    ?>
                                                    <a href="#" class="btn btn-secondary btn-sm" onclick="abrirImportacaoFicha(this)">Importar</a>
                                                    <?php
                                                    if ($_SESSION["HABILITA_EXCLUSAO_FICHA"] == "S"){
                                                        ?>
                                                        <a href="#" class="btn btn-danger btn-sm" onclick="abrirExclusaoFicha(this)">Excluir</a>
                                                        <?php
                                                    }                                                    
                                                }
                                            }
                                            ?>
                                        </td>
                                        <td style="display: none;"><?php echo $lista[$i]["DATAPROGFIM"] ?></td>
                                        <td style="display: none;"><?php echo $lista[$i]["HORAPROGFIM"] ?></td>
                                        <td style="display: none;"><?php echo $lista[$i]["IDEVOLUTION"] ?></td>
                                        <td style="display: none;"><?php echo $lista[$i]["IDFICHA"] ?></td>
                                    </tr>
                                    <?php

                                    $profissional = $lista[$i]["NMPROFESSIONAL"];
                                    $especialidade = $lista[$i]["NMESPECIALIDADE"];
                                    $data = $lista[$i]["DATAPROG"];
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
    </body>
</html>

<div class="modal fade" id="modalImportarFicha" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Importar Ficha - Registro Manual</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formImportarFicha" method="POST">
                <input type="hidden" name="txtCodAdmissaoImportarFicha" id="txtCodAdmissaoImportarFicha" />
                <input type="hidden" name="txtCodProfAgendaImportarFicha" id="txtCodProfAgendaImportarFicha" />
                <input type="hidden" name="txtCodIdEspecialidadeImportarFicha" id="txtCodIdEspecialidadeImportarFicha" />
                <input type="hidden" name="txtCodIdProfessionalImportarFicha" id="txtCodIdProfessionalImportarFicha" />
                <input type="hidden" name="txtRegistroProfessionalImportarFicha" id="txtRegistroProfessionalImportarFicha" />
                <input type="hidden" name="txtApelidoProfessionalImportarFicha" id="txtApelidoProfessionalImportarFicha" />
                <input type="hidden" name="txtNomeProfessionalImportarFicha" id="txtNomeProfessionalImportarFicha" />
                <input type="hidden" name="txtNomeEspecialidadeImportarFicha" id="txtNomeEspecialidadeImportarFicha" />
                <input type="hidden" name="txtIdCapConsultImportarFicha" id="txtIdCapConsultImportarFicha" />
                <input type="hidden" name="txtDataProgImportarFicha" id="txtDataProgImportarFicha" />
                <div class="modal-body">
                    <div class="row">
                        <label for="txtDataInicioImportarFicha" class="col-sm-2 col-form-label">Data/Hora Inicio:</label>
                        <div class="col-sm-2">
                            <div class="input-group">
                                <input type="text" id="txtDataInicioImportarFicha" name="txtDataInicioImportarFicha" class="form-control form-control-sm" aria-label="" placeholder="dd/mm/yyyy" onkeypress="mascaraData(this)" required>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="input-group">
                                <input type="text" id="txtHoraInicioImportarFicha" name="txtHoraInicioImportarFicha" class="form-control form-control-sm" aria-label="" placeholder="hh:mm" required>
                            </div>
                        </div>                        
                    </div>

                    <div class="row">
                        <label for="txtDataFimImportarFicha" class="col-sm-2 col-form-label">Data/Hora Fim:</label>
                        <div class="col-sm-2">
                            <div class="input-group">
                                <input type="text" id="txtDataFimImportarFicha" name="txtDataFimImportarFicha" class="form-control form-control-sm" aria-label="" placeholder="dd/mm/yyyy" onkeypress="mascaraData(this)" required>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="input-group">
                                <input type="text" id="txtHoraFimImportarFicha" name="txtHoraFimImportarFicha" class="form-control form-control-sm" aria-label="" placeholder="hh:mm" required>
                            </div>
                        </div>                        
                    </div>

                    <div class="row">
                        <label for="arquivoImportarFicha" class="col-sm-2 col-form-label">Anexar Arquivo:</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="file" id="arquivoImportarFicha" name="arquivoImportarFicha">
                        </div>                  
                    </div>

                    <small>
                        <div id="mensagem-importarficha" align="center"></div>
                    </small>

                    
                </div>
                <div class="modal-footer">
                    <button type="button" id="btn-fechar-importarficha" name="btn-fechar-importarficha" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Sair</button>
                    <button type="submit" class="btn btn-primary btn-sm">Salvar</button>
                </div>
            </form>                               
        </div>
    </div>
</div>

<div class="modal fade" id="modalExclusaoFicha" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Excluir Ficha</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formImportarFicha" method="POST">                
                <input type="hidden" name="txtIdCapConsultExcluirFicha" id="txtIdCapConsultExcluirFicha" />
                <input type="hidden" name="txtCodAdmissaoExcluirFicha" id="txtCodAdmissaoExcluirFicha" />
                <input type="hidden" name="txtDataProgExcluirFicha" id="txtDataProgExcluirFicha" />
                <input type="hidden" name="txtHoraProgExcluirFicha" id="txtHoraProgExcluirFicha" />
                <input type="hidden" name="txtCodIdProfessionalExcluirFicha" id="txtCodIdProfessionalExcluirFicha" />
                <input type="hidden" name="txtCodProfAgendaExcluirFicha" id="txtCodProfAgendaExcluirFicha" />
                <input type="hidden" name="txtDataFimExcluirFicha" id="txtDataFimExcluirFicha" />
                <input type="hidden" name="txtHoraFimExcluirFicha" id="txtHoraFimExcluirFicha" />
                <div class="modal-body">
                    Deseja excluir a visita?
                    <small>
                        <div id="mensagem-exclusaoficha" align="center"></div>
                    </small>

                    
                </div>
                <div class="modal-footer">
                    <button type="button" id="btn-fechar-exclusaoficha" name="btn-fechar-exclusaoficha" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">NÃO</button>
                    <button type="submit" class="btn btn-primary btn-sm">SIM</button>
                </div>
            </form>                               
        </div>
    </div>
</div>

<div class="modal fade" id="modalSubstituirFicha" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Substituir Ficha</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formSubstituirFicha" method="POST">
                <input type="hidden" name="txtCodAdmissaoSubstituirFicha" id="txtCodAdmissaoSubstituirFicha" />
                <input type="hidden" name="txtCodProfAgendaSubstituirFicha" id="txtCodProfAgendaSubstituirFicha" />
                <input type="hidden" name="txtCodIdEspecialidadeSubstituirFicha" id="txtCodIdEspecialidadeSubstituirFicha" />
                <input type="hidden" name="txtCodIdProfessionalSubstituirFicha" id="txtCodIdProfessionalSubstituirFicha" />
                <input type="hidden" name="txtRegistroProfessionalSubstituirFicha" id="txtRegistroProfessionalSubstituirFicha" />
                <input type="hidden" name="txtApelidoProfessionalSubstituirFicha" id="txtApelidoProfessionalSubstituirFicha" />
                <input type="hidden" name="txtNomeProfessionalSubstituirFicha" id="txtNomeProfessionalSubstituirFicha" />
                <input type="hidden" name="txtNomeEspecialidadeSubstituirFicha" id="txtNomeEspecialidadeSubstituirFicha" />
                <input type="hidden" name="txtIdCapConsultSubstituirFicha" id="txtIdCapConsultSubstituirFicha" />
                <input type="hidden" name="txtDataProgSubstituirFicha" id="txtDataProgSubstituirFicha" />
                <input type="hidden" name="txtIdEvolucaoSubstituirFicha" id="txtIdEvolucaoSubstituirFicha" />
                <input type="hidden" name="txtIdFichaSubstituirFicha" id="txtIdFichaSubstituirFicha" />
                <div class="modal-body">
                    <div class="row">
                        <label for="arquivoSubstituirFicha" class="col-sm-2 col-form-label">Anexar Arquivo:</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="file" id="arquivoSubstituirFicha" name="arquivoSubstituirFicha">
                        </div>                  
                    </div>

                    <small>
                        <div id="mensagem-substituirficha" align="center"></div>
                    </small>

                    
                </div>
                <div class="modal-footer">
                    <button type="button" id="btn-fechar-substituirficha" name="btn-fechar-substituirficha" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Sair</button>
                    <button type="submit" class="btn btn-primary btn-sm">Salvar</button>
                </div>
            </form>                               
        </div>
    </div>
</div>

<script>
    function abrirImportacaoFicha(linha){
        var tableData = $(linha).closest("tr").find("td:not(:last-child)").map(function(){
            return $(this).text().trim();
        }).get();
        $("#txtCodAdmissaoImportarFicha").val(tableData[0]);
        $("#txtCodProfAgendaImportarFicha").val(tableData[1]);
        $("#txtCodIdEspecialidadeImportarFicha").val(tableData[2]);
        $("#txtCodIdProfessionalImportarFicha").val(tableData[3]);
        $("#txtRegistroProfessionalImportarFicha").val(tableData[4]);
        $("#txtApelidoProfessionalImportarFicha").val(tableData[5]);
        $("#txtNomeProfessionalImportarFicha").val(tableData[6]);
        $("#txtNomeEspecialidadeImportarFicha").val(tableData[7]);
        $("#txtIdCapConsultImportarFicha").val(tableData[8]);

        $("#txtDataInicioImportarFicha").val("");
        $("#txtHoraInicioImportarFicha").val("");
        $("#txtDataFimImportarFicha").val("");
        $("#txtHoraFimImportarFicha").val("");
        $("#arquivoImportarFicha").val("");
        
        $("#mensagem-importarficha").text("");
        $("#mensagem-importarficha").removeClass();

        var myModal = new bootstrap.Modal(document.getElementById("modalImportarFicha"), {});
        myModal.show();
    }

    $("#formImportarFicha").submit(function(){
        event.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "visitasprogramadas_mov.php?tipo=FM",
            type: "POST",
            data: formData, 

            success: function(mensagem){
                $("#txtDataInicioImportarFicha").val("");
                $("#txtHoraInicioImportarFicha").val("");
                $("#txtDataFimImportarFicha").val("");
                $("#txtHoraFimImportarFicha").val("");
                $("#arquivoImportarFicha").val("");
                
                $("#mensagem-importarficha").text("");
                $("#mensagem-importarficha").removeClass();
                if (mensagem.trim() == "Incluído com sucesso."){
                    window.location.reload(true);
                    $("#btn-fechar-excluir").click();                            
                } else {
                    $("#mensagem-importarficha").addClass("text-danger")
                    $("#mensagem-importarficha").text(mensagem);
                }
            },

            cache: false,
            contentType: false,
            processData: false,
        });
    });

    function abrirExclusaoFicha(linha){
        var tableData = $(linha).closest("tr").find("td:not(:last-child)").map(function(){
            return $(this).text().trim();
        }).get();

        $("#txtIdCapConsultExcluirFicha").val(tableData[8]);
        $("#txtCodAdmissaoExcluirFicha").val(tableData[0]);
        $("#txtDataProgExcluirFicha").val(tableData[9]);
        $("#txtHoraProgExcluirFicha").val(tableData[10]);
        $("#txtCodIdProfessionalExcluirFicha").val(tableData[3]);
        $("#txtCodProfAgendaExcluirFicha").val(tableData[1]);
        $("#txtDataFimExcluirFicha").val(tableData[14]);
        $("#txtHoraFimExcluirFicha").val(tableData[15]);

        $("#mensagem-exclusaoficha").text("");
        $("#mensagem-exclusaoficha").removeClass();

        var myModal = new bootstrap.Modal(document.getElementById("modalExclusaoFicha"), {});
        myModal.show();
    }

    $("#formExclusaoFicha").submit(function(){
        event.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "visitasprogramadas_mov.php?tipo=EV",
            type: "POST",
            data: formData, 

            success: function(mensagem){
                
                $("#mensagem-exclusaoficha").text("");
                $("#mensagem-exclusaoficha").removeClass();
                if (mensagem.trim() == "Excluído com sucesso."){
                    window.location.reload(true);
                    $("#btn-fechar-exclusaoficha").click();                            
                } else {
                    $("#mensagem-exclusaoficha").addClass("text-danger")
                    $("#mensagem-exclusaoficha").text(mensagem);
                }
            },

            cache: false,
            contentType: false,
            processData: false,
        });
    });

    function abrirSubstituirFicha(linha){
        var tableData = $(linha).closest("tr").find("td:not(:last-child)").map(function(){
            return $(this).text().trim();
        }).get();
        $("#txtCodAdmissaoSubstituirFicha").val(tableData[0]);
        $("#txtCodProfAgendaSubstituirFicha").val(tableData[1]);
        $("#txtCodIdEspecialidadeSubstituirFicha").val(tableData[2]);
        $("#txtCodIdProfessionalSubstituirFicha").val(tableData[3]);
        $("#txtRegistroProfessionalSubstituirFicha").val(tableData[4]);
        $("#txtApelidoProfessionalSubstituirFicha").val(tableData[5]);
        $("#txtNomeProfessionalSubstituirFicha").val(tableData[6]);
        $("#txtNomeEspecialidadeSubstituirFicha").val(tableData[7]);
        $("#txtIdCapConsultSubstituirFicha").val(tableData[8]);
        $("#txtIdEvolucaoSubstituirFicha").val(tableData[16]);
        $("#txtIdFichaSubstituirFicha").val(tableData[17]);

        $("#arquivoSubstituirFicha").val("");
        
        $("#mensagem-substituirficha").text("");
        $("#mensagem-substituirficha").removeClass();

        var myModal = new bootstrap.Modal(document.getElementById("modalSubstituirFicha"), {});
        myModal.show();
    }

    $("#formSubstituirFicha").submit(function(){
        event.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "visitasprogramadas_mov.php?tipo=SF",
            type: "POST",
            data: formData, 

            success: function(mensagem){
                $("#arquivoSubstituirFicha").val("");
                
                $("#mensagem-substituirficha").text("");
                $("#mensagem-substituirficha").removeClass();
                if (mensagem.trim() == "Incluído com sucesso."){
                    window.location.reload(true);
                    $("#btn-fechar-substituirficha").click();                            
                } else {
                    $("#mensagem-substituirficha").addClass("text-danger")
                    $("#mensagem-substituirficha").text(mensagem);
                }
            },

            cache: false,
            contentType: false,
            processData: false,
        });
    });
</script>