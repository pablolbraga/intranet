<?php
require_once("../conexao/conexao.php");
require_once("../models/evolucaomodel.php");

class EvolucaoController{

    private $conn;

    public function __construct()
    {
        $this->conn = Conexao::getInstance();
    }

    public function incluir(EvolucaoModel $c){

        $sql = "
            INSERT INTO CAPEVOLUTION (
                IDADMISSION, 
                IDPROFESSIONAL, 
                SCSPECIALITY, 
                SIGNED, 
                PROGRAMMED, 
                STARTDATE, 
                ENDDATE, 
                CREATIONDATE, 
                PERSONNAME, 
                REGISTRYNUMBER, 
                PROFESSIONALNAME, 
                PROFSHORTNAME, 
                SCSPECIALITYNAME, 
                IDTEMPLATE, 
                XMLPERSISTENCETYPE
            ) VALUES (
                :IDADMISSION, 
                :IDPROFESSIONAL, 
                :SCSPECIALITY, 
                :SIGNED, 
                :PROGRAMMED, 
                TO_DATE(:STARTDATE, 'DD/MM/YYYY HH24:MI:SS'),
                TO_DATE(:ENDDATE, 'DD/MM/YYYY HH24:MI:SS'),
                TO_DATE(:CREATIONDATE, 'DD/MM/YYYY HH24:MI:SS'),
                :PERSONNAME, 
                :REGISTRYNUMBER, 
                :PROFESSIONALNAME, 
                :PROFSHORTNAME, 
                :SCSPECIALITYNAME, 
                :IDTEMPLATE, 
                :XMLPERSISTENCETYPE
            )";
        $qry = $this->conn->prepare($sql);
        $qry->bindValue(":IDADMISSION", $c->getIdadmission());
        $qry->bindValue(":IDPROFESSIONAL", $c->getIdprofessional());
        $qry->bindValue(":SCSPECIALITY", $c->getIdespecialidade());
        $qry->bindValue(":SIGNED", $c->getAssinado());
        $qry->bindValue(":PROGRAMMED", $c->getProgramado());
        $qry->bindValue(":STARTDATE", $c->getDataini());
        $qry->bindValue(":ENDDATE", $c->getDatafim());
        $qry->bindValue(":CREATIONDATE", $c->getDatacriacao());
        $qry->bindValue(":PERSONNAME", $c->getNmprofessional());
        $qry->bindValue(":REGISTRYNUMBER", $c->getRegistroprofessional());
        $qry->bindValue(":PROFESSIONALNAME", $c->getNmprofessional());
        $qry->bindValue(":PROFSHORTNAME", $c->getApelidoprofessional());
        $qry->bindValue(":SCSPECIALITYNAME", $c->getNmespecialidade());
        $qry->bindValue(":IDTEMPLATE", $c->getIdtemplate());
        $qry->bindValue(":XMLPERSISTENCETYPE", $c->getXml());
        $qry->execute();

    }

    public function buscarUltimaEvolucao($idadmission, $idprofessional, $idespecialidade, $dataini, $datafim, $datacriacao){

        $sql = "SELECT 
                    * 
                FROM 
                    CAPEVOLUTION EVO 
                WHERE 
                    EVO.IDADMISSION = :IDADMISSION 
                    AND EVO.IDPROFESSIONAL = :IDPROF 
                    AND EVO.SCSPECIALITY = :IDESP 
                    AND EVO.STARTDATE = TO_DATE(:DATAINI, 'DD/MM/YYYY HH24:MI:SS') 
                    AND EVO.ENDDATE = TO_DATE(:DATAFIM, 'DD/MM/YYYY HH24:MI:SS') 
                    AND EVO.CREATIONDATE = TO_DATE(:DATACRIACAO, 'DD/MM/YYYY HH24:MI:SS') 
                ORDER BY 
                    EVO.ID DESC";
        $qry = $this->conn->prepare($sql);
        $qry->bindValue(":IDADMISSION", $idadmission);
        $qry->bindValue(":IDPROF", $idprofessional);
        $qry->bindValue(":IDESP", $idespecialidade);
        $qry->bindValue(":DATAINI", $dataini);
        $qry->bindValue(":DATAFIM", $datafim);
        $qry->bindValue(":DATACRIACAO", $datacriacao);
        $qry->execute();
        $res = $qry->fetchAll(PDO::FETCH_ASSOC);
        return $res;

    }

    public function informarIdEvolucaoNoCapConsult($idevolution, $idcapconsult){

        $sql = "UPDATE CAPCONSULT SET IDEVOLUTION = :IDEVOL WHERE ID = :ID";
        $qry = $this->conn->prepare($sql);
        $qry->bindValue(":IDEVOL", $idevolution);
        $qry->bindValue(":ID", $idcapconsult);
        $qry->execute();
        
    }
}