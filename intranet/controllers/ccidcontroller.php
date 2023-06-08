<?php
require_once("../conexao/conexao.php");
require_once('../models/ccidantibioticomodel.php');

class CcidController{

    private $conn;

    public function __construct()
    {
        $this->conn = Conexao::getInstance();
    }

    public function listarControleAtb($dataInicio, $dataFim, $idAdmission, $status){

        $sql = "SELECT
                    G.NAME   AS NOME_PACIENTE,
                    (CASE 
                        WHEN C.IDENTERPRISE IS NULL THEN 'PARTICULAR'
                        ELSE 'OPERADORA'
                    END) AS EMPRESA,
                    TO_CHAR(A.DTSOLICITACAO,'DD/MM/YYYY') AS DATA_INICIO,
                    TO_CHAR(A.DT_ANTIB_INI,'DD/MM/YYYY') AS DATA_ATB_INI,
                    TO_CHAR(A.DT_ANTIB_FIM,'DD/MM/YYYY') AS DATA_ATB_FIM,
                    TO_CHAR(A.DT_ANTIB_FIM,'YYYYMMDDHH24MISS') AS DATA_ATB_FIM_FORMAT,
                    TO_CHAR(A.dt_antib_ini + (dias),'YYYYMMDDHH24MISS') AS DATA_ATB_PRAZO_FORMAT,
                    TO_CHAR(A.DT_ANTIB_INI,'HH24:MI') AS HORA_ATB_INI,
                    TO_CHAR(A.DT_ANTIB_FIM,'HH24:MI') AS HORA_ATB_FIM,
                    TO_CHAR(A.DATA_FINALIZADO,'YYYYMMDDHH24MISS') AS DATA_FINALIZADO_FORMAT,
                    A.*
                FROM
                    SR_ATENDIMENTO_ANTIBIOTICO A
                    INNER JOIN CAPADMISSION C ON A.IDADMISSION = C.ID
                    INNER JOIN GLBPATIENT P ON P.ID = C.IDPATIENT
                    INNER JOIN GLBPERSON G ON G.ID = P.IDPERSON
                WHERE
                    1 = 1 ";
        if ($dataInicio != ""){
            $sql .= "AND A.DT_ANTIB_INI >= TO_DATE(:DATAINICIO, 'DD/MM/YYYY HH24:MI:SS') ";
        }
        if ($dataFim != ""){
            $sql .= "AND A.DT_ANTIB_INI <= TO_DATE(:DATAFIM, 'DD/MM/YYYY HH24:MI:SS') ";
        }
        if ($idAdmission != ""){
            $sql .= "AND C.ID = :IDADMISSION ";
        }
        if ($status != "0"){
            $sql .= "AND A.STATUS = :STATUS AND A.STATUS_EXC IS NULL ";
        } else {
            $sql .= "AND A.STATUS IS NOT NULL AND A.STATUS_EXC IS NULL ";
        }
        $sql .= "ORDER BY G.NAME";
        
        $qry = $this->conn->prepare($sql);
        if ($dataInicio <> ""){
            $qry->bindValue(":DATAINICIO", $dataInicio . " 00:00:00");
        }
        if ($dataFim != ""){
            $qry->bindValue(":DATAFIM", $dataFim . " 23:59:59");
        }
        if ($idAdmission != ""){
            $qry->bindValue(":IDADMISSION", $idAdmission);
        }
        if ($status != "0"){
            $qry->bindValue(":STATUS", $status);
        }
        $qry->execute();
        $res = $qry->fetchAll(PDO::FETCH_ASSOC);
        return $res;

    }

    public function baixaAntibiotico(CcidAntibioticoModel $c){

        $sql = "UPDATE 
                    SR_ATENDIMENTO_ANTIBIOTICO 
                SET 
                    FINALIZADO = 'S', 
                    STATUS = 'E', 
                    DATA_FINALIZADO = TO_DATE('". date("d/m/Y H:i:s")."','DD/MM/YYYY HH24:MI:SS') 
                WHERE 
                    ID = :ID";
        $qry = $this->conn->prepare($sql); 
        $qry->bindValue(":ID", $c->getId());
        $qry->execute();

    }

    public function validaDadosAntibiotico(CcidAntibioticoModel $c){
        if ($c->getId() > 0){
            $this->alterarAntibiotico($c);
        } else {
            $this->incluirAntibiotico($c);
        }
    }

    private function alterarAntibiotico(CcidAntibioticoModel $c){

        $sql = "
            UPDATE  
                SR_ATENDIMENTO_ANTIBIOTICO
            SET
                IDADMISSION = :P1, 
                ANTIMICROBIANO = :P2, 
                DOSE = :P3,
                INTERVALO = :P4, 
                VIA = :P5, 
                DIAS = :P6, 
                MOTIVO = :P7, 
                TIPO_PAD = :P8, 
                ORIG_INFEC = :P9, 
                OBS = :P10, 
                EXAME = :P11, 
                RESULTADO = :P12,
                DT_ANTIB_INI = TO_DATE(:P13, 'DD/MM/YYYY HH24:MI:SS') , 
                DT_ANTIB_FIM = TO_DATE(:P14, 'DD/MM/YYYY HH24:MI:SS'), 
                STATUS = :P15 
            WHERE 
                ID = :P16
        ";
        $qry = $this->conn->prepare($sql); 
        $qry->bindValue(":P1", $c->getIdAdmission());
        $qry->bindValue(":P2", $c->getAntimicrobiano());
        $qry->bindValue(":P3", $c->getDose());
        $qry->bindValue(":P4", $c->getIntervalo());
        $qry->bindValue(":P5", $c->getVia());
        $qry->bindValue(":P6", $c->getDias());
        $qry->bindValue(":P7", $c->getMotivo());
        $qry->bindValue(":P8", $c->getTipoPad());
        $qry->bindValue(":P9", $c->getOrigemInfec());
        $qry->bindValue(":P10", $c->getObs());
        $qry->bindValue(":P11", $c->getExame());
        $qry->bindValue(":P12", $c->getResultado());
        $qry->bindValue(":P13", $c->getDtAntIni() . ":00");
        $qry->bindValue(":P14", $c->getDtAntFim() . ":00");
        $qry->bindValue(":P15", $c->getStatus());
        $qry->bindValue(":P16", $c->getId());
        $qry->execute();

    }

    private function incluirAntibiotico(CcidAntibioticoModel $c){
        
        $sql = "
            INSERT INTO SR_ATENDIMENTO_ANTIBIOTICO 
            (
                IDADMISSION, ANTIMICROBIANO, DTSOLICITACAO, DOSE,
                INTERVALO, VIA, DIAS, MOTIVO, FINALIZADO,  
                TIPO_PAD, ORIG_INFEC, OBS, 
                EXAME, RESULTADO,
                DT_ANTIB_INI, DT_ANTIB_FIM, STATUS
            ) 
            VALUES 
            (
                :P1, :P2, TO_DATE(:P17,'DD/MM/YYYY'), :P3, 
                :P4, :P5, :P6, :P7, 'N',  
                :P8, :P9, :P10, 
                :P11, :P12, 
                TO_DATE(:P13, 'DD/MM/YYYY HH24:MI:SS') , 
                TO_DATE(:P14, 'DD/MM/YYYY HH24:MI:SS'), 
                :P15
            )
        ";
        $qry = $this->conn->prepare($sql); 
        $qry->bindValue(":P1", $c->getIdAdmission());
        $qry->bindValue(":P2", $c->getAntimicrobiano());
        $qry->bindValue(":P3", $c->getDose());
        $qry->bindValue(":P4", $c->getIntervalo());
        $qry->bindValue(":P5", $c->getVia());
        $qry->bindValue(":P6", $c->getDias());
        $qry->bindValue(":P7", $c->getMotivo());
        $qry->bindValue(":P8", $c->getTipoPad());
        $qry->bindValue(":P9", $c->getOrigemInfec());
        $qry->bindValue(":P10", $c->getObs());
        $qry->bindValue(":P11", $c->getExame());
        $qry->bindValue(":P12", $c->getResultado());
        $qry->bindValue(":P13", $c->getDtAntIni() . ":00");
        $qry->bindValue(":P14", $c->getDtAntFim() . ":00");
        $qry->bindValue(":P15", $c->getStatus());
        $qry->bindValue(":P17", $c->getDataInicio());
        $qry->execute();

    }

    public function excluirAntibiotico($codigo, $idUsuario, $motivo){

        $sql = "UPDATE 
                    SR_ATENDIMENTO_ANTIBIOTICO 
                SET 
                    STATUS_EXC = 'I' 
                    , IDUSU_EXC = :IDUSUARIO 
                    , MOT_EXC = :MOTIVO 
                    , DT_EXC = TO_DATE('" . date("d/m/Y H:i:s") . "','DD/MM/YYYY HH24:MI:SS') 
                WHERE 
                    ID = :ID";
        $qry = $this->conn->prepare($sql);
        $qry->bindValue(":IDUSUARIO", $idUsuario);
        $qry->bindValue(":MOTIVO", $motivo);
        $qry->bindValue(":ID", $codigo);
        $qry->execute();

    }


}