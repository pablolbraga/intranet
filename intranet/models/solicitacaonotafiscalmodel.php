<?php

class SolicitacaoNotaFiscalModel{

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

    private $usuarioSolic;

    /**
     * Get the value of usuarioSolic
     */ 
    public function getUsuarioSolic()
    {
        return $this->usuarioSolic;
    }

    /**
     * Set the value of usuarioSolic
     *
     * @return  self
     */ 
    public function setUsuarioSolic($usuarioSolic)
    {
        $this->usuarioSolic = $usuarioSolic;

        return $this;
    }

    private $dataSolic;

    /**
     * Get the value of dataSolic
     */ 
    public function getDataSolic()
    {
        return $this->dataSolic;
    }

    /**
     * Set the value of dataSolic
     *
     * @return  self
     */ 
    public function setDataSolic($dataSolic)
    {
        $this->dataSolic = $dataSolic;

        return $this;
    }

    private $idPartConv;

    /**
     * Get the value of idPartConv
     */ 
    public function getIdPartConv()
    {
        return $this->idPartConv;
    }

    /**
     * Set the value of idPartConv
     *
     * @return  self
     */ 
    public function setIdPartConv($idPartConv)
    {
        $this->idPartConv = $idPartConv;

        return $this;
    }

    private $obsSolic;

    /**
     * Get the value of obsSolic
     */ 
    public function getObsSolic()
    {
        return $this->obsSolic;
    }

    /**
     * Set the value of obsSolic
     *
     * @return  self
     */ 
    public function setObsSolic($obsSolic)
    {
        $this->obsSolic = $obsSolic;

        return $this;
    }

    private $usuarioConf;

    /**
     * Get the value of usuarioConf
     */ 
    public function getUsuarioConf()
    {
        return $this->usuarioConf;
    }

    /**
     * Set the value of usuarioConf
     *
     * @return  self
     */ 
    public function setUsuarioConf($usuarioConf)
    {
        $this->usuarioConf = $usuarioConf;

        return $this;
    }

    private $dataConf;

    /**
     * Get the value of dataConf
     */ 
    public function getDataConf()
    {
        return $this->dataConf;
    }

    /**
     * Set the value of dataConf
     *
     * @return  self
     */ 
    public function setDataConf($dataConf)
    {
        $this->dataConf = $dataConf;

        return $this;
    }

    private $obsConf;

    /**
     * Get the value of obsConf
     */ 
    public function getObsConf()
    {
        return $this->obsConf;
    }

    /**
     * Set the value of obsConf
     *
     * @return  self
     */ 
    public function setObsConf($obsConf)
    {
        $this->obsConf = $obsConf;

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

    private $nmSolicitante;

    /**
     * Get the value of nmSolicitante
     */ 
    public function getNmSolicitante()
    {
        return $this->nmSolicitante;
    }

    /**
     * Set the value of nmSolicitante
     *
     * @return  self
     */ 
    public function setNmSolicitante($nmSolicitante)
    {
        $this->nmSolicitante = $nmSolicitante;

        return $this;
    }

    private $notaFiscal;

    /**
     * Get the value of notaFiscal
     */ 
    public function getNotaFiscal()
    {
        return $this->notaFiscal;
    }

    /**
     * Set the value of notaFiscal
     *
     * @return  self
     */ 
    public function setNotaFiscal($notaFiscal)
    {
        $this->notaFiscal = $notaFiscal;

        return $this;
    }

    private $valor;

    /**
     * Get the value of valor
     */ 
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set the value of valor
     *
     * @return  self
     */ 
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }

    private $dataEmissaoNota;

    /**
     * Get the value of dataEmissaoNota
     */ 
    public function getDataEmissaoNota()
    {
        return $this->dataEmissaoNota;
    }

    /**
     * Set the value of dataEmissaoNota
     *
     * @return  self
     */ 
    public function setDataEmissaoNota($dataEmissaoNota)
    {
        $this->dataEmissaoNota = $dataEmissaoNota;

        return $this;
    }

    private $obsSolicNota;

    /**
     * Get the value of obsSolicNota
     */ 
    public function getObsSolicNota()
    {
        return $this->obsSolicNota;
    }

    /**
     * Set the value of obsSolicNota
     *
     * @return  self
     */ 
    public function setObsSolicNota($obsSolicNota)
    {
        $this->obsSolicNota = $obsSolicNota;

        return $this;
    }
}