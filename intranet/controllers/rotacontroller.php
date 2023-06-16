<?php
require_once("../conexao/conexao.php");
require_once("../models/rotamodel.php");

class RotaController{

    private $conn;

    public function __construct(){
        $this->conn = Conexao::getInstance();
    }

    public function incluir(RotaModel $c){

        $sql = "INSERT INTO SR_ROTA_MOTORISTA (
            ID, IDUSU_SOLIC, LOCAL, JUSTIFICATIVA, DATASAIDA, 
            DATAMAXIMA, OBS_SOLIC, STATUS, EXTRA, MED_SOLIC
        ) VALUES (
            :ID, :IDUSU_SOLIC, :LOCAL, :JUSTIFICATIVA, TO_DATE('" . $c->getDatasaida() . "', 'DD/MM/YYYY HH24:MI:SS'), 
            TO_DATE('" . $c->getDatamaxima() . "', 'DD/MM/YYYY HH24:MI:SS'), :OBS_SOLIC, :STATUS, :EXTRA, :MED_SOLIC
        )";

        //echo $sql; exit();
        $qry = $this->conn->prepare($sql);
        $qry->bindValue(":ID", $c->getCodigo());
        $qry->bindValue(":IDUSU_SOLIC", $c->getIdusuariosolicitante());
        $qry->bindValue(":LOCAL", $c->getLocal());
        $qry->bindValue(":JUSTIFICATIVA", $c->getJustificativa());
        $qry->bindValue(":OBS_SOLIC", $c->getObservacao());
        $qry->bindValue(":STATUS", $c->getStatus());
        $qry->bindValue(":EXTRA", $c->getExtra());
        $qry->bindValue(":MED_SOLIC", $c->getIdmedicosolicitante());
        $qry->execute();

    }

    public function buscarRegistroPorSolicitacao($idSolicitacao){

        $sql = "
        SELECT 
            TO_CHAR(A.DATAATEND, 'DD/MM/YYYY HH24:MI:SS') AS DTINIATEND
        FROM
            SR_ROTA_MOTORISTA A
        WHERE
            A.IDSOLICITACAO = :IDSOLICITACAO
        ";
        //echo $sql . "<br>" . $idSolicitacao;
        $qry = $this->conn->prepare($sql);
        $qry->bindValue(":IDSOLICITACAO", $idSolicitacao);
        $qry->execute();
        $res = $qry->fetchAll(PDO::FETCH_ASSOC);
        return $res;

    }

}