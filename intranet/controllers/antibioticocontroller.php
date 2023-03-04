<?php
require_once("../conexao/conexao.php");
require_once("../models/antibioticomodel.php");

class AntibioticoController{

    private $conn;

    public function __construct()
    {
        $this->conn = Conexao::getInstance();
    }

    public function incluir(AntibioticoModel $c){

        $sql = "INSERT INTO SR_ATENDIMENTO_ANTIBIOTICO (
                    IDADMISSION, ANTIMICROBIANO, DTSOLICITACAO, DOSE, INTERVALO, 
                    VIA, DIAS, MOTIVO, FINALIZADO, IDUSUARIO, 
                    DILUICAO
                ) VALUES (
                    :IDADMISSION, :ANTIMICROBIANO, TO_DATE(:DTSOLICITACAO,'DD/MM/YYYY HH24:MI:SS'), :DOSE, :INTERVALO, 
                    :VIA, :DIAS, :MOTIVO, :FINALIZADO, :IDUSUARIO, 
                    :DILUICAO
                )";
        $qry = $this->conn->prepare($sql);
        $qry->bindValue(":IDADMISSION", $c->getIdadmission());
        $qry->bindValue(":ANTIMICROBIANO", $c->getAntimicrobiano());
        $qry->bindValue(":DTSOLICITACAO", date("d/m/Y H:i:s"));
        $qry->bindValue(":DOSE", $c->getDose());
        $qry->bindValue(":INTERVALO", $c->getIntervalo());
        $qry->bindValue(":VIA", $c->getVia());
        $qry->bindValue(":DIAS", $c->getDias());
        $qry->bindValue(":MOTIVO", $c->getMotivo());
        $qry->bindValue(":FINALIZADO", "N");
        $qry->bindValue(":IDUSUARIO", $c->getIdusuario());
        $qry->bindValue(":DILUICAO", $c->getDiluicao());
        $qry->execute();

    }

}