<?php

class PlantaoMovimentacaoModel{

    private $idTrocaPlantao;
    private $idUsuario;
    private $idMovPlantao;
    private $dtCad;
    private $categoria;
    private $obs;
    private $dtBaixa;
    private $usuarioBaixa;
    private $baixa;
    private $anexo;


    /**
     * Get the value of idTrocaPlantao
     */ 
    public function getIdTrocaPlantao()
    {
        return $this->idTrocaPlantao;
    }

    /**
     * Set the value of idTrocaPlantao
     *
     * @return  self
     */ 
    public function setIdTrocaPlantao($idTrocaPlantao)
    {
        $this->idTrocaPlantao = $idTrocaPlantao;

        return $this;
    }

    /**
     * Get the value of idUsuario
     */ 
    public function getIdUsuario()
    {
        return $this->idUsuario;
    }

    /**
     * Set the value of idUsuario
     *
     * @return  self
     */ 
    public function setIdUsuario($idUsuario)
    {
        $this->idUsuario = $idUsuario;

        return $this;
    }

    /**
     * Get the value of idMovPlantao
     */ 
    public function getIdMovPlantao()
    {
        return $this->idMovPlantao;
    }

    /**
     * Set the value of idMovPlantao
     *
     * @return  self
     */ 
    public function setIdMovPlantao($idMovPlantao)
    {
        $this->idMovPlantao = $idMovPlantao;

        return $this;
    }

    /**
     * Get the value of dtCad
     */ 
    public function getDtCad()
    {
        return $this->dtCad;
    }

    /**
     * Set the value of dtCad
     *
     * @return  self
     */ 
    public function setDtCad($dtCad)
    {
        $this->dtCad = $dtCad;

        return $this;
    }

    /**
     * Get the value of categoria
     */ 
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * Set the value of categoria
     *
     * @return  self
     */ 
    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;

        return $this;
    }

    /**
     * Get the value of obs
     */ 
    public function getObs()
    {
        return $this->obs;
    }

    /**
     * Set the value of obs
     *
     * @return  self
     */ 
    public function setObs($obs)
    {
        $this->obs = $obs;

        return $this;
    }

    /**
     * Get the value of dtBaixa
     */ 
    public function getDtBaixa()
    {
        return $this->dtBaixa;
    }

    /**
     * Set the value of dtBaixa
     *
     * @return  self
     */ 
    public function setDtBaixa($dtBaixa)
    {
        $this->dtBaixa = $dtBaixa;

        return $this;
    }

    /**
     * Get the value of usuarioBaixa
     */ 
    public function getUsuarioBaixa()
    {
        return $this->usuarioBaixa;
    }

    /**
     * Set the value of usuarioBaixa
     *
     * @return  self
     */ 
    public function setUsuarioBaixa($usuarioBaixa)
    {
        $this->usuarioBaixa = $usuarioBaixa;

        return $this;
    }

    /**
     * Get the value of baixa
     */ 
    public function getBaixa()
    {
        return $this->baixa;
    }

    /**
     * Set the value of baixa
     *
     * @return  self
     */ 
    public function setBaixa($baixa)
    {
        $this->baixa = $baixa;

        return $this;
    }

    /**
     * Get the value of anexo
     */ 
    public function getAnexo()
    {
        return $this->anexo;
    }

    /**
     * Set the value of anexo
     *
     * @return  self
     */ 
    public function setAnexo($anexo)
    {
        $this->anexo = $anexo;

        return $this;
    }
}