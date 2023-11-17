<?php
require_once("../conexao/conexao.php");
require_once("../models/notafiscalmodel.php");

class NotaFiscalController{

    private $conn;

    public function __construct()
    {
        $this->conn = Conexao::getInstance();
    }

    private function incluir(NotaFiscalModel $c){

        $sql = "INSERT INTO SR_NOTASFISCAIS (
                    ID, TIPO, CLIENTE, SERVICO, VALOR, 
                    IRRF, ISS, CONFINS, PIS, CSLL, 
                    DATAEMISSAO, STATUS, IDUSUARIOCAD, DATACAD, LOG, 
                    NOTAFISCAL) VALUES (
                    :ID, :TIPO, :CLIENTE, :SERVICO, :VALOR, 
                    :IRRF, :ISS, :CONFINS, :PIS, :CSLL, 
                    TO_DATE(:DATAEMISSAO, 'DD/MM/YYYY HH24:MI:SS'), :STATUS, :IDUSUARIOCAD, 
                    TO_DATE(:DATACAD, 'DD/MM/YYYY HH24:MI:SS'), :LOG, 
                    )";
        $qry = $this->conn->prepare($sql);
        $qry->bindValue(":ID", date("YmdHis"));
        $qry->bindValue(":TIPO", $c->getTipo());
        $qry->bindValue(":CLIENTE", $c->getCliente());
        $qry->bindValue(":SERVICO", $c->getServico());
        $qry->bindValue(":VALOR", $c->getValor());
        $qry->bindValue(":IRRF", $c->getIrrf());
        $qry->bindValue(":ISS", $c->getIss());
        $qry->bindValue(":CONFINS", $c->getCofins());
        $qry->bindValue(":PIS", $c->getPis());
        $qry->bindValue(":CSLL", $c->getCsll());
        $qry->bindValue(":DATAEMISSAO", $c->getDataemissao() . " 00:00:00");
        $qry->bindValue(":STATUS", "A");
        $qry->bindValue(":IDUSUARIOCAD", $c->getUsuariocad());
        $qry->bindValue(":DATACAD", date("d/m/Y H:i:s"));
        $qry->bindValue(":LOG", $c->getLog());
        $qry->execute();

    }

    private function alterar(NotaFiscalModel $c){

        $sql = "UPDATE SR_NOTASFISCAIS SET 
                    TIPO = :TIPO, 
                    CLIENTE = :CLIENTE, 
                    SERVICO = :SERVICO, 
                    VALOR = :VALOR,                      
                    IRRF = :IRRF, 
                    ISS = :ISS, 
                    CONFINS = :CONFINS, 
                    PIS = :PIS, 
                    CSLL = :CSLL, 
                    DATAEMISSAO = TO_DATE(:DATAEMISSAO, 'DD/MM/YYYY HH24:MI:SS'), 
                    IDUSUARIOALT = :IDUSUARIOALT, 
                    DATAALT = :DATAALT, 
                    LOG = :LOG, 
                    NOTAFISCAL = :NOTAFISCAL 
                    WHERE ID = :ID";
        $qry = $this->conn->prepare($sql);
        $qry->bindValue(":ID", $c->getCodigo());
        $qry->bindValue(":TIPO", $c->getTipo());
        $qry->bindValue(":CLIENTE", $c->getCliente());
        $qry->bindValue(":SERVICO", $c->getServico());
        $qry->bindValue(":VALOR", $c->getValor());
        $qry->bindValue(":IRRF", $c->getIrrf());
        $qry->bindValue(":ISS", $c->getIss());
        $qry->bindValue(":CONFINS", $c->getCofins());
        $qry->bindValue(":PIS", $c->getPis());
        $qry->bindValue(":CSLL", $c->getCsll());
        $qry->bindValue(":DATAEMISSAO", $c->getDataemissao() . " 00:00:00");
        $qry->bindValue(":STATUS", "A");
        $qry->bindValue(":IDUSUARIOALT", $c->getUsuariocad());
        $qry->bindValue(":DATAALT", date("d/m/Y H:i:s"));
        $qry->bindValue(":LOG", $c->getLog());
        $qry->execute();

    }

    public function excluir($codigo, $motivo, $idUsuario){

        $sql = "UPDATE SR_NOTASFISCAIS SET 
                    STATUS = 'I', 
                    IDUSUARIOEXC = :IDUSUARIO, 
                    MOTEXC = :MOTIVO, 
                    DATAEXC = TO_DATE('" . date("d/m/Y H:i:s") . "','DD/MM/YYYY HH24:MI:SS') 
                WHERE 
                    ID = :ID";
        $qry = $this->conn->prepare($sql);
        $qry->bindValue(":IDUSUARIO", $idUsuario);
        $qry->bindValue(":MOTIVO", $motivo);
        $qry->bindValue(":ID", $codigo);
        $qry->execute();

    }

    public function validaDados(NotaFiscalModel $c){
        if ($c->getCodigo() != "0"){
            $this->alterar($c);
        } else {
            $this->incluir($c);
        }
    }

    public function listarNotasFiscais($cliente, $dataInicio, $dataFim, $tipo){

        $sql = "SELECT NF.*, (CASE NF.TIPO WHEN 'O' THEN 'OPERADORA' WHEN 'P' THEN 'PARTICULAR' WHEN 'F' THEN 'FORNECEDOR' WHEN 'C' THEN 'CLIENTE' ELSE 'NÃO IDENTIFICADO' END) AS NMTIPO, 
        TO_CHAR(NF.DATAEMISSAO, 'DD/MM/YYYY') AS DATAEMISSAOFORM  
        FROM SR_NOTASFISCAIS NF WHERE 1 = 1 ";
        if ($cliente != ""){
            $sql .= "AND UPPER(NF.CLIENTE) LIKE :CLIENTE ";
        }
        if ($dataInicio != ""){
            $sql .= "AND NF.DATAEMISSAO >= TO_DATE(:DATAINICIO, 'DD/MM/YYYY HH24:MI:SS')";
        }
        if ($dataFim != ""){
            $sql .= "AND NF.DATAEMISSAO <= TO_DATE(:DATAFIM,'DD/MM/YYYY HH24:MI:SS') ";
        }
        if ($tipo != ""){
            $sql .= "AND NF.TIPO = :TIPO ";
        }
        $sql .= "ORDER BY NF.DATAEMISSAO, NF.ID";
        $qry = $this->conn->prepare($sql);
        if ($cliente != ""){
            $qry->bindValue(":CLIENTE", "%" . strtoupper($cliente) . "%");
        }
        if ($dataInicio != ""){
            $qry->bindValue(":DATAINICIO", $dataInicio . " 00:00:00");
        }
        if ($dataFim != ""){
            $qry->bindValue(":DATAFIM", $dataFim . " 23:59:59");
        }
        if ($tipo != ""){
            $qry->bindValue(":TIPO", $tipo);
        }
        $qry->execute();
        $res = $qry->fetchAll(PDO::FETCH_ASSOC);
        return $res;

    }

}