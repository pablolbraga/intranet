<?php
require_once("../conexao/conexao.php");

class PlantaoController{

    private $conn;

    public function __construct()
    {
        $this->conn = Conexao::getInstance();
    }

    public function listarPlantao($dataini, $datafim){
        
        $sql = "SELECT 
                    A.ID,
                    A.ID_USU_INI, 
                    TO_CHAR(A.DT_INI, 'DD/MM/YYYY HH24:MI:SS') AS DT_INI,
                    TO_CHAR(A.DT_FIM, 'DD/MM/YYYY HH24:MI:SS') AS DT_FIM,
                    (CASE WHEN A.STATUS = 'A' THEN 'EM ANDAMENTO' ELSE 'FECHADO' END) AS STATUS, 
                    USU.NOME AS NMUSUARIO, 
                    TO_CHAR(A.DT_INI, 'DD/MM/YYYY HH24:MI:SS') AS DATA,
                    A.ID_CAIXA  
                FROM 
                    SR_TROCA_PLANTAO A 
                    INNER JOIN SR_USUARIO USU ON USU.IDUSUARIO = A.ID_USU_INI                     
                WHERE 
                    A.DT_INI BETWEEN TO_DATE(:DATAINI, 'DD/MM/YYYY HH24:MI:SS') AND TO_DATE(:DATAFIM, 'DD/MM/YYYY HH24:MI:SS') 
                ORDER BY 
                    A.DT_INI DESC";
        $qry = $this->conn->prepare($sql);
        $qry->bindValue(":DATAINI", $dataini . " 00:00:00");
        $qry->bindValue(":DATAFIM", $datafim . " 23:59:59");
        $qry->execute();
        $res = $qry->fetchAll(PDO::FETCH_ASSOC);
        return $res;

    }

    public function buscarPlantaoPorId($id, $tipo){

        if ($tipo == 1){
            $categoria = "Solicitacao";
        } else if ($tipo == 2){
            $categoria = "Escala";
        } else if ($tipo == 3){
            $categoria = "Pendencia";
        } else if ($tipo == 4){
            $categoria = "Farmacia";
        }

        $sql = "
        SELECT 
            B.OBS,
            TO_CHAR(B.DT_CAD, 'DD/MM/YYYY') AS DT_CAD,
            TO_CHAR(B.DT_CAD, 'HH24:MI:SS') AS HR_CAD, 
            B.GERA_BAIXA, 
            B.ANEXO  
        FROM 
            SR_TROCA_PLANTAO A 
            INNER JOIN SR_TROCA_PLANTAO_MOV B ON A.ID = B.ID_TROCA_PLANT
        WHERE
            B.ID_TROCA_PLANT = :ID 
            AND B.ID_EXCLU IS NULL 
            AND B.CATEG = :CATEG 
        ORDER BY 
            B.DT_CAD
        ";
        $qry = $this->conn->prepare($sql);
        $qry->bindValue(":ID", $id);
        $qry->bindValue(":CATEG", $categoria);
        $qry->execute();
        $res = $qry->fetchAll(PDO::FETCH_ASSOC);
        return $res;

    }

    public function iniciarTrocaPlantao($idcaixa, $idusuario, $dataini){

        $sql = "INSERT INTO SR_TROCA_PLANTAO (
                    ID_USU_INI, DT_INI, STATUS, ID_CAIXA
                ) VALUES (
                    :ID_USU_INI, TO_DATE(:DT_INI, 'DD/MM/YYYY HH24:MI:SS'), :STATUS, :ID_CAIXA
                )";
        $qry = $this->conn->prepare($sql);
        $qry->bindValue(":ID_USU_INI", $idusuario);
        $qry->bindValue(":DT_INI", $dataini);
        $qry->bindValue(":STATUS", "A");
        $qry->bindValue(":ID_CAIXA", $idcaixa);
        $qry->execute();

    }

    public function buscarPlantaoAbertoPorUsuario($idusuario){

        $sql = "SELECT * FROM SR_TROCA_PLANTAO WHERE ID_USU_INI = :IDUSUARIO AND STATUS = 'A'";
        $qry = $this->conn->prepare($sql);
        $qry->bindValue(":IDUSUARIO", $idusuario);
        $qry->execute();
        $res = $qry->fetchAll(PDO::FETCH_ASSOC);
        return $res;

    }

    public function finalizarPlantao($idusuario, $data, $idplantao){

        $sql = "UPDATE SR_TROCA_PLANTAO SET ID_USU_FIM = :IDUSUARIO, DT_FIM = TO_DATE(:DATA, 'DD/MM/YYYY HH24:MI:SS'), STATUS = 'F' WHERE ID = :ID";
        $qry = $this->conn->prepare($sql);
        $qry->bindValue(":IDUSUARIO", $idusuario);
        $qry->bindValue(":DATA", $data);
        $qry->bindValue(":ID", $idplantao);
        $qry->execute();

    }

}