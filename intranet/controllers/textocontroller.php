<?php

class TextoController{
    
    private $conn;

    public function __construct(){
        $this->conn = Conexao::getInstance();
    }

    public function retornarTextoLongoIw($idTexto){

        $sql = "SELECT TXT.TEXT AS OBS FROM GLBTEXT TXT WHERE TXT.ID = :ID";
        $qry = $this->conn->prepare($sql);
        $qry->bindValue(":ID", $idTexto);
        $qry->execute();
        $res = $qry->fetchAll(PDO::FETCH_ASSOC);

        if (count($res) > 0){
            return $res[0]["OBS"];
        } else {
            return "";
        }

    }
}