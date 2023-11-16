<?php

class UsuarioModel{

    private $codigo;
    public function getCodigo(){ return $this->codigo; }
    public function setCodigo($value){ $this->codigo = $value; }
    
    private $nome;
    public function getNome(){ return $this->nome; }
    public function setNome($value){ $this->nome = $value; }
    
    private $login;
    public function getLogin(){ return $this->login; }
    public function setLogin($value){ $this->login = $value; }
    
    private $senha;
    public function getSenha(){ return $this->senha; }
    public function setSenha($value){ $this->senha = $value; }
    
    private $admin;
    public function getAdmin(){ return $this->admin; }
    public function setAdmin($value){ $this->admin = $value; }
    
    private $mudarsenha;
    public function getMudarSenha(){ return $this->mudarsenha; }
    public function setMudarSenha($value){ $this->mudarsenha = $value; }
    
    private $idperson;
    public function getIdPerson(){ return $this->idperson; }
    public function setIdPerson($value){ $this->idperson = $value; }
    
    private $tipocaixa;
    public function getTipoCaixa(){ return $this->tipocaixa; }
    public function setTipoCaixa($value){ $this->tipocaixa = $value; }
    
    private $os;
    public function getOs(){ return $this->os; }
    public function setOs($value){ $this->os = $value; }
    
    private $adm_os;
    public function getAdmOs(){ return $this->adm_os; }
    public function setAdmOs($value){ $this->adm_os = $value; }
    
    private $email;
    public function getEmail(){ return $this->email; }
    public function setEmail($value){ $this->email = $value; }
    
    private $baixamotorista;
    public function getBaixaMotorista(){ return $this->baixamotorista; }
    public function setBaixaMotorista($value){ $this->baixamotorista = $value; }
    
    private $ugb;
    public function getUgb(){ return $this->ugb; }
    public function setUgb($value){ $this->ugb = $value; }
    
    private $plantonista;
    public function getPlantonista(){ return $this->plantonista; }
    public function setPlantonista($value){ $this->plantonista = $value; }
    
    private $acessoexterno;
    public function getAcessoExterno(){ return $this->acessoexterno; }
    public function setAcessoExterno($value){ $this->acessoexterno = $value; }
    
    private $modomobile;
    public function getModoMobile(){ return $this->modomobile; }
    public function setModoMobile($value){ $this->modomobile = $value; }
    
    private $dtsenha;
    public function getDtSenha(){ return $this->dtsenha; }
    public function setDtSenha($value){ $this->dtsenha = $value; }
    
    private $profext;
    public function getProfExt(){ return $this->profext; }
    public function setProfExt($value){ $this->profext = $value; }
    
    private $modenf;
    public function getModEnf(){ return $this->modenf; }
    public function setModEnf($value){ $this->modenf = $value; }
    
    private $treinamentoedcontinuada;
    public function getTreinamentoEdContinuada(){ return $this->treinamentoedcontinuada; }
    public function setTreinamentoEdContinuada($value){ $this->treinamentoedcontinuada = $value; }  
    
    private $primeiroacesso;
    public function getPrimeiroAcesso(){ return $this->primeiroacesso; }
    public function setPrimeiroAcesso($value){ $this->primeiroacesso = $value; }
    
    private $somenteterapia;
    public function getSomenteTerapia(){ return $this->somenteterapia; }
    public function setSomenteTerapia($value){ $this->somenteterapia = $value; }
}