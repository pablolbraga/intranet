<?php
require_once("../controllers/solicitacaoservicocontroller.php");
require_once("../controllers/rotacontroller.php");
require_once("../controllers/pendenciascontroller.php");
require_once("../helpers/funcoes.php");
require_once("../helpers/contantes.php");

$ctr = new SolicitacaoServicoController();
$ctrRota = new RotaController();
$ctrPendencia = new PendenciasController();
$funcao = new Funcoes();

$arrayJustificativa = Constantes::$arrayJustificativaPrioridade;
$arraySituacao = Constantes::$arraySituacaoPrioridade;
$arraySimNao = Constantes::$arrSimNao;
$arrayMotivoExclusao = Constantes::$arrayMotivoExclusaoPrioridade;

$qryPendencia = $ctrPendencia->listarPendenciaPorIdPendenciaEIdUsuario(27, $_SESSION["ID_USUARIO"]);
?>

<html lang="pt">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../css/dt/dataTables.bootstrap5.min.css" rel="stylesheet" />
        <link href="../css/dt/buttons.dataTables.min.css" rel="stylesheet" />
        
        <script>
            function limparEnfermeiraPesq(){
                document.getElementById("txtCodEnfermeiraPesq").value = "";
                document.getElementById("txtDescEnfermeiraPesq").value = "";
            }

            function limparEnfermeiraCad(){
                document.getElementById("txtCodEnfermeira").value = "";
                document.getElementById("txtDescEnfermeira").value = "";
            }
        </script>
        <style>
            .roxo{
                background: #6f42c1;
            }
            .rosa{
                background: #d63384;
            }
        </style>
    </head>
    <body>
        <div class="container-fluid">
            <nav class="navbar navbar-extends-lg navbar-dark bg-primary">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">Triagem de Prioridade</a>
                    <div class="btn-group dropstart">
                        <button type="button" class="btn btn-success btn-sm" onclick="abrirGrafico()">Gráfico Mensal</button>
                    </div>
                </div>
            </nav>

            <br/>

            <form name="frmTriagemPrioridade" id="frmTriagemPrioridade" method="POST" action="index.php?pag=11">
                <div class="row">
                    <label for="txtCodEnfermeiraPesq" class="col-sm-2 col-form-label">Enfermeiro(a):</label>
                    <div class="col-sm-2">
                        <div class="input-group">
                            <input type="text" id="txtCodEnfermeiraPesq" name="txtCodEnfermeiraPesq" class="form-control form-control-sm" aria-label="" aria-describedby="btnPesqEnfermeiraPesq" readonly="readonly" value="<?php echo @$_POST["txtCodEnfermeiraPesq"] ?>" style="text-align: right;" required>
                            <button class="btn btn-outline-secondary btn-sm" type="button" id="btnPesqEnfermeiraPesq" onclick="window.open('busca.php?tipo=7&campocodigo=txtCodEnfermeiraPesq&campodescricao=txtDescEnfermeiraPesq&title=Pesquisar Enfermeiro(a)','','width=900, height=500')">...</button>
                        </div>
                    </div>
                    <div class="col-sm-7">
                        <input type="text" id="txtDescEnfermeiraPesq" name="txtDescEnfermeiraPesq" class="form-control form-control-sm" value="<?php echo @$_POST["txtDescEnfermeiraPesq"] ?>" readonly="readonly"/>
                    </div>
                    <div class="col-sm-1">
                        <button type="button" class="btn btn-primary btn-sm" id="btnLimparEnfermeiraPesq" name="btnLimparEnfermeiraPesq" onclick="limparEnfermeiraPesq()">Limpar</button>
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
                    <label for="cmbSituacaoPesq" class="col-sm-2 col-form-label">Situação:</label>
                    <div class="col-sm-2">
                        <select class="form-select form-select-sm" id="cmbSituacaoPesq" name="cmbSituacaoPesq">
                            <?php
                            for($s = 0; $s < count($arraySituacao); $s++){
                                if ($arraySituacao[$s]["ID"] == $_POST["cmbSituacaoPesq"]){ $selSituacaoPesq = "selected"; } else { $selSituacaoPesq = ""; }
                                ?>
                                <option <?php echo $selSituacaoPesq ?> value="<?php echo $arraySituacao[$s]["ID"] ?>"><?php echo $arraySituacao[$s]["NOME"] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <label for="cmbJustificativaPesq" class="col-sm-2 col-form-label">Justificativa:</label>
                    <div class="col-sm-4">
                        <select class="form-select form-select-sm" id="cmbJustificativaPesq" name="cmbJustificativaPesq">
                            <?php
                            for($j = 0; $j < count($arrayJustificativa); $j++){
                                if ($arrayJustificativa[$j]["ID"] == $_POST["cmbJustificativaPesq"]){ $selJustificativaPesq = "selected"; } else { $selJustificativaPesq = ""; }
                                ?>
                                <option <?php echo $selJustificativaPesq ?> value="<?php echo $arrayJustificativa[$j]["ID"] ?>"><?php echo $arrayJustificativa[$j]["NOME"] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <label for="cmbPedidoSemanalPesq" class="col-sm-2 col-form-label">Pedido Semanal:</label>
                    <div class="col-sm-2">
                        <select class="form-select form-select-sm" id="cmbPedidoSemanalPesq" name="cmbPedidoSemanalPesq">
                            <option value="">SELECIONE</option>
                            <?php
                            for($n = 0; $n < count($arraySimNao); $n++){
                                if ($arraySimNao[$n]["ID"] == $_POST["cmbPedidoSemanalPesq"]){ $selPedidoSemanalPesq = "selected"; } else { $selPedidoSemanalPesq = ""; }
                                ?>
                                <option <?php echo $selPedidoSemanalPesq ?> value="<?php echo $arraySimNao[$n]["ID"] ?>"><?php echo $arraySimNao[$n]["NOME"] ?></option>
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
                    
                    $qry = $ctr->listarTriagemPrioridade(
                        $_POST["txtDataInicioPesq"], 
                        $_POST["txtDataFimPesq"], 
                        $_POST["cmbSituacaoPesq"], 
                        $_POST["cmbPedidoSemanalPesq"],
                        $_POST["txtCodEnfermeiraPesq"],
                        $_POST["cmbJustificativaPesq"]
                    );
                    $qtd = count($qry);

                    if ($qtd > 0){
                        ?>
                        <br/>
                        <table id="example" class="table table-bordered table-sm" style="width:100%">
                            <thead>
                                <tr class="align-middle" style="text-align: center;">
                                    <th></th>
                                    <th colspan="7">Solicitação</th>
                                    <th colspan="3">Autorização</th>
                                    <th colspan="3">Triagem</th>
                                    <th colspan="3">Dispensação</th>
                                    <th colspan="2">Expedição</th>
                                    <th colspan="3">Entrega Realizada</th>
                                    <th></th>
                                    <th style="display: none;"></th>
                                    <th style="display: none;"></th>
                                    <th style="display: none;"></th>
                                    <th style="display: none;"></th>
                                    <th style="display: none;"></th>
                                    <th style="display: none;"></th>
                                    <th></th>
                                </tr>
                                <tr class="align-middle" style="text-align: center;">
                                    <th></th>
                                    <!-- Solicitação -->
                                    <th>Cor Anterior</th>
                                    <th>Solicitante</th>
                                    <th>Paciente</th>
                                    <th style="display: none;">Tipo de Pedido</th>
                                    <th>Justificativa</th>
                                    <th>Obs. Solic.</th>
                                    <th>Data Solic.</th>                                    
                                    <th>Data Máxima</th>
                                    <!-- Autorização -->
                                    <th>Usuário</th>
                                    <th>Data Baixa</th>
                                    <th>Duração</th>
                                    <!-- Triagem -->
                                    <th>Usuário</th>
                                    <th>Data Baixa</th>
                                    <th>Duração</th>
                                    <!-- Dispensação -->
                                    <th style="display: none;">Pendências</th>
                                    <th>Usuário</th>
                                    <th>Data Baixa</th>
                                    <th>Duração</th>
                                    <!-- Expedição -->
                                    <th>Data Baixa</th>
                                    <th>Duração</th>
                                    <!-- Entrega Realizada -->
                                    <th>Usuário</th>
                                    <th>Data Baixa</th>                                    
                                    <th>Duração</th>

                                    <th>Duração Total</th>
                                    <th style="display: none;">Observação Solic</th>
                                    <th style="display: none;">ID</th>
                                    <th style="display: none;">Obs. Autorização</th>
                                    <th style="display: none;">Obs. Logistica</th>
                                    <th style="display: none;">Obs. Inicio Atend. Suprimentos</th>
                                    <th style="display: none;">Obs. Fim Atend. Suprimentos</th>
                                    <th>Outras Observações</th>                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $solicitado_aut=0; 
                                $dentro_prazo_solicitado_aut=0; 
                                $fora_prazo_solicitado_aut = 0;
                                $finalizados_aut=0; 
                                $dentro_prazo_aut = 0; 
                                $fora_prazo_aut = 0;
                                
                                $solicitado_tri=0; 
                                $dentro_prazo_solicitado_tri=0; 
                                $fora_prazo_solicitado_tri = 0;
                                $finalizados_tri=0; 
                                $dentro_prazo_tri = 0; 
                                $fora_prazo_tri = 0;
                                
                                $solicitado_dis=0; 
                                $dentro_prazo_solicitado_dis=0; 
                                $fora_prazo_solicitado_dis = 0;
                                $finalizados_dis=0; 
                                $dentro_prazo_dis = 0; 
                                $fora_prazo_dis = 0;
                                
                                $solicitado_exp=0; 
                                $dentro_prazo_solicitado_exp=0; 
                                $fora_prazo_solicitado_exp = 0;
                                $finalizados_exp=0; 
                                $dentro_prazo_exp = 0; 
                                $fora_prazo_exp = 0;
                                
                                $solicitado_entr=0; 
                                $dentro_prazo_solicitado_entr=0; 
                                $fora_prazo_solicitado_entr = 0;
                                $finalizados_entr=0; 
                                $dentro_prazo_entr = 0; 
                                $fora_prazo_entr = 0;
                                
                                
                                //$qtd2 = count($qry2);
                                $modal = 0;
                                $modal2 = 0;
                                $pedSemanal = 0; $pedRotina = 0; $pedExtra = 0;
                                $red = 0; $orange = 0; $yellow = 0; $green = 0; 
                                $blue = 0;$pink = 0 ;$black = 0; $semCor = 0;
                                $gray = 0;$lilas=0;$azulclaro=0;
                                $increment = 0;
                                $increment_tri = 0;
                                $cont_horas_dis = 0;
                                
                                $cont_horas_aut = 0;
                                $cont_horas_tri = 0;
                                $cont_horas_exp = 0;
                                $cont_horas_entr = 0;
                                $cont_horas_total = 0;
                                for ($i = 0; $i < $qtd; $i++){
                                    if ($qry[$i]["PRIORIDADE"] == 1){
                                        $cor = "vermelho";
                                    } else if ($qry[$i]["PRIORIDADE"] == 2){
                                        $cor = "laranja";
                                    } else if ($qry[$i]["PRIORIDADE"] == 3){
                                        $cor = "amarelo";
                                    } else if ($qry[$i]["PRIORIDADE"] == 4){
                                        $cor = "verde";
                                    } else if ($qry[$i]["PRIORIDADE"] == 5){
                                        $cor = "azul";
                                    } else if ($qry[$i]["PRIORIDADE"] == 6){
                                        $cor = "rosa";
                                    } else if ($qry[$i]["PRIORIDADE"] == 7){
                                        $cor = "cinza";
                                    } else if ($qry[$i]["PRIORIDADE"] == 8){
                                        $cor = "roxo";
                                    } else if ($qry[$i]["PRIORIDADE"] == 9){
                                        $cor = "ciano";
                                    } else {
                                        $cor = "branco";
                                    }

                                    // Verifica se o prazo esta estourado
                                    if ($qry[$i]["STATUS"] == "F"){
                                        if ($qry[$i]["DATA_BAIXA_MOTORISTA"] == ""){
                                            $dataHoraSeparada = explode(" ",  $qry[$i]["DATA_BAIXA_LOGIS"]);
                                            $data = $dataHoraSeparada[0];
                                            $hora = $dataHoraSeparada[1];
                                            $dataSeparada = explode("/", $data);
                                            $horaSeparada = explode(":", $hora);
                                            $dt1 = $dataSeparada[2] . $dataSeparada[1] . $dataSeparada[0] . $horaSeparada[0] . $horaSeparada[1] . $horaSeparada[2];
                                        } else {
                                            $dataHoraSeparada = explode(" ",  $qry[$i]["DATA_BAIXA_MOTORISTA"]);
                                            $data = $dataHoraSeparada[0];
                                            $hora = $dataHoraSeparada[1];
                                            $dataSeparada = explode("/", $data);
                                            $horaSeparada = explode(":", $hora);
                                            $dt1 = $dataSeparada[2] . $dataSeparada[1] . $dataSeparada[0] . $horaSeparada[0] . $horaSeparada[1] . $horaSeparada[2];
                                        }
                                        $dataHoraSeparada = explode(" ",  $qry[$i]["DATA_MAXIMA"]);
                                        $data = $dataHoraSeparada[0];
                                        $hora = $dataHoraSeparada[1];
                                        $dataSeparada = explode("/", $data);
                                        $horaSeparada = explode(":", $hora);
                                        $dt2 = $dataSeparada[2] . $dataSeparada[1] . $dataSeparada[0] . $horaSeparada[0] . $horaSeparada[1] . $horaSeparada[2];
                                        //$dt2 = $qry[$i]["DATA_MAXIMA"];
                                    } else {
                                        $dt1 = date("YmdHis");
                                        $dataHoraSeparada = explode(" ",  $qry[$i]["DATA_MAXIMA"]);
                                        $data = $dataHoraSeparada[0];
                                        $hora = $dataHoraSeparada[1];
                                        $dataSeparada = explode("/", $data);
                                        $horaSeparada = explode(":", $hora);
                                        $dt2 = $dataSeparada[2] . $dataSeparada[1] . $dataSeparada[0] . $horaSeparada[0] . $horaSeparada[1] . $horaSeparada[2];
                                    }

                                    $dif = (int)$dt1 - (int)$dt2;

                                    $style = "";
                                    if ($dif > 0){
                                        $style = "table-dark";
                                    } 

                                    if($qry[$i]["PEDIDO_SEMANAL"] == "SIM")
                                        $pedSemanal++;
                                    else if($qry[$i]["PEDIDO_SEMANAL"] == "NAO")
                                        $pedExtra++;
                                    else
                                        $pedRotina++;

                                    ?>
                                    <tr class="align-middle <?php echo $style ?>" style="text-align: center;">
                                        <td>
                                            <?php
                                            if (count($qryPendencia) > 0){
                                                if ($qry[$i]["STATUS"] != "F"){
                                                    ?>
                                                    <a href="#" class="btn btn-danger btn-sm" onclick="excluirSolicitacao(this)">Excluir</a>
                                                    <a href="#" class="btn btn-primary btn-sm" onclick="mudarPrioridade(this)">Mudar Prioridade</a>
                                                    <?php
                                                }                                                
                                            }                                            
                                            ?>
                                        </td>
                                        <!-- Solicitação -->
                                        <td>
                                            <img class="rounded-circle" alt="100x100" width="40" height="40" src="../imgs/<?php echo $cor ?>.png"  data-holder-rendered="true">
                                        </td>
                                        <td><?php echo $qry[$i]["NMSOLICITANTE"] ?></td>
                                        <td><?php echo $qry[$i]["NMPACIENTE"] ?></td>
                                        <td style="display: none;"><?php echo $qry[$i]["TIPO_PEDIDOS"] ?></td>
                                        <td><?php echo $qry[$i]["JUSTIFICATIVA"] ?></td>
                                        <td>
                                            <a href="#" class="btn btn-link btn-sm" onclick="verObservacao(this)">Ver</a>
                                        </td>
                                        <td><?php echo $qry[$i]["DATA_SOLIC"] ?></td>
                                        <td><?php echo $qry[$i]["DATA_MAXIMA"] ?></td>
                                        <!-- Autorização -->
                                        <td><?php echo $qry[$i]["NMUSUBAIXA"] ?></td>
                                        <td><?php echo $qry[$i]["DATA_BAIXA"] ?></td>
                                        <td>
                                            <?php
                                            if ($qry[$i]["STATUS"] == "S"){
                                                $solicitado_aut++;
                                                $inicio = DateTime::createFromFormat('d/m/Y H:i:s', $qry[$i]["DATA_MAXIMA"]);
                                                $fim = DateTime::createFromFormat('d/m/Y H:i:s', date("d/m/Y H:i:s", strtotime('now')-(date('I')*3600)));
                                                if($inicio > $fim){
                                                    $dentro_prazo_solicitado_aut++;
                                                } else {
                                                    $fora_prazo_solicitado_aut++;
                                                }
                                            }
                                            if($qry[$i]["DATA_BAIXA"]!=''){
                                                $duracao = $funcao->retornarDiferencaDataHora($qry[$i]["DATA_SOLIC"], $qry[$i]["DATA_BAIXA"]);
                                                $inicio = DateTime::createFromFormat('d/m/Y H:i:s', $qry[$i]["DATA_MAXIMA"]);
                                                $fim = DateTime::createFromFormat('d/m/Y H:i:s', $qry[$i]["DATA_BAIXA"]);
                                                if($inicio > $fim){ 
                                                    $mensagem='-';  
                                                    //$classHoraUtil = 'labelAzul'; 
                                                    $dentro_prazo_aut++;
                                                } else { 
                                                    //$classHoraUtil = 'labelAzul';  
                                                    $fora_prazo_aut++;
                                                }
                                                $finalizados_aut++;
                                                echo $duracao;                                            
                                                $horas_aut[] = strtotime($duracao);
                                                $cont_horas_aut++;
                                            }
                                            ?>
                                        </td>
                                        <!-- Triagem -->
                                        <td><?php echo $qry[$i]["NMPRIORIDADE"] ?></td>
                                        <td><?php echo $qry[$i]["DATA_BAIXA_PRIORIDADE"] ?></td>
                                        <td>
                                            <?php
                                                if ($qry[$i]["STATUS"] == "P"){
                                                    $solicitado_tri++;
                                                    $inicio = DateTime::createFromFormat('d/m/Y H:i:s', $qry[$i]["DATA_MAXIMA"]);
                                                    $fim = DateTime::createFromFormat('d/m/Y H:i:s', date("d/m/Y H:i:s", strtotime('now')-(date('I')*3600)));
                                                    if($inicio > $fim){
                                                        $dentro_prazo_solicitado_tri++;
                                                    } else {
                                                        $fora_prazo_solicitado_tri++;
                                                    }
                                                }
                                                if($qry[$i]["DATA_BAIXA_PRIORIDADE"]!=''){
                                                    $duracao = $funcao->retornarDiferencaDataHora($qry[$i]["DATA_SOLIC"], $qry[$i]["DATA_BAIXA_PRIORIDADE"]);
                                                    $inicio = DateTime::createFromFormat('d/m/Y H:i:s', $qry[$i]["DATA_MAXIMA"]);
                                                    $fim = DateTime::createFromFormat('d/m/Y H:i:s', $qry[$i]["DATA_BAIXA_PRIORIDADE"]);
                                                    if($inicio > $fim){ 
                                                        $mensagem='-';  
                                                        //$classHoraUtil = 'labelAzul'; 
                                                        $dentro_prazo_tri++;
                                                    } else { 
                                                        //$classHoraUtil = 'labelAzul';  
                                                        $fora_prazo_tri++;
                                                    }
                                                    $finalizados_tri++;
                                                    echo $duracao;
                                                    $horas_tri[] = strtotime($duracao);
                                                    $cont_horas_tri++;
                                                } else {
                                                    echo "&nbsp;";
                                                }
                                            ?>
                                        </td>
                                        <!-- Dispensação -->
                                        <td style="display: none;"></td>
                                        <td><?php echo $qry[$i]["NMLOGISTICA"] ?></td>
                                        <td><?php echo $qry[$i]["DATA_BAIXA_LOGIS"] ?></td>                                        
                                        <td>
                                            <?php
                                                if ($qry[$i]["STATUS"] == "P"){
                                                    $solicitado_dis++;
                                                    $inicio = DateTime::createFromFormat('d/m/Y H:i:s', $qry[$i]["DATA_MAXIMA"]);
                                                    $fim = DateTime::createFromFormat('d/m/Y H:i:s', date("d/m/Y H:i:s", strtotime('now')-(date('I')*3600)));
                                                    if($inicio > $fim){
                                                        $dentro_prazo_solicitado_dis++;
                                                    } else {
                                                        $fora_prazo_solicitado_dis++;
                                                    }
                                                }
                                                if($qry[$i]["DATA_BAIXA_LOGIS"]!=''){
                                                    $duracao = $funcao->retornarDiferencaDataHora($qry[$i]["DATA_BAIXA"], $qry[$i]["DATA_BAIXA_LOGIS"]);
                                                    $inicio = DateTime::createFromFormat('d/m/Y H:i:s', $qry[$i]["DATA_MAXIMA"]);
                                                    $fim = DateTime::createFromFormat('d/m/Y H:i:s', $qry[$i]["DATA_BAIXA_LOGIS"]);
                                                    if($inicio > $fim){ 
                                                        $mensagem='-';  
                                                        //$classHoraUtil = 'labelAzul'; 
                                                        $dentro_prazo_dis++;
                                                    } else { 
                                                        //$classHoraUtil = 'labelAzul';  
                                                        $fora_prazo_dis++;
                                                    }
                                                    $finalizados_dis++;
                                                    echo $duracao;
                                                    $horas_dis[] = strtotime($duracao);
                                                    $cont_horas_dis++;
                                                } else {
                                                    echo "&nbsp;";
                                                }
                                            ?>
                                        </td>
                                        <!-- Expedição -->
                                        <?php
                                        $qryExp = $ctrRota->buscarRegistroPorSolicitacao($qry[$i]["ID"]);
                                        $qtdExp = count($qryExp);
                                        if ($qtdExp > 0){
                                            ?>
                                            <td><?php echo $qryExp[0]["DTINIATEND"] ?></td>
                                            <td>
                                                <?php
                                                if($qry[$i]["STATUS"]=='S'){
                                                    $solicitado_exp++;
                                                    $inicio = DateTime::createFromFormat('d/m/Y H:i:s', $qryExp[0]["DATA_MAXIMA"]);
                                                    $fim = DateTime::createFromFormat('d/m/Y H:i:s', date("d/m/Y H:i:s", strtotime('now')-(date('I')*3600)));
                                                    if($inicio > $fim){ 
                                                        $dentro_prazo_solicitado_exp++; 
                                                    } else { 
                                                        $fora_prazo_solicitado_exp++; 
                                                    }
                                                }
                                                if($qryExp[0]["DTINIATEND"] != ''){
                                                    $inicio = DateTime::createFromFormat('d/m/Y H:i:s', $qry[$i]["DATA_MAXIMA"]);
                                                    $fim = DateTime::createFromFormat('d/m/Y H:i:s', $qryExp[0]["DTINIATEND"]);
                                                    if($inicio > $fim){ 
                                                        $menssagem='-';  
                                                        //$classHoraUtil = 'labelAzul'; 
                                                        $dentro_prazo_exp++;
                                                    } else { 
                                                        //$classHoraUtil = 'labelAzul';  
                                                        $fora_prazo_exp++;
                                                    }
                                                    $finalizados_exp++;
                                                } else {
                                                    echo "&nbsp;";
                                                }

                                                if ($qry[$i]["DATA_BAIXA_LOGIS"] == ""){
                                                    $duracao = "";
                                                } else {
                                                    if ($qryExp[0]["DTINIATEND"] == "") 
                                                        $duracao = "";
                                                    else{
                                                        $duracao = $funcao->retornarDiferencaDataHora($qry[$i]["DATA_BAIXA_LOGIS"], $qryExp[0]["DTINIATEND"]);
                                                    }
                                                    //conta duração expedição
                                                    $horas_exp[] = strtotime($duracao);
                                                    $cont_horas_exp++;
                                                }
                                                echo $duracao;
                                                ?>
                                            </td>
                                            <?php
                                        } else {
                                            ?>
                                            <td></td>
                                            <td></td>
                                            <?php
                                        }
                                        ?>
                                        <!-- Entrega Realizada -->
                                        <td><?php echo $qry[$i]["NMMOTORISTA"] ?></td>
                                        <td><?php echo $qry[$i]["DATA_BAIXA_MOTORISTA"] ?></td>
                                        <td>
                                            <?php
                                            if($qry[$i]["STATUS"]=='S') {
                                                $solicitado_entr++;
                                                $inicio = DateTime::createFromFormat('d/m/Y H:i:s', $qry[$i]["DATA_MAXIMA"]);
                                                $fim = DateTime::createFromFormat('d/m/Y H:i:s', date("d/m/Y H:i:s", strtotime('now')-(date('I')*3600)));
                                                if($inicio > $fim){ 
                                                    $dentro_prazo_solicitado_entr++; 
                                                } else { 
                                                    $fora_prazo_solicitado_entr++; 
                                                }
                                            }
                                            if($qry[$i]["DATA_BAIXA_MOTORISTA"]!='') {
                                                $duracao = $funcao->diferenca_data_hora($qry[$i]["DATA_BAIXA"], $qry[$i]["DATA_BAIXA_MOTORISTA"]);
                                                $inicio = DateTime::createFromFormat('d/m/Y H:i:s', $qry[$i]["DATA_MAXIMA"]);
                                                $fim = DateTime::createFromFormat('d/m/Y H:i:s', $qry[$i]["DATA_BAIXA_MOTORISTA"]);
                                                if($inicio > $fim){ 
                                                    $menssagem='-';  
                                                    //$classHoraUtil = 'labelAzul'; 
                                                    $dentro_prazo_entr++;
                                                } else { 
                                                    //$classHoraUtil = 'labelAzul';  
                                                    $fora_prazo_entr++;
                                                }
                                                $finalizados_entr++;
                                                echo $duracao;
        
                                                //conta duração entrega
                                                $horas_entr[] = strtotime($duracao);
                                                $cont_horas_entr++;
        
                                            } else {
                                                echo "&nbsp;";
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if($qry[$i]["DATA_BAIXA_MOTORISTA"] != null){
                                                $duracaoTotal = $funcao->retornarDiferencaDataHora($qry[$i]["DATA_SOLIC"], $qry[$i]["DATA_BAIXA_MOTORISTA"]);
                                               //conta duração total
                                                $horas_total[] = strtotime($duracaoTotal);
                                                $cont_horas_total++; 
                                            }else{
                                                $duracaoTotal = "";
                                            }
                                            echo $duracaoTotal;
                                            ?>
                                        </td>
                                        <td style="display: none;"><?php echo $qry[$i]["OBSERVACAO_SOLIC"] ?></td>
                                        <td style="display: none;"><?php echo $qry[$i]["ID"] ?></td>
                                        <td style="display: none;"><?php echo $qry[$i]["OBS_AUTORIZACAO"] ?></td>
                                        <td style="display: none;"><?php echo $qry[$i]["OBS_LOGISTICA"] ?></td>
                                        <td style="display: none;"><?php echo $qry[$i]["OBS_INICIOATENDIMENTOSUPRI"] ?></td>
                                        <td style="display: none;"><?php echo $qry[$i]["OBS_FINALATENDIMENTOSUPRI"] ?></td>
                                        <td>
                                            <a href="#" class="btn btn-link btn-sm" onclick="abrirOutrasObservacoes(this)">Ver</a>
                                        </td>
                                        
                                    </tr>
                                    <?php

                                    if ($finalizados_aut > 0){
                                        $porcentagem_finalizados_aut = ($finalizados_aut/$finalizados_aut) *100;
                                        $porcentagem_dentro_prazo_aut = ($dentro_prazo_aut/$finalizados_aut) *100;
                                        $porcentagem_fora_prazo_aut = ($fora_prazo_aut/$finalizados_aut) *100;
                                    } else {
                                        $porcentagem_finalizados_aut = 0;
                                        $porcentagem_dentro_prazo_aut = 0;
                                        $porcentagem_fora_prazo_aut = 0;
                                    }

                                    if ($solicitado_aut > 0){
                                        $porcentagem_solicitados_aut = ($solicitado_aut/$solicitado_aut) *100;
                                        $porcentagem_solic_fora_prazo_aut = ($fora_prazo_solicitado_aut/$solicitado_aut) *100;
                                    } else {
                                        $porcentagem_solicitados_aut = 0;
                                        $porcentagem_solic_fora_prazo_aut = 0;
                                    }
                                    
                                    if ($finalizados_tri > 0){
                                        $porcentagem_finalizados_tri = ($finalizados_tri/$finalizados_tri) *100;
                                        $porcentagem_dentro_prazo_tri = ($dentro_prazo_tri/$finalizados_tri) *100;
                                        $porcentagem_fora_prazo_tri = ($fora_prazo_tri/$finalizados_tri) *100;
                                    } else {
                                        $porcentagem_finalizados_tri = 0;
                                        $porcentagem_dentro_prazo_tri = 0;
                                        $porcentagem_fora_prazo_tri = 0;
                                    }
                                    
                                    if ($solicitado_tri > 0){
                                        $porcentagem_solicitados_tri = ($solicitado_tri/$solicitado_tri) *100;
                                        $porcentagem_solic_fora_prazo_tri = ($fora_prazo_solicitado_tri/$solicitado_tri) *100;
                                    } else {
                                        $porcentagem_solicitados_tri = 0;
                                        $porcentagem_solic_fora_prazo_tri = 0;
                                    }

                                    if ($finalizados_dis > 0){
                                        $porcentagem_finalizados_dis = ($finalizados_dis/$finalizados_dis) *100;
                                        $porcentagem_dentro_prazo_dis = ($dentro_prazo_dis/$finalizados_dis) *100;
                                        $porcentagem_fora_prazo_dis = ($fora_prazo_dis/$finalizados_dis) *100;
                                    } else {
                                        $porcentagem_finalizados_dis = 0;
                                        $porcentagem_dentro_prazo_dis = 0;
                                        $porcentagem_fora_prazo_dis = 0;
                                    }

                                    if ($solicitado_dis > 0){
                                        $porcentagem_solicitados_dis = ($solicitado_dis/$solicitado_dis) *100;
                                        $porcentagem_solic_fora_prazo_dis = ($fora_prazo_solicitado_dis/$solicitado_dis) *100;
                                    } else {
                                        $porcentagem_solicitados_dis = 0;
                                        $porcentagem_solic_fora_prazo_dis = 0;
                                    }

                                    if ($finalizados_exp > 0){
                                        $porcentagem_finalizados_exp = ($finalizados_exp/$finalizados_exp) *100;
                                        $porcentagem_dentro_prazo_exp = ($dentro_prazo_exp/$finalizados_exp) *100;
                                        $porcentagem_fora_prazo_exp = ($fora_prazo_exp/$finalizados_exp) *100;
                                    } else {
                                        $porcentagem_finalizados_exp = 0;
                                        $porcentagem_dentro_prazo_exp = 0;
                                        $porcentagem_fora_prazo_exp = 0;
                                    }
                                    
                                    if ($solicitado_exp > 0){
                                        $porcentagem_solicitados_exp = ($solicitado_exp/$solicitado_exp) *100;
                                        $porcentagem_solic_fora_prazo_exp = ($fora_prazo_solicitado_exp/$solicitado_exp) *100;
                                    } else {
                                        $porcentagem_solicitados_exp = 0;
                                        $porcentagem_solic_fora_prazo_exp = 0;
                                    }
                                    
                                    if ($finalizados_entr > 0){
                                        $porcentagem_finalizados_entr = ($finalizados_entr/$finalizados_entr) *100;
                                        $porcentagem_dentro_prazo_entr = ($dentro_prazo_entr/$finalizados_entr) *100;
                                        $porcentagem_fora_prazo_entr = ($fora_prazo_entr/$finalizados_entr) *100;
                                    } else {
                                        $porcentagem_finalizados_entr = 0;
                                        $porcentagem_dentro_prazo_entr = 0;
                                        $porcentagem_fora_prazo_entr = 0;
                                    }

                                    if ($solicitado_entr > 0){
                                        $porcentagem_solicitados_entr = ($solicitado_entr/$solicitado_entr) *100;
                                        $porcentagem_solic_fora_prazo_entr = ($fora_prazo_solicitado_entr/$solicitado_entr) *100;
                                    } else {
                                        $porcentagem_solicitados_entr = 0;
                                        $porcentagem_solic_fora_prazo_entr = 0;
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                        <br/>
        
                        <table class="table table-bordered table-sm">
                            <tr>
                                <td colspan="3" style="text-align: center;"><b>Autorização</b></td>
                                <td colspan="3" style="text-align: center;"><b>Triagem</b></td>
                                <td colspan="3" style="text-align: center;"><b>Dispensação</b></td>
                                <td colspan="3" style="text-align: center;"><b>Expedição</b></td>
                                <td colspan="3" style="text-align: center;"><b>Entrega</b></td>
                                <td style="text-align: center;"><b>Total</b></td>
                            </tr>
                            <tr>
                                <td style="text-align: center;"><b>Média</b></td>
                                <td style="text-align: center;"><b>Finalizado</b></td>
                                <td style="text-align: center;"><b>Solicitado</b></td>
                                <td style="text-align: center;"><b>Média</b></td>
                                <td style="text-align: center;"><b>Finalizado</b></td>
                                <td style="text-align: center;"><b>Solicitado</b></td>
                                <td style="text-align: center;"><b>Média</b></td>
                                <td style="text-align: center;"><b>Finalizado</b></td>
                                <td style="text-align: center;"><b>Solicitado</b></td>
                                <td style="text-align: center;"><b>Média</b></td>
                                <td style="text-align: center;"><b>Finalizado</b></td>
                                <td style="text-align: center;"><b>Solicitado</b></td>
                                <td style="text-align: center;"><b>Média</b></td>
                                <td style="text-align: center;"><b>Finalizado</b></td>
                                <td style="text-align: center;"><b>Solicitado</b></td>
                                <td style="text-align: center;"><b>Média</b></td>
                            </tr>
                            <tr>
                                <td style="text-align: center;"><b><?php echo date('H:i:s', array_sum($horas_aut) / $cont_horas_aut); ?></b></td>
                                <td style="text-align: center;">
                                    <?php 
                                    echo "<b>" . $finalizados_aut ." (".round($porcentagem_finalizados_aut, 2) ."%)
                                    <br>No Prazo: " . $dentro_prazo_aut ." (".round($porcentagem_dentro_prazo_aut, 2) ."%) 
                                    <br>Fora do Prazo: " . $fora_prazo_aut ." (".round($porcentagem_fora_prazo_aut, 2) ."%)
                                    </b>";
                                    ?>
                                </td>
                                <td style="text-align: center;">
                                    <?php
                                    echo "<b>" . $solicitado_aut ." (".round($porcentagem_solicitados_aut, 2) ."%)" . "
                                    <br>Fora do Prazo solicitado: " . $fora_prazo_solicitado_aut ." (".round($porcentagem_fora_prazo_aut, 2) ."%)
                                    </b>";
                                    ?>
                                </td>

                                <td style="text-align: center;"><b><?php echo date('H:i:s', array_sum($horas_tri) / $cont_horas_tri); ?></b></td>
                                <td style="text-align: center;">
                                    <?php 
                                    echo "<b>" . $finalizados_tri ." (".round($porcentagem_finalizados_tri, 2) ."%)
                                    <br>No Prazo: " . $dentro_prazo_tri ." (".round($porcentagem_dentro_prazo_tri, 2) ."%) 
                                    <br>Fora do Prazo: " . $fora_prazo_tri ." (".round($porcentagem_fora_prazo_tri, 2) ."%)
                                    </b>";
                                    ?>
                                </td>
                                <td style="text-align: center;">
                                    <?php
                                    echo "<b>" . $solicitado_tri ." (".round($porcentagem_solicitados_tri, 2) ."%)" . "
                                    <br>Fora do Prazo solicitado: " . $fora_prazo_solicitado_tri ." (".round($porcentagem_fora_prazo_tri, 2) ."%)
                                    </b>";
                                    ?>
                                </td>
                                
                                <td style="text-align: center;"><b><?php echo date('H:i:s', array_sum($horas_dis) / $cont_horas_dis); ?></b></td>
                                <td style="text-align: center;">
                                    <?php 
                                    echo "<b>" . $finalizados_dis ." (".round($porcentagem_finalizados_dis, 2) ."%)
                                    <br>No Prazo: " . $dentro_prazo_dis ." (".round($porcentagem_dentro_prazo_dis, 2) ."%) 
                                    <br>Fora do Prazo: " . $fora_prazo_dis ." (".round($porcentagem_fora_prazo_dis, 2) ."%)
                                    </b>";
                                    ?>
                                </td>
                                <td style="text-align: center;">
                                    <?php
                                    echo "<b>" . $solicitado_dis ." (".round($porcentagem_solicitados_dis, 2) ."%)" . "
                                    <br>Fora do Prazo solicitado: " . $fora_prazo_solicitado_dis ." (".round($porcentagem_fora_prazo_dis, 2) ."%)
                                    </b>";
                                    ?>
                                </td>

                                <td style="text-align: center;"><b><?php echo date('H:i:s', array_sum($horas_exp) / $cont_horas_exp); ?></b></td>
                                <td style="text-align: center;">
                                    <?php 
                                    echo "<b>" . $finalizados_exp ." (".round($porcentagem_finalizados_exp, 2) ."%)
                                    <br>No Prazo: " . $dentro_prazo_exp ." (".round($porcentagem_dentro_prazo_exp, 2) ."%) 
                                    <br>Fora do Prazo: " . $fora_prazo_exp ." (".round($porcentagem_fora_prazo_exp, 2) ."%)
                                    </b>";
                                    ?>
                                </td>
                                <td style="text-align: center;">
                                    <?php
                                    echo "<b>" . $solicitado_exp ." (".round($porcentagem_solicitados_exp, 2) ."%)" . "
                                    <br>Fora do Prazo solicitado: " . $fora_prazo_solicitado_exp ." (".round($porcentagem_fora_prazo_exp, 2) ."%)
                                    </b>";
                                    ?>
                                </td>

                                <td style="text-align: center;"><b><?php echo date('H:i:s', array_sum($horas_entr) / $cont_horas_entr); ?></b></td>
                                <td style="text-align: center;">
                                    <?php 
                                    echo "<b>" . $finalizados_entr ." (".round($porcentagem_finalizados_entr, 2) ."%)
                                    <br>No Prazo: " . $dentro_prazo_entr ." (".round($porcentagem_dentro_prazo_entr, 2) ."%) 
                                    <br>Fora do Prazo: " . $fora_prazo_entr ." (".round($porcentagem_fora_prazo_entr, 2) ."%)
                                    </b>";
                                    ?>
                                </td>
                                <td style="text-align: center;">
                                    <?php
                                    echo "<b>" . $solicitado_entr ." (".round($porcentagem_solicitados_entr, 2) ."%)" . "
                                    <br>Fora do Prazo solicitado: " . $fora_prazo_solicitado_entr ." (".round($porcentagem_fora_prazo_entr, 2) ."%)
                                    </b>";
                                    ?>
                                </td>

                                <td style="text-align: center;"><b><?php echo date('H:i:s', array_sum($horas_total) / $cont_horas_total); ?></b></td>                
                            </tr>
                            <tr>
                                <td colspan="3">
                                    Pedidos Semanais: <?php echo $pedSemanal; ?>
                                </td>
                                <td colspan="3">
                                    Pedidos de Rotina: <?php echo $pedRotina; ?>
                                </td>
                                <td colspan="3">
                                    Pedidos Extras: <?php echo $pedExtra; ?>
                                </td>
                                <td colspan="7">&nbsp;</td>
                            </tr>
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

        <div class="modal fade" id="modalExcluirTriagem" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Excluir Solicitação</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="formExcluirSolicitacao" method="POST">
                        <input type="hidden" id="txtIdUsuarioExc" name="txtIdUsuarioExc" value="<?php echo $_SESSION["ID_USUARIO"] ?>" />
                        <input type="hidden" id="txtCodigoExc" name="txtCodigoExc" />
                        <div class="modal-body">
                            <div class="row">
                                <label for="txtDescPacienteExc" class="col-sm-2 col-form-label">Paciente:</label>
                                <div class="col-sm-10">
                                    <input type="text" id="txtDescPacienteExc" name="txtDescPacienteExc" class="form-control form-control-sm" readonly="readonly"/>
                                </div>
                            </div>
                            <div class="row">
                                <label for="txtDataSolicitacaoExc" class="col-sm-2 col-form-label">Data da Solicitação:</label>
                                <div class="col-sm-4">
                                    <input type="text" id="txtDataSolicitacaoExc" name="txtDataSolicitacaoExc" class="form-control form-control-sm" readonly="readonly" />
                                </div>                                
                            </div>
                            <div class="row">
                                <label for="txtDescSolicitanteExc" class="col-sm-2 col-form-label">Solicitante:</label>
                                <div class="col-sm-10">
                                    <input type="text" id="txtDescSolicitanteExc" name="txtDescSolicitanteExc" class="form-control form-control-sm" readonly="readonly"/>
                                </div>
                            </div>
                            <div class="row">
                                <label for="txtSolicitacaoExc" class="col-sm-2 col-form-label">Solicitação:</label>
                                <div class="col-sm-10">
                                    <input type="text" id="txtSolicitacaoExc" name="txtSolicitacaoExc" class="form-control form-control-sm" readonly="readonly"/>
                                </div>
                            </div>
                            <div class="row">
                                <label for="cmbMotivoExclusao" class="col-sm-2 col-form-label">Motivo:</label>
                                <div class="col-sm-4">
                                    <select class="form-select form-select-sm" id="cmbMotivoExclusao" name="cmbMotivoExclusao">
                                        <?php
                                        for($lt = 0; $lt < count($arrayMotivoExclusao); $lt++){
                                            if ($arrayMotivoExclusao[$lt]["ID"] == $_POST["cmbStatusPesq"]){ $selMotivoExclusao = "selected"; } else { $selMotivoExclusao = ""; }
                                            ?>
                                            <option <?php echo $selMotivoExclusao ?> value="<?php echo $arrayMotivoExclusao[$lt]["ID"] ?>"><?php echo $arrayMotivoExclusao[$lt]["NOME"] ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <label for="txtObservacaoExc" class="col-sm-2 col-form-label">Observação:</label>
                                <div class="col-sm-10">
                                    <input type="text" id="txtObservacaoExc" name="txtObservacaoExc" class="form-control form-control-sm"/>
                                </div>
                            </div>
                            <small>
                                <div id="mensagem-exc" align="center"></div>
                            </small> 
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="btn-fechar-exclusao" name="btn-fechar-exclusao" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Sair</button>
                            <button type="submit" id="btn-gravar-exclusao" name="btn-gravar-exclusao" class="btn btn-primary btn-sm">Excluir</button>
                        </div>
                    </form>                               
                </div>
            </div>
        </div>
        
        <div class="modal fade" id="modalMudancaTriagem" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Mudar Prioridade</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="formMudancaTriagem" method="POST">
                        <input type="hidden" id="txtIdUsuarioAlt" name="txtIdUsuarioAlt" value="<?php echo $_SESSION["ID_USUARIO"] ?>" />
                        <input type="hidden" id="txtCodigoAlt" name="txtCodigoAlt" />
                        <div class="modal-body">
                            <div class="row">
                                <label for="txtDescPacienteAlt" class="col-sm-2 col-form-label">Paciente:</label>
                                <div class="col-sm-10">
                                    <input type="text" id="txtDescPacienteAlt" name="txtDescPacienteAlt" class="form-control form-control-sm" readonly="readonly"/>
                                </div>
                            </div>
                            <div class="row">
                                <label for="txtDataSolicitacaoAlt" class="col-sm-2 col-form-label">Data da Solicitação:</label>
                                <div class="col-sm-4">
                                    <input type="text" id="txtDataSolicitacaoAlt" name="txtDataSolicitacaoAlt" class="form-control form-control-sm" readonly="readonly" />
                                </div>                                
                            </div>
                            <div class="row">
                                <label for="txtDataMaximaSolicitacaoAlt" class="col-sm-2 col-form-label">Data Máxima da Solicitação:</label>
                                <div class="col-sm-4">
                                    <input type="text" id="txtDataMaximaSolicitacaoAlt" name="txtDataMaximaSolicitacaoAlt" class="form-control form-control-sm" readonly="readonly" />
                                </div>                                
                            </div>
                            <div class="row">
                                <label for="txtDescSolicitanteAlt" class="col-sm-2 col-form-label">Solicitante:</label>
                                <div class="col-sm-10">
                                    <input type="text" id="txtDescSolicitanteAlt" name="txtDescSolicitanteAlt" class="form-control form-control-sm" readonly="readonly"/>
                                </div>
                            </div>
                            <div class="row">
                                <label for="txtSolicitacaoAlt" class="col-sm-2 col-form-label">Solicitação:</label>
                                <div class="col-sm-10">
                                    <input type="text" id="txtSolicitacaoAlt" name="txtSolicitacaoAlt" class="form-control form-control-sm" readonly="readonly"/>
                                </div>
                            </div>
                            <div class="row">
                                <label for="cmbPrioridadeAlt" class="col-sm-2 col-form-label">Prioridade:</label>
                                <div class="col-sm-4">
                                    <select class="form-select form-select-sm" id="cmbPrioridadeAlt" name="cmbPrioridadeAlt" required>
                                        <option value="">Selecione</option>
                                        <option value="1">Vermelho</option>
                                        <option value="2">Laranja</option>
                                        <option value="3">Amarelo</option>
                                        <option value="4">Verde</option>
                                        <option value="5">Azul</option>
                                        <option value="6">Rosa</option>
                                        <option value="7">Cinza</option>
                                        <option value="8">Lilás</option>
                                        <option value="9">Azul Claro</option>
                                    </select>
                                </div>
                            </div>
                            <small>
                                <div id="mensagem-alt" align="center"></div>
                            </small> 
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="btn-fechar-alt" name="btn-fechar-alt" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Sair</button>
                            <button type="submit" id="btn-gravar-alt" name="btn-gravar-alt" class="btn btn-primary btn-sm">Alterar</button>
                        </div>
                    </form>                               
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalVerObservacao" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Observação</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="formVerObservacao" method="POST">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <textarea class="form-control form-control-sm" id="txtVerObservacao" name="txtVerObservacao" style="height: 100px" maxlength="500" readonly="readonly"></textarea>
                                </div>
                            </div>
                            <small>
                                <div id="mensagem-obs" align="center"></div>
                            </small> 
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="btn-fechar-alt" name="btn-fechar-alt" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Sair</button>
                        </div>
                    </form>                               
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalOutrasObservacoes" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Outras Observações</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="formVerOutrasObservacoes" method="POST">
                        <div class="modal-body">
                            <div class="row">
                                <label for="txtObservacaoInicial" class="col-sm-2 col-form-label">Inicial:</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control form-control-sm" id="txtObservacaoInicial" name="txtObservacaoInicial" style="height: 50px" maxlength="500" readonly="readonly"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <label for="txtObservacaoAutorizacao" class="col-sm-2 col-form-label">Autorização:</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control form-control-sm" id="txtObservacaoAutorizacao" name="txtObservacaoAutorizacao" style="height: 50px" maxlength="500" readonly="readonly"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <label for="txtObservacaoLogistica" class="col-sm-2 col-form-label">Logistica:</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control form-control-sm" id="txtObservacaoLogistica" name="txtObservacaoLogistica" style="height: 50px" maxlength="500" readonly="readonly"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <label for="txtObservacaoInicioAtendimentoSuprimentos" class="col-sm-2 col-form-label">Inicio Atend. Supr.:</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control form-control-sm" id="txtObservacaoInicioAtendimentoSuprimentos" name="txtObservacaoInicioAtendimentoSuprimentos" style="height: 50px" maxlength="500" readonly="readonly"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <label for="txtObservacaoFimAtendimentoSuprimentos" class="col-sm-2 col-form-label">Fim Atend. Supr.:</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control form-control-sm" id="txtObservacaoFimAtendimentoSuprimentos" name="txtObservacaoFimAtendimentoSuprimentos" style="height: 50px" maxlength="500" readonly="readonly"></textarea>
                                </div>
                            </div>
                            <small>
                                <div id="mensagem-obs" align="center"></div>
                            </small> 
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="btn-fechar-alt" name="btn-fechar-alt" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Sair</button>
                        </div>
                    </form>                               
                </div>
            </div>
        </div>

        
    </body>
</html>

<script>    
    function excluirSolicitacao(linha){
        var tableData = $(linha).closest("tr").find("td:not(:last-child)").map(function(){
            return $(this).text().trim();
        }).get();

        //console.log(tableData);
        $("#txtCodigoExc").val(tableData[26]);
        $("#txtDescPacienteExc").val(tableData[3]);
        $("#txtDataSolicitacaoExc").val(tableData[7]);
        $("#txtDescSolicitanteExc").val(tableData[2]);
        $("#txtSolicitacaoExc").val(tableData[25]);
        $("#cmbMotivoExclusao").val("");
        $("#txtObservacaoExc").val("");

        $("#mensagem-exc").text("");
        $("#mensagem-exc").removeClass();

        var myModal = new bootstrap.Modal(document.getElementById("modalExcluirTriagem"), {});
        myModal.show();
    }

    $("#formExcluirSolicitacao").submit(function(){
        event.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "triagemprioridade_mov.php?tipo=E",
            type: "POST",
            data: formData, 

            success: function(mensagem){
                $("#mensagem-exc").text("");
                $("#mensagem-exc").removeClass();
                if (mensagem.trim() == "Excluído com sucesso."){
                    window.location.reload(true);
                    $("#btn-fechar-exclusao").click();                            
                } else {
                    $("#mensagem-exc").addClass("text-danger")
                    $("#mensagem-exc").text(mensagem);
                }
            },

            cache: false,
            contentType: false,
            processData: false,
        });
    });

    function mudarPrioridade(linha){
        var tableData = $(linha).closest("tr").find("td:not(:last-child)").map(function(){
            return $(this).text().trim();
        }).get();

        //console.log(tableData);
        $("#txtCodigoAlt").val(tableData[26]);
        $("#txtDescPacienteAlt").val(tableData[3]);
        $("#txtDataSolicitacaoAlt").val(tableData[7]);
        $("#txtDescSolicitanteAlt").val(tableData[2]);
        $("#txtSolicitacaoAlt").val(tableData[25]);
        $("#txtDataMaximaSolicitacaoAlt").val(tableData[8]);
        $("#cmbPrioridadeAlt").val("");

        //limparCamposCadastro();
        $("#mensagem-alt").text("");
        $("#mensagem-alt").removeClass();

        var myModal = new bootstrap.Modal(document.getElementById("modalMudancaTriagem"), {});
        myModal.show();
    }

    $("#formMudancaTriagem").submit(function(){
        event.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "triagemprioridade_mov.php?tipo=T",
            type: "POST",
            data: formData, 

            success: function(mensagem){
                $("#mensagem-alt").text("");
                $("#mensagem-alt").removeClass();
                if (mensagem.trim() == "Alterado com sucesso."){
                    window.location.reload(true);
                    $("#btn-fechar-alt").click();                            
                } else {
                    $("#mensagem-alt").addClass("text-danger")
                    $("#mensagem-alt").text(mensagem);
                }
            },

            cache: false,
            contentType: false,
            processData: false,
        });
    });

    function verObservacao(linha){
        var tableData = $(linha).closest("tr").find("td:not(:last-child)").map(function(){
            return $(this).text().trim();
        }).get();

        //console.log(tableData);
        $("#txtVerObservacao").val(tableData[25]);

        //limparCamposCadastro();
        $("#mensagem-obs").text("");
        $("#mensagem-obs").removeClass();

        var myModal = new bootstrap.Modal(document.getElementById("modalVerObservacao"), {});
        myModal.show();
    }

    function abrirOutrasObservacoes(linha){
        var tableData = $(linha).closest("tr").find("td:not(:last-child)").map(function(){
            return $(this).text().trim();
        }).get();

        console.log(tableData);
        $("#txtObservacaoInicial").val(tableData[25]);
        $("#txtObservacaoAutorizacao").val(tableData[27]);
        $("#txtObservacaoLogistica").val(tableData[28]);
        $("#txtObservacaoInicioAtendimentoSuprimentos").val(tableData[29]);
        $("#txtObservacaoFimAtendimentoSuprimentos").val(tableData[30]);
        
        //limparCamposCadastro();
        $("#mensagem-alt").text("");
        $("#mensagem-alt").removeClass();

        var myModal = new bootstrap.Modal(document.getElementById("modalOutrasObservacoes"), {});
        myModal.show();
    }

    $(document).ready(function () {
        $('#example').DataTable({
            language: {
                lengthMenu: 'Mostrar _MENU_ registros por página',
                zeroRecords: 'Nada encontrado - desculpe',
                info: 'Mostrando página _PAGE_ de _PAGES_',
                infoEmpty: 'Nenhum registro disponível',
                infoFiltered: '(filtrado de _MAX_ tegistros totais)',
                search: 'Procurar',
                paginate: {
                    "next": "Próximo",
                    "previous": "Anterior",
                    "first": "Primeiro",
                    "last": "Último"
                }
            },
        });
    });
</script>