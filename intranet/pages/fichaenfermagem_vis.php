<?php
require_once("../controllers/fichaenfermagemcontroller.php");
require_once("../helpers/contantes.php");
require_once("../controllers/assinaturacontroller.php");
$ctrFicha = new FichaEnfermagemController();
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
                        Registro de Acompanhamento de Enfermagem
                    </a>
                </div>
            </nav>

            <div>
                <div class="row">
                    <label for="txtPaciente" class="col-sm-4 col-form-label"><b>Paciente:</b><br/><?php echo $fm[0]["NMPACIENTE"] ?></label>
                    <label for="txtPaciente" class="col-sm-2 col-form-label"><b>Idade:</b><br/><?php echo $fm[0]["IDADE"] ?> ano(s)</label>
                    <label for="txtPaciente" class="col-sm-3 col-form-label"><b>Acompanhante:</b><br/><?php echo $fm[0]["ACOMPANHANTE"] ?></label>
                    <label for="txtPaciente" class="col-sm-3 col-form-label"><b>Convênio:</b><br/><?php echo $fm[0]["NMCONVENIO"] ?></label>
                </div>
                
                <div class="row">
                    <label for="txtPaciente" class="col-sm-6 col-form-label"><b>Serviço:</b><br/><?php echo $fm[0]["NMSERVICO"] ?></label>
                    <label for="txtPaciente" class="col-sm-3 col-form-label"><b>Inicio:</b><br/><?php echo $fm[0]["DATAINICIO"] ?></label>
                    <label for="txtPaciente" class="col-sm-3 col-form-label"><b>Fim:</b><br/><?php echo $fm[0]["DATAFIM"] ?></label>
                </div>
                
                <div class="row">
                    <label for="txtPaciente" class="col-sm-12 col-form-label">
                        <b>Dependência de Cuidados:</b><br/>
                        <?php 
                        $contador = 0;
                        if($fm[0]["AV_CUIDADO_BANHO"] > 0){
                            ?>BANHO<?php
                            $contador++;
                        }
                        if ($fm[0]["AV_CUIDADO_VESTIR"] > 0){
                            if ($contador > 0){
                                ?>, <?php
                            }
                            ?>VESTIR-SE<?php
                            $contador++;
                        }
                        if ($fm[0]["AV_CUIDADO_TRANSF"] > 0){
                            if ($contador > 0){
                                ?>, <?php
                            }
                            ?>TRANSFERÊNCIA<?php
                            $contador++;
                        }
                        if ($fm[0]["AV_CUIDADO_CONT"] > 0){
                            if ($contador > 0){
                                ?>, <?php
                            }
                            ?>CONTINÊNCIA<?php
                            $contador++;
                        }
                        if ($fm[0]["AV_CUIDADO_ALIM"] > 0){
                            if ($contador > 0){
                                ?>, <?php
                            }
                            ?>ALIMENTAÇÃO<?php
                            $contador++;
                        }
                        if ($contador == 0){
                            ?>SEM DEPENDÊNCIA DE CUIDADOS<?php
                        }
                        ?>
                    </label>
                </div>
                <div class="row">
                    <label for="txtPaciente" class="col-sm-6 col-form-label">
                        <b>Utilização de:</b><br/>
                        <?php 
                        $contador = 0;
                        if($fm[0]["UTILIZ_TQ"] > 0){
                            ?>TQT<?php
                            $contador++;
                        }
                        if ($fm[0]["UTILIZ_SNE"] > 0){
                            if ($contador > 0){
                                ?>, <?php
                            }
                            ?>CNE<?php
                            $contador++;
                        }
                        if ($fm[0]["UTILIZ_GT"] > 0){
                            if ($contador > 0){
                                ?>, <?php
                            }
                            ?>GT<?php
                            $contador++;
                        }
                        if ($fm[0]["UTILIZ_CVD"] > 0){
                            if ($contador > 0){
                                ?>, <?php
                            }
                            ?>CVD<?php
                            $contador++;
                        }
                        if ($fm[0]["UTILIZ_OUTRAS"] > 0){
                            if ($contador > 0){
                                ?>, <?php
                            }
                            echo $fm[0]["OUTRASUTIL"];
                            $contador++;
                        }
                        if ($contador == 0){
                            ?>SEM UTILIZAÇÃO DE SONDAS<?php
                        }
                        ?>
                    </label>
                    <label for="txtPaciente" class="col-sm-6 col-form-label">
                        <b>Oxigenoterapia:</b><br/>
                        <?php 
                        $contador = 0;
                        if($fm[0]["OXIGENOTERAPIA_CILINDRO"] > 0){
                            ?>CILINDRO<?php
                            $contador++;
                        }
                        if ($fm[0]["OXIGENOTERAPIA_CONCENTRADOR"] > 0){
                            if ($contador > 0){
                                ?>, <?php
                            }
                            ?>CONCENTRADOR<?php
                            $contador++;
                        }
                        if ($fm[0]["OXIGENOTERAPIA_CON"] > 0){
                            if ($contador > 0){
                                ?>, <?php
                            }
                            ?>CONTÍNUO<?php
                            $contador++;
                        }
                        if ($contador == 0){
                            ?>SEM OXIGENOTERAPIA<?php
                        }
                        ?>
                    </label>
                </div>
                
                <div class="row">
                    <label for="txtPaciente" class="col-sm-6 col-form-label">
                        <b>Ventilação Mecânica:</b><br/>
                        <?php
                        if ($fm[0]["VMEQUIP"] == ""){
                            echo "SEM EQUIPAMENTOS";
                        } else {
                            echo $fm[0]["VMEQUIP"];
                        }                        
                        ?>
                    </label>
                    <label for="txtPaciente" class="col-sm-6 col-form-label">
                        <b>PA:</b><br/>
                        <?php echo $fm[0]["PA_MAX"] . " x " . $fm[0]["PA_MIN"] . " mmHg" ?>
                    </label>
                </div>

                <div class="row">
                    <label for="txtPaciente" class="col-sm-6 col-form-label">
                        <b>Presença de Lesão:</b><br/>
                        <?php 
                        $contador = 0;
                        if($fm[0]["FERIDA_PRESSAO"] > 0){
                            ?>PRESSÃO<?php
                            $contador++;
                        }
                        if ($fm[0]["FERIDA_VASCULO"] > 0){
                            if ($contador > 0){
                                ?>, <?php
                            }
                            ?>VASCULOGÊNCIA<?php
                            $contador++;
                        }
                        if ($fm[0]["FERIDA_CIRURGIC"] > 0){
                            if ($contador > 0){
                                ?>, <?php
                            }
                            ?>CIRÚRGIA<?php
                            $contador++;
                        }
                        if ($fm[0]["FER_OUTROS"] != ""){
                            if ($contador > 0){
                                ?>, <?php
                            }
                            echo $fm[0]["FER_OUTROS"];
                            $contador++;
                        }
                        if ($contador == 0){
                            ?>SEM PRESENÇA DE LESÕES<?php
                        }
                        ?>
                    </label>
                    <label for="txtPaciente" class="col-sm-6 col-form-label">
                        <b>Diagnóstico de Enfermagem:</b><br/>
                        <?php 
                        $contador = 0;
                        for ($i = 0; $i < count(Constantes::$arrDiagnosticoEnfermagem); $i++){
                            if (@$fm[0]["DIAG_" . str_pad($i, 2, 0, STR_PAD_LEFT)] > 0){
                                if ($contador > 0){
                                    ?>, <?php
                                }
                                echo Constantes::$arrDiagnosticoEnfermagem[$i]["NOME"];
                                $contador++;
                            }
                        }
                        if ($contador == 0){
                            ?>SEM DIAGNÓSTICOS DE ENFERMAGEM<?php
                        }
                        ?>
                    </label>
                </div>

                <div class="row">
                    <label for="txtPaciente" class="col-sm-12 col-form-label">
                        <b>Procedimentos:</b><br/>
                        <?php 
                        $contador = 0;
                        if($fm[0]["PROC_COL_CVD"] > 0){
                            ?>Colocação e/ou troca de cateter vesical de demora<?php
                            $contador++;
                        }
                        if ($fm[0]["PROC_COL_CNE"] > 0){
                            if ($contador > 0){
                                ?>, <?php
                            }
                            ?>Colocação e/ou troca de cateter nasoenteral<?php
                            $contador++;
                        }
                        if ($fm[0]["PROC_COL_CNG"] > 0){
                            if ($contador > 0){
                                ?>, <?php
                            }
                            ?>Colocação e/ou troca de cateter nasogástrico<?php
                            $contador++;
                        }
                        if ($fm[0]["PROC_TROC_TQT"] > 0){
                            if ($contador > 0){
                                ?>, <?php
                            }
                            ?>Troca de traqueóstomo<?php
                            $contador++;
                        }
                        if ($fm[0]["PROC_COL_CVA"] > 0){
                            if ($contador > 0){
                                ?>, <?php
                            }
                            ?>Cateterismo vesical de alívio<?php
                            $contador++;
                        }
                        if ($fm[0]["PROC_COL_CV"] > 0){
                            if ($contador > 0){
                                ?>, <?php
                            }
                            ?>Troca de cistostomia<?php
                            $contador++;
                        }
                        if ($fm[0]["PROC_COL_GT"] > 0){
                            if ($contador > 0){
                                ?>, <?php
                            }
                            ?>Troca de cateter de gastrostomia<?php
                            $contador++;
                        }
                        if ($fm[0]["PROC_CURATIVO"] > 0){
                            if ($contador > 0){
                                ?>, <?php
                            }
                            ?>Curativo<?php
                            $contador++;
                        }
                        if ($fm[0]["PROC_OUTROS_DESC"] != ""){
                            if ($contador > 0){
                                ?>, <?php
                            }
                            echo $fm[0]["PROC_OUTROS_DESC"];
                            $contador++;
                        }
                        if ($contador == 0){
                            ?>SEM PROCEDIMENTOS<?php
                        }
                        ?>
                    </label>
                </div>

                <div class="row">
                    <label for="txtPaciente" class="col-sm-12 col-form-label">
                        <b>Planos de Cuidado:</b><br/>
                        <?php 
                        $contador = 0;
                        for ($i = 0; $i < count(Constantes::$arrPlanoCuidado); $i++){
                            if (@$fm[0]["PLANO_CUID_" . $i] > 0){
                                if ($contador > 0){
                                    ?>; <?php
                                }
                                echo $i . ". " . Constantes::$arrPlanoCuidado[$i]["NOME"];
                                $contador++;
                            }
                        }
                        if ($fm[0]["PLANO_CUID_OUTROS"] != ""){
                            if ($contador > 0){
                                ?>; <?php
                            }
                            echo $fm[0]["PLANO_CUID_OUTROS"];
                            $contador++;
                        }
                        if ($contador == 0){
                            ?>SEM PLANOS DE CUIDADO<?php
                        }
                        ?>
                    </label>
                </div>

                <div class="row">
                    <label class="col-sm-12 col-form-label"><b>Escala de Braden</b></label>
                </div>

                <div class="row">
                    <label class="col-sm-4 col-form-label">
                        <b>Percepção Sensorial:</b><br>
                        <?php echo Constantes::$arrBradenPercepcao[$fm[0]["BRADEN_PERCEP_SENSORIAL"]]["NOME"] ?>
                    </label>
                    <label class="col-sm-4 col-form-label">
                        <b>Umidade:</b><br>
                        <?php echo Constantes::$arrBradenUmidade[$fm[0]["BRADEN_UMIDADE"]]["NOME"] ?>
                    </label>
                    <label class="col-sm-4 col-form-label">
                        <b>Atividade:</b><br>
                        <?php echo Constantes::$arrBradenAtividade[$fm[0]["BRADEN_ATIVIDADE"]]["NOME"] ?>
                    </label>                    
                </div>

                <div class="row">
                    <label class="col-sm-4 col-form-label">
                        <b>Mobilidade:</b><br>
                        <?php echo Constantes::$arrBradenMobilidade[$fm[0]["BRADEN_MOBILIDADE"]]["NOME"] ?>
                    </label>
                    <label class="col-sm-4 col-form-label">
                        <b>Nutrição:</b><br>
                        <?php echo Constantes::$arrBradenNutricao[$fm[0]["BRADEN_NUTRICAO"]]["NOME"] ?>
                    </label>
                    <label class="col-sm-4 col-form-label">
                        <b>Ficção/Cisalhamento:</b><br>
                        <?php echo Constantes::$arrBradenFiccao[$fm[0]["BRADEN_FRICCAO"]]["NOME"] ?>
                    </label>
                </div>

                <div class="row">
                    <label class="col-sm-12 col-form-label">
                        <b>Observação</b><br/>
                        <?php echo $fm[0]["OBSERVACOES"] ?>
                    </label>
                </div>
                
                <br/>
                
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