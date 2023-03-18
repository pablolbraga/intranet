<?php
session_start();
if ($_SESSION["ID_USUARIO"] == ""){
    echo "<script>alert('Sessão expirada.');location.href='sair.php';</script>";
}

?>
<html>
    <head>
        <title>Saúde Residence - Intranet</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="../css/bs/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">               
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.0/jquery.mask.min.js"></script>
        <script src="../js/funcoes.js"></script>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <img class="rounded-circle" alt="100x100" width="50" height="50" src="../imgs/logo.png"  data-holder-rendered="true">
            &nbsp;
            <div class="dropdown">
                <button class="btn btn-success btn-sm dropdown-toggle" type="button" id="dropdownMenuVisitas" data-bs-toggle="dropdown" aria-expanded="false">
                    Visitas
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuVisitas">
                    <li><a class="dropdown-item" href="index.php?pag=1"><b>Agendamento</b></a></li>
                    <li><a class="dropdown-item" href="index.php?pag=4"><b>Programação</b></a></li>
                </ul>
            </div>
            &nbsp;
            <div class="dropdown">
                <button class="btn btn-success btn-sm dropdown-toggle" type="button" id="dropdownMenuServicos" data-bs-toggle="dropdown" aria-expanded="false">
                    Serviços
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuServicos">
                    <li><a class="dropdown-item" href="index.php?pag=2"><b>Solicitar Serviço</b></a></li>
                </ul>
            </div>
            &nbsp;
            <div class="dropdown">
                <button class="btn btn-success btn-sm dropdown-toggle" type="button" id="dropdownMenuAtendimento" data-bs-toggle="dropdown" aria-expanded="false">
                    Atendimento
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuAtendimento">
                    <li><a class="dropdown-item" href="index.php?pag=3"><b>Plantões</b></a></li>
                </ul>
            </div>

            <div class="container-fluid">
                <a class="navbar-brand" href="#"></a>
                <div>
                    <label style="color: white">Seja bem vindo, <?php echo $_SESSION["NOME_USUARIO"] ?></label>&nbsp;
                    <a href="sair.php" class="btn btn-danger btn-sm">Sair</a>
                </div>
            </div>
        </nav>

        <br>

        <?php
        if (@$_GET["pag"] == "1"){
            require_once("visitasagendamento.php");
        } else if (@$_GET["pag"] == "2"){
            require_once("solicitacaoservico.php");
        } else if (@$_GET["pag"] == "3"){
            require_once("plantao.php");
        } else if (@$_GET["pag"] == "4"){
            require_once("visitasprogramadas.php");
        }
        ?>


        <script src="../js/bs/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>        
    </body>
</html>