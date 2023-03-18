<?php
require_once("../conexao/conexao.php");

class AgendaController{

    private $conn;

    public function __construct()
    {
        $this->conn = Conexao::getInstance();
    }

    public function excluirAgendaPorId($codigo){

        $sql = "DELETE FROM CAPPROFAGENDA WHERE ID = :ID";
        $qry = $this->conn->prepare($sql);
        $qry->bindValue(":ID", $codigo);
        $qry->execute();

    }

    public function listarAgendamentoPorProfissional($idprofessional, $datainicio, $datafim = ""){

        $sql = "
        SELECT 
            DISTINCT AG.ID, 
            TO_CHAR(AG.AGENDASTARTDATE, 'DD/MM/YYYY') AS DATA,  
            TO_CHAR(AG.AGENDASTARTDATE, 'HH24:MI:SS') AS HORAINI, 
            TO_CHAR(AG.AGENDAENDDATE, 'HH24:MI:SS') AS HORAFIM, 
            TO_CHAR(AG.AGENDASTARTDATE, 'YYYYMMDD') AS ORDENACAO 
        FROM 
            CAPPROFAGENDA AG 
            LEFT JOIN CAPCONSULT CC ON CC.IDPROFAGENDA = AG.ID 
        WHERE 
            AG.IDPROFESSIONAL = :IDPROF 
            AND AG.AGENDASTARTDATE > TO_DATE(:DATAINI, 'DD/MM/YYYY HH24:MI:SS') 
            AND CC.ID IS NULL ";
        if ($datafim != ""){
            $sql .= "AND AG.AGENDASTARTDATE <= TO_DATE(:DATAFIM, 'DD/MM/YYYY HH24:MI:SS') ";
        }
        $sql .= "    
        ORDER BY 
            ORDENACAO, HORAINI ";
        $qry = $this->conn->prepare($sql);
        $qry->bindValue(":IDPROF", $idprofessional);
        $qry->bindValue(":DATAINI", $datainicio);
        if ($datafim != ""){
            $qry->bindValue(":DATAFIM", $datafim);
        }
        $qry->execute();
        $res = $qry->fetchAll(PDO::FETCH_ASSOC);
        return $res;
        
    }

    public function reagendamentoVisita($idprofagenda, $idprofagendaant, $data, $horaini, $horafim){

        // Busca os dados da consulta
        $sqlConsultaAnt = "SELECT * FROM CAPCONSULT CC WHERE CC.IDPROFAGENDA = :PAANT";
        $qryConsultaAnt = $this->conn->prepare($sqlConsultaAnt);
        $qryConsultaAnt->bindValue(":PAANT", $idprofagendaant);
        $qryConsultaAnt->execute();
        $resConsultaAnt = $qryConsultaAnt->fetchAll(PDO::FETCH_ASSOC);

        $idCapConsult = $resConsultaAnt[0]["ID"];

        // Realizar o reagendamento
        $sql = "
                UPDATE 
                    CAPCONSULT 
                SET 
                    IDPROFAGENDA = :PANOVO, 
                    AGENDASTARTDATE = TO_DATE(:DATAINI, 'DD/MM/YYYY HH24:MI:SS'), 
                    AGENDAENDDATE = TO_DATE(:DATAFIM, 'DD/MM/YYYY HH24:MI:SS'), 
                    PROGRAMMEDSTART = TO_DATE(:DATAINI, 'DD/MM/YYYY HH24:MI:SS'), 
                    PROGRAMMEDEND = TO_DATE(:DATAFIM, 'DD/MM/YYYY HH24:MI:SS')
                WHERE 
                    ID = :ID";
        $qry = $this->conn->prepare($sql);
        $qry->bindValue(":PANOVO", $idprofagenda);
        $qry->bindValue(":ID", $idCapConsult);
        $qry->bindValue(":DATAINI", $data . " " . $horaini);
        $qry->bindValue(":DATAFIM", $data . " " . $horafim);
        $qry->execute();


    }

}