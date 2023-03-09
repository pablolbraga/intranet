<?php
require_once("../conexao/conexao.php");

class CaixaController{

    private $conn;

    public function __construct()
    {
        $this->conn = Conexao::getInstance();
    }

    public function buscarPorId($id){

        $sql = "
        SELECT 
            A.ID, 
            B.ID AS ID_CAIXA_MOV, 
            A.VR_ENTRADA, 
            TO_CHAR(A.DATA_ENTRADA, 'DD/MM/YYYY HH24:MI:SS') AS DATA_ENTRADA, 
            TO_CHAR(A.DATA_SAIDA, 'DD/MM/YYYY HH24:MI:SS') AS DATA_SAIDA, 
            A.OBS_ENTRADA, 
            A.OBS_SAIDA, 
            B.TIPO, 
            B.VALOR, 
            B.DESCRICAO, 
            A.VR_SAIDA 
        FROM
            SR_CAIXA A 
            LEFT JOIN SR_CAIXA_MOVIMENTACAO B ON A.ID = B.IDCAIXA
        WHERE
            A.ID = :ID 
            AND B.IDUSUARIOEST IS NULL 
        ORDER BY
            B.DATA
        ";
        $qry = $this->conn->prepare($sql);
        $qry->bindValue(":ID", $id);
        $qry->execute();
        $res = $qry->fetchAll(PDO::FETCH_ASSOC);
        return $res;

    }

    public function existeCaixaEmAberto($idusuario){

        $sql = "SELECT * FROM SR_CAIXA WHERE STATUS = 'A' AND IDUSUARIO = :IDUSUARIO";
        $qry = $this->conn->prepare($sql);
        $qry->bindValue(":IDUSUARIO", $idusuario);
        $qry->execute();
        $res = $qry->fetchAll(PDO::FETCH_ASSOC);
        return count($res) > 0;

    }

    public function abrirCaixa($idusuario, $dataabertura, $valor, $observacao){

        $sql = "INSERT INTO SR_CAIXA (
                    IDUSUARIO, DATA_ENTRADA, VR_ENTRADA, OBS_ENTRADA, STATUS
                ) VALUES (
                    :IDUSUARIO, TO_DATE(:DATA_ENTRADA, 'DD/MM/YYYY HH24:MI:SS'), :VR_ENTRADA, :OBS_ENTRADA, :STATUS
                )";
        $qry = $this->conn->prepare($sql);
        $qry->bindValue(":IDUSUARIO", $idusuario);
        $qry->bindValue(":VR_ENTRADA", $valor);
        $qry->bindValue(":DATA_ENTRADA", $dataabertura);
        $qry->bindValue(":OBS_ENTRADA", $observacao);
        $qry->bindValue(":STATUS", "A");
        $qry->execute();

    }

    public function fecharCaixa($idcaixa, $idusuario, $valor, $descricao){

        $sql = "UPDATE SR_CAIXA SET 
                    VR_SAIDA = :VALOR, 
                    DATA_SAIDA = TO_DATE(:DATA, 'DD/MM/YYYY HH24:MI:SS'), 
                    OBS_SAIDA = :OBS, 
                    STATUS = 'PF' 
                WHERE 
                    ID = :ID 
                    AND IDUSUARIO = :IDUSUARIO";
        $qry = $this->conn->prepare($sql);
        $qry->bindValue(":VALOR", $valor);
        $qry->bindValue(":DATA", date("d/m/Y H:i:s"));
        $qry->bindValue(":OBS", $descricao);
        $qry->bindValue(":ID", $idcaixa);
        $qry->bindValue(":IDUSUARIO", $idusuario);
        $qry->execute();

    }

    public function buscarUltimoId($idusuario){

        $sql = "SELECT MAX(ID) AS ID FROM SR_CAIXA WHERE IDUSUARIO = :IDUSUARIO";
        $qry = $this->conn->prepare($sql);
        $qry->bindValue(":IDUSUARIO", $idusuario);
        $qry->execute();
        $res = $qry->fetchAll(PDO::FETCH_ASSOC);
        return $res;

    }

    public function retornarDadosCaixaAberto($idusuario){

        $sql = "SELECT * FROM SR_CAIXA WHERE STATUS = 'A' AND IDUSUARIO = :IDUSUARIO";
        $qry = $this->conn->prepare($sql);
        $qry->bindValue(":IDUSUARIO", $idusuario);
        $qry->execute();
        $res = $qry->fetchAll(PDO::FETCH_ASSOC);
        return $res;

    }

    public function retornarSaldoMovimentacao($idusuario){

        $sql = "SELECT 
                    SUM(
                        CASE J.TIPO 
                            WHEN 'AC' 
                            THEN (J.VALOR) 
                            WHEN 'E' 
                            THEN (J.VALOR) 
                            WHEN 'S' 
                            THEN (J.VALOR * -1) 
                            ELSE J.VALOR 
                    END) AS SALDO 
                FROM (
                    SELECT 
                        A.DATA_ENTRADA AS DT_MOVTO, 
                        A.VR_ENTRADA AS VALOR, 
                        A.OBS_ENTRADA AS OBS, 
                        'AC' AS TIPO, 
                        NULL AS IDUSUARIOEST 
                    FROM
                        SR_CAIXA A 
                    WHERE 
                        A.STATUS = 'A' 
                        AND A.IDUSUARIO = :IDUSUARIO 
                    UNION ALL 
                    SELECT 
                        B.DATA AS DT_MOVTO, 
                        B.VALOR, 
                        B.DESCRICAO AS OBS, 
                        B.TIPO,  
                        B.IDUSUARIOEST 
                    FROM
                        SR_CAIXA A 
                        INNER JOIN SR_CAIXA_MOVIMENTACAO B ON B.IDCAIXA = A.ID 
                    WHERE
                        A.STATUS = 'A' 
                        AND A.IDUSUARIO = :IDUSUARIO                 
                ) J 
                WHERE 
                    J.IDUSUARIOEST IS NULL";
        $qry = $this->conn->prepare($sql);
        $qry->bindValue(":IDUSUARIO", $idusuario);
        $qry->execute();
        $res = $qry->fetchAll(PDO::FETCH_ASSOC);
        if (count($res) > 0){
            return $res[0]["SALDO"];
        } else {
            return 0;
        }

    }
}