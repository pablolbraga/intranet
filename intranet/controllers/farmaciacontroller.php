<?php
require_once("../conexao/conexao.php");
require_once('../models/farmaciamodel.php');

class FarmaciaController{

    private $conn;

    public function __construct(){
        $this->conn = Conexao::getInstance();
    }

    public function incluir(FarmaciaModel $c){

        try{
            $sql = "INSERT INTO SR_SOLICITACAO_FARMACIA (
                        ID, IDUSU_SOLIC, IDENFER_SOLIC, IDADMISSION, DTSOLIC, 
                        DTMAX, EXTRA, JUSTIFICATIVA, OBSERVACAO, STATUS
                    ) VALUES (
                        :ID, :IDUSU_SOLIC, :IDENFER_SOLIC, :IDADMISSION, TO_DATE(:DTSOLIC, 'DD/MM/YYYY HH24:MI:SS'), 
                        TO_DATE(:DTMAX, 'DD/MM/YYYY HH24:MI:SS'), :EXTRA, :JUSTIFICATIVA, :OBSERVACAO, :STATUS
                    )";
            $qry = $this->conn->prepare($sql);
            $qry->bindValue(":ID", $c->getId());
            $qry->bindValue(":IDUSU_SOLIC", $c->getIdusu_solic());
            $qry->bindValue(":IDENFER_SOLIC", $c->getIdenfer_solic());
            $qry->bindValue(":IDADMISSION", $c->getIdadmission());
            $qry->bindValue(":DTSOLIC", $c->getDtsolic());
            $qry->bindValue(":DTMAX", $c->getDtmax());
            $qry->bindValue(":EXTRA", $c->getExtra());
            $qry->bindValue(":JUSTIFICATIVA", $c->getJustificativa());
            $qry->bindValue(":OBSERVACAO", $c->getObservacao());
            $qry->bindValue(":STATUS", "S");
            $qry->execute();
        } catch(Exception $e){
            echo "Erro ao incluir a solicitação de farmácia. Erro: " . $e->getMessage();
            exit();
        }

    }

}