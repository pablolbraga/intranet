<?php

class AntibioticoModel{

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

    private $idadmission;

    /**
     * Get the value of idadmission
     */ 
    public function getIdadmission()
    {
        return $this->idadmission;
    }

    /**
     * Set the value of idadmission
     *
     * @return  self
     */ 
    public function setIdadmission($idadmission)
    {
        $this->idadmission = $idadmission;

        return $this;
    }

    private $antimicrobiano;

    /**
     * Get the value of antimicrobiano
     */ 
    public function getAntimicrobiano()
    {
        return $this->antimicrobiano;
    }

    /**
     * Set the value of antimicrobiano
     *
     * @return  self
     */ 
    public function setAntimicrobiano($antimicrobiano)
    {
        $this->antimicrobiano = $antimicrobiano;

        return $this;
    }

    private $dose;

    /**
     * Get the value of dose
     */ 
    public function getDose()
    {
        return $this->dose;
    }

    /**
     * Set the value of dose
     *
     * @return  self
     */ 
    public function setDose($dose)
    {
        $this->dose = $dose;

        return $this;
    }

    private $intervalo;

    /**
     * Get the value of intervalo
     */ 
    public function getIntervalo()
    {
        return $this->intervalo;
    }

    /**
     * Set the value of intervalo
     *
     * @return  self
     */ 
    public function setIntervalo($intervalo)
    {
        $this->intervalo = $intervalo;

        return $this;
    }

    private $via;

    /**
     * Get the value of via
     */ 
    public function getVia()
    {
        return $this->via;
    }

    /**
     * Set the value of via
     *
     * @return  self
     */ 
    public function setVia($via)
    {
        $this->via = $via;

        return $this;
    }

    private $dias;

    /**
     * Get the value of dias
     */ 
    public function getDias()
    {
        return $this->dias;
    }

    /**
     * Set the value of dias
     *
     * @return  self
     */ 
    public function setDias($dias)
    {
        $this->dias = $dias;

        return $this;
    }

    private $motivo;

    /**
     * Get the value of motivo
     */ 
    public function getMotivo()
    {
        return $this->motivo;
    }

    /**
     * Set the value of motivo
     *
     * @return  self
     */ 
    public function setMotivo($motivo)
    {
        $this->motivo = $motivo;

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

    private $diluicao;

    /**
     * Get the value of diluicao
     */ 
    public function getDiluicao()
    {
        return $this->diluicao;
    }

    /**
     * Set the value of diluicao
     *
     * @return  self
     */ 
    public function setDiluicao($diluicao)
    {
        $this->diluicao = $diluicao;

        return $this;
    }
}