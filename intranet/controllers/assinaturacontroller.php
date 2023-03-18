<?php
require_once("../conexao/conexao.php");

class AssinaturaController{

    private $conn;

    public function __construct()
    {
        $this->conn = Conexao::getInstance();
    }

    public function retornarQuantidadeLinhasAssinatura($idevolucao, $idadmission){

        $sql = "
                SELECT 
                    ROUND((LENGTH(ASS.ASS_PAC) / 4000)+1) AS LINHAS_PAC, 
                    ROUND((LENGTH(ASS.ASS_PROF) / 4000)+1) AS LINHAS_PROF
                FROM 
                    SR_ASSINATURAS ASS 
                WHERE
                    ASS.IDEVOLUCAO = :IDEVO 
                    AND ASS.IDADMISSION = :IDADM";
        $qry = $this->conn->prepare($sql);
        $qry->bindValue(":IDEVO", $idevolucao);
        $qry->bindValue(":IDADM", $idadmission);
        $qry->execute();
        $res = $qry->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }

    public function retornarLinhasAssinatura($linhas, $tipo, $idevolucao, $idadmission){

        //Tipo: 1 - Paciente, 2 - Profissional 
        if ($tipo == 1){
            $campo = "ASS.ASS_PAC";
        } else if ($tipo == 2){
            $campo = "ASS.ASS_PROF";
        }

        $inicioTexto = 0;
        $sql = "";
        for ($i = 0; $i < $linhas; $i++){
            $sql .= "
                    SELECT 
                        TO_CHAR(SUBSTR({$campo}, {$inicioTexto} + 1, 4000)) AS LINHA 
                    FROM 
                        SR_ASSINATURAS ASS 
                    WHERE 
                        ASS.IDEVOLUCAO = :P1 
                        AND ASS.IDADMISSION = :P2 
                    UNION ALL ";
            $inicioTexto = $inicioTexto + 4000;
        }
        $sql = substr($sql, 0, strlen($sql) - 10);

        $qry = $this->conn->prepare($sql);
        $qry->bindValue(":P1", $idevolucao);
        $qry->bindValue(":P2", $idadmission);
        $qry->execute();
        $res = $qry->fetchAll(PDO::FETCH_ASSOC);
        return $res;

    }
}