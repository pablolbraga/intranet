<?php
require_once("../conexao/conexao.php");

class EmailsController{

    private $conn;

    public function __construct()
    {
        $this->conn = Conexao::getInstance();
    }

    public function listarEmailsPorTipoPendencia($idTipoPendencia){

        $sql = "
        SELECT 
        A.*, 
        B.EMAIL 
        FROM 
        SR_USUARIO_TIPOPENDENCIA A
        INNER JOIN SR_USUARIO B ON B.IDUSUARIO = A.IDUSUARIO AND B.STATUS = 'A' 
        WHERE 
        A.IDTIPOPENDENCIA = :IDTIPOPENDENCIA
        ";
        $qry = $this->conn->prepare($sql);
        $qry->bindValue(":IDTIPOPENDENCIA", $idTipoPendencia);
        $qry->execute();
        $res = $qry->fetchAll(PDO::FETCH_ASSOC);
        return $res;

    }

}