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

    public function retornarDadosProfissional($idprofessional){

        $sql = "SELECT 
                    PROF.*, PF.NAME AS NMPROFESSIONAL 
                FROM 
                    GLBPROFESSIONAL PROF 
                    INNER JOIN GLBPERSON PF ON PF.ID = PROF.IDPERSON 
                WHERE 
                    PROF.IDPERSON = :ID";
        $qry = $this->conn->prepare($sql);
        $qry->bindValue(":ID", $idprofessional);
        $qry->execute();
        $res = $qry->fetchAll(PDO::FETCH_ASSOC);
        return $res;

    }

}