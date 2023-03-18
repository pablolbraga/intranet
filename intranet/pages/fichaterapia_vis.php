<?php
require_once("../controllers/fichaterapiacontroller.php");
require_once("../helpers/contantes.php");
require_once("../controllers/assinaturacontroller.php");
$ctrFicha = new FichaTerapiaController();
$ctrAssinatura = new AssinaturaController();

$fm = $ctrFicha->buscarDadosPorEvolucao($_REQUEST["evol"]);

$dadosLinhaAssinatura = @$ctrAssinatura->retornarQuantidadeLinhasAssinatura($fm[0]["IDEVOLUTION"], $fm[0]["IDADMISSION"]);
if (count($dadosLinhaAssinatura) > 0){
    $qtdeLinhasAssPac = @$dadosLinhaAssinatura[0]["LINHAS_PAC"];
    $dadosAssinaturaPac = @$ctrAssinatura->retornarLinhasAssinatura(
        $qtdeLinhasAssPac,
        1,
        $fm[0]["IDEVOLUTION"], 
        $fm[0]["IDADMISSION"]
    );

    $linhaAssinaturaPac = "";
    for($i = 0; $i < $qtdeLinhasAssPac; $i++){
        $linhaAssinaturaPac .= $dadosAssinaturaPac[$i]["LINHA"];
    }

    $qtdeLinhasAssProf = @$dadosLinhaAssinatura[0]["LINHAS_PROF"];
    $dadosAssinaturaProf = @$ctrAssinatura->retornarLinhasAssinatura(
        $qtdeLinhasAssProf,
        2,
        $fm[0]["IDEVOLUTION"], 
        $fm[0]["IDADMISSION"]
    );

    $linhaAssinaturaProf = "";
    for($i = 0; $i < $qtdeLinhasAssProf; $i++){
        $linhaAssinaturaProf .= $dadosAssinaturaProf[$i]["LINHA"];
    }
} else {
    $linhaAssinaturaPac = "";
    $linhaAssinaturaProf = "";
}
?>

<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../css/bs/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">               
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.0/jquery.mask.min.js"></script>
        <script src="../js/funcoes.js"></script>
    </head>
    <body>
        <div class="container-fluid">
            <nav class="navbar navbar-extends-lg navbar-dark bg-primary">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">
                        <img class="rounded-circle" alt="100x100" width="50" height="50" src="../imgs/logo.png"  data-holder-rendered="true">
                        Registro de Acompanhamento Terapêutico
                    </a>
                </div>
            </nav>

            <div>
                <div class="row">
                    <label for="txtPaciente" class="col-sm-4 col-form-label"><b>Paciente:</b><br/><?php echo $fm[0]["NMPACIENTE"] ?></label>
                    <label for="txtPaciente" class="col-sm-2 col-form-label"><b>Idade:</b><br/><?php echo $fm[0]["IDADE"] ?> ano(s)</label>
                    <label for="txtPaciente" class="col-sm-3 col-form-label"><b>Convênio:</b><br/><?php echo $fm[0]["NMCONVENIO"] ?></label>
                    <label for="txtPaciente" class="col-sm-3 col-form-label"><b>Especialidade:</b><br/><?php echo $fm[0]["NMESPECIALIDADE"] ?></label>
                </div>
                
                <div class="row">
                    <label for="txtPaciente" class="col-sm-6 col-form-label"><b>Serviço:</b><br/><?php echo $fm[0]["NMSERVICO"] ?></label>
                    <label for="txtPaciente" class="col-sm-3 col-form-label"><b>Inicio:</b><br/><?php echo $fm[0]["DATAINICIOEVO"] ?></label>
                    <label for="txtPaciente" class="col-sm-3 col-form-label"><b>Fim:</b><br/><?php echo $fm[0]["DATAFIMEVO"] ?></label>
                </div>
                
                <div class="row">
                    <label for="txtPaciente" class="col-sm-3 col-form-label">
                        <b>Participação do Cliente:</b><br/>
                        <?php 
                        if ($fm[0]["PARTATIVO"] == "S")
                            echo "ATIVO";
                        else if ($fm[0]["PARTATIVOASSISTIDO"] == "S")
                            echo "ATIVO ASSISTIDO";
                        else if ($fm[0]["PARTPASSIVO"] == "S")
                            echo "PASSIVO";
                        else if ($fm[0]["PARTNAOREALIZADO"] == "S")
                            echo "NÃO REALIZADO";
                        else 
                            echo "";
                        ?>
                    </label>

                    <label for="txtPaciente" class="col-sm-3 col-form-label">
                        <b>Execução das Técnicas Propostas:</b><br/>
                        <?php 
                        if ($fm[0]["EXECCOMPLETA"] == "S")
                            echo "COMPLETA";
                        else if ($fm[0]["EXECPARCIAL"] == "S")
                            echo "PARCIAL";
                        else if ($fm[0]["EXECMINIMA"] == "S")
                            echo "MÍNIMA";
                        else 
                            echo "";
                        ?>
                    </label>

                    <label for="txtPaciente" class="col-sm-6 col-form-label">
                        <b>Observação:</b><br/>
                        <?php echo $fm[0]["OBSERVACAO"] ?>                        
                    </label>
                </div>                
                
                <div class="row">
                    <label for="txtPaciente" class="col-sm-6 col-form-label text-center"><b>Usuário/Responsável</b></label>
                    <label for="txtPaciente" class="col-sm-6 col-form-label text-center"><b>Médico</b></label>
                </div>
                <div class="row">
                    <div class="col-sm-6 text-center">
                        <?php
                        if ($linhaAssinaturaPac != ""){
                            $b64 = $linhaAssinaturaPac;
                            $bin = base64_decode($b64);
                            $im = imageCreateFromString($bin);
                            imagesavealpha($im, true);
                            $cor_fundo = imagecolorallocatealpha($im, 0, 0, 0, 127);
                            imagefill($im, 0, 0, $cor_fundo);
                            if (!$im){
                                die("");
                            }
                            $img_file = "../assinaturasfichas/asspac_" . @$fm[0]["IDADMISSION"] . "_" . @$fm[0]["IDEVOLUTION"] . ".png";
                            imagepng($im, $img_file, 0);
                            ?>
                            <img src="<?php echo $img_file ?>" width="200" height="80">
                            <?php
                        }                        
                        ?>
                    </div>
                    <div class="col-sm-6 text-center">
                    <?php
                        if ($linhaAssinaturaProf != ""){
                            $b64 = $linhaAssinaturaProf;
                            $bin = base64_decode($b64);
                            $im = imageCreateFromString($bin);
                            imagesavealpha($im, true);
                            $cor_fundo = imagecolorallocatealpha($im, 0, 0, 0, 127);
                            imagefill($im, 0, 0, $cor_fundo);
                            if (!$im){
                                die("");
                            }
                            $img_file = "../assinaturasfichas/assprof_" . @$fm[0]["IDADMISSION"] . "_" . @$fm[0]["IDEVOLUTION"] . ".png";
                            imagepng($im, $img_file, 0);
                            ?>
                            <img src="<?php echo $img_file ?>" width="200" height="80">
                            <?php
                        }                        
                        ?>
                    </div>                    
                </div>
                <div class="row">
                    <label for="txtPaciente" class="col-sm-6 col-form-label text-center"><b>ASSINATURA PACIENTE/RESPONSÁVEL</b></label>
                    <label for="txtPaciente" class="col-sm-6 col-form-label text-center"><b><?php echo $fm[0]["NMPROFESSIONAL"] ?><br/><?php echo $fm[0]["CONSELHO"] ?> - <?php echo $fm[0]["REGISTRO"] ?></b></label>
                </div>
            </div>
            
            <br/>

            <div class="container-fluid text-center">
                <a class="navbar-brand" href="#">
                    <b>Saúde Residence Atendimento Médico Ltda.</b> - 
                    Av. Rui Barbosa, 1630 Aldeota Fortaleza/CE 60.115-221<br>
                    Fone/fax: (85)3311.3000 - sr.ce@sauderesidence.com.br - www.sauderesidence.com.br
                </a>
            </div>
        </div>
        <script src="../js/bs/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>        
    </body>
</html>