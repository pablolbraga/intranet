<?php

class NotaFiscalModel{

    private $codigo;
    private $tipo;
    private $cliente;
    private $notafiscal;
    private $servico;
    private $dataemissao;
    private $valor;
    private $irrf;
    private $iss;
    private $cofins;
    private $pis;
    private $csll;
    private $usuariocad;
    private $datacad;
    private $usuarioalt;
    private $dataalt;
    private $usuarioexc;
    private $dataexc;
    private $motivoexc;
    private $log;
    
    public function getCodigo(){ return $this->codigo; }
    public function setCodigo($value){ $this->codigo = $value; }
    
    public function getTipo(){ return $this->tipo; }
    public function setTipo($value){ $this->tipo = $value; }
    
    public function getCliente(){ return $this->cliente; }
    public function setCliente($value){ $this->cliente = $value; }
    
    public function getNotafiscal(){ return $this->notafiscal; }
    public function setNotafiscal($value){ $this->notafiscal = $value; }
    
    public function getServico(){ return $this->servico; }
    public function setServico($value){ $this->servico = $value; }
    
    public function getDataemissao(){ return $this->dataemissao; }
    public function setDataemissao($value){ $this->dataemissao = $value; }
    
    public function getValor(){ return $this->valor; }
    public function setValor($value){ $this->valor = $value; }
    
    public function getIrrf(){ return $this->irrf; }
    public function setIrrf($value){ $this->irrf = $value; }
    
    public function getIss(){ return $this->iss; }
    public function setIss($value){ $this->iss = $value; }
    
    public function getCofins(){ return $this->cofins; }
    public function setCofins($value){ $this->cofins = $value; }
    
    public function getPis(){ return $this->pis; }
    public function setPis($value){ $this->pis = $value; }
    
    public function getCsll(){ return $this->csll; }
    public function setCsll($value){ $this->csll = $value; }
    
    public function getUsuariocad(){ return $this->usuariocad; }
    public function setUsuariocad($value){ $this->usuariocad = $value; }
    
    public function getDatacad(){ return $this->datacad; }
    public function setDatacad($value){ $this->datacad = $value; }
    
    public function getUsuarioalt(){ return $this->usuarioalt; }
    public function setUsuarioalt($value){ $this->usuarioalt = $value; }
    
    public function getDataalt(){ return $this->dataalt; }
    public function setDataalt($value){ $this->dataalt = $value; }
    
    public function getUsuarioexc(){ return $this->usuarioexc; }
    public function setUsuarioexc($value){ $this->usuarioexc = $value; }
    
    public function getDataexc(){ return $this->dataexc; }
    public function setDataexc($value){ $this->dataexc = $value; }
    
    public function getMotivoexc(){ return $this->motivoexc; }
    public function setMotivoexc($value){ $this->motivoexc = $value; }
    
    public function getLog(){ return $this->log; }
    public function setLog($value){ $this->log = $value; }

}