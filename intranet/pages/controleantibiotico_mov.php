<?php
require_once('../models/ccidantibioticomodel.php');
require_once("../controllers/ccidcontroller.php");

$ctr = new CcidController();

if ($_REQUEST["tipo"] == "E"){
    try{
        $ctr->excluirAntibiotico($_POST["txtCodigoExc"], $_POST["txtUsuarioExc"], $_POST["txtMotivoExc"]);
        echo "Excluído com sucesso."; exit();
    } catch(Exception $e){
        echo "Erro ao excluir o antibiótico. Erro: " . $e->getMessage(); exit();
    }
} else if ($_REQUEST["tipo"] == "I"){
    $c = new CcidAntibioticoModel();
    try{
        $c->setId($_POST["txtCodigo"]);
        $c->setIdAdmission($_POST["txtCodPaciente"]);
        $c->setDataInicio(date("d/m/Y"));
        $c->setTipoPad($_POST["cmbTipoPad"]);
        $c->setOrigemInfec($_POST["cmbOrigemInfeccao"]);
        $c->setStatus($_POST["cmbStatus"]);
        $c->setAntimicrobiano($_POST["txtAntimicrobiano"]);
        $c->setMotivo($_POST["cmbTipoInfeccao"]);
        $c->setObs($_POST["txtObservacao"]);
        $c->setDose($_POST["txtDose"]);
        $c->setIntervalo($_POST["txtIntervalo"]);
        $c->setVia($_POST["txtVia"]);
        $c->setDias($_POST["txtDia"]);
        $c->setDtAntIni($_POST["txtDataInicio"]);
        $c->setDtAntFim($_POST["txtDataFim"]);
        $c->setExame($_POST["txtExame"]);
        $c->setResultado($_POST["txtResultado"]);
        $ctr->validaDadosAntibiotico($c);
        echo "Incluído com sucesso."; exit();
    } catch(Exception $e){
        echo "Erro ao inserir o antibiótico. Erro: " . $e->getMessage(); exit();
    }
}