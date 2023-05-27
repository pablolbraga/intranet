<?php
require_once("../conexao/conexao.php");

class OrcamentoController{

    private $conn;

    public function __construct()
    {
        $this->conn = Conexao::getInstance();
    }


    public function buscarPorId($idOrcamento){

        $sql = "
        SELECT 
            DISTINCT
            orci.id AS IDITEMORCAMENTO,  ORC.AUTHORIZINTSTATUS AS AUTORIZACAOINTERNA,  ORCI.SEQ,  ORC.ID,  ORC.IDTEXT, 
            ORCI.COMMENTS AS OBS, ORC.IDADMISSION, CONV.ID AS IDCONVENIO, (CASE WHEN CONV.NAME IS NULL THEN 'PARTICULAR' ELSE CONV.NAME END) AS NMCONVENIO, PAC.NAME AS NMPACIENTE,
            PAC.ADDRESS || ' ' || PAC.COMPLEMENT || ' ' || PAC.DISTRICT || ' ' || PAC.CITY || ' ' || PAC.STATE || ' ' || PAC.ZIPCODE AS ENDERECO,
            HP.NAME AS NIVELCOMPLEXIDADE, TO_CHAR(ORC.STARTDATE,'DD/MM/YYYY') AS DTINICIOORC, TO_CHAR(ORC.ENDDATE,'DD/MM/YYYY') AS DTFIMORC, 
            (case sct.IDANCESTRAL WHEN 77 THEN 'DIARIA' ELSE SCT.NAME END) AS NMTABLE, SCT.ID AS IDTABLE, SCC.ID AS CODPRODUTO, ORCI.SCCODEREFER AS CODPRODUTOREF,
            SCC.CODENAME AS NMPRODUTO, ORCI.QUANTITY AS QTDE,  ORCI.MU AS UNIDMED, ROUND(ORCI.UNITPRICE,2) AS VRUNITARIO, ORCI.COVERAGEQUANTITY AS QTDENOPACOTE,
            ORCI.DISCOUNT AS VRDESCONTO, ROUND(((ORCI.QUANTITY - ORCI.COVERAGEQUANTITY) * ORCI.UNITPRICE),2) AS VRTOTAL, ((ORC.ENDDATE - ORC.STARTDATE) + 1) AS DIAS,
            ROUND((((ORCI.QUANTITY - ORCI.COVERAGEQUANTITY) * ORCI.UNITPRICE) / ((ORC.ENDDATE - ORC.STARTDATE) + 1)),2) AS VRTOTALDIA,
            ORCI.IDPRICELSTVERSION, (CASE SCT.ID WHEN 55 THEN TB.NAME || ' - ' || TBV.NAME WHEN 56 THEN TB.NAME || ' - ' || TBV.NAME ELSE TBV.NAME END) AS NMTABPRECO, 
            'ORC' AS TIPO, TRMED.EXTERNALCODE AS TISSGRPMED, TRMAT.EXTERNALCODE AS TISSGRPMAT 
        FROM 
            CAPBUDGET ORC 
            INNER JOIN CAPBUDGETITEM ORCI ON ORCI.IDBUDGET = ORC.ID
            INNER JOIN CAPADMISSION ADM ON ADM.ID = ORC.IDADMISSION    
            INNER JOIN GLBPATIENT PT ON PT.ID = ADM.IDPATIENT
            INNER JOIN GLBPERSON PAC ON PAC.ID = PT.IDPERSON
            INNER JOIN GLBHEALTHPROVDEP HPD ON HPD.ID = ADM.IDHEALTHPROVDEP
            INNER JOIN GLBHEALTHPROVIDER HP ON HP.ID = HPD.IDHEALTHPROVIDER
            INNER JOIN SCCCODE SCC ON SCC.ID = ORCI.SCRESOURCE
            INNER JOIN SCCTABLE SCT ON SCT.ID = SCC.IDTABLE
            LEFT JOIN CTRPRICELSTVERSION TBV ON TBV.ID = ORCI.IDPRICELSTVERSION
            LEFT JOIN CTRPRICELIST TB ON TB.ID = TBV.IDPRICELIST
            LEFT JOIN GLBENTERPRISE CONV ON CONV.ID = ADM.IDENTERPRISE 
            LEFT JOIN TDTISSRESOURCEGRP TRMED ON TRMED.IDENTERPRISE = ADM.IDENTERPRISE AND TRMED.IDSYNONYM = 12
            LEFT JOIN TDTISSRESOURCEGRP TRMAT ON TRMAT.IDENTERPRISE = ADM.IDENTERPRISE AND TRMAT.IDSYNONYM = 1
        WHERE 
            ORC.ID = :IDORCAMENTO 
            AND NOT SCT.ID IN (156)
        UNION ALL 
        SELECT
            DISTINCT
            orci.id AS IDITEMORCAMENTO, ORC.AUTHORIZINTSTATUS AS AUTORIZACAOINTERNA, ORCI.SEQ, ORC.ID, 0 AS IDTEXT, 
            ORCI.COMMENTS AS OBS, ORC.IDADMISSION, CONV.ID AS IDCONVENIO, (CASE WHEN CONV.NAME IS NULL THEN 'PARTICULAR' ELSE CONV.NAME END) AS NMCONVENIO, PAC.NAME AS NMPACIENTE,
            PAC.ADDRESS || ' ' || PAC.COMPLEMENT || ' ' || PAC.DISTRICT || ' ' || PAC.CITY || ' ' || PAC.STATE || ' ' || PAC.ZIPCODE AS ENDERECO,
            HP.NAME AS NIVELCOMPLEXIDADE, TO_CHAR(ORC.STARTDATE,'DD/MM/YYYY') AS DTINICIOORC, TO_CHAR(ORC.ENDDATE,'DD/MM/YYYY') AS DTFIMORC,
            (case sct.IDANCESTRAL WHEN 77 THEN 'DIARIA' ELSE SCT.NAME END) AS NMTABLE, SCT.ID AS IDTABLE, SCC.ID AS CODPRODUTO, ORCI.SCCODEREFER AS CODPRODUTOREF,
            SCC.CODENAME AS NMPRODUTO, ORCI.QUANTITY AS QTDE, ORCI.MU AS UNIDMED, ROUND(ORCI.UNITPRICE,2) AS VRUNITARIO, ORCI.COVERAGEQUANTITY AS QTDENOPACOTE,
            ORCI.DISCOUNT AS VRDESCONTO, ROUND(((ORCI.QUANTITY - ORCI.COVERAGEQUANTITY) * ORCI.UNITPRICE),2) AS VRTOTAL, ((ORC.ENDDATE - ORC.STARTDATE) + 1) AS DIAS,
            ROUND((((ORCI.QUANTITY - ORCI.COVERAGEQUANTITY) * ORCI.UNITPRICE) / ((ORC.ENDDATE - ORC.STARTDATE) + 1)),2) AS VRTOTALDIA,
            ORCI.IDPRICELSTVERSION, (CASE SCT.ID WHEN 55 THEN TB.NAME || ' - ' || TBV.NAME WHEN 56 THEN TB.NAME || ' - ' || TBV.NAME ELSE TBV.NAME END) AS NMTABPRECO, 
            'ADT' AS TIPO, TRMED.EXTERNALCODE AS TISSGRPMED, TRMAT.EXTERNALCODE AS TISSGRPMAT 
        FROM 
            CAPBUDGETADDITIVE ORC 
            INNER JOIN CAPBUDGETITEM ORCI ON ORCI.IDBUDGETADDITIVE = ORC.ID
            INNER JOIN CAPADMISSION ADM ON ADM.ID = ORC.IDADMISSION    
            INNER JOIN GLBPATIENT PT ON PT.ID = ADM.IDPATIENT
            INNER JOIN GLBPERSON PAC ON PAC.ID = PT.IDPERSON
            INNER JOIN GLBHEALTHPROVDEP HPD ON HPD.ID = ADM.IDHEALTHPROVDEP
            INNER JOIN GLBHEALTHPROVIDER HP ON HP.ID = HPD.IDHEALTHPROVIDER
            INNER JOIN SCCCODE SCC ON SCC.ID = ORCI.SCRESOURCE
            INNER JOIN SCCTABLE SCT ON SCT.ID = SCC.IDTABLE
            LEFT JOIN CTRPRICELSTVERSION TBV ON TBV.ID = ORCI.IDPRICELSTVERSION
            LEFT JOIN CTRPRICELIST TB ON TB.ID = TBV.IDPRICELIST
            LEFT JOIN GLBENTERPRISE CONV ON CONV.ID = ADM.IDENTERPRISE 
            LEFT JOIN TDTISSRESOURCEGRP TRMED ON TRMED.IDENTERPRISE = ADM.IDENTERPRISE AND TRMED.IDSYNONYM = 12
            LEFT JOIN TDTISSRESOURCEGRP TRMAT ON TRMAT.IDENTERPRISE = ADM.IDENTERPRISE AND TRMAT.IDSYNONYM = 1
        WHERE 
            ORC.ID = :IDORCAMENTO 
            AND NOT SCT.ID IN (156) 
        ORDER BY 
            SEQ, NMPRODUTO
        ";
        //echo $sql . "<br>";
        $qry = $this->conn->prepare($sql);
        $qry->bindValue(":IDORCAMENTO", $idOrcamento);
        $qry->execute();
        $res = $qry->fetchAll(PDO::FETCH_ASSOC);
        return $res;

    }

    public function buscarCodigosTiss($idEnterprise, $idProduto){

        $sql = "SELECT DISTINCT EXTERNALCODE FROM CTRBILLINGCODEREF TISS WHERE TISS.SCCODE = :IDPRODUTO AND TISS.IDENTERPRISE = :IDENTERPRISE";
        $qry = $this->conn->prepare($sql);
        $qry->bindValue(":IDPRODUTO", $idProduto);
        $qry->bindValue(":IDENTERPRISE", $idEnterprise);
        $qry->execute();
        $res = $qry->fetchAll(PDO::FETCH_ASSOC);

        $items = "";
        for($i = 0; $i < count($res); $i++){
            $items = $items . $res[$i]["EXTERNALCODE"] . ",";
        }


        return substr($items, 0, strlen($items) - 1);

    }

    public function buscarCodigoTissTuss($produtoId, $convenioId){

        $sql = 
        "
        select distinct j.*, ctr.sccode as codigoiw from (
            select b.codbrasind as codbras_simpro, b.codtiss as tiss, tuss.codtuss as tuss, c.id as idproduto, c.codename as nmproduto, 'BRASINDICE' as nmtabela 
            from tdtissbrasindice b 
            inner join scccode c on c.alternatename = b.codbrasind and c.idtable = 33 
            left join TDTUSSCODEREFER tuss on tuss.sccode = c.id and tuss.idpricelist = 1
            UNION ALL
            select c.alternatename as codbras_simpro, c.alternatename as tiss, '' as tuss, c.id as idproduto, c.codename as nmproduto, 'SIMPRO' as nmtabela 
            from scccode c
            where c.idtable = 34 
            UNION ALL
            SELECT 
                '' as codbras_simpro,
                '' as tiss,
                TUSS.CODTUSS as tuss,
                REF.sccoderefer as idproduto,
                '' as nmproduto,
                'TUSS' AS nmtabela
            FROM 
                CTRSCCODEREFER REF INNER JOIN tdtusscoderefer TUSS ON tuss.sccode = ref.sccoderefer AND tuss.idpricelist = 4                 
            ) j inner join CTRSCCODEREFER ctr on ctr.sccoderefer = j.idproduto
            where ctr.sccode = :CODIGO 
        UNION ALL
        select 
                '' as codbras_simpro,
                '' as tiss,
                externalcode as tuss,
                sccode as idproduto,
                '' as nmproduto,
                'TUSS' AS nmtabela,                
                sccode as CODIGOIW
            from
                CTRBILLINGCODEREF where sccode = :CODIGO and IDENTERPRISE = :IDCONVENIO 
            order by 5,4
        ";
        $qry = $this->conn->prepare($sql);
        $qry->bindValue(":CODIGO", $produtoId);
        $qry->bindValue(":IDCONVENIO", $convenioId);
        $qry->execute();
        $res = $qry->fetchAll(PDO::FETCH_ASSOC);
        return $res;

    }
}