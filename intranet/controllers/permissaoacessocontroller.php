<?php
require_once("../conexao/conexao.php");

class PermissaoAcessoController{
    
    private $conn;

    public function __construct()
    {
        $this->conn = Conexao::getInstance();
    }

    public function clonarPermissaoTelas($idUsuarioDe, $idUsuarioPara){

        // Exclui as permissões de telas para o usuário que está solicitando clonagem
        $sqlDelPermissaoTelaPara = "DELETE FROM SR_PERMISSAO_TELA WHERE IDUSUARIO = :IDUSUARIO";
        $qryDelPermissaoTelaPara = $this->conn->prepare($sqlDelPermissaoTelaPara);
        $qryDelPermissaoTelaPara->bindValue(":IDUSUARIO", $idUsuarioPara);
        $qryDelPermissaoTelaPara->execute();

        // Lista as permissões de telas do usuário clonado
        $sqlPermissaoTelaDe = "SELECT * FROM SR_PERMISSAO_TELA WHERE IDUSUARIO  = :IDUSUARIO";
        $qryPermissaoTelaDe = $this->conn->prepare($sqlPermissaoTelaDe);
        $qryPermissaoTelaDe->bindValue(":IDUSUARIO", $idUsuarioDe);
        $qryPermissaoTelaDe->execute();
        $resPermissaoTelaDe = $qryPermissaoTelaDe->fetchAll(PDO::FETCH_ASSOC);
        $qtdPermissaoTelaDe = count($resPermissaoTelaDe);
        for ($i = 0; $i < $qtdPermissaoTelaDe; $i++){

            // Realiza a cópia das permissões de telas do usuário clonado.
            $sqlInsPermissaoTelaPara = "INSERT INTO SR_PERMISSAO_TELA (IDUSUARIO, IDTELA) VALUES (:IDUSUARIO, :IDTELA)";
            $qryInsPermissaoTelaPara = $this->conn->prepare($sqlInsPermissaoTelaPara);
            $qryInsPermissaoTelaPara->bindValue(":IDUSUARIO", $idUsuarioPara);
            $qryInsPermissaoTelaPara->bindValue(":IDTELA", $resPermissaoTelaDe[$i]["IDTELA"]);
            $qryInsPermissaoTelaPara->execute();

        }

        // Permissão de Pendencias
        // Exclui as permissões de pendencias para o usuário que está solicitando clonagem
        $sqlDelPermissaoPendenciaPara = "DELETE FROM SR_USUARIO_TIPOPENDENCIA WHERE IDUSUARIO = :IDUSUARIO";
        $qryDelPermissaoPendenciaPara = $this->conn->prepare($sqlDelPermissaoPendenciaPara);
        $qryDelPermissaoPendenciaPara->bindValue(":IDUSUARIO", $idUsuarioPara);
        $qryDelPermissaoPendenciaPara->execute();

        // Lista as permissões de pendencias do usuário clonado
        $sqlPermissaoPendenciaDe = "SELECT * FROM SR_USUARIO_TIPOPENDENCIA WHERE IDUSUARIO  = :IDUSUARIO";
        $qryPermissaoPendenciaDe = $this->conn->prepare($sqlPermissaoPendenciaDe);
        $qryPermissaoPendenciaDe->bindValue(":IDUSUARIO", $idUsuarioDe);
        $resPermissaoPendenciaDe = $qryPermissaoPendenciaDe->fetchAll(PDO::FETCH_ASSOC);
        $qtdPermissaoPendenciaDe = count($resPermissaoPendenciaDe);
        for ($j = 0; $j < $qtdPermissaoPendenciaDe; $j++){

            // Realiza a cópia das permissões de pendencias do usuário clonado.
            $sqlInsPermissaoPendenciaPara = "INSERT INTO SR_USUARIO_TIPOPENDENCIA (IDUSUARIO, IDTIPOPENDENCIA) VALUES (:IDUSUARIO, :IDTIPOPENDENCIA)";
            $qryInsPermissaoPendenciaPara = $this->conn->prepare($sqlInsPermissaoPendenciaPara);
            $qryInsPermissaoPendenciaPara->bindValue(":IDUSUARIO", $idUsuarioPara);
            $qryInsPermissaoPendenciaPara->bindValue(":IDTIPOPENDENCIA", $resPermissaoPendenciaDe[$j]["IDTIPOPENDENCIA"]);
            $qryInsPermissaoPendenciaPara->execute();

        }

    }
}