<?php
require_once("../controllers/solicitacaoprescricaocontroller.php");

$ctrSolicPresc = new SolicitacaoPrescricaoController();

$arrTipo = array('Inclusão', 'Alteração', 'Exclusão');
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
        </script>
    </head>
    <body>
        <div class="container-fluid">
            <nav class="navbar navbar-extends-lg navbar-dark bg-primary">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">Alteração de Prescrição</a>                    
                </div>
            </nav>
            <br/>
            <form name="frmSolicitarCompra" id="frmSolicitarCompra" method="POST" action="index.php?pag=9">
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
                            <input type="text" id="txtCodPacientePesq" name="txtCodPacientePesq" class="form-control form-control-sm" aria-label="" aria-describedby="btnPesqPacientePesq" readonly="readonly" value="<?php echo @$_POST["txtCodPacientePesq"] ?>" style="text-align: right;" required>
                            <button class="btn btn-outline-secondary btn-sm" type="button" id="btnPesqPacientePesq" onclick="window.open('busca.php?tipo=4&campocodigo=txtCodPacientePesq&campodescricao=txtDescPacientePesq&title=Pesquisar Paciente','','width=900, height=500')">...</button>
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

                    $qry = $ctrSolicPresc->listarAlteracaoPrescricao($_POST["txtDataInicioPesq"], $_POST["txtDataFimPesq"], "", $_POST["txtCodPacientePesq"]);
                    $qtd = count($qry);
                    if ($qtd > 0){
                        ?>
                        <br/>
                        <table class="table table-bordered table-sm">
                            <thead>
                                <tr class="align-middle">
                                    <th scope="col" rowspan="2" style="text-align: center;">Solicitação</th>
                                    <th scope="col" rowspan="2" style="text-align: center;">Paciente</th>
                                    <th scope="col" rowspan="2" style="text-align: center;">Descrição</th>
                                    <th scope="col" rowspan="2" style="text-align: center;">Status</th>
                                    <th scope="col" rowspan="2" style="text-align: center;">Data de Solicitação</th>
                                    <th scope="col" colspan="3" style="text-align: center;">Validação</th>
                                    <th scope="col" colspan="3" style="text-align: center;">Autorização</th>
                                    <th scope="col" colspan="3" style="text-align: center;">Finalização</th>
                                </tr>
                                <tr class="align-middle">
                                    <th scope="col" style="text-align: center;">Usuário</th>
                                    <th scope="col" style="text-align: center;">Data</th>
                                    <th scope="col" style="text-align: center;">Observação</th>
                                    <th scope="col" style="text-align: center;">Usuário</th>
                                    <th scope="col" style="text-align: center;">Data</th>
                                    <th scope="col" style="text-align: center;">Observação</th>
                                    <th scope="col" style="text-align: center;">Usuário</th>
                                    <th scope="col" style="text-align: center;">Data</th>
                                    <th scope="col" style="text-align: center;">Observação</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $solicitado = 0;
                                $validado = 0;
                                for ($i = 0; $i < $qtd; $i++){
                                    $index = $qry[$i]["TIPO_ALT_PRESC"];
                                    ?>
                                    <tr>
                                        <td><?php echo $qry[$i]["NMSOLIC"] ?></td>
                                        <td><?php echo $qry[$i]["NMPACIENTE"] ?></td>
                                        <td>
                                            <?php
                                            $linha = "<b><h5>Tipo da Solicitação: " . $arrTipo[$index - 1] . "</h5></b>
                                            <b>Medicamento: </b>" . $qry[$i]["MEDICAMENTO"] . "
                                            <br/>
                                            <b>Posologia: </b>" . $qry[$i]["POSOLOGIA"] . "
                                            <br/>
                                            <b>Duração: </b>" . $qry[$i]["DURACAO"] . "
                                            <br/>
                                            <b>Via: </b>" . $qry[$i]["VIA"] . "
                                            <br/>
                                            <b>Observação: </b>" . $qry[$i]["OBSERVACAO_SOLIC"];
                                            echo $linha;
                                            ?>
                                        </td>
                                        <td><?php echo $qry[$i]["STATUS_APROV"] ?></td>
                                        <td><?php echo $qry[$i]["DATA_SOLIC"] ?></td>
                                        <td><?php echo $qry[$i]["NOME_VALIDA"] ?></td>
                                        <td><?php echo $qry[$i]["DATA_VALIDA"] ?></td>
                                        <td><?php echo $qry[$i]["OBS_CASE"] ?></td>
                                        <td><?php echo $qry[$i]["NOME_AUTORIZ"] ?></td>
                                        <td><?php echo $qry[$i]["DATA_AUTORIZ"] ?></td>
                                        <td><?php echo $qry[$i]["OBSERVACAO_BAIXA"] ?></td>
                                        <td><?php echo $qry[$i]["NOME_BAIXA"] ?></td>
                                        <td><?php echo $qry[$i]["DATA_BAIXA"] ?></td>
                                        <td><?php echo $qry[$i]["OBS_FINAL"] ?></td>
                                    </tr>
                                    <?php
                                    $solicitado++;
                                    if ($qry[$i]["ID_VALIDA"] || (!$qry[$i]["ID_VALIDA"] && $qry[$i]["IDBAIXA"]) || (!$qry[$i]["IDBAIXA"] && $qry[$i]["ID_AUTORIZ"])){
                                        $validado++;
                                    }
                                }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="14">
                                        <b>Solicitado: </b><?php echo $solicitado . " (" . round(100,2) . "%)" ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="14">
                                        <b>Atualizados: </b><?php echo $validado . " (" . round($validado/$solicitado * 100,2) . "%)" ?>
                                    </td>
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