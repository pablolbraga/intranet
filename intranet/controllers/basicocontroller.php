<?php
require_once("../conexao/conexao.php");

class BasicoController{

    private $conn;

    public function __construct(){
        $this->conn = Conexao::getInstance();
    }

    public function listarEmailsPorCategoria($categoria){

        $sql = "SELECT * FROM SR_CATEGORIAS_EMAIL WHERE TIPO = :TIPO ORDER BY CODIGO";
        $qry = $this->conn->prepare($sql);
        $qry->bindValue(":TIPO", $categoria);
        $qry->execute();
        $res = $qry->fetchAll(PDO::FETCH_ASSOC);
        return $res;

    }

}