<?php
require_once("../conexao/conexao.php");

class MotoTaxiController{

    private $conn;

    public function __construct()
    {
        $this->conn = Conexao::getInstance();
    }

    public function listarPorUsuario($idusuario, $dataini, $datafim){

        $sql = "
                SELECT
                    A.ID,
                    A.IDSOLICITANTE,
                    B.NOME   AS NMSOLICITANTE,
                    A.IDJUSTIFICATIVA,
                    A.USUINS,
                    C.NOME   AS NMJUSTIFICATIVA,
                    A.DESTINO,
                    A.ORIGEM,
                    TO_CHAR(A.DATA,'DD/MM/YYYY') AS DATA,
                    TO_CHAR(A.HORA,'HH24:MI') AS HORA,
                    A.VALOR,
                    A.OBSERVACAO
                FROM
                    SR_MT_MOVIMENTACAO A
                    INNER JOIN SR_MT_SOLICITANTE B ON B.ID = A.IDSOLICITANTE
                    INNER JOIN SR_MT_JUSTIFICATIVA C ON C.ID = A.IDJUSTIFICATIVA
                WHERE
                    A.DTEXC IS NULL
                    AND A.USUINS = :IDUSUARIO 
                    AND DATA BETWEEN TO_DATE(:DATAINI, 'DD/MM/YYYY HH24:MI:SS') AND TO_DATE(:DATAFIM, 'DD/MM/YYYY HH24:MI:SS')
                ORDER BY 
                    A.DATA";
        $qry = $this->conn->prepare($sql);
        $qry->bindValue(":IDUSUARIO", $idusuario);
        $qry->bindValue(":DATAINI", $dataini . " 00:00:00");        
        if ($datafim != ""){
            $qry->bindValue(":DATAFIM",  $datafim . " 23:59:59");
        } else {
            $qry->bindValue(":DATAFIM", date("d/m/Y") . " 23:59:59");
        }
        $qry->execute();
        $res = $qry->fetchAll(PDO::FETCH_ASSOC);
        return $res;

    }
}