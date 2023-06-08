<?php

class CcidAntibioticoModel{

    private $id;
    private $paciente;
    private $idAdmission;
    private $antimicrobiano;
    private $dataInicio;
    private $dose;
    private $intervalo;
    private $via;
    private $dias;
    private $motivo;
    private $tipoPad;
    private $origemInfec;
    private $status;
    private $obs;
    private $dtAntIni;
    private $dtAntFim;
    private $exame;
    private $resultado;    
    private $idusuario;
    private $nmusuario;
    private $diluicao;

    function getId() {
        return $this->id;
    }

    function getPaciente() {
        return $this->paciente;
    }

    function getAntimicrobiano() {
        return $this->antimicrobiano;
    }

    function getDataInicio() {
        return $this->dataInicio;
    }

    function getDose() {
        return $this->dose;
    }

    function getIntervalo() {
        return $this->intervalo;
    }

    function getVia() {
        return $this->via;
    }

    function getDias() {
        return $this->dias;
    }

    function getMotivo() {
        return $this->motivo;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setPaciente($paciente) {
        $this->paciente = $paciente;
    }

    function setAntimicrobiano($antimicrobiano) {
        $this->antimicrobiano = $antimicrobiano;
    }

    function setDataInicio($dataInicio) {
        $this->dataInicio = $dataInicio;
    }

    function setDose($dose) {
        $this->dose = $dose;
    }

    function setIntervalo($intervalo) {
        $this->intervalo = $intervalo;
    }

    function setVia($via) {
        $this->via = $via;
    }

    function setDias($dias) {
        $this->dias = $dias;
    }

    function setMotivo($motivo) {
        $this->motivo = $motivo;
    }

    public function getTipoPad()
    {
        return $this->tipoPad;
    }

    public function setTipoPad($tipoPad)
    {
        $this->tipoPad = $tipoPad;

        return $this;
    }

    public function getOrigemInfec()
    {
        return $this->origemInfec;
    }

    public function setOrigemInfec($origemInfec)
    {
        $this->origemInfec = $origemInfec;

        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    public function getObs()
    {
        return $this->obs;
    }

    public function setObs($obs)
    {
        $this->obs = $obs;

        return $this;
    }

    public function getDtAntIni()
    {
        return $this->dtAntIni;
    }

    public function setDtAntIni($dtAntIni)
    {
        $this->dtAntIni = $dtAntIni;

        return $this;
    }

    public function getDtAntFim()
    {
        return $this->dtAntFim;
    }

    public function setDtAntFim($dtAntFim)
    {
        $this->dtAntFim = $dtAntFim;

        return $this;
    }

    public function getExame()
    {
        return $this->exame;
    }

    public function setExame($exame)
    {
        $this->exame = $exame;

        return $this;
    }

    public function getResultado()
    {
        return $this->resultado;
    }

    public function setResultado($resultado)
    {
        $this->resultado = $resultado;

        return $this;
    }

    public function getIdAdmission()
    {
        return $this->idAdmission;
    }

    public function setIdAdmission($idAmission)
    {
        $this->idAdmission = $idAmission;

        return $this;
    }
    
    public function getIdusuario(){
        return $this->idusuario;
    }
    
    public function setIdusuario($value){
        $this->idusuario = $value;
    }
    
    public function getNmusuario(){
        return $this->nmusuario;
    }
    
    public function setNmusuario($value){
        $this->nmusuario = $value;
    }
    
    public function getDiluicao(){
        return $this->diluicao;
    }
    
    public function setDiluicao($value){
        $this->diluicao = $value;
    }

}