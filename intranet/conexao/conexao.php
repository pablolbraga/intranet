<?php

date_default_timezone_set("America/Sao_Paulo");

class Conexao{

    private static $pdo;

    private function __construct(){

    }

    public static function getInstance(){

        if (!isset(self::$pdo)){
            try{
                self::$pdo = $pdo = new PDO("oci:dbname=192.168.0.3:1521/SRID;charset=AL32UTF8","dbIwSaudeResid", "x", array(PDO::ATTR_PERSISTENT => true));
            } catch(PDOException $e){
                echo "Não foi possível conectar com o banco de dados. Erro: " . $e->getMessage();
            }
        }
        return self::$pdo;

    }
}