<?php
require_once("../models/solicitacaomatmedmodel.php");
require_once("../models/rotamodel.php");
require_once("../models/farmaciamodel.php");
require_once("../helpers/funcoes.php");
require_once("../controllers/usuariocontroller.php");

$funcao = new Funcoes();
$ctrUsuario = new UsuarioController();

if ($_REQUEST["tipo"] == "1"){

    require_once("../controllers/solicitacaoservicocontroller.php");
    $ctrSolicitacaoServico = new SolicitacaoServicoController();

    $datamax = explode("/", $_POST["txtDataMaximaResolucaoSolMatMed"]);
    $xdata = $datamax[2] . $datamax[1] . $datamax[0];
    $xhora = "183000";
    $hoje = date("YmdHis");
    $dt = $xdata . $xhora;
    if ($hoje > $dt){
        echo "Data solicitada não pode ser menor que a data máxima. Data Máxima: " . $dt . ", Hoje: " . $hoje; exit();
    } else {

        $sol = new SolicitacaoMatMedModel();
        $sol->setIdusuariosolicitante(@$_POST["txtIdUsuarioSolMatMed"]);
        $sol->setDatasolicitacao(date("d/m/Y H:i:s"));
        $sol->setDatamaxima(@$_POST["txtDataMaximaResolucaoSolMatMed"]);
        $sol->setIdpaciente(@$_POST["txtCodPacienteSolMatMed"]);
        $sol->setIdenfermeiro(@$_POST["txtCodEnfermeiroSolMatMed"]);
        $sol->setPedidosemanal(@$_POST["cmbTipoSolMatMed"]);
        $sol->setInclusaoprescricao(@$_POST["cmbInclusaoPrescricaoSolMatMed"]);
        $sol->setObservacao(@$_POST["txtObservacaoSolMatMed"]);
        $sol->setJustificativa(@$_POST["cmbJustificativaSolMatMed"]);
        $sol->setTipopedido("");

        if($_POST["cmbJustificativaSolMatMed"] == "Alteração no estado clínico"){
            $sol->setStatus("A");
            $sol->setTipo("2");
        } else if($_POST["cmbJustificativaSolMatMed"] == "Recolhimentos (Equipamentos / Mat /Med)"){
            $sol->setStatus("A");
            $sol->setTipo("3");
        } else {
            $sol->setStatus("");
            $sol->setTipo("2");
        }
        $ctrSolicitacaoServico->incluir($sol);

    }

} else if ($_REQUEST["tipo"] == "2"){

    require_once("../controllers/rotacontroller.php");
    $ctrRota = new RotaController();

    $data_solic = date("d/m/Y");
    $hora_solic = date("H:i");

    $x_data_min = $funcao->adicionarHoraUtil($data_solic . " " . $hora_solic, 1);
    //echo $x_data_min; exit();

    $data_min = substr($x_data_min, 0, 10);
    $hora_min = substr($x_data_min, 11, 5);
    $dia_semana = $funcao->retornarDiaSemana($data_solic);
    //echo "Dia da Semana: " . $dia_semana; exit();

    // trata-se os dias uteis e dias nao uteis para chegar a data correta de solicitacao minima
    if ($dia_semana == "6") {
        if ($hora_solic > date("22:59")) {
            $data_min = $funcao->adicionarDiasUteis($data_min, 1);
            $hora_min = $funcao->adicionarHora($hora_min, 55);
        }
    } else if ($dia_semana == "7") {
        if ($hora_solic >= date("00:00")) {
            $data_min = $funcao->adicionarDiasUteis($data_min, 1);
            $hora_min = date("08:00");
        }
    } else if ($dia_semana == "1") {
        if ($hora_solic >= date("00:00")) {
            $data_min = $funcao->adicionarDiasUteis($data_min, 1);
            $hora_min = date("08:00");
        }
    } else if ($hora_solic > date("22:59")) {
        $hora_min = $funcao->adicionarHora($hora_min, 7);
    } else if ($hora_solic >= date("00:00") && $hora_solic <= date("06:59")) {
        $hora_min = date("08:00");
    }
    //echo "Data Mínima: {$data_min}, Hora Mínima:  {$hora_min}"; exit();

    $datamin = explode("/", $data_min);
    $xdatamin = $datamin[2] . $datamin[1] . $datamin[0];
    $horamin = explode(":", $hora_min);
    $xhoramin = $horamin[0] . $horamin[1] . ":00";

    $datamax = explode("/", @$_POST["txtDataMaximaResolucaoSolRota"]);
    $xdata = $datamax[2] . $datamax[1] . $datamax[0];
    $horamax = explode(":", "23:59");
    $xhora = $horamax[0] . $horamax[1] . ":00";
    $dtmax = substr($xdata . $xhora, 0, 12);
    $dtmin = substr($xdatamin . $xhoramin, 0, 12);
    //echo "Data Mínima: {$dtmin}, Data Máxima:  {$dtmax}"; exit();
    

    if ($dtmax >= $dtmin){
        $hoje = date("YmdHis", strtotime('now') - (date('I') * 3600));
        $dt = $xdata . $xhora;
        if ($hoje > $dt) { // Abre quando $hoje é maior de $dt
            echo "Data Maxima não pode ser anterior a data atual";
            exit();
        } else { //Fecha quando $hoje é maior de $dt e abre quando $dt <= $hoje
            $rotaModel = new RotaModel();
            $rotaModel->setCodigo(date("YmdHis") . $funcao->gerarSenha());
            $rotaModel->setIdusuariosolicitante(@$_POST["txtIdUsuarioSolRota"]);
            $rotaModel->setLocal(@$_POST["txtDestinoSolRota"]);
            $rotaModel->setJustificativa(@$_POST["cmbJustificativaSolRota"]);
            $rotaModel->setObservacao(@$_POST["txtObservacaoSolRota"]);
            $rotaModel->setStatus("S");
            $rotaModel->setExtra(@$_POST["cmbExtraSolRota"]);
            $rotaModel->setDatasaida(date("d/m/Y H:i:s"));
            $rotaModel->setDatamaxima(@$_POST["txtDataMaximaResolucaoSolRota"] . " 23:59:59");
            $rotaModel->setIdmedicosolicitante(null);
            $ctrRota->incluir($rotaModel);            
            echo "Incluído com sucesso.";
            exit();
        }
    } else {
        echo "Data máxima não pode ser menor que 2 horas uteis da data de solicitação.";
        exit();
    }

} else if ($_REQUEST["tipo"] == "3"){
    require_once("../controllers/farmaciacontroller.php");
    $ctrFarmacia = new FarmaciaController();

    $datamax = explode("/", @$_POST["txtDataMaximaResolucaoSolFarmacia"]);
    $xdata = $datamax[2] . $datamax[1] . $datamax[0];
    $horamax = explode(":", @$_POST["txtHoraMaximaResolucaoSolFarmacia"]);
    $xhora = $horamax[0] . $horamax[1] . ":00";
    $hoje = date("YmdHis");
    $dt = $xdata . $xhora;

    if ($hoje > $dt){
        echo "Data solicitada da Farmácia não pode ser menor que a data máxima!";
        exit();
    } else {
        
        $farmModel = new FarmaciaModel();
        $farmModel->setId(date("YmdHis") . $funcao->gerarSenha());
        $farmModel->setIdusu_solic(@$_POST["txtIdUsuarioSolFarmacia"]);
        $farmModel->setDtsolic(date("d/m/Y H:i:s"));
        $farmModel->setDtmax($_POST["txtDataMaximaResolucaoSolFarmacia"] . " " . $_POST["txtHoraMaximaResolucaoSolFarmacia"] . ":00");
        $farmModel->setIdadmission(@$_POST["txtCodPacienteSolFarmacia"]);
        $farmModel->setIdenfer_solic(@$_POST["txtCodEnfermeiroSolFarmacia"]);
        $farmModel->setExtra(@$_POST["cmbExtraSolFarmacia"] == "NAO" ? "N" : "S");
        $farmModel->setObservacao(@$_POST["txtObservacaoSolFarmacia"]);
        $farmModel->setJustificativa(@$_POST["cmbJustificativaSolFarmacia"]);
        $ctrFarmacia->incluir($farmModel);

        $dadosUsuario = $ctrUsuario->buscarPorId(@$_POST["txtIdUsuarioSolFarmacia"]);

        $html = "
        <html>
            <head>
                <style type='text/css'>
                    .titulo_gg{ font-family: 'Myriad Pro' ,Arial, Helvetica, sans-serif; font-size: 25px; font-weight: normal; letter-spacing: 0.9px; white-space: nowrap; color: #0d4362; text-align: left; }
                    .cor1{ background: rgb(0, 153, 204); }
                    .cor2{ background: rgb(232, 250, 255); }
                    .fonte1{ font-family: Tahoma; color: #FFFFFF; font-weight: bold; vertical-align: middle; font-size: 10px; }
                    .fonte2{ font-family: Tahoma; color: #FFFFFF; font-weight: bold; vertical-align: middle; font-size: 14px; }
                    .label1{ font-family: Tahoma; color: rgb(51, 102, 153); font-weight: normal; vertical-align: middle; font-size: 14px; }
                </style>
            </head>
            <body>
                <table style='width=100%;'>
                    <tr>
                        <td style='width=50%;' class='cor1'>
                            <label class='fonte2'>Solicitante:</label>
                        </td>
                        <td style='width=50%;' class='cor2'>
                            <label class='label1'>" . $dadosUsuario[0]["NOME"] . "</label>
                        </td>
                    </tr>
                    <tr>
                        <td style='width=50%;' class='cor1'><label class='fonte2'>Paciente:</label></td>
                        <td style='width=50%;' class='cor2'><label class='label1'>" . @$_POST["txtDescPacienteSolFarmacia"] . "</label></td>
                    </tr>
                    <tr>
                        <td style='width=50%;' class='cor1'><label class='fonte2'>Enfermeira:</label></td>
                        <td style='width=50%;' class='cor2'><label class='label1'>" . @$_POST["txtDescEnfermeiroSolFarmacia"] . "</label></td>
                    </tr>
                    <tr>
                        <td style='width=50%;' class='cor1'><label class='fonte2'>Data da Solicitação:</label></td>
                        <td style='width=50%;' class='cor2'><label class='label1'>" . $farmModel->getDtsolic() . "</label></td>
                    </tr>
                    <tr>
                        <td style='width=50%;' class='cor1'><label class='fonte2'>Data máxima para resolução:</label></td>
                        <td style='width=50%;' class='cor2'><label class='label1'>" . $farmModel->getDtmax() . "</label></td>
                    </tr>                
                    <tr>
                        <td style='width=50%;' class='cor1'><label class='fonte2'>Justificativa:</label></td>
                        <td style='width=50%;' class='cor2'><label class='label1'>" . $farmModel->getJustificativa() . "</label></td>
                    </tr>
                    <tr>
                        <td style='width=50%;' class='cor1'><label class='fonte2'>Observação:</label></td>
                        <td style='width=50%;' class='cor2'><label class='label1'>" . $farmModel->getObservacao() . "</label></td>
                    </tr>
                    <tr>
                        <td style='width=100%;' colspan='2'><i>Acessar à intranet para dar baixa na solicitação.</i></td>
                    </tr>
                </table>
            </body>
        </html>
        ";
        $funcao->enviarEmail("suprimentos_geral@sauderesidence.com.br", "SOLICITAÇÃO FARMÁCIA", $html);
        echo "Incluído com sucesso.";
        exit();
    }

} else if ($_REQUEST["tipo"] == "4"){
    require_once("../controllers/antibioticocontroller.php");
    $ctrAntibiotico = new AntibioticoController();

        
    $antib = new AntibioticoModel();
    $antib->setIdadmission(@$_POST["txtCodPacienteSolAntibiotico"]);
    $antib->setAntimicrobiano(@$_POST["txtAntimicrobianoSolAntibiotico"]);
    $antib->setDose(@$_POST["txtDoseSolAntibiotico"]);
    $antib->setIntervalo(@$_POST["txtIntervaloSolAntibiotico"]);
    $antib->setVia(@$_POST["txtViaSolAntibiotico"]);
    $antib->setDias(@$_POST["txtDiasSolAntibiotico"]);
    $antib->setMotivo(@$_POST["txtMotivoSolAntibiotico"]);
    $antib->setIdusuario(@$_POST["txtIdUsuarioSolAntibiotico"]);
    $antib->setDiluicao(@$_POST["txtDiluicaoSolAntibiotico"]);
    $ctrAntibiotico->incluir($antib);

    $dadosUsuario = $ctrUsuario->buscarPorId(@$_POST["txtIdUsuarioSolAntibiotico"]);

    $html = "
    <html>
        <head>
            <style type='text/css'>
                .titulo_gg{ font-family: 'Myriad Pro' ,Arial, Helvetica, sans-serif; font-size: 25px; font-weight: normal; letter-spacing: 0.9px; white-space: nowrap; color: #0d4362; text-align: left; }
                .cor1{ background: rgb(0, 153, 204); }
                .cor2{ background: rgb(232, 250, 255); }
                .fonte1{ font-family: Tahoma; color: #FFFFFF; font-weight: bold; vertical-align: middle; font-size: 10px; }
                .fonte2{ font-family: Tahoma; color: #FFFFFF; font-weight: bold; vertical-align: middle; font-size: 14px; }
                .label1{ font-family: Tahoma; color: rgb(51, 102, 153); font-weight: normal; vertical-align: middle; font-size: 14px; }
            </style>
        </head>
        <body>
            <table style='width=100%;'>
                <tr>
                    <td style='width=50%;' class='cor1'><label class='fonte2'>Paciente:</label></td>
                    <td style='width=50%;' class='cor2'><label class='label1'>" . @$_POST["txtDescPacienteSolAntibiotico"] . "</label></td>
                </tr>
                <tr>
                    <td style='width=50%;' class='cor1'><label class='fonte2'>Antimicrobiano:</label></td>
                    <td style='width=50%;' class='cor2'><label class='label1'>" . $antib->getAntimicrobiano() . "</label></td>
                </tr>
                <tr>
                    <td style='width=50%;' class='cor1'><label class='fonte2'>Data da Solicitação:</label></td>
                    <td style='width=50%;' class='cor2'><label class='label1'>" . date("d/m/Y H:i:s") . "</label></td>
                </tr>
                <tr>
                    <td style='width=50%;' class='cor1'><label class='fonte2'>Solicitante:</label></td>
                    <td style='width=50%;' class='cor2'><label class='label1'>" . $dadosUsuario[0]["NOME"] . "</label></td>
                </tr>                 
                <tr>
                    <td style='width=50%;' class='cor1'><label class='fonte2'>Dose:</label></td>
                    <td style='width=50%;' class='cor2'><label class='label1'>" . $antib->getDose() . "</label></td>
                </tr>
                <tr>
                    <td style='width=50%;' class='cor1'><label class='fonte2'>Diluição:</label></td>
                    <td style='width=50%;' class='cor2'><label class='label1'>" . $antib->getDiluicao() . "</label></td>
                </tr>
                <tr>
                    <td style='width=50%;' class='cor1'><label class='fonte2'>Intervalo:</label></td>
                    <td style='width=50%;' class='cor2'><label class='label1'>" . $antib->getIntervalo() . "</label></td>
                </tr>
                <tr>
                    <td style='width=50%;' class='cor1'><label class='fonte2'>Via:</label></td>
                    <td style='width=50%;' class='cor2'><label class='label1'>" . $antib->getVia() . "</label></td>
                </tr>
                <tr>
                    <td style='width=50%;' class='cor1'><label class='fonte2'>Dias:</label></td>
                    <td style='width=50%;' class='cor2'><label class='label1'>" . $antib->getDias() . "</label></td>
                </tr>
                <tr>
                    <td style='width=50%;' class='cor1'><label class='fonte2'>Motivo:</label></td>
                    <td style='width=50%;' class='cor2'><label class='label1'>" . $antib->getMotivo() . "</label></td>
                </tr>
            </table>
        </body>
    </html>
    ";
    $funcao->enviarEmail("solicitacaoantibiotico@sauderesidence.com.br", "SOLICITAÇÃO ATB", $html);
    echo "Incluído com sucesso.";
    exit();
    

}