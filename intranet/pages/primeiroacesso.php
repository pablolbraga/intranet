<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="../css/login.css">
        <link href="../css/bs/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    </head>
    <body>
        <section class="ftco-section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-7 col-lg-5">
                        <div class="wrap">
                            <br>
                            <div class="container">
                                <img src="../imgs/logo_completa.png" width="100%"/>
                            </div>
                            <div class="login-wrap p-4 p-md-5">
                                <form action="primeiroacesso.php?usu=<?php echo $_REQUEST["usu"] ?>" class="signin-form" method="POST">
                                    <input type="hidden" name="idusuario" id="idusuario" value="<?php echo $_REQUEST["usu"] ?>" />
                                    <div class="w-100 text-md-center">
                                        <a href="#">Alterar Senha</a>
                                    </div>
                                    </br>
                                    <div class="form-group">
                                        <input id="senha" name="senha" type="password" class="form-control" value="<?php echo @$_POST["senha"] ?>" required>
                                        <label class="form-control-placeholder" for="senha">Senha</label>
                                        <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                    </div>
                                    <div class="form-group">
                                        <input id="confirmasenha" name="confirmasenha" type="password" class="form-control" value="<?php echo @$_POST["confirmasenha"] ?>" required>
                                        <label class="form-control-placeholder" for="confirmasenha">Confirmar Senha</label>
                                        <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                    </div>
                                    <div class="form-group">
                                        <button id="btnGravar" name="btnGravar" type="submit" class="form-control btn btn-primary rounded submit px-3">Gravar</button>
                                    </div>

                                    </br>
                                    
                                    <?php
                                    if (isset($_POST["btnGravar"])){
                                        if ($_POST["senha"] == $_POST["confirmasenha"]){
                                            require_once("../controllers/usuariocontroller.php");
                                            $ctrUsuario = new UsuarioController();
                                            try{
                                                $ctrUsuario->alterarSenha($_POST["idusuario"], $_POST["senha"]);
                                                echo "<script>location.href='login.php';</script>";
                                            } catch(Exception $e){
                                                ?>
                                                <div class="alert alert-danger" role="alert">
                                                    Erro ao alterar a senha. Erro: <?php echo $e->getMessage() ?>
                                                </div>
                                                <?php
                                            }
                                        } else {
                                            ?>
                                            <div class="alert alert-danger" role="alert">
                                                Senhas estão diferentes.
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                    
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <script src="../js/bs/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    </body>
</html>