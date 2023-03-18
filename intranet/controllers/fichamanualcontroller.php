<?php
require_once("../conexao/conexao.php");

class FichaManualController{

    private $conn;

    public function __construct()
    {
        $this->conn = Conexao::getInstance();
    }

    public function inserirFicha($idtemplate, $idadmission, $idevolucao, $dataCad, $idprofessional, $idespecialidade, $textoBase, $imagem){

        $sql = "";
        $incluirProfEsp = "N";
        switch($idtemplate){
            case 98  :  $sql = "INSERT INTO 
                                TDACENFA 
                                (IDREFERENCE, EVENTDATE, IDEVOLUTION, INTERNACAO, OBSERVACOES, ACOMPANHANTE, OFF_LINE, IMAGEM) 
                                VALUES 
                                (:IDADM, TO_DATE(:DTCAD, 'DD/MM/YYYY HH24:MI:SS'), :IDEVOL, 1, :TEXTOBASE, :TEXTOBASE, 'S', :IMAGEM)";
                        break;
            case 101 :  $sql = "INSERT INTO 
                                TDACAUX 
                                (IDREFERENCE, EVENTDATE, IDEVOLUTION, MEDICAMENTOS, EVOLUCAO, IMAGEM) 
                                VALUES 
                                (:IDADM, TO_DATE(:DTCAD, 'DD/MM/YYYY HH24:MI:SS'), :IDEVOL, :TEXTOBASE, :TEXTOBASE, :IMAGEM)";
                        break;
            case 107 :  $sql = "INSERT INTO 
                                TDACMEDICO 
                                (IDREFERENCE, EVENTDATE, IDEVOLUTION, PROBLEMAS, CONDUTAS, SITCLINICA, EXFISICO, PARTERIAL, HD, NOME_ACOMPANHANTE, JUST_ATEND_DOMIC, IMAGEM) 
                                VALUES 
                                (:IDADM, TO_DATE(:DTCAD, 'DD/MM/YYYY HH24:MI:SS'), :IDEVOL, :TEXTOBASE, :TEXTOBASE, :TEXTOBASE, :TEXTOBASE, :TEXTOBASE, :TEXTOBASE, :TEXTOBASE, :TEXTOBASE, :IMAGEM)";
                        break;
            case 108 :  {
                        $incluirProfEsp = "S";
                        $sql = "INSERT INTO 
                                TDACESPECIALIDADE 
                                (IDREFERENCE, EVENTDATE, IDEVOLUTION, SCSPECIALITY, IDPROFESSIONAL, OBSERVACAO, OFF_LINE, IMAGEM) 
                                VALUES 
                                (:IDADM, TO_DATE(:DTCAD, 'DD/MM/YYYY HH24:MI:SS'), :IDEVOL, :IDESP, :IDPROF, :TEXTOBASE, 'S', :IMAGEM)";
                        break;
                        }
            case 109 :  $sql = "INSERT INTO 
                                TDACNUTRICAO 
                                (IDREFERENCE, EVENTDATE, IDEVOLUTION, ACOMPANHANTE, CONDUTA, OFF_LINE, IMAGEM) 
                                VALUES 
                                (:IDADM, TO_DATE(:DTCAD, 'DD/MM/YYYY HH24:MI:SS'), :IDEVOL, :TEXTOBASE, :TEXTOBASE, 'S', :IMAGEM)";
                        break;
            case 110 :  {
                        $incluirProfEsp = "S";
                        $sql = "INSERT INTO 
                                TDACPSICOLOGIA  
                                (IDREFERENCE, EVENTDATE, IDEVOLUTION, SCSPECIALITY, IDPROFESSIONAL, ACOMPANHANTE, SINTOMAS, OFF_LINE, IMAGEM) 
                                VALUES 
                                (:IDADM, TO_DATE(:DTCAD, 'DD/MM/YYYY HH24:MI:SS'), :IDEVOL, :IDESP, :IDPROF, :TEXTOBASE, :TEXTOBASE, 'S', :IMAGEM)";
                        break;
                        }
            case 111 :  $sql = "INSERT INTO 
                                TDACMEDICO_TELE 
                                (IDREFERENCE, EVENTDATE, IDEVOLUTION, ACOMPANHANTE, TECNOLOGIA, QUEIXAPRINCIPAL, HISTORICODOEATUAL, MEDICAMENTOS, EXAMES, DIAGNOSTICO, DECISAOCLINICA, EXAMESSOLICITADOS, IMAGEM) 
                                VALUES 
                                (:IDADM, TO_DATE(:DTCAD, 'DD/MM/YYYY HH24:MI:SS'), :IDEVOL, :TEXTOBASE, :TEXTOBASE, :TEXTOBASE, :TEXTOBASE, :TEXTOBASE, :TEXTOBASE, :TEXTOBASE, :TEXTOBASE, :TEXTOBASE, :IMAGEM)";
                        break;
            $qry = $this->conn->prepare($sql);
            $qry->bindValue(":IDADM", $idadmission);
            $qry->bindValue(":DTCAD", $dataCad);
            $qry->bindValue(":IDEVOL", $idevolucao);
            $qry->bindValue(":TEXTOBASE", $textoBase);
            $qry->bindValue(":IMAGEM", $imagem);
            if ($incluirProfEsp == "S"){
                $qry->bindValue(":IDESP", $idespecialidade);
                $qry->bindValue(":IDPROF", $idprofessional);
            }
            $qry->execute();
        }

    }

    public function atualizarVisitasProg($idadmission, $idprofagenda){

        $sql = "UPDATE 
                    SR_PROG_VISITASPROG 
                SET 
                    CANCELADO = 'N', 
                    MOTIVOCANC = 'REALIZADA MANUALMENTE', 
                    DATACANC = TO_DATE('" . date("d/m/Y H:i:s") . "','DD/MM/YYYY HH24:MI:SS'), 
                    JUSTIFICATIVA = 'REALIZADA MANUALMENTE' 
                WHERE 
                    IDADMISSION = " . $idadmission . " AND IDPROFAGENDA = " . $idprofagenda;
        $qry = $this->conn->prepare($sql);
        $qry->execute();
    }

    public function substituirFichaImagem($idtemplate, $idficha, $imagem){

        $tabela = "";
        switch($idtemplate){
            case 98  :  $tabela = "TDACENFA";
                        break;
            case 101 :  $tabela = "TDACAUX";
                        break;
            case 107 :  $tabela = "TDACMEDICO";            
                        break;
            case 108 :  $tabela = "TDACESPECIALIDADE"; 
                        break;
            case 109 :  $tabela = "TDACNUTRICAO";
                        break;
            case 110 :  $tabela = "TDACPSICOLOGIA";
                        break;
            case 111 :  $tabela = "TDACMEDICO_TELE";
                        break;
            $sql = "UPDATE " . $tabela . " SET IMAGEM = :IMAGEM WHERE ID = :ID";

            $qry = $this->conn->prepare($sql);
            $qry->bindValue(":IMAGEM", $imagem);
            $qry->bindValue(":ID", $idficha);
            $qry->execute();
        }

    }

}