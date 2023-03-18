<?php
require_once("../controllers/fichamedicacontroller.php");
require_once("../helpers/contantes.php");
require_once("../controllers/assinaturacontroller.php");
$ctrFicha = new FichaMedicaController();
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
                        Registro de Acompanhamento Médico
                    </a>
                </div>
            </nav>

            <div>
                <div class="row">
                    <label for="txtPaciente" class="col-sm-4 col-form-label"><b>Paciente:</b><br/><?php echo $fm[0]["NMPACIENTE"] ?></label>
                    <label for="txtPaciente" class="col-sm-2 col-form-label"><b>Idade:</b><br/><?php echo $fm[0]["IDADE"] ?> ano(s)</label>
                    <label for="txtPaciente" class="col-sm-3 col-form-label"><b>Acompanhante:</b><br/><?php echo $fm[0]["NOME_ACOMPANHANTE"] ?></label>
                    <label for="txtPaciente" class="col-sm-3 col-form-label"><b>Convênio:</b><br/><?php echo $fm[0]["NMCONVENIO"] ?></label>
                </div>
                
                <div class="row">
                    <label for="txtPaciente" class="col-sm-6 col-form-label"><b>Serviço:</b><br/><?php echo $fm[0]["NMSERVICO"] ?></label>
                    <label for="txtPaciente" class="col-sm-3 col-form-label"><b>Inicio:</b><br/><?php echo $fm[0]["DATAINICIO"] ?></label>
                    <label for="txtPaciente" class="col-sm-3 col-form-label"><b>Fim:</b><br/><?php echo $fm[0]["DATAFIM"] ?></label>
                </div>
                
                <div class="row">
                    <label for="txtPaciente" class="col-sm-12 col-form-label">
                        <b>HD:</b><br/><?php echo $fm[0]["HD"] ?>
                    </label>
                </div>
                <div class="row">
                    <label for="txtPaciente" class="col-sm-12 col-form-label">
                        <b>Situação Clínica:</b><br/><?php echo $fm[0]["SITCLINICA"] ?>
                    </label>
                </div>
                
                <div class="row">
                    <label for="txtPaciente" class="col-sm-12 col-form-label"><b>Justificativa:</b><br/><?php echo $fm[0]["JUST_ATEND_DOMIC"] ?></label>                    
                </div>
                <div class="row">
                    <label for="txtPaciente" class="col-sm-12 col-form-label">
                        <b>Terapias:</b><br/>
                        <?php
                        $contadorTerapia = 0;
                        if ($fm[0]["RESPX"] != 0){                            
                            ?>Fisioterapia Respiratória: <?php echo $fm[0]["RESPX"] ?> (x/sem)<?php
                            $contadorTerapia++;
                        }
                        if ($fm[0]["MOTX"] != 0){
                            if ($contadorTerapia > 0){
                                ?>, <?php
                            }
                            ?>Fisioterapia Motora: <?php echo $fm[0]["MOTX"] ?> (x/sem)<?php
                            $contadorTerapia++;
                        }
                        if ($fm[0]["FONOTERAPIA"] != 0){
                            if ($contadorTerapia > 0){
                                ?>, <?php
                            }
                            ?>Fonoterapia: <?php echo $fm[0]["FONOTERAPIA"] ?> (x/sem)<?php
                            $contadorTerapia++;
                        }
                        if ($fm[0]["ENFERMAGEM"] != 0){
                            if ($contadorTerapia > 0){
                                ?>, <?php
                            }
                            ?>Enfermagem: <?php echo $fm[0]["ENFERMAGEM"] ?> (x/sem)<?php
                            $contadorTerapia++;
                        }
                        if ($fm[0]["TERAP_OCUP"] != 0){
                            if ($contadorTerapia > 0){
                                ?>, <?php
                            }
                            ?>Terapia Ocupacional: <?php echo $fm[0]["TERAP_OCUP"] ?> (x/sem)<?php
                            $contadorTerapia++;
                        }
                        if ($fm[0]["PSICOLOGO"] != 0){
                            if ($contadorTerapia > 0){
                                ?>, <?php
                            }
                            ?>Psicologia: <?php echo $fm[0]["PSICOLOGO"] ?> (x/sem)<?php
                            $contadorTerapia++;
                        }
                        if ($fm[0]["NUTRICIONISTA"] != 0){
                            if ($contadorTerapia > 0){
                                ?>, <?php
                            }
                            ?>Nutricionista: <?php echo $fm[0]["NUTRICIONISTA"] ?> (x/mês)<?php
                            $contadorTerapia++;
                        }

                        if ($contadorTerapia == 0){
                            ?>NÃO POSSUI<?php
                        }
                        ?>
                    </label>
                </div>

                <div class="row">
                    <label for="txtPaciente" class="col-sm-12 col-form-label">
                        <b>Exame Físico:</b><br/>
                        <?php echo $fm[0]["EXFISICO"] ?>
                    </label>
                </div>

                <div class="row">
                    <label for="txtPaciente" class="col-sm-12 col-form-label">
                        <b>Antibiótico:</b><br/>
                        <?php echo $fm[0]["OUTROSANTIB"] ?>
                    </label>
                </div>

                <div class="row">
                    <label for="txtPaciente" class="col-sm-3 col-form-label">
                        <b>Nutrição:</b><br/>
                        <?php
                        $contadorNutricao = 0;
                        if ($fm[0]["NUTRI_ORAL"] != 0){                            
                            ?>Oral<?php
                            $contadorNutricao++;
                        }
                        if ($fm[0]["NUTRI_GT"] != 0){
                            if ($contadorNutricao > 0){
                                ?>, <?php
                            }
                            ?>GT<?php
                            $contadorNutricao++;
                        }
                        if ($fm[0]["NUTRI_CNE"] != 0){
                            if ($contadorNutricao > 0){
                                ?>, <?php
                            }
                            ?>CNE<?php
                            $contadorNutricao++;
                        }
                        if ($fm[0]["NUTRI_IV"] != 0){
                            if ($contadorNutricao > 0){
                                ?>, <?php
                            }
                            ?>IV<?php
                            $contadorNutricao++;
                        }                       

                        if ($contadorNutricao == 0){
                            ?>NÃO POSSUI<?php
                        }
                        ?>
                    </label>
                    <label for="txtPaciente" class="col-sm-3 col-form-label">
                        <b>AVD:</b><br/>
                        <?php echo Constantes::$arrAtividadeFisicaDiaria[$fm[0]["AVD"]]["NOME"] ?>
                    </label>
                    <label for="txtPaciente" class="col-sm-2 col-form-label">
                        <b>PA:</b><br/>
                        <?php echo $fm[0]["PARTERIAL"] ?>
                    </label>
                    <label for="txtPaciente" class="col-sm-2 col-form-label">
                        <b>FC:</b><br/>
                        <?php echo $fm[0]["FC"] ?>
                    </label>
                    <label for="txtPaciente" class="col-sm-2 col-form-label">
                        <b>FR:</b><br/>
                        <?php echo $fm[0]["FR"] ?>
                    </label>
                </div>                
                
                <div class="row">
                    <label for="txtPaciente" class="col-sm-3 col-form-label">
                        <b>ECG:</b><br/>
                        <?php
                        $contadorNivelConsciencia = 0;
                        if ($fm[0]["RM"] != 0){                            
                            ?>RM: <?php echo $fm[0]["RM"] ?><?php
                            $contadorNivelConsciencia++;
                        }
                        if ($fm[0]["RV"] != 0){
                            if ($contadorNivelConsciencia > 0){
                                ?>, <?php
                            }
                            ?>RV: <?php echo $fm[0]["RV"] ?><?php
                            $contadorNivelConsciencia++;
                        }
                        if ($fm[0]["AO"] != 0){
                            if ($contadorNivelConsciencia > 0){
                                ?>, <?php
                            }
                            ?>AO: <?php echo $fm[0]["AO"] ?><?php
                            $contadorNivelConsciencia++;
                        }                        
                        ?>
                        &nbsp;-&nbsp;ECG: <?php echo $fm[0]["RM"] + $fm[0]["RV"] + $fm[0]["AO"] ?>
                    </label>
                    <label for="txtPaciente" class="col-sm-3 col-form-label">
                        <b>VM:</b><br/>
                        <?php echo Constantes::$arrVentilacaoMecanica[$fm[0]["VM_TIPO"]]["NOME"] ?>
                    </label>
                    <label for="txtPaciente" class="col-sm-3 col-form-label">
                        <b>Ventilador</b><br/>
                        <?php echo $fm[0]["VENTILADOR"] == "" ? "NÃO POSSUI" : $fm[0]["VENTILADOR"] ?>
                    </label>
                    <label for="txtPaciente" class="col-sm-3 col-form-label">
                        <b>Ostomias</b><br/>
                        <?php
                        $contador = 0;
                        if ($fm[0]["OST_TRAQUEOSTOMIA"] != 0){                            
                            ?>TRAQUEÓSTOMIA<?php
                            $contador++;
                        }
                        if ($fm[0]["OST_GASTROSTOMIA"] != 0){
                            if ($contador > 0){
                                ?>, <?php
                            }
                            ?>GASTROSTOMIA<?php
                            $contador++;
                        }
                        if ($fm[0]["OST_CISTOSTOMIA"] != 0){
                            if ($contador > 0){
                                ?>, <?php
                            }
                            ?>CISTOSTOMIA<?php
                            $contador++;
                        }
                        if ($fm[0]["OST_COLONOSTOMIA"] != 0){
                            if ($contador > 0){
                                ?>, <?php
                            }
                            ?>COLONOSTOMIA<?php
                            $contador++;
                        }
                        if ($fm[0]["OST_OUTROS"] != ""){
                            if ($contador > 0){
                                ?>, <?php
                            }
                            echo $fm[0]["OST_OUTROS"];
                            $contador++;
                        }
                        if ($contador == 0){
                            ?>NÃO POSSUI<?php
                        }
                        ?>
                    </label>
                </div>                
                
                <div class="row">
                    <label for="txtPaciente" class="col-sm-3 col-form-label">
                        <b>Aspiração Traqueal:</b><br/>
                        <?php echo Constantes::$arrSimNao2[$fm[0]["ASP_TRAQUEAL"]]["NOME"] ?>
                    </label>
                    <label for="txtPaciente" class="col-sm-3 col-form-label">
                        <b>Acesso Venoso:</b><br/>
                        <?php echo Constantes::$arrAcessoVenoso[$fm[0]["AV_TIPO"]]["NOME"] ?>
                    </label>
                    <label for="txtPaciente" class="col-sm-3 col-form-label">
                        <b>Sup. Oxigênio:</b><br/>
                        <?php
                        $contador = 0;
                        if ($fm[0]["OX_CIL"] == 1){                            
                            ?>CILINDRO<?php
                            $contador++;
                        }
                        if ($fm[0]["OX_CONC"] == 1){
                            if ($contador > 0){
                                ?>, <?php
                            }
                            ?>CONCENTRADOR<?php
                            $contador++;
                        }
                        if ($contador == 0){
                            ?>NÃO POSSUI<?php
                        }
                        ?>
                    </label>
                    <label for="txtPaciente" class="col-sm-3 col-form-label">
                        <b>Oxigenoterapia:</b><br/>
                        <?php echo Constantes::$arrOxigenoterapia[$fm[0]["OX_TIPO"]]["NOME"] ?>
                    </label>
                </div>                
                
                <div class="row">
                    <label for="txtPaciente" class="col-sm-6 col-form-label">
                        <b>Solicitação de Exames:</b><br/>
                        <?php echo Constantes::$arrSimNao2[$fm[0]["SOL_EXAMES"]]["NOME"] ?>
                    </label>
                    <label for="txtPaciente" class="col-sm-6 col-form-label">
                        <b>Mudança de Prescrição:</b><br/>
                        <?php echo Constantes::$arrSimNao2[$fm[0]["MUD_PRESC"]]["NOME"] ?>
                    </label>
                </div>                
                <div class="row">
                    <label for="txtPaciente" class="col-sm-12 col-form-label">
                        <b>Problemas:</b><br/>
                        <?php echo $fm[0]["PROBLEMAS"] ?>
                    </label>
                    
                </div>
                <div class="row">
                    <label for="txtPaciente" class="col-sm-12 col-form-label">
                        <b>Orientação/Conduta:</b><br/>
                        <?php echo $fm[0]["CONDUTAS"] ?>
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