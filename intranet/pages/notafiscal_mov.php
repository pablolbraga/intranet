<?php
require_once("../controllers/notafiscalcontroller.php");
require_once("../models/notafiscalmodel.php");
require_once("../helpers/funcoes.php");

$funcao = new Funcoes();
$ctr = new NotaFiscalController();

if ($_REQUEST["tipo"] == "N"){

    try{
        $c = new NotaFiscalModel();
        $c->setCodigo($_POST["txtCodigoNotaFiscal"]);
        $c->setTipo($_POST["cmbTipo"]);
        $c->setCliente($_POST["txtCliente"]);
        $c->setServico($_POST["txtServico"]);
        $c->setValor($funcao->converterDecimalParaBanco($_POST["txtValorNota"]));
        $c->setIrrf($funcao->converterDecimalParaBanco($_POST["txtIrrf"]));
        $c->setIss($funcao->converterDecimalParaBanco($_POST["txtIss"]));
        $c->setCofins($funcao->converterDecimalParaBanco($_POST["txtCofins"]));
        $c->setPis($funcao->converterDecimalParaBanco($_POST["txtPis"]));
        $c->setCsll($funcao->converterDecimalParaBanco($_POST["txtCsll"]));
        $c->setDataemissao($_POST["txtDataEmissao"]);
        $c->setUsuariocad($_POST["txtCodUsuario"]);
        $c->setLog("");
        $c->setNotafiscal($_POST["txtNotaFiscal"]);
        $ctr->validaDados($c);
        echo "Incluído com sucesso."; exit();
    } catch(Exception $e){
        echo "Erro ao registrar a nota fiscal. Erro: " . $e->getMessage(); exit();
    }

} else if ($_REQUEST["tipo"] == "X"){
    try{
        $ctr->excluir($_POST["txtCodigoNotaFiscalExc"], $_POST["txtMotivoExc"], $_POST["txtCodUsuarioExc"]);
        echo "Excluído com sucesso."; exit();
    } catch(Exception $e){
        echo "Erro ao excluir a nota fiscal. Erro: " . $e->getMessage(); exit();
    }
}