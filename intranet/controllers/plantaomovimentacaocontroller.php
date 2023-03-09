<?php
require_once("../conexao/conexao.php");
require_once("../models/plantaomovimentacaomodel.php");

class PlantaoMovimentacaoController{

    private $conn;

    public function __construct()
    {
        $this->conn = Conexao::getInstance();
    }

    public function inserir(PlantaoMovimentacaoModel $c){

        $sql = "INSERT INTO SR_TROCA_PLANTAO_MOV (
                    ID_TROCA_PLANT, ID_USUARIO, DT_CAD, CATEG, OBS, 
                    GERA_BAIXA, ANEXO
                ) VALUES (
                    :ID_TROCA_PLANT, :ID_USUARIO, TO_DATE(:DT_CAD, 'DD/MM/YYYY HH24:MI:SS'), :CATEG, :OBS, 
                    :GERA_BAIXA, :ANEXO
                )";
        $qry = $this->conn->prepare($sql);
        $qry->bindValue(":ID_TROCA_PLANT", $c->getIdTrocaPlantao());
        $qry->bindValue(":ID_USUARIO", $c->getIdUsuario());
        $qry->bindValue(":DT_CAD", $c->getDtCad());
        $qry->bindValue(":CATEG", $c->getCategoria());
        $qry->bindValue(":OBS", $c->getObs());
        $qry->bindValue(":GERA_BAIXA", $c->getBaixa());
        $qry->bindValue(":ANEXO", $c->getAnexo());
        $qry->execute();

    }

}