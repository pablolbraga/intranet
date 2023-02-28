<?php
require_once("../conexao/conexao.php");

class AdmissaoController{

    private $conn;

    public function __construct(){
        $this->conn = Conexao::getInstance();
    }

    public function retornarDadosPorAdmissao($idadmission){

        $sql = "
        SELECT 
            ADM.*,
            PF.NAME AS NMPACIENTE, 
            (CASE ADM.IDENTERPRISE WHEN 0 THEN 'PARTICULAR' ELSE CV.NAME END) AS NMCONVENIO, 
            PF.ADDRESS AS ENDERECO, 
            PF.COMPLEMENT AS COMPLEMENTO, 
            PF.DISTRICT AS BAIRRO, 
            PF.CITY AS CIDADE, 
            PF.STATE AS UF, 
            PF.ZIPCODE AS CEP
        FROM 
            CAPADMISSION ADM 
            INNER JOIN GLBPATIENT PAT ON PAT.ID = ADM.IDPATIENT 
            INNER JOIN GLBPERSON PF ON PF.ID = PAT.IDPERSON 
            LEFT JOIN GLBENTERPRISE CV ON CV.ID = ADM.IDENTERPRISE 
        WHERE 
            ADM.ID = :IDADMISSION";
        $qry = $this->conn->prepare($sql);
        $qry->bindValue(":IDADMISSION", $idadmission);
        $qry->execute();
        $res = $qry->fetchAll(PDO::FETCH_ASSOC);
        return $res;
        

    }

}