<?php
require_once('../helpers/contantes.php');
require_once("../controllers/solicitacaoservicocontroller.php");
require_once("../helpers/funcoes.php");

$listaTipo = Constantes::$arrTipoSolicitacaoMatMed;
$listaSimNao = Constantes::$arrSimNao;
$listaJustificativa = Constantes::$arrJustificativaMatMed;

$ctrSolServico = new SolicitacaoServicoController();
$funcao = new Funcoes();
?>

<html>
    <head>
        <script>
            $("#txtHoraMaximaResolucaoSolFarmacia").mask("AB:CD", {
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
                    <a class="navbar-brand" href="#">Solicitação de Serviços</a>
                    <div class="btn-group dropstart">
                        <button type="button" class="btn btn-success dropdown-toggle btn-sm" data-bs-toggle="dropdown" aria-expanded="false">
                            Serviços
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="#" class="dropdown-item" onclick="abrirSolicitacaoMatMed()">Material/Medicamento/Equipamento</a></li>
                            <li><a href="#" class="dropdown-item" onclick="abrirSolicitacaoRota()">Rotas</a></li>
                            <li><a href="#" class="dropdown-item" onclick="abrirSolicitacaoFarmacia()">Farmácia</a></li>
                            <li><a href="#" class="dropdown-item" onclick="abrirSolicitacaoAntibiotico()">Antibiótico</a></li>
                        </ul>
                    </div>
                </div>
            </nav>

        <br>

            <form name="frmSolicitacaoServico" id="frmSolicitacaoServico" method="POST" action="index.php?pag=2">
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
                            <input type="text" id="txtCodPacientePesq" name="txtCodPacientePesq" class="form-control form-control-sm" aria-label="" aria-describedby="btnPacientePesq" readonly="readonly" style="text-align: right;" required>
                            <button class="btn btn-outline-secondary btn-sm" type="button" id="btnPacientePesq" onclick="window.open('busca.php?tipo=8&campocodigo=txtCodPacientePesq&campodescricao=txtDescPacientePesq&title=Pesquisar Paciente','','width=900, height=500')">...</button>
                        </div>
                    </div>
                    <div class="col-sm-7">
                        <input type="text" id="txtDescPacientePesq" name="txtDescPacientePesq" class="form-control form-control-sm" readonly="readonly"/>
                    </div>
                    <div class="col-sm-1">
                        <button type="button" class="btn btn-primary btn-sm" id="btnLimparPacientePesq" name="btnLimparPacientePesq" onclick="limparPacientePesq()">Limpar</button>
                    </div>
                </div>
                <div class="row">
                    <label for="txtCodEnfermeiroPesq" class="col-sm-2 col-form-label">Enfermeiro(a):</label>
                    <div class="col-sm-2">
                        <div class="input-group">
                            <input type="text" id="txtCodEnfermeiroPesq" name="txtCodEnfermeiroPesq" class="form-control form-control-sm" aria-label="" aria-describedby="btnEnfermeiroPesq" readonly="readonly" style="text-align: right;" required>
                            <button class="btn btn-outline-secondary btn-sm" type="button" id="btnEnfermeiroPesq" onclick="window.open('busca.php?tipo=7&campocodigo=txtCodEnfermeiroPesq&campodescricao=txtDescEnfermeiroPesq&title=Pesquisar Enfermeiro','','width=900, height=500')">...</button>
                        </div>
                    </div>
                    <div class="col-sm-7">
                        <input type="text" id="txtDescEnfermeiroPesq" name="txtDescEnfermeiroPesq" class="form-control form-control-sm" readonly="readonly"/>
                    </div>
                    <div class="col-sm-1">
                        <button type="button" class="btn btn-primary btn-sm" id="btnLimparEnfermeiroPesq" name="btnLimparEnfermeiroPesq" onclick="limparEnfermeiroPesq()">Limpar</button>
                    </div>
                </div>
                <div class="row">
                    <label for="cmbTipoPesq" class="col-sm-2 col-form-label">Tipo:</label>
                    <div class="col-sm-2">
                        <select class="form-select form-select-sm" id="cmbTipoPesq" name="cmbTipoPesq">
                            <option value="">SELECIONE</option>
                            <?php
                            for($lt = 0; $lt < count($listaTipo); $lt++){
                                ?>
                                <option value="<?php echo $listaTipo[$lt]["ID"] ?>"><?php echo $listaTipo[$lt]["NOME"] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <label for="cmbInclusaoPrescricaoPesq" class="col-sm-2 col-form-label">Inclusão Prescrição:</label>
                    <div class="col-sm-2">
                        <select class="form-select form-select-sm" id="cmbInclusaoPrescricaoPesq" name="cmbInclusaoPrescricaoPesq">
                            <option value="">SELECIONE</option>
                            <?php
                            for($lsn = 0; $lsn < count($listaSimNao); $lsn++){
                                ?>
                                <option value="<?php echo $listaSimNao[$lsn]["ID"] ?>"><?php echo $listaSimNao[$lsn]["NOME"] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <label for="cmbJustificativaPesq" class="col-sm-2 col-form-label">Justificativa:</label>
                    <div class="col-sm-6">
                        <select class="form-select form-select-sm" id="cmbJustificativaPesq" name="cmbJustificativaPesq">
                            <option value="">SELECIONE</option>
                            <?php
                            for($lsn = 0; $lsn < count($listaJustificativa); $lsn++){
                                ?>
                                <option value="<?php echo $listaJustificativa[$lsn]["ID"] ?>"><?php echo $listaJustificativa[$lsn]["NOME"] ?></option>
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
                    $qry = $ctrSolServico->listar(
                        @$_POST["txtDataInicioPesq"], 
                        @$_POST["txtDataFimPesq"],
                        @$_POST["txtCodPacientePesq"],
                        @$_POST["txtCodEnfermeiroPesq"],
                        @$_POST["cmbTipoPesq"],
                        @$_POST["cmbInclusaoPrescricaoPesq"],
                        @$_POST["cmbJustificativaPesq"]
                    );
                    $qtde = count($qry);

                    if ($qtde > 0){
                        ?>
                        </br>
                        <table class="table table-bordered table-striped border-primary table-sm">
                            <thead>
                                <tr>
                                    <th scope="col">Solicitante</th>
                                    <th scope="col">Paciente</th>
                                    <th scope="col">Enf. Resp.</th>
                                    <th scope="col">Observação Solic.</th>
                                    <th scope="col">Observação Baixa</th>
                                    <th scope="col">Data Solic.</th>
                                    <th scope="col">Data Máxima</th>
                                    <th scope="col">Data Baixa</th>
                                    <th scope="col">Pedido Semanal</th>
                                    <th scope="col">Inclusão na Prescrição</th>
                                    <th scope="col">Justificativa</th>
                                    <th scope="col">Duração</th>
                                    <th scope="col">Baixado Por</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $solicitado=0;
                            $dentro_prazo_solicitado=0;
                            $fora_prazo_solicitado = 0;
                            $finalizados=0;
                            $dentro_prazo = 0;
                            $fora_prazo = 0;
                            for ($i = 0; $i < $qtde; $i++){
                                if($qry[$i]["STATUS"]=='S') {
                                    $solicitado++;
                
                                    $inicio = DateTime::createFromFormat('d/m/Y H:i:s', $qry[$i]["DATA_MAXIMA"]);
                                    $fim = DateTime::createFromFormat('d/m/Y H:i:s', date("d/m/Y H:i:s", strtotime('now')-(date('I')*3600)));
                
                                    if($inicio > $fim){
                                        $dentro_prazo_solicitado++;
                                    }else{
                                        $fora_prazo_solicitado++;
                                    }
                                }

                                if($qry[$i]["DATA_BAIXA"] != ''){
                                    $duracao = $funcao->diferenca_data_hora($qry[$i]["DATA_MAXIMA"], $qry[$i]["DATA_BAIXA"]);
                                    $fim = DateTime::createFromFormat('d/m/Y H:i:s', $qry[$i]["DATA_BAIXA"]);
                                    $finalizados++;
                                } else {
                                    $duracao = $funcao->diferenca_data_hora($qry[$i]["DATA_MAXIMA"], date("d/m/Y H:i:s"));
                                    $fim = DateTime::createFromFormat('d/m/Y H:i:s', date("d/m/Y H:i:s"));
                                }
                                $inicio = DateTime::createFromFormat('d/m/Y H:i:s', $qry[$i]["DATA_MAXIMA"]);

                                if($inicio < $fim){
                                $textodif = "";
                                $fora_prazo++;
                                ?>
                                <tr class="table-danger">
                                <?php
                                } else {
                                $textodif = "-";
                                $dentro_prazo++;
                                ?>
                                <tr>
                                <?php
                                }
                                ?>
                                    <td><?php echo $qry[$i]["NMSOLICITANTE"]?></td>
                                    <td><?php echo $qry[$i]["NMPACIENTE"]?></td>
                                    <td><?php echo $qry[$i]["NMENFERMEIRA"]?></td>
                                    <td><?php echo $qry[$i]["OBSERVACAO_SOLIC"]?></td>
                                    <td><?php echo $qry[$i]["OBSERVACAO_BAIXA"]?></td>
                                    <td><?php echo $qry[$i]["DATA_SOLIC"]?></td>
                                    <td><?php echo $qry[$i]["DATA_MAXIMA"]?></td>
                                    <td><?php echo $qry[$i]["DATA_BAIXA"]?></td>
                                    <td><?php echo $qry[$i]["PEDIDO_SEMANAL"]?></td>
                                    <td><?php echo $qry[$i]["INCLUSAO_PRESCRICAO"]?></td>
                                    <td><?php echo $qry[$i]["JUSTIFICATIVA"]?></td>
                                    <td>
                                        <?php
                                        echo $textodif . $duracao;
                                        ?>
                                    </td>
                                    <td><?php echo $qry[$i]["NMUSUBAIXA"]?></td>
                                </tr>
                                <?php
                            }
                            if ($finalizados > 0){
                                $porcentagem_finalizados = ($finalizados/$finalizados) *100;
                                $porcentagem_dentro_prazo = ($dentro_prazo/$finalizados) *100;
                                $porcentagem_fora_prazo = ($fora_prazo/$finalizados) *100;
                            }
                            else{
                                $porcentagem_finalizados = 0;
                                $porcentagem_dentro_prazo = 0;
                                $porcentagem_fora_prazo = 0;
                            }

                            if ($solicitado > 0){
                                $porcentagem_solicitados = ($solicitado/$solicitado) *100;
                                $porcentagem_solic_fora_prazo = ($fora_prazo_solicitado/$solicitado) *100;
                            }
                            else{
                                $porcentagem_solicitados = 0;
                                $porcentagem_solic_fora_prazo = 0;
                            }
                            
                            
                            ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th scope="col" colspan="5">Finalizados: <?php echo $finalizados ."(".round($porcentagem_finalizados, 2) ."%)"?></th>
                                    <th scope="col" colspan="8">Solicitados: <?php echo $solicitado ." (".round($porcentagem_solicitados, 2) ."%)"?></th>
                                </tr>
                                <tr>
                                    <th scope="col" colspan="5">
                                        No Prazo: <?php echo $dentro_prazo ." (".round($porcentagem_dentro_prazo, 2) ."%)"?><br />
                                        Fora do Prazo: <?php echo $fora_prazo ." (".round($porcentagem_fora_prazo, 2) ."%)"?>
                                    </th>
                                    <th scope="col" colspan="8">
                                        <br />
                                        Fora do Prazo: <?php echo $fora_prazo_solicitado ." (".round($porcentagem_solic_fora_prazo, 2) ."%)"?>
                                    </th>
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

        <div class="modal fade" id="modalSolicitarMatMed" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Solicitar Material/Medicamento/Equipamento</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="formAdicionarSolMatMed" method="POST">
                        <input type="hidden" id="txtIdUsuarioSolMatMed" name="txtIdUsuarioSolMatMed" value="<?php echo $_SESSION["ID_USUARIO"] ?>" />
                        <div class="modal-body">
                            <div class="row">
                                <label for="txtDataMaximaResolucaoSolMatMed" class="col-sm-2 col-form-label">Data Máxima:</label>
                                <div class="col-sm-2">
                                    <input type="text" id="txtDataMaximaResolucaoSolMatMed" name="txtDataMaximaResolucaoSolMatMed" class="form-control form-control-sm" placeholder="dd/mm/yyyy" onkeypress="mascaraData(this)" required/>
                                </div>                                
                            </div>
                            <div class="row">
                                <label for="txtCodPacienteSolMatMed" class="col-sm-2 col-form-label">Paciente:</label>
                                <div class="col-sm-2">
                                    <div class="input-group">
                                        <input type="text" id="txtCodPacienteSolMatMed" name="txtCodPacienteSolMatMed" class="form-control form-control-sm" aria-label="" aria-describedby="btnPesqPaciente" readonly="readonly" style="text-align: right;" required>
                                        <button class="btn btn-outline-secondary btn-sm" type="button" id="btnPesqPacienteSolMatMed" onclick="window.open('busca.php?tipo=8&campocodigo=txtCodPacienteSolMatMed&campodescricao=txtDescPacienteSolMatMed&title=Pesquisar Paciente','','width=900, height=500')">...</button>
                                    </div>
                                </div>
                                <div class="col-sm-7">
                                    <input type="text" id="txtDescPacienteSolMatMed" name="txtDescPacienteSolMatMed" class="form-control form-control-sm" readonly="readonly"/>
                                </div>
                                <div class="col-sm-1">
                                    <button type="button" class="btn btn-primary btn-sm" id="btnLimparPacienteSolMatMed" name="btnLimparPacienteSolMatMed" onclick="limparPacienteSolMatMed()">Limpar</button>
                                </div>
                            </div>
                            <div class="row">
                                <label for="txtCodEnfermeiroSolMatMed" class="col-sm-2 col-form-label">Enfermeiro(a):</label>
                                <div class="col-sm-2">
                                    <div class="input-group">
                                        <input type="text" id="txtCodEnfermeiroSolMatMed" name="txtCodEnfermeiroSolMatMed" class="form-control form-control-sm" aria-label="" aria-describedby="btnPesqPacienteSolMatMed" readonly="readonly" style="text-align: right;" required>
                                        <button class="btn btn-outline-secondary btn-sm" type="button" id="btnPesqPacienteSolMatMed" onclick="window.open('busca.php?tipo=7&campocodigo=txtCodEnfermeiroSolMatMed&campodescricao=txtDescEnfermeiroSolMatMed&title=Pesquisar Enfermeiro','','width=900, height=500')">...</button>
                                    </div>
                                </div>
                                <div class="col-sm-7">
                                    <input type="text" id="txtDescEnfermeiroSolMatMed" name="txtDescEnfermeiroSolMatMed" class="form-control form-control-sm" readonly="readonly"/>
                                </div>
                                <div class="col-sm-1">
                                    <button type="button" class="btn btn-primary btn-sm" id="btnLimparEnfermeiroSolMatMed" name="btnLimparEnfermeiroSolMatMed" onclick="limparEnfermeiroSolMatMed()">Limpar</button>
                                </div>
                            </div>
                            <div class="row">
                                <label for="cmbTipoSolMatMed" class="col-sm-2 col-form-label">Tipo:</label>
                                <div class="col-sm-2">
                                    <select class="form-select form-select-sm" id="cmbTipoSolMatMed" name="cmbTipoSolMatMed" required>
                                        <option value="">SELECIONE</option>
                                        <?php
                                        for($lt = 0; $lt < count($listaTipo); $lt++){
                                            ?>
                                            <option value="<?php echo $listaTipo[$lt]["ID"] ?>"><?php echo $listaTipo[$lt]["NOME"] ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <label for="cmbInclusaoPrescricaoSolMatMed" class="col-sm-2 col-form-label">Inclusão Prescrição:</label>
                                <div class="col-sm-2">
                                    <select class="form-select form-select-sm" id="cmbInclusaoPrescricaoSolMatMed" name="cmbInclusaoPrescricaoSolMatMed" required>
                                        <option value="">SELECIONE</option>
                                        <?php
                                        for($lsn = 0; $lsn < count($listaSimNao); $lsn++){
                                            ?>
                                            <option value="<?php echo $listaSimNao[$lsn]["ID"] ?>"><?php echo $listaSimNao[$lsn]["NOME"] ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <label for="cmbJustificativa" class="col-sm-2 col-form-label">Justificativa:</label>
                                <div class="col-sm-6">
                                    <select class="form-select form-select-sm" id="cmbJustificativaSolMatMed" name="cmbJustificativaSolMatMed" required>
                                        <option value="">SELECIONE</option>
                                        <?php
                                        for($lsn = 0; $lsn < count($listaJustificativa); $lsn++){
                                            ?>
                                            <option value="<?php echo $listaJustificativa[$lsn]["ID"] ?>"><?php echo $listaJustificativa[$lsn]["NOME"] ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <label for="txtObservacaoSolMatMed" class="col-sm-2 col-form-label">Observação:</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control form-control-sm" id="txtObservacaoSolMatMed" name="txtObservacaoSolMatMed" style="height: 100px" maxlength="500" required></textarea>
                                </div>                                
                            </div>
                            <small>
                                <div id="mensagemsolmatmed" align="center"></div>
                            </small>                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="btn-fechar-solicitarmatmed" name="btn-fechar-solicitarmatmed" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Sair</button>
                            <button type="submit" id="btn-gravar-solicitarmatmed" name="btn-gravar-solicitarmatmed" class="btn btn-primary btn-sm">Gravar</button>
                        </div>
                    </form>                               
                </div>
            </div>
        </div>

        <!-- Rotas -->
        <div class="modal fade" id="modalSolicitarRota" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Solicitar Rota</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="formAdicionarSolRota" method="POST">
                        <input type="hidden" id="txtIdUsuarioSolRota" name="txtIdUsuarioSolRota" value="<?php echo $_SESSION["ID_USUARIO"] ?>" />
                        <div class="modal-body">
                            <div class="row">
                                <label for="txtDestinoSolRota" class="col-sm-2 col-form-label">Destino:</label>
                                <div class="col-sm-10">
                                    <input type="text" id="txtDestinoSolRota" name="txtDestinoSolRota" class="form-control form-control-sm" required/>
                                </div>                                
                            </div>
                            <div class="row">
                                <label for="txtDataMaximaResolucaoSolRota" class="col-sm-2 col-form-label">Data Máxima:</label>
                                <div class="col-sm-2">
                                    <input type="text" id="txtDataMaximaResolucaoSolRota" name="txtDataMaximaResolucaoSolRota" class="form-control form-control-sm" placeholder="dd/mm/yyyy" onkeypress="mascaraData(this)" required/>
                                </div>                                
                            </div>
                            <div class="row">
                                <label for="cmbJustificativaSolRota" class="col-sm-2 col-form-label">Justificativa:</label>
                                <div class="col-sm-6">
                                    <select class="form-select form-select-sm" id="cmbJustificativaSolRota" name="cmbJustificativaSolRota" required>
                                        <option value="">SELECIONE</option>
                                        <?php
                                        for($lsn = 0; $lsn < count($listaJustificativa); $lsn++){
                                            ?>
                                            <option value="<?php echo $listaJustificativa[$lsn]["ID"] ?>"><?php echo $listaJustificativa[$lsn]["NOME"] ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <label for="cmbExtraSolRota" class="col-sm-2 col-form-label">Extra:</label>
                                <div class="col-sm-2">
                                    <select class="form-select form-select-sm" id="cmbExtraSolRota" name="cmbExtraSolRota" required>
                                        <option value="">SELECIONE</option>
                                        <?php
                                        for($lsn = 0; $lsn < count($listaSimNao); $lsn++){
                                            ?>
                                            <option value="<?php echo $listaSimNao[$lsn]["ID"] ?>"><?php echo $listaSimNao[$lsn]["NOME"] ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <label for="txtObservacaoSolRota" class="col-sm-2 col-form-label">Observação:</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control form-control-sm" id="txtObservacaoSolRota" name="txtObservacaoSolRota" style="height: 100px" maxlength="500" required></textarea>
                                </div>                                
                            </div>
                            <small>
                                <div id="mensagemsolrota" align="center"></div>
                            </small>                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="btn-fechar-SolRota" name="btn-fechar-SolRota" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Sair</button>
                            <button type="submit" id="btn-gravar-SolRota" name="btn-gravar-SolRota" class="btn btn-primary btn-sm">Gravar</button>
                        </div>
                    </form>                               
                </div>
            </div>
        </div>

        <!-- Farmácia -->
        <div class="modal fade" id="modalSolicitarFarmacia" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Farmácia</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="formAdicionarSolFarmacia" method="POST">
                        <input type="hidden" id="txtIdUsuarioSolFarmacia" name="txtIdUsuarioSolFarmacia" value="<?php echo $_SESSION["ID_USUARIO"] ?>" />
                        <div class="modal-body">                            
                            <div class="row">
                                <label for="txtCodPacienteSolFarmacia" class="col-sm-2 col-form-label">Paciente:</label>
                                <div class="col-sm-2">
                                    <div class="input-group">
                                        <input type="text" id="txtCodPacienteSolFarmacia" name="txtCodPacienteSolFarmacia" class="form-control form-control-sm" aria-label="" aria-describedby="btnPesqPacienteSolFarmacia" readonly="readonly" style="text-align: right;" required>
                                        <button class="btn btn-outline-secondary btn-sm" type="button" id="btnPesqPacienteSolFarmacia" onclick="window.open('busca.php?tipo=3&campocodigo=txtCodPacienteSolFarmacia&campodescricao=txtDescPacienteSolFarmacia&title=Pesquisar Paciente','','width=900, height=500')">...</button>
                                    </div>
                                </div>
                                <div class="col-sm-7">
                                    <input type="text" id="txtDescPacienteSolFarmacia" name="txtDescPacienteSolFarmacia" class="form-control form-control-sm" readonly="readonly"/>
                                </div>
                                <div class="col-sm-1">
                                    <button type="button" class="btn btn-primary btn-sm" id="btnLimparPacienteSolFarmacia" name="btnLimparPacienteSolFarmacia" onclick="limparPacienteSolFarmacia()">Limpar</button>
                                </div>
                            </div>
                            <div class="row">
                                <label for="txtCodEnfermeiroSolFarmacia" class="col-sm-2 col-form-label">Enfermeiro(a):</label>
                                <div class="col-sm-2">
                                    <div class="input-group">
                                        <input type="text" id="txtCodEnfermeiroSolFarmacia" name="txtCodEnfermeiroSolFarmacia" class="form-control form-control-sm" aria-label="" aria-describedby="btnPesqEnfermeiroSolFarmacia" readonly="readonly" style="text-align: right;" required>
                                        <button class="btn btn-outline-secondary btn-sm" type="button" id="btnPesqEnfermeiroSolFarmacia" onclick="window.open('busca.php?tipo=7&campocodigo=txtCodEnfermeiroSolFarmacia&campodescricao=txtDescEnfermeiroSolFarmacia&title=Pesquisar Enfermeiro','','width=900, height=500')">...</button>
                                    </div>
                                </div>
                                <div class="col-sm-7">
                                    <input type="text" id="txtDescEnfermeiroSolFarmacia" name="txtDescEnfermeiroSolFarmacia" class="form-control form-control-sm" readonly="readonly"/>
                                </div>
                                <div class="col-sm-1">
                                    <button type="button" class="btn btn-primary btn-sm" id="btnLimparEnfermeiroSolFarmacia" name="btnLimparEnfermeiroSolFarmacia" onclick="limparEnfermeiroSolFarmacia()">Limpar</button>
                                </div>
                            </div>                        
                            <div class="row">
                                <label for="txtDataMaximaResolucaoSolFarmacia" class="col-sm-2 col-form-label">Data Máxima:</label>
                                <div class="col-sm-2">
                                    <input type="text" id="txtDataMaximaResolucaoSolFarmacia" name="txtDataMaximaResolucaoSolFarmacia" class="form-control form-control-sm" placeholder="dd/mm/yyyy" onkeypress="mascaraData(this)" required/>
                                </div>
                                <div class="col-sm-2">
                                    <input type="text" id="txtHoraMaximaResolucaoSolFarmacia" name="txtHoraMaximaResolucaoSolFarmacia" class="form-control form-control-sm" placeholder="hh:mm" onkeypress="mascaraHora(this)"  required/>
                                </div>                                
                            </div>
                            <div class="row">
                                <label for="cmbJustificativaSolFarmacia" class="col-sm-2 col-form-label">Justificativa:</label>
                                <div class="col-sm-6">
                                    <select class="form-select form-select-sm" id="cmbJustificativaSolFarmacia" name="cmbJustificativaSolFarmacia" required>
                                        <option value="">SELECIONE</option>
                                        <?php
                                        for($lsn = 0; $lsn < count($listaJustificativa); $lsn++){
                                            ?>
                                            <option value="<?php echo $listaJustificativa[$lsn]["ID"] ?>"><?php echo $listaJustificativa[$lsn]["NOME"] ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <label for="cmbExtraSolFarmacia" class="col-sm-2 col-form-label">Extra:</label>
                                <div class="col-sm-2">
                                    <select class="form-select form-select-sm" id="cmbExtraSolFarmacia" name="cmbExtraSolFarmacia" required>
                                        <option value="">SELECIONE</option>
                                        <?php
                                        for($lsn = 0; $lsn < count($listaSimNao); $lsn++){
                                            ?>
                                            <option value="<?php echo $listaSimNao[$lsn]["ID"] ?>"><?php echo $listaSimNao[$lsn]["NOME"] ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <label for="txtObservacaoSolFarmacia" class="col-sm-2 col-form-label">Observação:</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control form-control-sm" id="txtObservacaoSolFarmacia" name="txtObservacaoSolFarmacia" style="height: 100px" maxlength="500" required></textarea>
                                </div>                                
                            </div>
                            <small>
                                <div id="mensagemsolfarmacia" align="center"></div>
                            </small>                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="btn-fechar-SolFarmacia" name="btn-fechar-SolFarmacia" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Sair</button>
                            <button type="submit" id="btn-gravar-SolFarmacia" name="btn-gravar-SolFarmacia" class="btn btn-primary btn-sm">Gravar</button>
                        </div>
                    </form>                               
                </div>
            </div>
        </div>

        <!-- Antibiótico -->
        <div class="modal fade" id="modalSolicitarAntibiotico" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Antibiótico</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="formAdicionarSolAntibiotico" method="POST">
                        <input type="hidden" id="txtIdUsuarioSolAntibiotico" name="txtIdUsuarioSolAntibiotico" value="<?php echo $_SESSION["ID_USUARIO"] ?>" />
                        <div class="modal-body">                            
                            <div class="row">
                                <label for="txtCodPacienteSolAntibiotico" class="col-sm-2 col-form-label">Paciente:</label>
                                <div class="col-sm-2">
                                    <div class="input-group">
                                        <input type="text" id="txtCodPacienteSolAntibiotico" name="txtCodPacienteSolAntibiotico" class="form-control form-control-sm" aria-label="" aria-describedby="btnPesqPacienteSolAntibiotico" readonly="readonly" style="text-align: right;" required>
                                        <button class="btn btn-outline-secondary btn-sm" type="button" id="btnPesqPacienteSolAntibiotico" onclick="window.open('busca.php?tipo=3&campocodigo=txtCodPacienteSolAntibiotico&campodescricao=txtDescPacienteSolAntibiotico&title=Pesquisar Paciente','','width=900, height=500')">...</button>
                                    </div>
                                </div>
                                <div class="col-sm-7">
                                    <input type="text" id="txtDescPacienteSolAntibiotico" name="txtDescPacienteSolAntibiotico" class="form-control form-control-sm" readonly="readonly"/>
                                </div>
                                <div class="col-sm-1">
                                    <button type="button" class="btn btn-primary btn-sm" id="btnLimparPacienteSolAntibiotico" name="btnLimparPacienteSolAntibiotico" onclick="limparPacienteSolAntibiotico()">Limpar</button>
                                </div>
                            </div>
                            <div class="row">
                                <label for="txtAntimicrobianoSolAntibiotico" class="col-sm-2 col-form-label">Antimicrobiano:</label>
                                <div class="col-sm-4">
                                    <input type="text" id="txtAntimicrobianoSolAntibiotico" name="txtAntimicrobianoSolAntibiotico" class="form-control form-control-sm" required/>
                                </div>                  
                            </div>
                            <div class="row">
                                <label for="txtDoseSolAntibiotico" class="col-sm-2 col-form-label">Dose:</label>
                                <div class="col-sm-4">
                                    <input type="text" id="txtDoseSolAntibiotico" name="txtDoseSolAntibiotico" class="form-control form-control-sm" required/>
                                </div>                  
                            </div>                            
                            <div class="row">
                                <label for="txtDiluicaoSolAntibiotico" class="col-sm-2 col-form-label">Diluição:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control form-control-sm" id="txtDiluicaoSolAntibiotico" name="txtDiluicaoSolAntibiotico" maxlength="100" required />
                                </div>                  
                            </div>
                            <div class="row">
                                <label for="txtIntervaloSolAntibiotico" class="col-sm-2 col-form-label">Intervalo:</label>
                                <div class="col-sm-4">
                                    <input type="text" id="txtIntervaloSolAntibiotico" name="txtIntervaloSolAntibiotico" class="form-control form-control-sm" required/>
                                </div>                  
                            </div>
                            <div class="row">
                                <label for="txtViaSolAntibiotico" class="col-sm-2 col-form-label">Via:</label>
                                <div class="col-sm-4">
                                    <input type="text" id="txtViaSolAntibiotico" name="txtViaSolAntibiotico" class="form-control form-control-sm" required/>
                                </div>                  
                            </div>
                            <div class="row">
                                <label for="txtDiasSolAntibiotico" class="col-sm-2 col-form-label">Dias:</label>
                                <div class="col-sm-4">
                                    <input type="text" id="txtDiasSolAntibiotico" name="txtDiasSolAntibiotico" class="form-control form-control-sm" onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="5" required/>
                                </div>                  
                            </div>
                            <div class="row">
                                <label for="txtMotivoSolAntibiotico" class="col-sm-2 col-form-label">Motivo:</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control form-control-sm" id="txtMotivoSolAntibiotico" name="txtMotivoSolAntibiotico" style="height: 100px" maxlength="500" required></textarea>
                                </div>                  
                            </div>
                            <small>
                                <div id="mensagemsolantibiotico" align="center"></div>
                            </small>                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="btn-fechar-SolAntibiotico" name="btn-fechar-SolAntibiotico" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Sair</button>
                            <button type="submit" id="btn-gravar-SolAntibiotico" name="btn-gravar-SolAntibiotico" class="btn btn-primary btn-sm">Gravar</button>
                        </div>
                    </form>                               
                </div>
            </div>
        </div>
    </body>
</html>

<script>    
    function limparEnfermeiroSolMatMed(){
        document.getElementById('txtCodEnfermeiro').value = "";
        document.getElementById('txtDescEnfermeiro').value = "";
    }

    function limparPacienteSolMatMed(){
        document.getElementById('txtCodPaciente').value = "";
        document.getElementById('txtDescPaciente').value = "";
    }

    function limparEnfermeiroSolFarmacia(){
        document.getElementById('txtCodEnfermeiroSolFarmacia').value = "";
        document.getElementById('txtDescEnfermeiroSolFarmacia').value = "";
    }

    function limparPacienteSolFarmacia(){
        document.getElementById('txtCodPacienteSolFarmacia').value = "";
        document.getElementById('txtDescPacienteSolFarmacia').value = "";
    }

    function limparPacienteSolAntibiotico(){
        document.getElementById('txtCodPacienteSolAntibiotico').value = "";
        document.getElementById('txtDescPacienteSolAntibiotico').value = "";
    }

    function limparPacientePesq(){
        document.getElementById('txtCodPacientePesq').value = "";
        document.getElementById('txtDescPacientePesq').value = "";
    }

    function limparEnfermeiroPesq(){
        document.getElementById('txtCodEnfermeiroPesq').value = "";
        document.getElementById('txtDescEnfermeiroPesq').value = "";
    }
    
    function abrirSolicitacaoMatMed(){
        $("#mensagemsolmatmed").text("");
        $("#mensagemsolmatmed").removeClass();

        var myModal = new bootstrap.Modal(document.getElementById("modalSolicitarMatMed"), {});
        myModal.show();
    }

    function abrirSolicitacaoRota(){
        $("#mensagemsolrota").text("");
        $("#mensagemsolrota").removeClass();

        var myModal = new bootstrap.Modal(document.getElementById("modalSolicitarRota"), {});
        myModal.show();
    }

    function abrirSolicitacaoFarmacia(){
        $("#mensagemsolfarmacia").text("");
        $("#mensagemsolfarmacia").removeClass();

        var myModal = new bootstrap.Modal(document.getElementById("modalSolicitarFarmacia"), {});
        myModal.show();
    }

    function abrirSolicitacaoAntibiotico(){
        $("#mensagemsolantibiotico").text("");
        $("#mensagemsolantibiotico").removeClass();

        var myModal = new bootstrap.Modal(document.getElementById("modalSolicitarAntibiotico"), {});
        myModal.show();
    }

    $("#formAdicionarSolMatMed").submit(function(){
        event.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "solicitacaoservico_mov.php?tipo=1",
            type: "POST",
            data: formData, 

            success: function(mensagem){
                $("#mensagemsolmatmed").text("");
                $("#mensagemsolmatmed").removeClass();
                if (mensagem.trim() == "Incluído com sucesso."){
                    window.location.reload(true);
                    $("#btn-fechar-solicitarmatmed").click();                            
                } else {
                    $("#mensagemsolmatmed").addClass("text-danger")
                    $("#mensagemsolmatmed").text(mensagem);
                }
            },

            cache: false,
            contentType: false,
            processData: false,
        });
    });

    $("#formAdicionarSolRota").submit(function(){
        event.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "solicitacaoservico_mov.php?tipo=2",
            type: "POST",
            data: formData, 

            success: function(mensagem){
                $("#mensagemsolrota").text("");
                $("#mensagemsolrota").removeClass();
                if (mensagem.trim() == "Incluído com sucesso."){
                    window.location.reload(true);
                    $("#btn-fechar-solicitarrota").click();                            
                } else {
                    $("#mensagemsolrota").addClass("text-danger")
                    $("#mensagemsolrota").text(mensagem);
                }
            },

            cache: false,
            contentType: false,
            processData: false,
        });
    });

    $("#formAdicionarSolFarmacia").submit(function(){
        event.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "solicitacaoservico_mov.php?tipo=3",
            type: "POST",
            data: formData, 

            success: function(mensagem){
                $("#mensagemsolfarmacia").text("");
                $("#mensagemsolfarmacia").removeClass();
                if (mensagem.trim() == "Incluído com sucesso."){
                    window.location.reload(true);
                    $("#btn-fechar-SolFarmacia").click();                            
                } else {
                    $("#mensagemsolfarmacia").addClass("text-danger")
                    $("#mensagemsolfarmacia").text(mensagem);
                }
            },

            cache: false,
            contentType: false,
            processData: false,
        });
    });

    $("#formAdicionarSolAntibiotico").submit(function(){
        event.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "solicitacaoservico_mov.php?tipo=4",
            type: "POST",
            data: formData, 

            success: function(mensagem){
                $("#mensagemsolantibiotico").text("");
                $("#mensagemsolantibiotico").removeClass();
                if (mensagem.trim() == "Incluído com sucesso."){
                    window.location.reload(true);
                    $("#btn-fechar-SolAntibiotico").click();                            
                } else {
                    $("#mensagemsolantibiotico").addClass("text-danger")
                    $("#mensagemsolantibiotico").text(mensagem);
                }
            },

            cache: false,
            contentType: false,
            processData: false,
        });
    });
</script>