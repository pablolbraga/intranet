<?php
require_once("../conexao/conexao.php");

class FinanceiroController{

    private $conn;

    public function __construct()
    {
        $this->conn = Conexao::getInstance();
    }

    public function listarNotas($status, $dataInicio, $dataFim, $tipo, $idPaciente){

        $sql = "SELECT 
                A.ID, A.IDPARTCONV, TO_CHAR(A.DT_SOLIC, 'DD/MM/YYYY HH24:MI:SS') AS DT_SOLIC, B.NOME AS NMPACIENTE, 
                E.NOME AS NMUSU_SOLIC, A.OBS_SOLIC, A.IDUSU_CONF, F.NOME AS NMUSU_CONF, 
                TO_CHAR(A.DT_CONF, 'DD/MM/YYYY HH24:MI:SS') AS DT_CONF, A.OBS_CONF, 
                A.STATUS, A.TIPO, (CASE A.TIPO WHEN 'N' THEN 'SOL. NOTA FISCAL' WHEN 'C' THEN 'SOL. BAIXA CRÉDITO' END) AS NMTIPO, 
                A.IDUSU_SOLIC, A.VALOR    
                FROM SR_SOLICNOTA A
                INNER JOIN VW_LISTA_PART_CONVENIO_GERAL B ON B.CODIGO = A.IDPARTCONV
                INNER JOIN SR_USUARIO E ON E.IDUSUARIO = A.IDUSU_SOLIC
                LEFT JOIN SR_USUARIO F ON F.IDUSUARIO = A.IDUSU_CONF
                WHERE 1 = 1 AND A.STATUS != 'X' ";
        if ($tipo != ""){
            $sql .= "AND A.TIPO = :TIPO ";
        }
        if ($idPaciente != ""){
            $sql .= "AND B.CODIGO = :IDPACIENTE ";
        }
        if ($status != ""){
            $sql .= "AND A.STATUS = :STATUS ";
        }
        if ($dataInicio != ""){
            $sql .= "AND A.DT_SOLIC >= TO_DATE(:DATAINI, 'DD/MM/YYYY HH24:MI:SS') ";
        }
        if ($dataFim != ""){
            $sql .= "AND A.DT_SOLIC <= TO_DATE(:DATAFIM, 'DD/MM/YYYY HH24:MI:SS') ";
        }
        $sql .= "ORDER BY A.ID";

        $qry = $this->conn->prepare($sql);
        if ($tipo != ""){
            $qry->bindValue(":TIPO", $tipo);
        }
        if ($idPaciente != ""){
            $qry->bindValue(":IDPACIENTE", $idPaciente);
        }
        if ($status != ""){
            $qry->bindValue(":STATUS", $status);
        }
        if ($dataInicio != ""){
            $qry->bindValue(":DATAINI", $dataInicio . " 00:00:00");
        }
        if ($dataFim != ""){
            $qry->bindValue(":DATAFIM", $dataFim . " 23:59:59");
        }

        $qry->execute();
        $res = $qry->fetchAll(PDO::FETCH_ASSOC);
        return $res;

    }

    public function validaDadosNotaFiscal(NotaFiscalModel $nf){

        if ($this->existeRegistro($nf->getCodigo())){
            $this->alterarNotaFiscal($nf);
        } else {
            $this->incluirNotaFiscal($nf);
        }

    }

    private function existeRegistro($codigo){
        $qry = $this->buscarNotaFiscalPorId($codigo);
        return count($qry) > 0;
    }

    private function incluirNotaFiscal(NotaFiscalModel $nf){

        $sql  = "INSERT INTO SR_SOLICNOTA (ID, IDUSU_SOLIC, DT_SOLIC, IDPARTCONV, OBS_SOLIC, STATUS, TIPO, VALOR) ";
        $sql .= "VALUES (:P1, :P2, TO_DATE(:P3,'DD/MM/YYYY HH24:MI:SS'), :P4, :P5, :P6, :P7, :P8)";
        
        //echo $sql  . ": Código " . $nf->getCodigo() . "<br>Usuario: " . $nf->getUsuarioSolic() . "<br>Data Solicitação: " . $nf->getDataSolic() . "<br>IdPartConv: " . $nf->getIdPartConv() . "<br>Observação: " . $nf->getObsSolic() . 
        //"<br>Tipo: " . $nf->getTipo() . "<br>Valor: " . $nf->getValor(); exit();
        
        $qry = $this->conn->prepare($sql);
        $qry->bindValue(":P1", $nf->getCodigo());
        $qry->bindValue(":P2", $nf->getUsuarioSolic());
        $qry->bindValue(":P3", $nf->getDataSolic());
        $qry->bindValue(":P4", $nf->getIdPartConv());
        $qry->bindValue(":P5", $nf->getObsSolic());
        $qry->bindValue(":P6", 'A');
        $qry->bindValue(":P7", $nf->getTipo());
        $qry->bindValue(":P8", $nf->getValor());
        $qry->execute();

    }

    private function alterarNotaFiscal(NotaFiscalModel $nf){

        $sql = "UPDATE SR_SOLICNOTA SET IDPARTCONV = :P1, OBS_SOLIC = :P2 WHERE ID = :P3";
        $qry = $this->conn->prepare($sql);
        $qry->bindValue(":P1", $nf->getIdPartConv());
        $qry->bindValue(":P2", $nf->getObsSolic());
        $qry->bindValue(":P3", $nf->getCodigo());
        $qry->execute();

    }

    public function buscarNotaFiscalPorId($codigo){

        $sql = "SELECT 
                A.*, E.NOME AS NMSOLICITANTE, TO_CHAR(DT_SOLIC, 'DD/MM/YYYY HH24:MI:SS') AS DATA_SOLICITACAO, 
                B.NOME AS NMPACCONV  
                FROM 
                SR_SOLICNOTA A 
                INNER JOIN SR_USUARIO E ON E.IDUSUARIO = A.IDUSU_SOLIC 
                INNER JOIN VW_LISTA_PART_CONVENIO_GERAL B ON B.CODIGO = A.IDPARTCONV
                WHERE 
                A.ID = :ID";
        //echo $sql . " - Código: " . $codigo; exit(); 
        $qry = $this->conn->prepare($sql);
        $qry->bindValue(":ID", $codigo);
        $qry->execute();
        $res = $qry->fetchAll(PDO::FETCH_ASSOC);
        return $res;

    }

    public function excluir($id, $idUsuario, $observacao){

        $data = date("d/m/Y H:i:s");
        $sql = "UPDATE 
                    SR_SOLICNOTA 
                SET 
                    STATUS = 'X', 
                    MOTEXC = :MOTIVO, 
                    DTEXC = TO_DATE('" . $data . "','dd/mm/yyyy hh24:mi:ss'), 
                    IDUSUARIOEXC = :IDUSUARIO 
                WHERE 
                    ID = :ID";
        $qry = $this->conn->prepare($sql);
        $qry->bindValue(":MOTIVO", $observacao);
        $qry->bindValue(":IDUSUARIO", $idUsuario);
        $qry->bindValue(":ID", $id);
        $qry->execute();

    }

}