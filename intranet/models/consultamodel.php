<?php

class ConsultaModel{

    private $idadmission;

    public function getIdadmission()
    {
        return $this->idadmission;
    }

    public function setIdadmission($idadmission)
    {
        $this->idadmission = $idadmission;

        return $this;
    }

    private $idprofagenda;

    /**
     * Get the value of idprofagenda
     */ 
    public function getIdprofagenda()
    {
        return $this->idprofagenda;
    }

    /**
     * Set the value of idprofagenda
     *
     * @return  self
     */ 
    public function setIdprofagenda($idprofagenda)
    {
        $this->idprofagenda = $idprofagenda;

        return $this;
    }

    private $idespecialidade;

    /**
     * Get the value of idespecialidade
     */ 
    public function getIdespecialidade()
    {
        return $this->idespecialidade;
    }

    /**
     * Set the value of idespecialidade
     *
     * @return  self
     */ 
    public function setIdespecialidade($idespecialidade)
    {
        $this->idespecialidade = $idespecialidade;

        return $this;
    }

    private $datainicioagenda;

    /**
     * Get the value of datainicioagenda
     */ 
    public function getDatainicioagenda()
    {
        return $this->datainicioagenda;
    }

    /**
     * Set the value of datainicioagenda
     *
     * @return  self
     */ 
    public function setDatainicioagenda($datainicioagenda)
    {
        $this->datainicioagenda = $datainicioagenda;

        return $this;
    }

    private $datafimagenda;

    /**
     * Get the value of datafimagenda
     */ 
    public function getDatafimagenda()
    {
        return $this->datafimagenda;
    }

    /**
     * Set the value of datafimagenda
     *
     * @return  self
     */ 
    public function setDatafimagenda($datafimagenda)
    {
        $this->datafimagenda = $datafimagenda;

        return $this;
    }

    private $procedimento;

    /**
     * Get the value of procedimento
     */ 
    public function getProcedimento()
    {
        return $this->procedimento;
    }

    /**
     * Set the value of procedimento
     *
     * @return  self
     */ 
    public function setProcedimento($procedimento)
    {
        $this->procedimento = $procedimento;

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

    private $iduseragenda;

    /**
     * Get the value of iduseragenda
     */ 
    public function getIduseragenda()
    {
        return $this->iduseragenda;
    }

    /**
     * Set the value of iduseragenda
     *
     * @return  self
     */ 
    public function setIduseragenda($iduseragenda)
    {
        $this->iduseragenda = $iduseragenda;

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

    private $idprofessional;

    /**
     * Get the value of idprofessional
     */ 
    public function getIdprofessional()
    {
        return $this->idprofessional;
    }

    /**
     * Set the value of idprofessional
     *
     * @return  self
     */ 
    public function setIdprofessional($idprofessional)
    {
        $this->idprofessional = $idprofessional;

        return $this;
    }

    private $nmprofessional;

    /**
     * Get the value of nmprofessional
     */ 
    public function getNmprofessional()
    {
        return $this->nmprofessional;
    }

    /**
     * Set the value of nmprofessional
     *
     * @return  self
     */ 
    public function setNmprofessional($nmprofessional)
    {
        $this->nmprofessional = $nmprofessional;

        return $this;
    }
}