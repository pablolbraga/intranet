<?php

class FarmaciaModel{

    private $id;
    private $idusu_solic;
    private $idenfer_solic;
    private $idadmission;
    private $dtsolic;
    private $dtmax;
    private $extra;
    private $justificativa;
    private $observacao;
    private $idusu_baixa;
    private $dtbaixa;
    private $resposta;

    function getObservacao() {
        return $this->observacao;
    }

    function setObservacao($observacao) {
        $this->observacao = $observacao;
    }

    function getId() {
        return $this->id;
    }

    function getIdusu_solic() {
        return $this->idusu_solic;
    }

    function getIdenfer_solic() {
        return $this->idenfer_solic;
    }

    function getIdadmission() {
        return $this->idadmission;
    }

    function getDtsolic() {
        return $this->dtsolic;
    }

    function getDtmax() {
        return $this->dtmax;
    }

    function getExtra() {
        return $this->extra;
    }

    function getJustificativa() {
        return $this->justificativa;
    }

    function getIdusu_baixa() {
        return $this->idusu_baixa;
    }

    function getDtbaixa() {
        return $this->dtbaixa;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdusu_solic($idusu_solic) {
        $this->idusu_solic = $idusu_solic;
    }

    function setIdenfer_solic($idenfer_solic) {
        $this->idenfer_solic = $idenfer_solic;
    }

    function setIdadmission($idadmission) {
        $this->idadmission = $idadmission;
    }

    function setDtsolic($dtsolic) {
        $this->dtsolic = $dtsolic;
    }

    function setDtmax($dtmax) {
        $this->dtmax = $dtmax;
    }

    function setExtra($extra) {
        $this->extra = $extra;
    }

    function setJustificativa($justificativa) {
        $this->justificativa = $justificativa;
    }

    function setIdusu_baixa($idusu_baixa) {
        $this->idusu_baixa = $idusu_baixa;
    }

    function setDtbaixa($dtbaixa) {
        $this->dtbaixa = $dtbaixa;
    }

    function getResposta() {
        return $this->resposta;
    }

    function setResposta($resposta) {
        $this->resposta = $resposta;
    }

}