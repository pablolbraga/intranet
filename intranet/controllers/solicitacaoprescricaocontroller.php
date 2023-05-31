<?php
require_once("../conexao/conexao.php");

class SolicitacaoPrescricaoController{

    private $conn;

    public function __construct(){
        $this->conn = Conexao::getInstance();
    }

    public function listarAlteracaoPrescricao($dataInicio, $dataFim, $id, $idPaciente){

        $sql = "SELECT 
                    A.ID, A.IDUSU_SOLIC, B.NOME AS NMSOLIC, ADM.ID AS IDADMISSION, 
                    TO_CHAR(A.DATA_SOLIC, 'DD/MM/YYYY HH24:MI:SS') AS DATA_SOLIC,
                    A.IDBAIXA, (SELECT NOME FROM SR_USUARIO X WHERE X.IDUSUARIO = A.IDBAIXA) AS NOME_BAIXA,
                    TO_CHAR(A.DATA_BAIXA, 'DD/MM/YYYY HH24:MI:SS') AS DATA_BAIXA, A.ID_AUTORIZ,
                    (SELECT NOME FROM SR_USUARIO X WHERE X.IDUSUARIO = A.ID_AUTORIZ) AS NOME_AUTORIZ,
                    TO_CHAR(A.DATA_AUTORIZ, 'DD/MM/YYYY HH24:MI:SS') AS DATA_AUTORIZ, A.id_valida,
                    (SELECT NOME FROM SR_USUARIO X WHERE X.IDUSUARIO = A.ID_valida) AS NOME_VALIDA,
                    TO_CHAR(A.DATA_VALIDA, 'DD/MM/YYYY HH24:MI:SS') AS DATA_VALIDA, A.IDPACIENTE,
                    C.NAME AS NMPACIENTE, A.OBSERVACAO_SOLIC, A.OBSERVACAO_BAIXA, A.OBS_FINAL,
                    A.OBS_CASE, A.MEDICAMENTO, A.DOSE, A.POSOLOGIA, A.DURACAO, A.VIA,
                    ( CASE 
                        WHEN A.STATUS_APROV IS NULL THEN 'SOLICITADO' 
                        WHEN A.STATUS_APROV = 1 THEN 'APROVADO'
                        WHEN A.STATUS_APROV = 2 THEN 'AGUARDANDO APROVAÇÃO'
                        ELSE 'REPROVADO' 
                    END) AS STATUS_APROV,
                    A.TIPO_ALT_PRESC, A.STATUS_ALT_PRESC
                FROM 
                    SR_SOLICITACAO_PRESC A
                    INNER JOIN SR_USUARIO B ON A.IDUSU_SOLIC = B.IDUSUARIO
                    INNER JOIN GLBPERSON C ON C.ID = A.IDPACIENTE 
                    LEFT JOIN CAPADMISSION ADM ON ADM.ID = A.IDADMISSION 
                WHERE
                    1 = 1 ";
        if ($dataInicio != ""){
            $sql .= "AND DATA_SOLIC >= TO_DATE(:DATAINICIO, 'DD/MM/YYYY HH24:MI:SS') ";
        }
        if ($dataFim != ""){
            $sql .= "AND DATA_SOLIC <= TO_DATE(:DATAFIM, 'DD/MM/YYYY HH24:MI:SS') ";
        }
        if ($id != ""){
            $sql .= "AND A.ID = :ID ";
        }
        if ($idPaciente != ""){
            $sql .= "AND ADM.ID = :IDPACIENTE ";
        }
        $sql .= "ORDER BY A.ID DESC";
        $qry = $this->conn->prepare($sql);
        if ($dataInicio != ""){
            $qry->bindValue(":DATAINICIO", $dataInicio . " 00:00:00");
        }
        if ($dataFim != ""){
            $qry->bindValue(":DATAFIM", $dataFim . " 23:59:59");
        }
        if ($id != ""){
            $qry->bindValue(":ID", $id);
        }
        if ($idPaciente != ""){
            $qry->bindValue(":IDPACIENTE", $idPaciente);
        }
        $qry->execute();
        $res = $qry->fetchAll(PDO::FETCH_ASSOC);
        return $res;

    }

}