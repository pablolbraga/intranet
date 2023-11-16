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
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
        <link href="../css/bs/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">   
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.0/jquery.mask.min.js"></script>
        <script src="../js/funcoes.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.7.0.js"></script>
	    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container-fluid">
                <div>
                    <img class="rounded-circle" alt="100x100" width="50" height="50" src="../imgs/logo.png"  data-holder-rendered="true">
                    &nbsp;
                    <a class="btn btn-success btn-sm" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
                        <i class="bi bi-list"></i>
                        Menu
                    </a>
                </div>
                <div>
                    <label style="color: white">Seja bem vindo, <?php echo $_SESSION["NOME_USUARIO"] ?></label>&nbsp;
                    <a href="sair.php" class="btn btn-danger btn-sm">Sair</a>
                </div>
            </div>
        </nav>

        <br/>

        <?php
        if (@$_GET["pag"] == "1"){
            require_once("visitasagendamento.php");
        } else if (@$_GET["pag"] == "2"){
            require_once("solicitacaoservico.php");
        } else if (@$_GET["pag"] == "3"){
            require_once("plantao.php");
        } else if (@$_GET["pag"] == "4"){
            require_once("visitasprogramadas.php");
        } else if (@$_GET["pag"] == "5"){
            require_once("solicitarcompra.php");
        } else if (@$_GET["pag"] == "6"){
            require_once("orcamento.php");
        } else if (@$_GET["pag"] == "7"){
            require_once("orcamento_pesq.php");
        } else if (@$_GET["pag"] == "8"){
            require_once("notafiscal.php");
        } else if (@$_GET["pag"] == "9"){
            require_once("alteracaoprescricao.php");
        } else if (@$_GET["pag"] == "10"){
            require_once("controleantibiotico.php");
        } else if (@$_GET["pag"] == "11"){
            require_once("triagemprioridade.php");
        } else if (@$_GET["pag"] == "12"){
            require_once("usuario.php");
        }
        ?>

        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasExampleLabel">Saúde Residence</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <div>
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseAtendimento" aria-expanded="false" aria-controls="flush-collapseAtendimento">
                                    Atendimento
                                </button>
                            </h2>
                            <div id="flush-collapseAtendimento" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <a class="btn btn-primary btn-sm" href="index.php?pag=3"><b>Passagem de Plantão</b></a>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseAutorizacao" aria-expanded="false" aria-controls="flush-collapseAutorizacao">
                                    Autorização     
                                </button>
                            </h2>
                            <div id="flush-collapseAutorizacao" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <a class="btn btn-primary btn-sm" href="index.php?pag=6"><b>Visualizar Orçamento</b></a>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseCcid" aria-expanded="false" aria-controls="flush-collapseCcid">
                                    CCID     
                                </button>
                            </h2>
                            <div id="flush-collapseCcid" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <a class="btn btn-primary btn-sm" href="index.php?pag=10"><b>Controle de Antibiótico</b></a>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseEnfermagem" aria-expanded="false" aria-controls="flush-collapseEnfermagem">
                                    Enfermagem     
                                </button>
                            </h2>
                            <div id="flush-collapseEnfermagem" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <a class="btn btn-primary btn-sm" href="index.php?pag=9"><b>Alteração de Prescrição</b></a>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFinanceiro" aria-expanded="false" aria-controls="flush-collapseFinanceiro">
                                    Financeiro
                                </button>
                            </h2>
                            <div id="flush-collapseFinanceiro" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <a class="btn btn-primary btn-sm" href="index.php?pag=8"><b>Solicitar Nota</b></a>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseServicos" aria-expanded="false" aria-controls="flush-collapseServicos">
                                    Serviços
                                </button>
                            </h2>
                            <div id="flush-collapseServicos" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <a class="btn btn-primary btn-sm" href="index.php?pag=2"><b>Solicitar Serviço</b></a>
                                    <a class="btn btn-primary btn-sm" href="index.php?pag=11"><b>Triagem de Prioridade</b></a>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseSuprimentos" aria-expanded="false" aria-controls="flush-collapseSuprimentos">
                                    Suprimentos
                                </button>
                            </h2>
                            <div id="flush-collapseSuprimentos" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <a class="btn btn-primary btn-sm" href="index.php?pag=5"><b>Solicitação de Compras</b></a>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseVisitas" aria-expanded="false" aria-controls="flush-collapseVisitas">
                                    Visitas
                                </button>
                            </h2>
                            <div id="flush-collapseVisitas" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <a class="btn btn-primary btn-sm" href="index.php?pag=1"><b>Agendamento</b></a>
                                    <a class="btn btn-primary btn-sm" href="index.php?pag=4"><b>Programação</b></a>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTI" aria-expanded="false" aria-controls="flush-collapseTI">
                                    TI
                                </button>
                            </h2>
                            <div id="flush-collapseTI" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <a class="btn btn-primary btn-sm" href="index.php?pag=12"><b>Usuários</b></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>           
        
        <script>
            new DataTable('#table', {
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/pt-BR.json',
                }
            });
        </script>
        <script src="../js/bs/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>        
    </body>
</html>