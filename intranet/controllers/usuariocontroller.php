<?php
require_once("../conexao/conexao.php");
require_once("../models/usuariomodel.php");
require_once("../helpers/criptografia.php");

class UsuarioController{

    private $conn;
    private $cripto;

    public function __construct(){
        $this->conn = Conexao::getInstance();
        $this->cripto = new Criptografia();
    }

    public function validaLoginSenha($login, $senha){

        $sql = "SELECT USU.*, SEC.NAME AS NMSECUSER FROM 
        SR_USUARIO USU 
        INNER JOIN GLBPERSON PF ON PF.ID = USU.IDPERSON 
        INNER JOIN SECUSER SEC ON PF.IDUSER = SEC.NAME 
        WHERE USU.STATUS = 'A' AND LOGIN = :LOGIN AND SENHA = :SENHA";
        $qry = $this->conn->prepare($sql);
        $qry->bindValue(":LOGIN", $login);
        $qry->bindValue(":SENHA", $this->cripto->criptografarBase64($senha));
        $qry->execute();
        $res = $qry->fetchAll(PDO::FETCH_ASSOC);
        return $res;

    }

    public function alterarSenha($idusuario, $senha){

        $sql = "UPDATE SR_USUARIO SET NOVO = 'N', SENHA = :SENHA WHERE IDUSUARIO = :IDUSUARIO";
        $qry = $this->conn->prepare($sql);
        $qry->bindValue(":SENHA", $this->cripto->criptografarBase64($senha));
        $qry->bindValue(":IDUSUARIO", $idusuario);
        $qry->execute();

    }

    public function buscarPorId($idusuario){

        $sql = "SELECT * FROM SR_USUARIO WHERE IDUSUARIO = :IDUSUARIO";
        $qry = $this->conn->prepare($sql);
        $qry->bindValue(":IDUSUARIO", $idusuario);
        $qry->execute();
        $res = $qry->fetchAll(PDO::FETCH_ASSOC);
        return $res;

    }

    public function listarUsuarios($nome){

        $sql = "SELECT USU.*, PF.NAME AS NMUSUARIOIW, UGB.ID AS IDUGB  
        FROM SR_USUARIO USU 
        INNER JOIN GLBPERSON PF ON PF.ID = USU.IDPERSON 
        INNER JOIN SR_UGB UGB ON UGB.NOME = USU.UGB
        WHERE USU.STATUS = 'A' ";
        if ($nome != ""){
            $sql .= "AND (UPPER(USU.LOGIN) LIKE :NOME OR UPPER(USU.NOME) LIKE :NOME) ";
        }
        $sql .= "ORDER BY USU.NOME";
        $qry = $this->conn->prepare($sql);
        if ($nome != ""){
            $qry->bindValue(":NOME", "%" . strtoupper($nome) . "%");
        }
        $qry->execute();
        $res = $qry->fetchAll(PDO::FETCH_ASSOC);
        return $res;

    }

    public function listarUsuariosTerapia($nome){

        $sql = "SELECT USU.*, PF.NAME AS NMUSUARIOIW, UGB.ID AS IDUGB  
        FROM SR_USUARIO USU 
        INNER JOIN GLBPROFESSIONAL PROF ON PROF.IDPERSON = USU.IDPERSON AND PROF.SCSPECIALITY IN (122646, 122647, 123931, 122633, 123932, 334849, 335485) 
        INNER JOIN GLBPERSON PF ON PF.ID = PROF.IDPERSON 
        INNER JOIN SR_UGB UGB ON UGB.NOME = USU.UGB
        WHERE USU.STATUS = 'A' ";
        if ($nome != ""){
            $sql .= "AND (UPPER(USU.LOGIN) LIKE :NOME OR UPPER(USU.NOME) LIKE :NOME) ";
        }
        $sql .= "ORDER BY USU.NOME";
        $qry = $this->conn->prepare($sql);
        if ($nome != ""){
            $qry->bindValue(":NOME", "%" . strtoupper($nome) . "%");
        }
        $qry->execute();
        $res = $qry->fetchAll(PDO::FETCH_ASSOC);
        return $res;

    }

    public function existeLoginCadastrado($idUsuario, $login){

        $sql = "SELECT * FROM SR_USUARIO WHERE LOGIN = :LOGIN AND NOT IDUSUARIO IN (:IDUSUARIO)";
        $qry = $this->conn->prepare($sql);
        $qry->bindValue(":LOGIN", $login);
        $qry->bindValue(":IDUSUARIO", $idUsuario);
        $qry->execute();
        $res = $qry->fetchAll(PDO::FETCH_ASSOC);
        return count($res) > 0;

    }

    public function validaDados(UsuarioModel $usu){

        if ($usu->getCodigo() == "0"){
            $this->incluir($usu);
        } else {
            $this->alterar($usu);
        }

    }

    private function incluir(UsuarioModel $usu){

        $sql = "INSERT INTO SR_USUARIO (";
        $sql .= "NOME, LOGIN, SENHA, ADM, STATUS, ";
        $sql .= "DTCAD, EMAIL, IDPERSON, TIPOCAIXA, OS, ";
        $sql .= "ADM_OS, BAIXASOLMOT, NOVO, UGB, DTSENHA, ";
        $sql .= "EXTERNO, PLANTONISTA, MOBILE, PROFEXT, MODOENFA, ";
        $sql .= "REALIZATREINAMENTO, SOMENTETERAPIA ";
        $sql .= ") VALUES (";
        $sql .= ":NOME, :LOGIN, :SENHA, :ADM, 'A', ";
        $sql .= "TO_DATE(TO_CHAR(SYSDATE, 'DD/MM/YYYY HH24:MI:SS'), 'DD/MM/YYYY HH24:MI:SS'), :EMAIL, :IDPERSON, :TIPOCAIXA, :OS, ";
        $sql .= ":ADM_OS, :BAIXASOLMOT, 'S', :UGB, TO_DATE(TO_CHAR(SYSDATE, 'DD/MM/YYYY HH24:MI:SS'), 'DD/MM/YYYY HH24:MI:SS'), ";
        $sql .= ":EXTERNO, :PLANTONISTA, :MOBILE, :PROFEXT, :MODOENFA, ";
        $sql .= ":REALIZATREINAMENTO, :SOMENTETERAPIA ";
        $sql .= ")";
        $qry = $this->conn->prepare($sql);
        $qry->bindValue(":NOME", $usu->getNome());
        $qry->bindValue(":LOGIN", $usu->getLogin());
        $qry->bindValue(":SENHA", $usu->getSenha());
        $qry->bindValue(":ADM", $usu->getAdmin());
        $qry->bindValue(":EMAIL", $usu->getEmail());
        $qry->bindValue(":IDPERSON", $usu->getIdPerson());
        $qry->bindValue(":TIPOCAIXA", $usu->getTipoCaixa());
        $qry->bindValue(":OS", $usu->getOs());
        $qry->bindValue(":ADM_OS", $usu->getAdmOs());
        $qry->bindValue(":BAIXASOLMOT", $usu->getBaixaMotorista());
        $qry->bindValue(":UGB", $usu->getUgb());
        $qry->bindValue(":EXTERNO", $usu->getAcessoExterno());
        $qry->bindValue(":PLANTONISTA", $usu->getPlantonista());
        $qry->bindValue(":MOBILE", $usu->getModoMobile());
        $qry->bindValue(":PROFEXT", $usu->getProfExt());
        $qry->bindValue(":MODOENFA", $usu->getModEnf());
        $qry->bindValue(":REALIZATREINAMENTO", $usu->getTreinamentoEdContinuada());
        $qry->bindValue(":SOMENTETERAPIA", $usu->getSomenteTerapia());
        $qry->execute();       

    }

    private function alterar(UsuarioModel $usu){

        $sql = "UPDATE SR_USUARIO SET ";
        $sql .= "NOME = :NOME, LOGIN = :LOGIN, ADM = :ADM, ";
        $sql .= "EMAIL = :EMAIL, IDPERSON = :IDPERSON, TIPOCAIXA = :TIPOCAIXA, OS = :OS, ";
        $sql .= "ADM_OS = :ADM_OS, BAIXASOLMOT = :BAIXASOLMOT, UGB = :UGB, ";
        $sql .= "EXTERNO = :EXTERNO, PLANTONISTA = :PLANTONISTA, MOBILE = :MOBILE, PROFEXT = :PROFEXT, MODOENFA = :MODOENFA, ";
        $sql .= "REALIZATREINAMENTO = :REALIZATREINAMENTO, SOMENTETERAPIA = :SOMENTETERAPIA ";
        $sql .= "WHERE IDUSUARIO = :IDUSUARIO";
        $qry = $this->conn->prepare($sql);
        $qry->bindValue(":NOME", $usu->getNome());
        $qry->bindValue(":LOGIN", $usu->getLogin());
        $qry->bindValue(":ADM", $usu->getAdmin());
        $qry->bindValue(":EMAIL", $usu->getEmail());
        $qry->bindValue(":IDPERSON", $usu->getIdPerson());
        $qry->bindValue(":TIPOCAIXA", $usu->getTipoCaixa());
        $qry->bindValue(":OS", $usu->getOs());
        $qry->bindValue(":ADM_OS", $usu->getAdmOs());
        $qry->bindValue(":BAIXASOLMOT", $usu->getBaixaMotorista());
        $qry->bindValue(":UGB", $usu->getUgb());
        $qry->bindValue(":EXTERNO", $usu->getAcessoExterno());
        $qry->bindValue(":PLANTONISTA", $usu->getPlantonista());
        $qry->bindValue(":MOBILE", $usu->getModoMobile());
        $qry->bindValue(":PROFEXT", $usu->getProfExt());
        $qry->bindValue(":MODOENFA", $usu->getModEnf());
        $qry->bindValue(":REALIZATREINAMENTO", $usu->getTreinamentoEdContinuada());
        $qry->bindValue(":SOMENTETERAPIA", $usu->getSomenteTerapia());
        $qry->bindValue(":IDUSUARIO", $usu->getCodigo());
        $qry->execute();        

    }

    public function excluir($idUsuario){

        $sql = "UPDATE SR_USUARIO SET STATUS = 'I', 
        DTEXC = TO_DATE(TO_CHAR(SYSDATE, 'DD/MM/YYYY HH24:MI:SS'), 'DD/MM/YYYY HH24:MI:SS') 
        WHERE IDUSUARIO = :IDUSUARIO";
        $qry = $this->conn->prepare($sql);
        $qry->bindValue(":IDUSUARIO", $idUsuario);
        $qry->execute();  

    }

}