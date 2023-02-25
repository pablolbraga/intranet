<?php

date_default_timezone_set("America/Sao_Paulo");

class Conexao{

    public function abrirConexao(){

        try{
            $pdo = new PDO("oci:dbname=192.168.0.3:1521/SRID;charset=AL32UTF8","dbIwSaudeResid", "x");
            return $pdo;
        } catch(Exception $ex){
            echo "Não foi possível conectar com o banco de dados. Erro: " . $ex->getMessage();
        }
    }
}