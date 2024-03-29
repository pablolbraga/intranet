<?php
session_start();
require_once("../controllers/usuariocontroller.php");

$ctrUsuario = new UsuarioController();

$qryUsuario = $ctrUsuario->validaLoginSenha($_POST["login"], $_POST["senha"]);

if (count($qryUsuario) > 0){

    if ($qryUsuario[0]["NOVO"] == "S"){
        // Primeiro acesso ao sistema;
        echo "<script>location.href=primeiroacesso.php?usu=" . $qryUsuario[0]["IDUSUARIO"] . "</script>";
    } else {
        $_SESSION["ID_USUARIO"] = $qryUsuario[0]["IDUSUARIO"];
        $_SESSION["LOGIN_USUARIO"] = $qryUsuario[0]["LOGIN"];
        $_SESSION["NOME_USUARIO"] = $qryUsuario[0]["NOME"];
        $_SESSION["EMAIL_USUARIO"] = $qryUsuario[0]["EMAIL"];
        $_SESSION["NMSECUSER_USUARIO"] = $qryUsuario[0]["NMSECUSER"];
        $_SESSION["UGB_USUARIO"] = $qryUsuario[0]["UGB"];
        $_SESSION["ADM_USUARIO"] = $qryUsuario[0]["ADM"];
        
        $_SESSION["HABILITA_EXCLUSAO_FICHA"] = "N";
        if ($_SESSION["ADM_USUARIO"] == "S"){
            $_SESSION["HABILITA_EXCLUSAO_FICHA"] = "S";
        } else if ($_SESSION["UGB_USUARIO"] == "GERENCIA"){
            $_SESSION["HABILITA_EXCLUSAO_FICHA"] = "S";
        } else if ($_SESSION["UGB_USUARIO"] == "COORDENAÇÃO DE ENFERMAGEM"){
            $_SESSION["HABILITA_EXCLUSAO_FICHA"] = "S";
        }
        
        echo "<script>location.href='index.php';</script>";
    }
} else {
    echo "<script>alert('Login e/ou senha incorreto(s)'); location.href='login.php';</script>";
}