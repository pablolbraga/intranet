<?php
require_once("../conexao/conexao.php");
require_once("../models/solicitacaocompramodel.php");

class ComprasController{

    private $conn;

    public function __construct()
    {
        $this->conn = Conexao::getInstance();
    }

    public function listarCompras($dataini, $datafim, $matmed, $fornecedor, $status){

        $sql = "SELECT 
                    DISTINCT C.ID,C.COD_MATERIAL,S.CODENAME AS NOME_COMERCIAL,
                    C.QUANTIDADE as QTD_SOLICITADA,
                    C.NOTAFISCAL,
                    CI.QUANTIDADE AS QTD_COMPRADA,
                    TO_CHAR(C.DATA_SOLICITACAO,'DD/MM/YYYY') AS DATA_SOLICITACAO,
                    TO_CHAR(C.DATA_CHEGADA,'DD/MM/YYYY HH24:MI') AS DATA_CHEGADA,
                    C.QTD_RECEBIDA,
                    TO_CHAR(C.DATA_NECESSIDADE,'DD/MM/YYYY') AS DATA_NECESSIDADE,
                    TO_CHAR(CI.DATA_PREV_CHEGADA,'DD/MM/YYYY HH24:MI') AS DATA_PREVISAOCHEGADA,
                    C.STATUS,
                    CI.IDFORNECEDOR,
                    EMP.NAME AS NMFORNECEDOR, 
                    NFI.UNITPRICE AS VRUNITARIO, 
                    TO_CHAR(NF.LAYAWAYDATE1,'DD/MM/YYYY') AS VCT001, 
                    TO_CHAR(NF.LAYAWAYDATE2,'DD/MM/YYYY') AS VCT002, 
                    TO_CHAR(NF.LAYAWAYDATE3,'DD/MM/YYYY') AS VCT003, 
                    TO_CHAR(NF.LAYAWAYDATE4,'DD/MM/YYYY') AS VCT004, 
                    TO_CHAR(NF.LAYAWAYDATE5,'DD/MM/YYYY') AS VCT005, 
                    TO_CHAR(NF.LAYAWAYDATE6,'DD/MM/YYYY') AS VCT006, 
                    NF.LAYAWAYVALUE1 AS VAL001, 
                    NF.LAYAWAYVALUE2 AS VAL002, 
                    NF.LAYAWAYVALUE3 AS VAL003, 
                    NF.LAYAWAYVALUE4 AS VAL004, 
                    NF.LAYAWAYVALUE5 AS VAL005, 
                    NF.LAYAWAYVALUE6 AS VAL006, 
                    TO_CHAR(C.DATA_SOLICITACAO, 'YYYYMMDD') AS ORDENACAODATA, 
                    CI.VALOR_PRODUTO 
                FROM 
                    SR_SOLICTACAO_COMPRAS C 
                    INNER JOIN SCCCODE S ON S.ID = C.COD_MATERIAL
                    LEFT JOIN SR_COTACAO_MED_ITEM CI ON CI.IDSOLICITACAO = C.ID
                    LEFT JOIN GLBENTERPRISE EMP ON EMP.ID = CI.IDFORNECEDOR 
                    LEFT JOIN FINBILLOFSALE NF ON NF.BSNUMBER = c.notafiscal AND NF.IDSUPPLIER = EMP.ID 
                    LEFT JOIN FINBILLOFSALEITEM NFI ON nfi.idbillofsale = NF.ID  AND NFI.SCCODE = C.COD_MATERIAL
                WHERE 
                    C.DATA_SOLICITACAO BETWEEN TO_DATE(:DATAINI ,'DD/MM/YYYY HH24:MI:SS') AND TO_DATE(:DATAFIM,'DD/MM/YYYY HH24:MI:SS') ";
        if ($matmed != ""){
            $sql .= "AND C.COD_MATERIAL = :IDPRODUTO ";
        }
        if ($fornecedor != ""){
            $sql .= "AND EMP.ID = :IDFORNECEDOR ";
        }
        if ($status != ""){
            $sql .= "AND C.STATUS = :STATUS ";
        }
        $sql .= "ORDER BY 
                    ORDENACAODATA, NMFORNECEDOR, NOME_COMERCIAL";
        $qry = $this->conn->prepare($sql);
        $qry->bindValue(":DATAINI", $dataini);
        $qry->bindValue(":DATAFIM", $datafim);
        if ($matmed != ""){
            $qry->bindValue(":IDPRODUTO", $matmed);
        }
        if ($fornecedor != ""){
            $qry->bindValue(":IDFORNECEDOR", $fornecedor);
        }
        if ($status != ""){
            $qry->bindValue(":STATUS", $status);
        }
        $qry->execute();
        $res = $qry->fetchAll(PDO::FETCH_ASSOC);
        return $res;

    }

    public function confereNotaFiscal($nota, $idmaterial){

        $sql = "SELECT 
                    B.BSNUMBER AS IDNOTA, 
                    M.SCMATERIAL, 
                    SUM(M.SCHEDULEQUANTITY) AS QTD_TOTAL, 
                    TO_CHAR(B.CREATIONDATE,'DD/MM/YYYY HH24:MI:SS') AS DTNOTAFISCAL, 
                    B.IDSUPPLIER AS IDFORNECEDOR,
                    G.FULLNAME AS NMFORNECEDOR, 
                    COUNT(*)
                from 
                    FINBILLOFSALE B 
                    INNER JOIN FINBILLOFSALEITEM B1 ON B1.IDBILLOFSALE = B.ID
                    INNER JOIN MATMATERIALMOV M ON M.ID = B1.IDMATERIALMOV
                    INNER JOIN GLBENTERPRISE G ON G.ID = B.IDSUPPLIER
                WHERE 
                    B.BSNUMBER LIKE :NOTAFISCAL 
                    AND B1.STATUS = 0 
                    AND B1.SCCODE = :IDMATERIAL  
                GROUP BY 
                    B.BSNUMBER, 
                    M.SCMATERIAL, 
                    TO_CHAR(B.CREATIONDATE,'DD/MM/YYYY HH24:MI:SS'), 
                    B.IDSUPPLIER,
                    G.FULLNAME";
        $qry = $this->conn->prepare($sql);
        $qry->bindValue(":IDMATERIAL", $idmaterial);
        $qry->bindValue(":NOTAFISCAL", "%" . trim($nota) . "%");
        $qry->execute();
        $res = $qry->fetchAll(PDO::FETCH_ASSOC);
        return $res;

    }

    function verificarDuplicata($nota, $idmaterial, $idfornecedor){

        $sql = "SELECT 
                    S.ID,
                    S.NOTAFISCAL,
                    S.COD_MATERIAL AS IDMATERIAL,
                    S.STATUS
                FROM 
                    SR_SOLICTACAO_COMPRAS S
                WHERE 
                    S.NOTAFISCAL like :NOTAFISCAL 
                    AND S.COD_MATERIAL = :IDMATERIAL 
                    AND STATUS like '%RECEBIDO%'";
        $qry = $this->conn->prepare($sql);
        $qry->bindValue(":IDMATERIAL", $idmaterial);
        $qry->bindValue(":NOTAFISCAL", "%" . trim($nota) . "%");
        $qry->execute();
        $res = $qry->fetchAll(PDO::FETCH_ASSOC);
        
        if(count($res) > 0){

            $sql2 = "SELECT 
                        C.IDFORNECEDOR 
                    FROM 
                        SR_SOLICTACAO_COMPRAS S
                        INNER JOIN SR_COTACAO_MED_ITEM C ON C.IDSOLICITACAO = S.ID
                    WHERE 
                        S.NOTAFISCAL like :NOTAFISCAL 
                        AND S.COD_MATERIAL = :IDMATERIAL 
                        AND C.IDFORNECEDOR = :IDFORNECEDOR";
            $qry2 = $this->conn->prepare($sql2);
            $qry2->bindValue(":IDMATERIAL", $idmaterial);
            $qry2->bindValue(":NOTAFISCAL", "%" . trim($nota) . "%");
            $qry2->bindValue(":IDFORNECEDOR", $idfornecedor);
            $qry2->execute();
            $res2 = $qry2->fetchAll(PDO::FETCH_ASSOC);
            return $res2;

        } else {
            return $res;
        }

    }

    public function confirmarCompra($id,$data,$radioConsignacao,$notafiscal,$qtdrecebida){

        $sql = "UPDATE 
                    SR_SOLICTACAO_COMPRAS 
                SET 
                    STATUS = 'RECEBIDO',
                    DATA_CHEGADA = TO_DATE(:DATA,'DD/MM/YYYY HH24:MI:SS'), 
                    QTD_RECEBIDA = :QTDERECEBIDA, 
                    NOTAFISCAL = :NOTAFISCAL, 
                    CONSIGNACAO = :CONSIGNACAO 
                WHERE 
                    ID = :ID";
        $qry = $this->conn->prepare($sql);
        $qry->bindValue(":DATA", $data . ":00");
        $qry->bindValue(":QTDERECEBIDA", $qtdrecebida);
        $qry->bindValue(":NOTAFISCAL", trim($notafiscal));
        $qry->bindValue(":CONSIGNACAO", $radioConsignacao == "" ? "NAO" : "SIM");
        $qry->bindValue(":ID", $id);
        $qry->execute();

    }

    public function cancelarCompra($codigo, $observacao){

        $sql = "UPDATE 
                    SR_SOLICTACAO_COMPRAS 
                SET 
                    STATUS = 'CANCELADO',
                    DATA_CANCELADO = TO_DATE('" . date("d/m/Y H:i:s") . "','DD/MM/YYYY HH24:MI:SS'),
                    OBS_CANCELADO = :OBS 
                WHERE 
                    ID = :ID";
        $qry = $this->conn->prepare($sql);
        $qry->bindValue(":OBS", $observacao);
        $qry->bindValue(":ID", $codigo);
        $qry->execute();

    }

    public function existeSolicitacaoPorStatus($idmaterial, $status){

        $sql = "SELECT * FROM SR_SOLICTACAO_COMPRAS C WHERE C.IDUSUARIO != 305 AND C.NOTAFISCAL IS NULL AND C.DATA_CANCELADO IS NULL AND C.STATUS like :STATUS AND C.COD_MATERIAL = :IDMATERIAL";
        $qry = $this->conn->prepare($sql);
        $qry->bindValue(":IDMATERIAL", $idmaterial);
        $qry->bindValue(":STATUS", "%" . trim($status) . "%");
        $qry->execute();
        $res = $qry->fetchAll(PDO::FETCH_ASSOC);
        return $res;

    }

    public function inserirSolicitacaoCompra(SolicitacaoCompraModel $c){

        $sql = "INSERT INTO SR_SOLICTACAO_COMPRAS (
                    FALTANTE, 
                    COD_MATERIAL, 
                    QUANTIDADE, 
                    DATA_SOLICITACAO, 
                    DATA_NECESSIDADE, 
                    STATUS, 
                    OBS_URGENCIA, 
                    URGENCIA, 
                    IDUSUARIO
                ) VALUES (
                    :FALTANTE, 
                    :COD_MATERIAL, 
                    :QUANTIDADE, 
                    TO_DATE(:DATA_SOLICITACAO, 'DD/MM/YYYY HH24:MI:SS'), 
                    TO_DATE(:DATA_NECESSIDADE, 'DD/MM/YYYY HH24:MI:SS'), 
                    :STATUS, 
                    :OBS_URGENCIA, 
                    :URGENCIA, 
                    :IDUSUARIO
                )";
        $qry = $this->conn->prepare($sql);
        $qry->bindValue(":FALTANTE", $c->getFaltante());
        $qry->bindValue(":COD_MATERIAL", $c->getIdmaterial());
        $qry->bindValue(":QUANTIDADE", $c->getQuantidade());
        $qry->bindValue(":DATA_SOLICITACAO", $c->getDatasolicitacao());
        $qry->bindValue(":DATA_NECESSIDADE", $c->getDatanecessidadeinicio() + " " + $c->getHoraprevista());
        $qry->bindValue(":STATUS", $c->getStatus());
        $qry->bindValue(":OBS_URGENCIA", $c->getUrgencia());
        $qry->bindValue(":URGENCIA", $c->getUrgencia() == "" ? "NAO" : "SIM");
        $qry->bindValue(":IDUSUARIO", $c->getIdusuario());
        $qry->execute();

    }
}