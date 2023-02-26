<?php
require_once("../controllers/usuariocontroller.php");

$ctrUsuario = new UsuarioController();

$qryUsuario = $ctrUsuario->validaLoginSenha($_POST["login"], $_POST["senha"]);

if (count($qryUsuario) > 0){

    if ($qryUsuario[0]["NOVO"] == "S"){
        // Primeiro acesso ao sistema;
    } else {

    }
} else {
    echo "<script>alert('Login e/ou senha incorreto(s)'); location.href='login.php';</script>";
}