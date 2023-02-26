<?php
require_once("../conexao/conexao.php");
require_once("../helpers/criptografia.php");

class UsuarioController{

    private $conn;
    private $cripto;

    public function __construct(){
        $this->conn = Conexao::getInstance();
        $this->cripto = new Criptografia();
    }

    public function validaLoginSenha($login, $senha){

        $sql = "SELECT * FROM SR_USUARIO USU WHERE USU.STATUS = 'A' AND LOGIN = :LOGIN AND SENHA = :SENHA";
        $qry = $this->conn->prepare($sql);
        $qry->bindValue(":LOGIN", $login);
        $qry->bindValue(":SENHA", $this->cripto->criptografarBase64($senha));
        $qry->execute();
        $res = $qry->fetchAll(PDO::FETCH_ASSOC);
        return $res;

    }

    public function alterarSenha($idusuario, $senha){

        $sql = "UPDATE SR_USUARIO SET NOVO = 'N', SENHA = :SENHA WHERE IDUSUARIO = :IDUSUARIO";
        $qry = $this->conn->prepare($sql);
        $qry->bindValue(":SENHA", $this->cripto->criptografarBase64($senha));
        $qry->bindValue(":IDUSUARIO", $idusuario);
        $qry->execute();

    }

}