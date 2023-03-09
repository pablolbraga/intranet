<?php
require_once('../controllers/plantaocontroller.php');
require_once("../controllers/caixacontroller.php");
require_once("../controllers/solicitacaoservicocontroller.php");
require_once("../controllers/mototaxicontroller.php");
require_once("../helpers/contantes.php");

$ctrPlantao = new PlantaoController();
$ctrCaixa = new CaixaController();
$ctrSolicServico = new SolicitacaoServicoController();
$ctrMotoTaxi = new MotoTaxiController();

$listaEntradaSaida = Constantes::$arrEntradaSaida;
?>

<html>
    <head>
        
    </head>
    <body>
        <div class="container-fluid">
            <nav class="navbar navbar-extends-lg navbar-dark bg-primary">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">Plantões</a>
                    <div class="btn-group dropstart">
                        <?php
                        if ($ctrCaixa->existeCaixaEmAberto($_SESSION["ID_USUARIO"])){
                            ?>
                            <div class="btn-group dropstart">
                                <button type="button" class="btn btn-success dropdown-toggle btn-sm" data-bs-toggle="dropdown" aria-expanded="false">
                                    Adicionar Movimentação
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a href="#" class="dropdown-item" onclick="abrirDadosMovimentacaoSolicitacao()">Solicitação</a></li>
                                    <li><a href="#" class="dropdown-item" onclick="abrirDadosMovimentacaoEscala()">Escala</a></li>
                                    <li><a href="#" class="dropdown-item" onclick="abrirDadosMovimentacaoCaixa()">Caixa</a></li>
                                    <li><a href="#" class="dropdown-item" onclick="abrirDadosMovimentacaoPendencia()">Pendência</a></li>
                                    <li><a href="#" class="dropdown-item" onclick="abrirDadosMovimentacaoFarmacia()">Farmácia</a></li>
                                </ul>
                            </div>
                            
                            &nbsp;
                            <button type="button" class="btn btn-danger btn-sm" onclick="abrirDadosEncerrarPlantao()">Encerrar Plantão</button>
                            <?php
                        } else {
                            ?>
                            <button type="button" class="btn btn-success btn-sm" onclick="abrirDadosSolicitacao()">Iniciar Plantão</button>
                            <?php
                        }
                        ?>                        
                    </div>
                </div>
            </nav>
            </br>
            <form name="frmPlantao" id="frmPlantao" method="POST" action="index.php?pag=3">
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
                    <div class="col-sm-2">
                        <button type="submit" class="btn btn-primary btn-sm" id="btnPesquisar" name="btnPesquisar">Pesquisar</button>
                    </div>
                </div>
                <br>
                <?php
                if (isset($_POST["btnPesquisar"])){
                    $lista = $ctrPlantao->listarPlantao($_POST["txtDataInicioPesq"], $_POST["txtDataFimPesq"]);
                    $qtde = count($lista);
                    if ($qtde > 0){
                        ?>
                        </br>                        
                        <?php
                        for ($i = 0; $i < $qtde; $i++){
                            $data = explode(" ", $lista[$i]["DATA"]);
                            ?>
                            <p>
                                <a class="btn btn-success btn-sm" data-bs-toggle="collapse" href="#collapsePlantao<?php echo $i ?>" role="button" aria-expanded="false" aria-controls="collapseExample<?php echo $i ?>">
                                    <?php
                                    echo $lista[$i]["NMUSUARIO"] . " - " . $lista[$i]["STATUS"] . "<br>" . $data[0]
                                    ?>
                                </a>
                                <div class="collapse" id="collapsePlantao<?php echo $i ?>">
                                    <nav>
                                        <div class="nav nav-tabs" id="nab-tab<?php echo $i ?>" role="tablist">
                                            <button class="nav-link active" id="nav-solicitacao-tab<?php echo $i ?>" data-bs-toggle="tab" data-bs-target="#nav-solicitacao-<?php echo $i ?>" type="button" role="tab" aria-controls="nav-solicitacao-<?php echo $i ?>" aria-selected="true">Solicitação</button>
                                            <button class="nav-link" id="nav-escala-tab<?php echo $i ?>" data-bs-toggle="tab" data-bs-target="#nav-escala-<?php echo $i ?>" type="button" role="tab" aria-controls="nav-escala-<?php echo $i ?>" aria-selected="true">Escala</button>
                                            <button class="nav-link" id="nav-caixa-tab<?php echo $i ?>" data-bs-toggle="tab" data-bs-target="#nav-caixa-<?php echo $i ?>" type="button" role="tab" aria-controls="nav-caixa-<?php echo $i ?>" aria-selected="true">Caixa</button>
                                            <button class="nav-link" id="nav-farmacia-tab<?php echo $i ?>" data-bs-toggle="tab" data-bs-target="#nav-farmacia-<?php echo $i ?>" type="button" role="tab" aria-controls="nav-farmacia-<?php echo $i ?>" aria-selected="true">Farmácia</button>
                                            <button class="nav-link" id="nav-mototaxi-tab<?php echo $i ?>" data-bs-toggle="tab" data-bs-target="#nav-mototaxi-<?php echo $i ?>" type="button" role="tab" aria-controls="nav-mototaxi-<?php echo $i ?>" aria-selected="true">Moto Taxi</button>
                                            <button class="nav-link" id="nav-pendencia-tab<?php echo $i ?>" data-bs-toggle="tab" data-bs-target="#nav-pendencia-<?php echo $i ?>" type="button" role="tab" aria-controls="nav-pendencia-<?php echo $i ?>" aria-selected="true">Pendência</button>
                                        </div>
                                    </nav>
                                    <div class="tab-content" id="nav-tabContent-<?php echo $i ?>">
                                        <div class="tab-pane fade show active" id="nav-solicitacao-<?php echo $i ?>" role="tabpanel" aria-labelledby="nav-solicitacao-tab-<?php echo $i ?>">
                                            <?php
                                            $listaSolic = $ctrPlantao->buscarPlantaoPorId($lista[$i]["ID"], 1);
                                            $qtdeSolic = count($listaSolic);
                                            if ($qtdeSolic > 0){
                                                ?>
                                                <table class="table table-bordered table-striped border-primary table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Horário</th>
                                                            <th scope="col">Atendente</th>
                                                            <th scope="col">Protocolo</th>
                                                            <th scope="col">Observação</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        for ($s = 0; $s < $qtdeSolic; $s++){
                                                            $item = explode("<*>", $listaSolic[$s]["OBS"]);
                                                            ?>
                                                            <tr>
                                                                <td><?php echo @$listaSolic[$s]["HR_CAD"] ?></td>
                                                                <td><?php echo $item[0] ?></td>
                                                                <td><?php echo $item[1] ?></td>
                                                                <td><?php echo $item[2] ?></td>
                                                            </tr>
                                                            <?php
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                                <?php
                                            }
                                            ?>
                                        </div>

                                        <div class="tab-pane fade" id="nav-escala-<?php echo $i ?>" role="tabpanel" aria-labelledby="nav-escala-tab-<?php echo $i ?>">
                                            <?php
                                            $listaEscala = $ctrPlantao->buscarPlantaoPorId($lista[$i]["ID"], 2);
                                            $qtdeEscala = count($listaEscala);
                                            if ($qtdeEscala > 0){
                                                ?>
                                                <table class="table table-bordered table-striped border-primary table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Horário</th>
                                                            <th scope="col">Paciente</th>
                                                            <th scope="col">Quem Faltou</th>
                                                            <th scope="col">Substituto</th>
                                                            <th scope="col">Observação</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        for ($e = 0; $e < $qtdeEscala; $e++){
                                                            $item = explode("<*>", $listaEscala[$e]["OBS"]);
                                                            ?>
                                                            <tr>
                                                                <td><?php echo @$listaEscala[$e]["HR_CAD"] ?></td>
                                                                <td><?php echo $item[0] ?></td>
                                                                <td><?php echo $item[1] ?></td>
                                                                <td><?php echo $item[2] ?></td>
                                                                <td><?php echo $item[3] ?></td>
                                                            </tr>
                                                            <?php
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                                <?php
                                            }
                                            ?>
                                        </div>

                                        <div class="tab-pane fade" id="nav-caixa-<?php echo $i ?>" role="tabpanel" aria-labelledby="nav-caixa-tab-<?php echo $i ?>">
                                            <?php
                                            $listaCaixa = $ctrCaixa->buscarPorId($lista[$i]["ID_CAIXA"]);
                                            $qtdeCaixa = count($listaCaixa);
                                            if ($qtdeCaixa > 0){
                                                if ($listaCaixa[0]["VR_ENTRADA"] != ""){
                                                    ?>
                                                    <ul>
                                                        <b>Iniciou com: </b> R$ <?php echo $listaCaixa[0]["VR_ENTRADA"] ?>
                                                    </ul>
                                                    <ul>
                                                        <b>Data de Abertura: </b> <?php echo $listaCaixa[0]["DATA_ENTRADA"] ?>
                                                    </ul>
                                                    <ul>
                                                        <b>Observação: </b> <?php echo $listaCaixa[0]["OBS_ENTRADA"] ?>
                                                    </ul>
                                                    <?php
                                                }

                                                if ($listaCaixa[0]["TIPO"] != ""){
                                                    ?>
                                                    <ul>
                                                        <b>Movimentação do Caixa</b>
                                                        <br/>
                                                        <?php
                                                        for ($c = 0; $c < $qtdeCaixa; $c++){
                                                            if ($listaCaixa[$c]["TIPO"] == "E"){
                                                                $tipo = "Entrou";
                                                            } else {
                                                                $tipo = "Saiu";
                                                            }

                                                            if ($lista[$i]["STATUS"] == "EM ANDAMENTO"){
                                                                ?>
                                                                <div class="excluir" data-tipo="excluirMovCaixa" data-titulo="Deseja excluir o caixa?" data-mov="<?php echo $listaCaixa[$c]["ID_CAIXA_MOV"] ?>">
                                                                    <button title="Excluir Movimentação de Caixa" class="btn btn-danger btn-sm pull-right">
                                                                        <span class="glyphicon glyphicon-remove"></span>
                                                                    </button>
                                                                </div>
                                                                <?php
                                                            }
                                                            ?>
                                                            <ul>
                                                                <b><?php echo $tipo ?></b> R$ <?php echo $listaCaixa[$c]["VALOR"] ?>
                                                            </ul>
                                                            <ul>
                                                                <b>Descrição: </b> R$ <?php echo $listaCaixa[$c]["DESCRICAO"] ?>
                                                            </ul>
                                                            <?php
                                                        }
                                                        ?>
                                                    </ul>
                                                    <?php
                                                }

                                                if ($listaCaixa[0]["VR_SAIDA"] != ""){
                                                    ?>
                                                    <ul>
                                                        <b>Fechou com: </b> R$ <?php echo $listaCaixa[0]["VR_SAIDA"] ?>
                                                    </ul>
                                                    <ul>
                                                        <b>Data de Fechamento: </b> <?php echo $listaCaixa[0]["DATA_SAIDA"] ?>
                                                    </ul>
                                                    <ul>
                                                        <b>Observação: </b> <?php echo $listaCaixa[0]["OBS_SAIDA"] ?>
                                                    </ul>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </div>

                                        <div class="tab-pane fade" id="nav-farmacia-<?php echo $i ?>" role="tabpanel" aria-labelledby="nav-farmacia-tab-<?php echo $i ?>">
                                            <?php
                                            $listaFarmacia = $ctrPlantao->buscarPlantaoPorId($lista[$i]["ID"], 4);
                                            $qtdeFarmacia = count($listaFarmacia);
                                            if ($qtdeFarmacia > 0){
                                                ?>
                                                <table class="table table-bordered table-striped border-primary table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Data</th>
                                                            <th scope="col">Observação</th>
                                                            <th scope="col"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        for ($f = 0; $f < $qtdeFarmacia; $f++){
                                                            $item = explode("<*>", $listaFarmacia[$f]["OBS"]);
                                                            ?>
                                                            <tr>
                                                                <td><?php echo @$listaFarmacia[$f]["DT_CAD"] . " " . @$listaFarmacia[$f]["HR_CAD"] ?></td>
                                                                <td><?php echo $item[0] ?></td>
                                                                <td>
                                                                <?php
                                                                if (@$listaFarmacia[$f]["ANEXO"] != ""){
                                                                    ?>
                                                                    <a class="btn btn-success btn-sm" href="javascript:window.open('<?php echo $listaFarmacia[$f]["ANEXO"] ?>','','width=800, height=600');void[0]">Visualizar Anexo</a>
                                                                    <?php
                                                                }
                                                                ?>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                                <?php
                                            }
                                            ?>
                                        </div>

                                        <div class="tab-pane fade" id="nav-mototaxi-<?php echo $i ?>" role="tabpanel" aria-labelledby="nav-mototaxi-tab-<?php echo $i ?>">
                                            <?php
                                            //echo "Data Inicio: " . $data[0] . ", Data Fim: " . $data[0] . ", Usuario: " . $lista[$i]["ID_USU_INI"]; exit();
                                            $listaMotoTaxi = $ctrMotoTaxi->listarPorUsuario($lista[$i]["ID_USU_INI"], $data[0], $data[0]);
                                            $qtdeMotoTaxi = count($listaMotoTaxi);
                                            if ($qtdeMotoTaxi > 0){
                                                ?>
                                                <table class="table table-bordered table-striped border-primary table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Origem</th>
                                                            <th scope="col">Destino</th>
                                                            <th scope="col">Valor</th>
                                                            <th scope="col">Justificativa</th>
                                                            <th scope="col">Observação</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        for ($mt = 0; $mt < $qtdeMotoTaxi; $mt++){
                                                            ?>
                                                            <tr>
                                                                <td><?php echo @$listaMotoTaxi[$mt]["ORIGEM"] ?></td>
                                                                <td><?php echo @$listaMotoTaxi[$mt]["DESTINO"] ?></td>
                                                                <td><?php echo number_format(@$listaMotoTaxi[$mt]["VALOR"], 2, ',', '.') ?></td>
                                                                <td><?php echo @$listaMotoTaxi[$mt]["NMJUSTIFICATIVA"] ?></td>
                                                                <td><?php echo @$listaMotoTaxi[$mt]["OBSERVACAO"] ?></td>
                                                            </tr>
                                                            <?php
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                                <?php
                                            }
                                            ?>
                                        </div>

                                        <div class="tab-pane fade" id="nav-pendencia-<?php echo $i ?>" role="tabpanel" aria-labelledby="nav-pendencia-tab-<?php echo $i ?>">
                                            <?php
                                            $listaPendencia = $ctrPlantao->buscarPlantaoPorId($lista[$i]["ID"], 3);
                                            $qtdePendencia = count($listaPendencia);
                                            if ($qtdePendencia > 0){
                                                ?>
                                                <table class="table table-bordered table-striped border-primary table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Horário</th>
                                                            <th scope="col">Observação</th>
                                                            <th scope="col">Observação Baixa</th>
                                                            <th scope="col">Status</th>
                                                            <th scope="col"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        for ($lp = 0; $lp < $qtdePendencia; $lp++){
                                                            $item = explode("<*>", $listaPendencia[$lp]["OBS"]);
                                                            $status = "";
                                                            if ($listaPendencia[$lp]["GERA_BAIXA"] == "S"){
                                                                $status = "EM ANDAMENTO";
                                                            } else {
                                                                $status = "BAIXADO";
                                                            }
                                                            ?>
                                                            <tr>
                                                                <td><?php echo @$listaPendencia[$lp]["HR_CAD"] ?></td>
                                                                <td><?php echo @$item[0] ?></td>
                                                                <td><?php echo @$item[1] ?></td>
                                                                <td><?php echo $status ?></td>
                                                                <td>
                                                                    <?php
                                                                    if (@$listaPendencia[$i]["ANEXO"] != ""){
                                                                        ?>
                                                                        <br/>
                                                                        <a class="btn btn-success btn-sm" href="javascript:window.open('<?php echo $listaPendencia[$i]["ANEXO"] ?>','','width=800, height=600');void[0]">Visualizar Anexo</a>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </p>
                            <?php
                        }
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

<div class="modal fade" id="modalTrocaPlantaoInicio" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <?php
            if ($_SESSION["UGB_USUARIO"] == "RECEPCAO"){
                ?>
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Abertura do Plantão - Caixa</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>                
                <form id="formAberturaPlantaoCaixaRecepcao" method="POST">
                    <input type="hidden" name="txtCodUsuarioPlantao" id="txtCodUsuarioPlantao" value="<?php echo $_SESSION["ID_USUARIO"] ?>">                    
                    <div class="modal-body">
                        <div class="row">
                            <label for="txtDataAberturaPlantaoCaixaRecepcao" class="col-sm-2 col-form-label">Abertura:</label>
                            <div class="col-sm-5">
                                <input type="text" id="txtDataAberturaPlantaoCaixaRecepcao" name="txtDataAberturaPlantaoCaixaRecepcao" class="form-control form-control-sm" value="<?php echo date("d/m/Y H:i:s") ?>" readonly="readonly" />
                            </div>
                        </div>
                        <div class="row">
                            <label for="txtValorPlantaoCaixaRecepcao" class="col-sm-2 col-form-label">Valor:</label>
                            <div class="col-sm-5">
                                <input type="text" id="txtValorPlantaoCaixaRecepcao" name="txtValorPlantaoCaixaRecepcao" class="form-control form-control-sm" onKeyPress="return(mascaraMoeda(this,'.',',',event))" required/>
                            </div>
                        </div>
                        <div class="row">
                            <label for="txtObservacaoPlantaoCaixaRecepcao" class="col-sm-2 col-form-label">Observação:</label>
                            <div class="col-sm-10">
                                <textarea class="form-control form-control-sm" id="txtObservacaoPlantaoCaixaRecepcao" name="txtObservacaoPlantaoCaixaRecepcao" style="height: 100px" maxlength="500" required></textarea>
                            </div>                  
                        </div>
                        <small>
                            <div id="mensagemplantaocaixarecepcao" align="center"></div>
                        </small>   
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-fechar-plantaocaixa-recepcao" name="btn-fechar-plantaocaixa-recepcao" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Sair</button>
                        <button type="submit" id="btn-gravar-plantaocaixa-recepcao" name="btn-gravar-plantaocaixa-recepcao" class="btn btn-primary btn-sm">Gravar</button>
                    </div>
                </form>
                <?php
            } else {
                ?>
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Abertura do Plantão</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>                
                <form id="formAberturaPlantaoCaixa" method="POST">
                    <input type="hidden" name="txtCodUsuarioPlantao" id="txtCodUsuarioPlantao" value="<?php echo $_SESSION["ID_USUARIO"] ?>">                    
                    <div class="modal-body">
                        <div class="row">
                            <label for="txtDataAberturaPlantaoCaixa" class="col-sm-2 col-form-label">Abertura:</label>
                            <div class="col-sm-5">
                                <input type="text" id="txtDataAberturaPlantaoCaixa" name="txtDataAberturaPlantaoCaixa" class="form-control form-control-sm" value="<?php echo date("d/m/Y H:i:s") ?>" readonly="readonly" />
                            </div>
                        </div>
                        <div class="row">
                            <label for="txtObservacaoPlantaoCaixa" class="col-sm-2 col-form-label">Observação:</label>
                            <div class="col-sm-10">
                                <textarea class="form-control form-control-sm" id="txtObservacaoPlantaoCaixa" name="txtObservacaoPlantaoCaixa" style="height: 100px" maxlength="500" required></textarea>
                            </div>                  
                        </div>
                        <small>
                            <div id="mensagemplantaocaixa" align="center"></div>
                        </small>   
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-fechar-plantaocaixa" name="btn-fechar-plantaocaixa" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Sair</button>
                        <button type="submit" id="btn-gravar-plantaocaixa" name="btn-gravar-plantaocaixa" class="btn btn-primary btn-sm">Gravar</button>
                    </div>
                </form>
                <?php
            }
            ?>
            </form>                               
        </div>
    </div>
</div>

<!-- Adicionar Solicitação -->
<div class="modal fade" id="modalMovimentacaoSolicitacao" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Solicitações</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formMovimentacaoSolicitacao" method="POST">
                <input type="hidden" name="txtCodUsuarioMovimentacaoSolicitacao" id="txtCodUsuarioMovimentacaoSolicitacao" value="<?php echo $_SESSION["ID_USUARIO"] ?>">                    
                <div class="modal-body">
                    <div class="row">
                        <label for="txtAtendenteMovimentacaoSolicitacao" class="col-sm-2 col-form-label">Atendente:</label>
                        <div class="col-sm-5">
                            <input type="text" id="txtAtendenteMovimentacaoSolicitacao" name="txtAtendenteMovimentacaoSolicitacao" class="form-control form-control-sm" />
                        </div>
                    </div>
                    <div class="row">
                        <label for="txtProtocoloMovimentacaoSolicitacao" class="col-sm-2 col-form-label">Protocolo/Pedido:</label>
                        <div class="col-sm-5">
                            <input type="text" id="txtProtocoloMovimentacaoSolicitacao" name="txtProtocoloMovimentacaoSolicitacao" class="form-control form-control-sm" />
                        </div>
                    </div>
                    <div class="row">
                        <label for="txtDescricaoMovimentacaoSolicitacao" class="col-sm-2 col-form-label">Descrição:</label>
                        <div class="col-sm-10">
                            <textarea class="form-control form-control-sm" id="txtDescricaoMovimentacaoSolicitacao" name="txtDescricaoMovimentacaoSolicitacao" style="height: 100px" maxlength="500" required></textarea>
                        </div>                  
                    </div>
                    <small>
                        <div id="mensagem_movimentacao_solicitacao" align="center"></div>
                    </small>   
                </div>
                <div class="modal-footer">
                    <button type="button" id="btn-fechar-movimentacao-solicitacao" name="btn-fechar-movimentacao-solicitacao" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Sair</button>
                    <button type="submit" id="btn-gravar-movimentacao-solicitacao" name="btn-gravar-movimentacao-solicitacao" class="btn btn-primary btn-sm">Gravar</button>
                </div>
            </form> 
            </div>                              
        </div>
    </div>
</div>

<!-- Adicionar Escala -->
<div class="modal fade" id="modalMovimentacaoEscala" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Escala</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formMovimentacaoEscala" method="POST">
                <input type="hidden" name="txtCodUsuarioMovimentacaoEscala" id="txtCodUsuarioMovimentacaoEscala" value="<?php echo $_SESSION["ID_USUARIO"] ?>">                    
                <div class="modal-body">
                    <div class="row">
                        <label for="txtCodPacienteMovimentacaoEscala" class="col-sm-2 col-form-label">Paciente:</label>
                        <div class="col-sm-2">
                            <div class="input-group">
                                <input type="text" id="txtCodPacienteMovimentacaoEscala" name="txtCodPacienteMovimentacaoEscala" class="form-control form-control-sm" aria-label="" aria-describedby="btnPacienteMovimentacaoEscala" readonly="readonly" style="text-align: right;" required>
                                <button class="btn btn-outline-secondary btn-sm" type="button" id="btnPacienteMovimentacaoEscala" onclick="window.open('busca.php?tipo=8&campocodigo=txtCodPacienteMovimentacaoEscala&campodescricao=txtDescPacienteMovimentacaoEscala&title=Pesquisar Paciente','','width=900, height=500')">...</button>
                            </div>
                        </div>
                        <div class="col-sm-7">
                            <input type="text" id="txtDescPacienteMovimentacaoEscala" name="txtDescPacienteMovimentacaoEscala" class="form-control form-control-sm" readonly="readonly"/>
                        </div>
                    </div>
                    <div class="row">
                        <label for="txtTecnicoFaltaMovimentacaoEscala" class="col-sm-2 col-form-label">Técnico(a) Faltou:</label>
                        <div class="col-sm-5">
                            <input type="text" id="txtTecnicoFaltaMovimentacaoEscala" name="txtTecnicoFaltaMovimentacaoEscala" class="form-control form-control-sm" required/>
                        </div>
                    </div>
                    <div class="row">
                        <label for="txtTecnicoSubstitutoMovimentacaoEscala" class="col-sm-2 col-form-label">Técnico(a) Substituto(a):</label>
                        <div class="col-sm-5">
                            <input type="text" id="txtTecnicoSubstitutoMovimentacaoEscala" name="txtTecnicoSubstitutoMovimentacaoEscala" class="form-control form-control-sm" required/>
                        </div>
                    </div>
                    <div class="row">
                        <label for="txtDescricaoMovimentacaoEscala" class="col-sm-2 col-form-label">Descrição:</label>
                        <div class="col-sm-10">
                            <textarea class="form-control form-control-sm" id="txtDescricaoMovimentacaoEscala" name="txtDescricaoMovimentacaoEscala" style="height: 100px" maxlength="500" required></textarea>
                        </div>                  
                    </div>
                    
                    <small>
                        <div id="mensagem_movimentacao_escala" align="center"></div>
                    </small>   
                </div>
                <div class="modal-footer">
                    <button type="button" id="btn-fechar-movimentacao-escala" name="btn-fechar-movimentacao-escala" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Sair</button>
                    <button type="submit" id="btn-gravar-movimentacao-escala" name="btn-gravar-movimentacao-escala" class="btn btn-primary btn-sm">Gravar</button>
                </div>
            </form> 
            </div>                              
        </div>
    </div>
</div>

<!-- Adicionar Caixa -->
<div class="modal fade" id="modalMovimentacaoCaixa" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Caixa</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formMovimentacaoCaixa" method="POST">
                <input type="hidden" name="txtCodUsuarioMovimentacaoCaixa" id="txtCodUsuarioMovimentacaoCaixa" value="<?php echo $_SESSION["ID_USUARIO"] ?>">                    
                <div class="modal-body">
                    <div class="row">
                        <label for="cmbTipoMovimentacaoCaixa" class="col-sm-2 col-form-label">Tipo:</label>
                        <div class="col-sm-2">
                            <select class="form-select form-select-sm" id="cmbTipoMovimentacaoCaixa" name="cmbTipoMovimentacaoCaixa">
                                <option value="">SELECIONE</option>
                                <?php
                                for($lsn = 0; $lsn < count($listaEntradaSaida); $lsn++){
                                    ?>
                                    <option value="<?php echo $listaEntradaSaida[$lsn]["ID"] ?>"><?php echo $listaEntradaSaida[$lsn]["NOME"] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <label for="txtValorMovimentacaoCaixa" class="col-sm-2 col-form-label">Valor:</label>
                        <div class="col-sm-5">
                            <input type="text" id="txtValorMovimentacaoCaixa" name="txtValorMovimentacaoCaixa" class="form-control form-control-sm" style="text-align: right;" onKeyPress="return(mascaraMoeda(this,'.',',',event))" required/>
                        </div>
                    </div>
                    <div class="row">
                        <label for="txtDescricaoMovimentacaoCaixa" class="col-sm-2 col-form-label">Descrição:</label>
                        <div class="col-sm-10">
                            <textarea class="form-control form-control-sm" id="txtDescricaoMovimentacaoCaixa" name="txtDescricaoMovimentacaoCaixa" style="height: 100px" maxlength="500" required></textarea>
                        </div>                  
                    </div>
                    
                    <small>
                        <div id="mensagem_movimentacao_caixa" align="center"></div>
                    </small>   
                </div>
                <div class="modal-footer">
                    <button type="button" id="btn-fechar-movimentacao-caixa" name="btn-fechar-movimentacao-escala" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Sair</button>
                    <button type="submit" id="btn-gravar-movimentacao-caixa" name="btn-gravar-movimentacao-escala" class="btn btn-primary btn-sm">Gravar</button>
                </div>
            </form> 
            </div>                              
        </div>
    </div>
</div>

<!-- Adicionar Pendencia -->
<div class="modal fade" id="modalMovimentacaoPendencia" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Pendência</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formMovimentacaoPendencia" method="POST">
                <input type="hidden" name="txtCodUsuarioMovimentacaoPendencia" id="txtCodUsuarioMovimentacaoPendencia" value="<?php echo $_SESSION["ID_USUARIO"] ?>">                    
                <div class="modal-body">
                    <div class="row">
                        <label for="arquivoMovimentacaoPendencia" class="col-sm-2 col-form-label">Anexar Arquivo:</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="file" id="arquivoMovimentacaoPendencia" name="arquivoMovimentacaoPendencia">
                        </div>                  
                    </div>                
                    <br>
                    <div class="row">
                        <label for="txtDescricaoMovimentacaoPendencia" class="col-sm-2 col-form-label">Descrição:</label>
                        <div class="col-sm-10">
                            <textarea class="form-control form-control-sm" id="txtDescricaoMovimentacaoPendencia" name="txtDescricaoMovimentacaoPendencia" style="height: 100px" maxlength="500" required></textarea>
                        </div>                  
                    </div>                    
                    
                    <small>
                        <div id="mensagem_movimentacao_pendencia" align="center"></div>
                    </small>   
                </div>
                <div class="modal-footer">
                    <button type="button" id="btn-fechar-movimentacao-pendencia" name="btn-fechar-movimentacao-pendencia" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Sair</button>
                    <button type="submit" id="btn-gravar-movimentacao-pendencia" name="btn-gravar-movimentacao-pendencia" class="btn btn-primary btn-sm">Gravar</button>
                </div>
            </form> 
            </div>                              
        </div>
    </div>
</div>

<!-- Adicionar Farmacia -->
<div class="modal fade" id="modalMovimentacaoFarmacia" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Farmácia</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formMovimentacaoFarmacia" method="POST">
                <input type="hidden" name="txtCodUsuarioMovimentacaoFarmacia" id="txtCodUsuarioMovimentacaoFarmacia" value="<?php echo $_SESSION["ID_USUARIO"] ?>">                    
                <div class="modal-body">
                    <div class="row">
                        <label for="arquivoMovimentacaoFarmacia" class="col-sm-2 col-form-label">Anexar Arquivo:</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="file" id="arquivoMovimentacaoFarmacia" name="arquivoMovimentacaoFarmacia">
                        </div>                  
                    </div>                
                    <br>
                    <div class="row">
                        <label for="txtDescricaoMovimentacaoFarmacia" class="col-sm-2 col-form-label">Descrição:</label>
                        <div class="col-sm-10">
                            <textarea class="form-control form-control-sm" id="txtDescricaoMovimentacaoFarmacia" name="txtDescricaoMovimentacaoFarmacia" style="height: 100px" maxlength="500" required></textarea>
                        </div>                  
                    </div>                    
                    
                    <small>
                        <div id="mensagem_movimentacao_farmacia" align="center"></div>
                    </small>   
                </div>
                <div class="modal-footer">
                    <button type="button" id="btn-fechar-movimentacao-farmacia" name="btn-fechar-movimentacao-farmacia" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Sair</button>
                    <button type="submit" id="btn-gravar-movimentacao-farmacia" name="btn-gravar-movimentacao-farmacia" class="btn btn-primary btn-sm">Gravar</button>
                </div>
            </form> 
            </div>                              
        </div>
    </div>
</div>

<!-- Encerrar Plantão -->
<div class="modal fade" id="modalEncerrarPlantao" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Encerrar Plantão</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEncerrarPlantao" method="POST">
                <input type="hidden" name="txtCodUsuarioEncerrarPlantao" id="txtCodUsuarioEncerrarPlantao" value="<?php echo $_SESSION["ID_USUARIO"] ?>">                                    
                <input type="hidden" name="txtUgbEncerrarPlantao" id="txtUgbEncerrarPlantao" value="<?php echo $_SESSION["UGB_USUARIO"] ?>">     
                <div class="modal-body">
                    <?php
                    if ($_SESSION["UGB_USUARIO"] == "RECEPCAO"){
                        $saldo = $ctrCaixa->retornarSaldoMovimentacao($_SESSION["ID_USUARIO"]);
                        ?>
                        <div class="row">
                            <label for="txtSaldoEncerrarPlantao" class="col-sm-2 col-form-label">Saldo:</label>
                            <div class="col-sm-10">
                                <input type="text" id="txtSaldoEncerrarPlantao" name="txtSaldoEncerrarPlantao" class="form-control form-control-sm" value="<?php echo number_format($saldo,2,',','.') ?>" required/>
                            </div>                  
                        </div>
                        <?php
                    }
                    ?>
                    <div class="row">
                        <label for="txtDescricaoEncerrarPlantao" class="col-sm-2 col-form-label">Descrição:</label>
                        <div class="col-sm-10">
                            <textarea class="form-control form-control-sm" id="txtDescricaoEncerrarPlantao" name="txtDescricaoEncerrarPlantao" style="height: 100px" maxlength="500" required></textarea>
                        </div>                  
                    </div>                    
                    
                    <small>
                        <div id="mensagem_movimentacao_encerrarplantao" align="center"></div>
                    </small>   
                </div>
                <div class="modal-footer">
                    <button type="button" id="btn-fechar-movimentacao-encerrarplantao" name="btn-fechar-movimentacao-encerrarplantao" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Sair</button>
                    <button type="submit" id="btn-gravar-movimentacao-encerrarplantao" name="btn-gravar-movimentacao-encerrarplantao" class="btn btn-primary btn-sm">Gravar</button>
                </div>
            </form> 
            </div>                              
        </div>
    </div>
</div>

<script>
    function abrirDadosSolicitacao(){
        var myModal = new bootstrap.Modal(document.getElementById("modalTrocaPlantaoInicio"), {});
        myModal.show();
    }

    $("#formAberturaPlantaoCaixaRecepcao").submit(function(){
        event.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "plantao_mov.php?tipo=1",
            type: "POST",
            data: formData, 

            success: function(mensagem){
                $("#mensagemplantaocaixarecepcao").text("");
                $("#mensagemplantaocaixarecepcao").removeClass();
                if (mensagem.trim() == "Incluído com sucesso."){
                    window.location.reload(true);
                    $("#btn-fechar-plantaocaixa-recepcao").click();                            
                } else {
                    $("#mensagemplantaocaixarecepcao").addClass("text-danger")
                    $("#mensagemplantaocaixarecepcao").text(mensagem);
                }
            },

            cache: false,
            contentType: false,
            processData: false,
        });
    });

    $("#formAberturaPlantaoCaixa").submit(function(){
        event.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "plantao_mov.php?tipo=2",
            type: "POST",
            data: formData, 

            success: function(mensagem){
                $("#mensagemplantaocaixa").text("");
                $("#mensagemplantaocaixa").removeClass();
                if (mensagem.trim() == "Incluído com sucesso."){
                    window.location.reload(true);
                    $("#btn-fechar-plantaocaixa").click();                            
                } else {
                    $("#mensagemplantaocaixa").addClass("text-danger")
                    $("#mensagemplantaocaixa").text(mensagem);
                }
            },

            cache: false,
            contentType: false,
            processData: false,
        });
    });

    function abrirDadosMovimentacaoSolicitacao(){
        var myModal = new bootstrap.Modal(document.getElementById("modalMovimentacaoSolicitacao"), {});
        myModal.show();
    }

    $("#formMovimentacaoSolicitacao").submit(function(){
        event.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "plantao_mov.php?tipo=3",
            type: "POST",
            data: formData, 

            success: function(mensagem){
                $("#mensagem_movimentacao_solicitacao").text("");
                $("#mensagem_movimentacao_solicitacao").removeClass();
                if (mensagem.trim() == "Incluído com sucesso."){
                    window.location.reload(true);
                    $("#btn-gravar-movimentacao-solicitacao").click();                            
                } else {
                    $("#mensagem_movimentacao_solicitacao").addClass("text-danger")
                    $("#mensagem_movimentacao_solicitacao").text(mensagem);
                }
            },

            cache: false,
            contentType: false,
            processData: false,
        });
    });

    function abrirDadosMovimentacaoEscala(){
        var myModal = new bootstrap.Modal(document.getElementById("modalMovimentacaoEscala"), {});
        myModal.show();
    }

    $("#formMovimentacaoEscala").submit(function(){
        event.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "plantao_mov.php?tipo=4",
            type: "POST",
            data: formData, 

            success: function(mensagem){
                $("#mensagem_movimentacao_escala").text("");
                $("#mensagem_movimentacao_escala").removeClass();
                if (mensagem.trim() == "Incluído com sucesso."){
                    window.location.reload(true);
                    $("#btn-gravar-movimentacao-escala").click();                            
                } else {
                    $("#mensagem_movimentacao_escala").addClass("text-danger")
                    $("#mensagem_movimentacao_escala").text(mensagem);
                }
            },

            cache: false,
            contentType: false,
            processData: false,
        });
    });

    function abrirDadosMovimentacaoCaixa(){
        var myModal = new bootstrap.Modal(document.getElementById("modalMovimentacaoCaixa"), {});
        myModal.show();
    }

    $("#formMovimentacaoCaixa").submit(function(){
        event.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "plantao_mov.php?tipo=5",
            type: "POST",
            data: formData, 

            success: function(mensagem){
                $("#mensagem_movimentacao_caixa").text("");
                $("#mensagem_movimentacao_caixa").removeClass();
                if (mensagem.trim() == "Incluído com sucesso."){
                    window.location.reload(true);
                    $("#btn-gravar-movimentacao-caixa").click();                            
                } else {
                    $("#mensagem_movimentacao_caixa").addClass("text-danger")
                    $("#mensagem_movimentacao_caixa").text(mensagem);
                }
            },

            cache: false,
            contentType: false,
            processData: false,
        });
    });

    function abrirDadosMovimentacaoPendencia(){
        $("#arquivoMovimentacaoPendencia").val("");
        $("#txtDescricaoMovimentacaoPendencia").val("");
        $("#mensagem_movimentacao_pendencia").text("");
        $("#mensagem_movimentacao_pendencia").removeClass();
        var myModal = new bootstrap.Modal(document.getElementById("modalMovimentacaoPendencia"), {});
        myModal.show();
    }

    $("#formMovimentacaoPendencia").submit(function(){
        event.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "plantao_mov.php?tipo=6",
            type: "POST",
            data: formData, 

            success: function(mensagem){
                $("#mensagem_movimentacao_pendencia").text("");
                $("#mensagem_movimentacao_pendencia").removeClass();
                if (mensagem.trim() == "Incluído com sucesso."){
                    window.location.reload(true);
                    $("#btn-gravar-movimentacao-pendencia").click();                            
                } else {
                    $("#mensagem_movimentacao_pendencia").addClass("text-danger")
                    $("#mensagem_movimentacao_pendencia").text(mensagem);
                }
            },

            cache: false,
            contentType: false,
            processData: false,
        });
    });

    function abrirDadosMovimentacaoFarmacia(){
        $("#arquivoMovimentacaoFarmacia").val("");
        $("#txtDescricaoMovimentacaoFarmacia").val("");
        $("#mensagem_movimentacao_farmacia").text("");
        $("#mensagem_movimentacao_farmacia").removeClass();
        var myModal = new bootstrap.Modal(document.getElementById("modalMovimentacaoFarmacia"), {});
        myModal.show();
    }

    $("#formMovimentacaoFarmacia").submit(function(){
        event.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "plantao_mov.php?tipo=7",
            type: "POST",
            data: formData, 

            success: function(mensagem){
                $("#mensagem_movimentacao_farmacia").text("");
                $("#mensagem_movimentacao_farmacia").removeClass();
                if (mensagem.trim() == "Incluído com sucesso."){
                    window.location.reload(true);
                    $("#btn-gravar-movimentacao-farmacia").click();                            
                } else {
                    $("#mensagem_movimentacao_farmacia").addClass("text-danger")
                    $("#mensagem_movimentacao_farmacia").text(mensagem);
                }
            },

            cache: false,
            contentType: false,
            processData: false,
        });
    });

    function abrirDadosEncerrarPlantao(){
        $("#txtDescricaoEncerrarPlantao").val("");
        $("#mensagem_movimentacao_encerrarplantao").text("");
        $("#mensagem_movimentacao_encerrarplantao").removeClass();
        var myModal = new bootstrap.Modal(document.getElementById("modalEncerrarPlantao"), {});
        myModal.show();
    }

    $("#formEncerrarPlantao").submit(function(){
        event.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "plantao_mov.php?tipo=8",
            type: "POST",
            data: formData, 

            success: function(mensagem){
                $("#mensagem_movimentacao_encerrarplantao").text("");
                $("#mensagem_movimentacao_encerrarplantao").removeClass();
                if (mensagem.trim() == "Incluído com sucesso."){
                    window.location.reload(true);
                    $("#btn-gravar-movimentacao-encerrarplantao").click();                            
                } else {
                    $("#mensagem_movimentacao_encerrarplantao").addClass("text-danger")
                    $("#mensagem_movimentacao_encerrarplantao").text(mensagem);
                }
            },

            cache: false,
            contentType: false,
            processData: false,
        });
    });
</script>