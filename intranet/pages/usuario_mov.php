<?php
require_once '../controllers/usuariocontroller.php';
require_once '../models/usuariomodel.php';
require_once '../helpers/Criptografia.php';

$usuController = new UsuarioController();
$cripto = new Criptografia();

if ($_REQUEST["tipo"] == "N"){
    try{
        if ($usuController->existeLoginCadastrado($_POST["txtCodigo"], $_POST["txtLogin"])){
            echo "Já existe um usuário cadastrado com o login informado.";
            exit();
        } else {
            $usu = new UsuarioModel();
            $usu->setCodigo($_POST["txtCodigo"]);
            $usu->setNome($_POST["txtNome"]);
            $usu->setLogin($_POST["txtLogin"]);
            $usu->setSenha($cripto->criptografarBase64("sauderes@12"));
            $usu->setAdmin($_POST["cmbAministrador"]);
            $usu->setEmail($_POST["txtEmail"]);
            $usu->setIdPerson($_POST["txtCodUsuarioIw"]);
            $usu->setTipoCaixa($_POST["cmbCaixa"]);
            $usu->setOs($_POST["cmbRecebeOs"]);
            $usu->setAdmOs($_POST["cmbAdmOs"]);
            $usu->setBaixaMotorista($_POST["cmbBaixaMoto"]);
            $usu->setUgb($_POST["txtDescUgb"]);
            $usu->setAcessoExterno($_POST["cmbAcesso"]);
            $usu->setPlantonista($_POST["cmbPlantonista"]);
            $usu->setModoMobile($_POST["cmbMobile"]);
            $usu->setProfExt($_POST["cmbProfExt"]);
            $usu->setModEnf($_POST["cmbModEnf"]);
            $usu->setTreinamentoEdContinuada($_POST["cmbTreinamentoEdContinuada"]);
            $usu->setSomenteTerapia($_POST["cmbSomenteTerapia"]);
            $usuController->validaDados($usu);
            echo "Incluído com sucesso.";
        }
    } catch (Exception $ex) {
        echo "Erro ao registrar o usuário. Erro: " . $ex->getMessage(); exit();
    }
} else if ($_REQUEST["tipo"] == "X"){

    try{
        $usuController->excluir($_POST["txtCodigoExc"]);
        echo "Excluído com sucesso.";
    } catch(Exception $e){
        echo "Erro ao excluir o usuário. Erro: " . $e->getMessage(); exit();
    }

} else if ($_REQUEST["tipo"] == "AS"){

    try{
        if ($_POST["txtSenha"] != $_POST["txtConfirmarSenha"]){
            echo "Senha estão diferentes.";
            exit();
        } else if (strlen ($_POST['txtConfirmarSenha']) < 8){
            echo "Quantidade de caracterer não pode ser menor que 8";
            exit();
        } else {
            $usuController->alterarSenha($_POST["txtCodigoAltSenha"], $cripto->criptografarBase64($_POST["txtConfirmarSenha"]));
            echo "Alterado com sucesso.";
        }        
        
    } catch(Exception $e){
        echo "Erro ao alterar a senha do usuário. Erro: " . $e->getMessage(); exit();
    }

}