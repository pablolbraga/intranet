<?php
require_once("../controllers/fichanutricaocontroller.php");
require_once("../helpers/contantes.php");
require_once("../controllers/assinaturacontroller.php");
$ctrFicha = new FichaNutricaoController();
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
                        Registro de Acompanhamento de Nutricional
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
                    <label for="txtPaciente" class="col-sm-6 col-form-label">
                        <b>Grupos:</b><br/>
                        <?php 
                        $contador = 0;
                        if($fm[0]["GRUPO_HAS"] == "S"){
                            ?>HAS<?php
                            $contador++;
                        }
                        if ($fm[0]["GRUPO_DIABETES"] == "S"){
                            if ($contador > 0){
                                ?>, <?php
                            }
                            ?>DIABETES<?php
                            $contador++;
                        }
                        if ($fm[0]["GRUPO_DISLIPIDEMIA"] == "S"){
                            if ($contador > 0){
                                ?>, <?php
                            }
                            ?>DISLIPIDEMIA<?php
                            $contador++;
                        }
                        if ($fm[0]["GRUPO_IMOBILIDADE"] == "S"){
                            if ($contador > 0){
                                ?>, <?php
                            }
                            ?>IMOBILIDADE<?php
                            $contador++;
                        }
                        if ($fm[0]["GRUPO_OBESIDADE"] == "S"){
                            if ($contador > 0){
                                ?>, <?php
                            }
                            ?>OBESIDADE<?php
                            $contador++;
                        }
                        if ($fm[0]["GRUPO_DESNUTRICAO"] == "S"){
                            if ($contador > 0){
                                ?>, <?php
                            }
                            ?>DESNUTRIÇÃO<?php
                            $contador++;
                        }
                        if ($fm[0]["GRUPO_OUTROS"] == "S"){
                            if ($contador > 0){
                                ?>, <?php
                            }
                            echo $fm[0]["GRUPO_OUTROS"];
                            $contador++;
                        }
                        if ($contador == 0){
                            ?>SEM DEPENDÊNCIA DE CUIDADOS<?php
                        }
                        ?>
                    </label>
                    <label for="txtPaciente" class="col-sm-6 col-form-label">
                        <b>Nutrição:</b><br/>
                        <?php
                        echo Constantes::$arrFichaNutricaoNutricao[$fm[0]["NUTRICAO"]]["NOME"] . 
                            " " . Constantes::$arrFichaNutricaoNutricaoEnteral[$fm[0]["NUT_ENT_TIPO"]]["NOME"] .
                            " " . $fm[0]["NUT_ENT_TIPO_OUTRO"];
                        
                        ?>
                    </label>
                </div>
                
                <div class="row">
                    <label for="txtPaciente" class="col-sm-6 col-form-label">
                        <b>Dieta Enteral:</b><br/>
                        <?php
                        if ($fm[0]["DIETA_ENTUPIMENTO"] == "S"){
                            $entupimento = " - ENTUPIMENTO DE SONDA";
                        } else {
                            $entupimento = "";
                        }
                        echo Constantes::$arrFichaNutricaoDietaEnteral[$fm[0]["DIETA_ENTERAL"]]["NOME"] . 
                        $entupimento;
                        ?>
                    </label>
                    <?php
                    if ($fm[0]["DIETA_IND_TIPO"] == 1 || $fm[0]["DIETA_IND_TIPO"] == 3){
                        ?>
                        <label for="txtPaciente" class="col-sm-3 col-form-label">
                            <?php
                            if ($fm[0]["DIETA_IND_MAN_QTDE"] != ""){
                                ?>
                                <b>Necessidade Energética Total:</b><br/>
                                <?php echo $fm[0]["DIETA_IND_MAN_QTDE"] ?><br/>
                                <?php
                            }

                            if ($fm[0]["DIETA_IND_MAN_DESC"] != ""){
                                ?>
                                <b>Descrição:</b><br/>
                                <?php echo $fm[0]["DIETA_IND_MAN_DESC"] ?><br/>
                                <?php
                            }
                            ?>                            
                            
                            <b>Fornecedor:</b><br/>
                            <?php echo Constantes::$arrFichaNutricaoDietaEnteralIndustForn[$fm[0]["DIETA_IND_FORN"]]["NOME"]; ?>
                        </label>
                        <?php
                    } else if ($fm[0]["DIETA_IND_TIPO"] == 2 || $fm[0]["DIETA_IND_TIPO"] == 3){
                        ?>
                        <label for="txtPaciente" class="col-sm-3 col-form-label">
                            <b>Kcal/Dia:</b><br/>
                            <?php echo $fm[0]["DIETA_IND_PRO_QTDE"] ?><br/>
                            <b>Descrição:</b><br/>
                            <?php echo $fm[0]["DIETA_IND_PRO_DESC"] ?><br/>
                            <b>Fabricante:</b><br/>
                            <?php echo $fm[0]["DIETA_IND_PRO_FAB"] ?><br/>
                        </label>
                        <?php
                    }
                    ?>
                </div>

                <div class="row">
                    <label for="txtPaciente" class="col-sm-12 col-form-label">
                        <b>Avaliação Subjetiva:</b><br/>                        
                    </label>                    
                </div>

                <div class="row">
                    <label for="txtPaciente" class="col-sm-3 col-form-label">
                        <b>Ingesta:</b><br/>
                        <?php echo Constantes::$arrFichaNutricaoAvalSubjIngesta[$fm[0]["AVALSUB_ING"]]["NOME"] ?>                        
                    </label>
                    <label for="txtPaciente" class="col-sm-3 col-form-label">
                        <b>Peso:</b><br/>
                        <?php echo Constantes::$arrFichaNutricaoAvalSubjPeso[$fm[0]["AVALSUB_PESO_TIPO"]]["NOME"] ?>, Quantidade: <?php echo $fm[0]["AVALSUB_PESO_QTDE"] ?>, Tempo: <?php echo $fm[0]["AVALSUB_PESO_TEMPO"] ?> 
                    </label>
                    <label for="txtPaciente" class="col-sm-3 col-form-label">
                        <b>Sintomas:</b><br/>
                        <?php
                        $contador = 0;
                        if ($fm[0]["AVALSUB_SINT_DIA"] == "S"){
                            echo "DIARRÉIA";
                            $contador++;
                        }
                        if ($fm[0]["AVALSUB_SINT_HIP"] == "S"){
                            if ($contador > 0){
                                ?>, <?php
                            }
                            ?>HIPOREXIA<?php
                            $contador++;
                        }
                        if ($fm[0]["AVALSUB_SINT_CONST"] == "S"){
                            if ($contador > 0){
                                ?>, <?php
                            }
                            ?>CONSTIPAÇÃO<?php
                            $contador++;
                        }
                        if ($fm[0]["AVALSUB_SINT_OUTRO"] != ""){
                            if ($contador > 0){
                                ?>, <?php
                            }
                            echo $fm[0]["AVALSUB_SINT_OUTRO"];                            
                        }
                        ?>                        
                    </label>
                    <label for="txtPaciente" class="col-sm-3 col-form-label">
                        <b>Ritmo Intestinal:</b><br/>
                        <?php echo $fm[0]["AVALSUB_RITMO_INT"] ?>
                    </label>
                </div>

                <div class="row">
                    <label for="txtPaciente" class="col-sm-12 col-form-label">
                        <b>Avaliação Antropométrica:</b><br/>                        
                    </label>                    
                </div>

                <div class="row">
                    <label for="txtPaciente" class="col-sm-2 col-form-label">
                        <b>AJ:&nbsp;</b>
                        <?php echo $fm[0]["AVALANTRO_AJ"] ?>
                    </label>
                    <label for="txtPaciente" class="col-sm-2 col-form-label">
                        <b>Peso: </b>
                        <?php echo $fm[0]["AVALANTRO_PESO"] ?>
                    </label> 
                    <label for="txtPaciente" class="col-sm-2 col-form-label">
                        <b>Circ. Abd.(cm): </b>
                        <?php echo $fm[0]["AVALANTRO_CIRCABD"] ?>
                    </label> 
                    <label for="txtPaciente" class="col-sm-2 col-form-label">
                        <b>IMC: </b>
                        <?php echo $fm[0]["AVALANTRO_IMC"] ?>
                    </label>
                    <label for="txtPaciente" class="col-sm-2 col-form-label">
                        <b>CP: </b>
                        <?php echo $fm[0]["AVALANTRO_CP"] ?>
                    </label>
                    <label for="txtPaciente" class="col-sm-2 col-form-label">
                        <b>DCT(mm): </b>
                        <?php echo $fm[0]["AVALANTRO_DCT"] ?>
                    </label>  
                </div>

                <div class="row">                    
                    <label for="txtPaciente" class="col-sm-2 col-form-label">
                        <b>CB(cm): </b>
                        <?php echo $fm[0]["AVALANTRO_CB"] ?>
                    </label> 
                    <label for="txtPaciente" class="col-sm-2 col-form-label">
                        <b>CMB(cm): </b>
                        <?php echo $fm[0]["AVALANTRO_CMB"] ?>
                    </label>   
                    <label for="txtPaciente" class="col-sm-2 col-form-label">
                        <b>Altura(m): </b>
                        <?php echo $fm[0]["AVALANTRO_ALT"] ?>
                    </label>                                        
                </div>

                <div class="row">
                    <label for="txtPaciente" class="col-sm-6 col-form-label">
                        <b>Diagnóstico Nutricional:</b><br/>
                        <?php echo Constantes::$arrFichaNutricaoDiagNutriAbaixo65[$fm[0]["DIAG_NUT"]]["NOME"] . Constantes::$arrFichaNutricaoDiagNutriAcima65[$fm[0]["DIAG_NUT_65"]]["NOME"] ?>
                    </label> 
                    <label for="txtPaciente" class="col-sm-6 col-form-label">
                        <b>Observação:</b><br/>
                        <?php echo $fm[0]["DIAG_NUT_DESC"] ?>
                    </label>                    
                </div>

                <div class="row">
                    <label for="txtPaciente" class="col-sm-12 col-form-label">
                        <b>Condutas:</b><br/>
                        <?php echo $fm[0]["CONDUTA"] ?>
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