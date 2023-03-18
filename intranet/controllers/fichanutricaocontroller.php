<?php
require_once("../conexao/conexao.php");

class FichaNutricaoController{

    private $conn;

    public function __construct()
    {
        $this->conn = Conexao::getInstance();
    }

    public function buscarDadosPorEvolucao($idevolucao){

        $sql = "
                SELECT
                    PF.NAME AS NMPACIENTE,
                    (
                        TRUNC((MONTHS_BETWEEN(SYSDATE, TO_DATE(TO_CHAR(PF.BIRTHDAY, 'DD/MM/YYYY'), 'DD/MM/YYYY')))/12)
                    ) AS IDADE, 
                    HP.NAME AS NMSERVICO, 
                    (CASE WHEN ADM.IDENTERPRISE IS NULL THEN 'PARTICULAR' ELSE CV.NAME END) AS NMCONVENIO, 
                    TO_CHAR(EVO.STARTDATE, 'DD/MM/YYYY HH24:MI:SS') AS DATAINICIO,
                    TO_CHAR(EVO.ENDDATE, 'DD/MM/YYYY HH24:MI:SS') AS DATAFIM, 
                    ASS.ASS_PAC, 
                    ASS.ASS_PROF, 
                    ADM.ID AS IDADMISSION, 
                    PFPROF.NAME AS NMPROFESSIONAL, 
                    PROF.REGISTRYNUMBER AS REGISTRO, 
                    (SELECT D.TRANSLATION FROM IFRCONSTANTITEM D WHERE D.KEYINDEX = PROF.REGISTRYTYPE AND D.IDCONSTANT = 182) AS CONSELHO, 
                    AC.* 
                FROM 
                    TDACNUTRICAO AC 
                    INNER JOIN CAPEVOLUTION EVO ON EVO.ID = AC.IDEVOLUTION 
                    INNER JOIN CAPADMISSION ADM ON ADM.ID = EVO.IDADMISSION 
                    INNER JOIN GLBPATIENT PAT ON PAT.ID = ADM.IDPATIENT 
                    INNER JOIN GLBPERSON PF ON PF.ID = PAT.IDPERSON 
                    INNER JOIN GLBHEALTHPROVDEP HPD ON HPD.ID = ADM.IDHEALTHPROVDEP 
                    INNER JOIN GLBHEALTHPROVIDER HP ON HP.ID = ADM.IDHEALTHPROVIDER  
                    INNER JOIN GLBPROFESSIONAL PROF ON PROF.IDPERSON = EVO.IDPROFESSIONAL 
                    INNER JOIN GLBPERSON PFPROF ON PFPROF.ID = PROF.IDPERSON 
                    LEFT JOIN GLBENTERPRISE CV ON CV.ID = ADM.IDENTERPRISE 
                    LEFT JOIN SR_ASSINATURAS ASS ON ASS.IDEVOLUCAO = EVO.ID AND ASS.IDADMISSION = ADM.ID 
                WHERE 
                    AC.IDEVOLUTION = :IDEVOL";
        $qry = $this->conn->prepare($sql);
        $qry->bindValue(":IDEVOL", $idevolucao);
        $qry->execute();
        $res = $qry->fetchAll(PDO::FETCH_ASSOC);
        return $res;

    }

}