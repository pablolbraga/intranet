<?php
require_once("../conexao/conexao.php");
require_once("../models/caixamovimentacaomodel.php");

class CaixaMovimentacaoController{

    private $conn;

    public function __construct()
    {
        $this->conn = Conexao::getInstance();
    }

    public function incluir(CaixaMovimentacaoModel $c){

        $sql = "INSERT INTO SR_CAIXA_MOVIMENTACAO (
                    IDUSUARIO, IDCAIXA, TIPO, VALOR, DESCRICAO, 
                    STATUS, DATA
                ) VALUES (
                    :IDUSUARIO, :IDCAIXA, :TIPO, :VALOR, :DESCRICAO, 
                    :STATUS, TO_DATE(:DATA, 'DD/MM/YYYY HH24:MI:SS')
                )";
        $qry = $this->conn->prepare($sql);
        $qry->bindValue(":IDUSUARIO", $c->getUsuario());
        $qry->bindValue(":IDCAIXA", $c->getCaixa());
        $qry->bindValue(":TIPO", $c->getTipo());
        $qry->bindValue(":VALOR", $c->getValor());
        $qry->bindValue(":DESCRICAO", $c->getDescricao());
        $qry->bindValue(":STATUS", "A");
        $qry->bindValue(":DATA", $c->getData());
        $qry->execute();

    }

}