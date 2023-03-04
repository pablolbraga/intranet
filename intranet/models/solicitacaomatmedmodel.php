<?php

class SolicitacaoMatMedModel{

    private $idusuariosolicitante;


    /**
     * Get the value of idusuariosolicitante
     */ 
    public function getIdusuariosolicitante()
    {
        return $this->idusuariosolicitante;
    }

    /**
     * Set the value of idusuariosolicitante
     *
     * @return  self
     */ 
    public function setIdusuariosolicitante($idusuariosolicitante)
    {
        $this->idusuariosolicitante = $idusuariosolicitante;

        return $this;
    }

    private $datasolicitacao;

    /**
     * Get the value of datasolicitacao
     */ 
    public function getDatasolicitacao()
    {
        return $this->datasolicitacao;
    }

    /**
     * Set the value of datasolicitacao
     *
     * @return  self
     */ 
    public function setDatasolicitacao($datasolicitacao)
    {
        $this->datasolicitacao = $datasolicitacao;

        return $this;
    }

    private $datamaxima;

    /**
     * Get the value of datamaxima
     */ 
    public function getDatamaxima()
    {
        return $this->datamaxima;
    }

    /**
     * Set the value of datamaxima
     *
     * @return  self
     */ 
    public function setDatamaxima($datamaxima)
    {
        $this->datamaxima = $datamaxima;

        return $this;
    }

    private $idpaciente;

    /**
     * Get the value of idpaciente
     */ 
    public function getIdpaciente()
    {
        return $this->idpaciente;
    }

    /**
     * Set the value of idpaciente
     *
     * @return  self
     */ 
    public function setIdpaciente($idpaciente)
    {
        $this->idpaciente = $idpaciente;

        return $this;
    }

    private $idenfermeiro;

    /**
     * Get the value of idenfermeiro
     */ 
    public function getIdenfermeiro()
    {
        return $this->idenfermeiro;
    }

    /**
     * Set the value of idenfermeiro
     *
     * @return  self
     */ 
    public function setIdenfermeiro($idenfermeiro)
    {
        $this->idenfermeiro = $idenfermeiro;

        return $this;
    }

    private $pedidosemanal;

    /**
     * Get the value of pedidosemanal
     */ 
    public function getPedidosemanal()
    {
        return $this->pedidosemanal;
    }

    /**
     * Set the value of pedidosemanal
     *
     * @return  self
     */ 
    public function setPedidosemanal($pedidosemanal)
    {
        $this->pedidosemanal = $pedidosemanal;

        return $this;
    }

    private $inclusaoprescricao;

    /**
     * Get the value of inclusaoprescricao
     */ 
    public function getInclusaoprescricao()
    {
        return $this->inclusaoprescricao;
    }

    /**
     * Set the value of inclusaoprescricao
     *
     * @return  self
     */ 
    public function setInclusaoprescricao($inclusaoprescricao)
    {
        $this->inclusaoprescricao = $inclusaoprescricao;

        return $this;
    }

    private $observacao;

    /**
     * Get the value of observacao
     */ 
    public function getObservacao()
    {
        return $this->observacao;
    }

    /**
     * Set the value of observacao
     *
     * @return  self
     */ 
    public function setObservacao($observacao)
    {
        $this->observacao = $observacao;

        return $this;
    }

    private $status;

    /**
     * Get the value of status
     */ 
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */ 
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    private $tipo;

    /**
     * Get the value of tipo
     */ 
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set the value of tipo
     *
     * @return  self
     */ 
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    private $justificativa;

    /**
     * Get the value of justificativa
     */ 
    public function getJustificativa()
    {
        return $this->justificativa;
    }

    /**
     * Set the value of justificativa
     *
     * @return  self
     */ 
    public function setJustificativa($justificativa)
    {
        $this->justificativa = $justificativa;

        return $this;
    }

    private $tipopedido;

    /**
     * Get the value of tipopedido
     */ 
    public function getTipopedido()
    {
        return $this->tipopedido;
    }

    /**
     * Set the value of tipopedido
     *
     * @return  self
     */ 
    public function setTipopedido($tipopedido)
    {
        $this->tipopedido = $tipopedido;

        return $this;
    }
}