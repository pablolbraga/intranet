<?php
require_once("../conexao/conexao.php");

class PendenciasController{

    private $conn;

    public function __construct(){
        $this->conn = Conexao::getInstance();
    }

    public function listarPendenciaPorIdUsuario($idUsuario){

        $sql = "SELECT * FROM SR_USUARIO_TIPOPENDENCIA WHERE IDUSUARIO = :IDUSUARIO ORDER BY IDTIPOPENDENCIA";
        $qry = $this->conn->prepare($sql);
        $qry->bindValue(":IDUSUARIO", $idUsuario);
        $qry->execute();
        $res = $qry->fetchAll(PDO::FETCH_ASSOC);
        return $res;

    }

    public function listarPendenciaPorIdPendenciaEIdUsuario($idPendencia, $idUsuario){

        $sql = "SELECT * FROM SR_USUARIO_TIPOPENDENCIA 
        WHERE IDUSUARIO = :IDUSUARIO AND IDTIPOPENDENCIA = :IDPENDENCIA 
        ORDER BY IDTIPOPENDENCIA";
        $qry = $this->conn->prepare($sql);
        $qry->bindValue(":IDUSUARIO", $idUsuario);
        $qry->bindValue(":IDPENDENCIA", $idPendencia);
        $qry->execute();
        $res = $qry->fetchAll(PDO::FETCH_ASSOC);
        return $res;

    }

}