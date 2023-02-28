<?php

class RotaModel{

    private $codigo;


    /**
     * Get the value of codigo
     */ 
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set the value of codigo
     *
     * @return  self
     */ 
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

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

    private $local;

    /**
     * Get the value of local
     */ 
    public function getLocal()
    {
        return $this->local;
    }

    /**
     * Set the value of local
     *
     * @return  self
     */ 
    public function setLocal($local)
    {
        $this->local = $local;

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

    private $datasaida;

    /**
     * Get the value of datasaida
     */ 
    public function getDatasaida()
    {
        return $this->datasaida;
    }

    /**
     * Set the value of datasaida
     *
     * @return  self
     */ 
    public function setDatasaida($datasaida)
    {
        $this->datasaida = $datasaida;

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

    private $extra;

    /**
     * Get the value of extra
     */ 
    public function getExtra()
    {
        return $this->extra;
    }

    /**
     * Set the value of extra
     *
     * @return  self
     */ 
    public function setExtra($extra)
    {
        $this->extra = $extra;

        return $this;
    }

    private $idmedicosolicitante;

    /**
     * Get the value of idmedicosolicitante
     */ 
    public function getIdmedicosolicitante()
    {
        return $this->idmedicosolicitante;
    }

    /**
     * Set the value of idmedicosolicitante
     *
     * @return  self
     */ 
    public function setIdmedicosolicitante($idmedicosolicitante)
    {
        $this->idmedicosolicitante = $idmedicosolicitante;

        return $this;
    }
}