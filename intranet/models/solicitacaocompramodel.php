<?php

class SolicitacaoCompraModel{

    private $idmaterial;

    /**
     * Get the value of idmaterial
     */ 
    public function getIdmaterial()
    {
        return $this->idmaterial;
    }

    /**
     * Set the value of idmaterial
     *
     * @return  self
     */ 
    public function setIdmaterial($idmaterial)
    {
        $this->idmaterial = $idmaterial;

        return $this;
    }

    private $quantidade;

    /**
     * Get the value of quantidade
     */ 
    public function getQuantidade()
    {
        return $this->quantidade;
    }

    /**
     * Set the value of quantidade
     *
     * @return  self
     */ 
    public function setQuantidade($quantidade)
    {
        $this->quantidade = $quantidade;

        return $this;
    }

    private $datanecessidadeinicio;


    /**
     * Get the value of datanecessidadeinicio
     */ 
    public function getDatanecessidadeinicio()
    {
        return $this->datanecessidadeinicio;
    }

    /**
     * Set the value of datanecessidadeinicio
     *
     * @return  self
     */ 
    public function setDatanecessidadeinicio($datanecessidadeinicio)
    {
        $this->datanecessidadeinicio = $datanecessidadeinicio;

        return $this;
    }

    private $horaprevista;

    /**
     * Get the value of horaprevista
     */ 
    public function getHoraprevista()
    {
        return $this->horaprevista;
    }

    /**
     * Set the value of horaprevista
     *
     * @return  self
     */ 
    public function setHoraprevista($horaprevista)
    {
        $this->horaprevista = $horaprevista;

        return $this;
    }

    private $datanecessidadefim;

    /**
     * Get the value of datanecessidadefim
     */ 
    public function getDatanecessidadefim()
    {
        return $this->datanecessidadefim;
    }

    /**
     * Set the value of datanecessidadefim
     *
     * @return  self
     */ 
    public function setDatanecessidadefim($datanecessidadefim)
    {
        $this->datanecessidadefim = $datanecessidadefim;

        return $this;
    }

    private $urgencia;

    /**
     * Get the value of urgencia
     */ 
    public function getUrgencia()
    {
        return $this->urgencia;
    }

    /**
     * Set the value of urgencia
     *
     * @return  self
     */ 
    public function setUrgencia($urgencia)
    {
        $this->urgencia = $urgencia;

        return $this;
    }

    private $idusuario;

    /**
     * Get the value of idusuario
     */ 
    public function getIdusuario()
    {
        return $this->idusuario;
    }

    /**
     * Set the value of idusuario
     *
     * @return  self
     */ 
    public function setIdusuario($idusuario)
    {
        $this->idusuario = $idusuario;

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

    private $faltante;

    /**
     * Get the value of faltante
     */ 
    public function getFaltante()
    {
        return $this->faltante;
    }

    /**
     * Set the value of faltante
     *
     * @return  self
     */ 
    public function setFaltante($faltante)
    {
        $this->faltante = $faltante;

        return $this;
    }
}