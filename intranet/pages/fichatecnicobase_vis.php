<?php
require_once("../controllers/fichatecnicobasecontroller.php");
require_once("../helpers/contantes.php");
require_once("../controllers/assinaturacontroller.php");
$ctrFicha = new FichaTecnicoBaseController();
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
                    <label for="txtPaciente" class="col-sm-3 col-form-label"><b>Tipo da Chamada:</b><br/><?php echo Constantes::$arrFichaTecBaseTipoChamada[$fm[0]["TP_CHAMADA"]]["NOME"] ?></label>
                    <label for="txtPaciente" class="col-sm-3 col-form-label"><b>Convênio:</b><br/><?php echo $fm[0]["NMCONVENIO"] ?></label>
                </div>
                
                <div class="row">
                    <label for="txtPaciente" class="col-sm-6 col-form-label"><b>Serviço:</b><br/><?php echo $fm[0]["NMSERVICO"] ?></label>
                    <label for="txtPaciente" class="col-sm-3 col-form-label"><b>Inicio:</b><br/><?php echo $fm[0]["DATAINICIO"] ?></label>
                    <label for="txtPaciente" class="col-sm-3 col-form-label"><b>Fim:</b><br/><?php echo $fm[0]["DATAFIM"] ?></label>
                </div>
                
                <div class="row">
                    <label for="txtPaciente" class="col-sm-12 col-form-label">
                        <b>Procedimento:</b><br/>
                        <?php 
                        $contador = 0;
                        if ($fm[0]["IV"] == 1){
                            echo "ADMINISTRAÇÃO DE MEDICAMENTO - IV";
                            $contador++;
                        }
                        if ($fm[0]["IM"] == 1){
                            if ($contador > 0){ echo ", "; }
                            echo "ADMINISTRAÇÃO DE MEDICAMENTO - IM";
                            $contador++;
                        }
                        if ($fm[0]["SC"] == 1){
                            if ($contador > 0){ echo ", "; }
                            echo "ADMINISTRAÇÃO DE MEDICAMENTO - SC";
                            $contador++;
                        }
                        if ($fm[0]["CLISTER"] == 1){
                            if ($contador > 0){ echo ", "; }
                            echo "CLISTER EVACUATIVO";
                            $contador++;
                        }
                        if ($fm[0]["CURATIVO"] == 1){
                            if ($contador > 0){ echo ", "; }
                            echo "CURATIVO";
                            $contador++;
                        }
                        if ($fm[0]["CAT_ALIVIO"] == 1){
                            if ($contador > 0){ echo ", "; }
                            echo "CATETERISMO VESICAL DE ALIVIO";
                            $contador++;
                        }
                        if ($fm[0]["CAT_URINA"] == 1){
                            if ($contador > 0){ echo ", "; }
                            echo "CATETERISMO VESICAL DE COLETA DE URINA";
                            $contador++;
                        }
                        if ($fm[0]["CUID_GERAIS"] == 1){
                            if ($contador > 0){ echo ", "; }
                            echo "ORIENTAÇÃO P/ CUIDADOS GERAIS";
                            $contador++;
                        }
                        if ($fm[0]["ECG"] == 1){
                            if ($contador > 0){ echo ", "; }
                            echo "ECG";
                            $contador++;
                        }
                        if ($fm[0]["PUNCAO"] == 1){
                            if ($contador > 0){ echo ", "; }
                            echo "PUNÇÃO VENOSA";
                            $contador++;
                        }
                        if ($fm[0]["RET_PONTOS"] == 1){
                            if ($contador > 0){ echo ", "; }
                            echo "RETIRADA DE PONTOS";
                            $contador++;
                        }
                        if ($fm[0]["PROC_OUTROS"] != ""){
                            if ($contador > 0){ echo ", "; }
                            echo $fm[0]["PROC_OUTROS"];                            
                        }
                        ?>
                    </label>
                </div>
                <div class="row">
                    <label for="txtPaciente" class="col-sm-6 col-form-label">
                        <b>Materiais:</b><br/>
                        <?php 
                        $contador = 0;
                        if ($fm[0]["ABD_UNIT"] != ""){
                            echo $fm[0]["ABD_UNIT"] . " - ABD 10ml (unid)";
                            $contador++;
                        }
                        if ($fm[0]["ALGODAO_UNIT"] != ""){
                            if ($contador > 0){ echo ", "; }
                            echo $fm[0]["ALGODAO_UNIT"] . " - Algodão (unid)";
                            $contador++;
                        }
                        if ($fm[0]["AGULHA1_UNIT"] != ""){
                            if ($contador > 0){ echo ", "; }
                            echo $fm[0]["AGULHA1_UNIT"] . " - Agulha (unid)";
                            $contador++;
                        }
                        if ($fm[0]["AGULHA2_UNIT"] != ""){
                            if ($contador > 0){ echo ", "; }
                            echo $fm[0]["AGULHA1_UNIT"] . " - Agulha (unid)";
                            $contador++;
                        }
                        if ($fm[0]["CATETER_UNIT"] != ""){
                            if ($contador > 0){ echo ", "; }
                            echo $fm[0]["CATETER_UNIT"] . " - Cateter (unid)";
                            $contador++;
                        }
                        if ($fm[0]["EQUIPO_UNIT"] != ""){
                            if ($contador > 0){ echo ", "; }
                            echo $fm[0]["EQUIPO_UNIT"] . " - Equipo (unid)";
                            $contador++;
                        }
                        if ($fm[0]["EXTENSOR1_UNIT"] != ""){
                            if ($contador > 0){ echo ", "; }
                            echo $fm[0]["EXTENSOR1_UNIT"] . " - Extensor 1 via 10cm (unid)";
                            $contador++;
                        }
                        if ($fm[0]["EXTENSOR2_UNIT"] != ""){
                            if ($contador > 0){ echo ", "; }
                            echo $fm[0]["EXTENSOR2_UNIT"] . " - Extensor 2 vias (unid)";
                            $contador++;
                        }
                        if ($fm[0]["GAZE_AC_UNIT"] != ""){
                            if ($contador > 0){ echo ", "; }
                            echo $fm[0]["GAZE_AC_UNIT"] . " - Gaze acolchoada (unid)";
                            $contador++;
                        }
                        if ($fm[0]["GAZE_EM_UNIT"] != ""){
                            if ($contador > 0){ echo ", "; }
                            echo $fm[0]["GAZE_EM_UNIT"] . " - Gaze embebida (pct)";
                            $contador++;
                        }
                        if ($fm[0]["GAZE_ES_UNIT"] != ""){
                            if ($contador > 0){ echo ", "; }
                            echo $fm[0]["GAZE_ES_UNIT"] . " - Gaze estéril (unid)";
                            $contador++;
                        }
                        if ($fm[0]["HEPARINA_UNIT"] != ""){
                            if ($contador > 0){ echo ", "; }
                            echo $fm[0]["HEPARINA_UNIT"] . " - Heparina (ml)";
                            $contador++;
                        }
                        if ($fm[0]["IV_FIX_UNIT"] != ""){
                            if ($contador > 0){ echo ", "; }
                            echo $fm[0]["IV_FIX_UNIT"] . " - IV Fix (unid)";
                            $contador++;
                        }
                        if ($fm[0]["JELCO_UNIT"] != ""){
                            if ($contador > 0){ echo ", "; }
                            echo $fm[0]["JELCO_UNIT"] . " - Jelco (unid)";
                            $contador++;
                        }
                        if ($fm[0]["LAMINA_UNIT"] != ""){
                            if ($contador > 0){ echo ", "; }
                            echo $fm[0]["LAMINA_UNIT"] . " - Lâmina de Bisturi (unid)";
                            $contador++;
                        }
                        if ($fm[0]["LUVA_ES_UNIT"] != ""){
                            if ($contador > 0){ echo ", "; }
                            echo $fm[0]["LUVA_ES_UNIT"] . " - Luva estéril (par)";
                            $contador++;
                        }
                        if ($fm[0]["LUVA_PROC_UNIT"] != ""){
                            if ($contador > 0){ echo ", "; }
                            echo $fm[0]["LUVA_PROC_UNIT"] . " - Luva de Procedimento (par)";
                            $contador++;
                        }
                        if ($fm[0]["MASK_UNIT"] != ""){
                            if ($contador > 0){ echo ", "; }
                            echo $fm[0]["MASK_UNIT"] . " - Máscara (unid)";
                            $contador++;
                        }
                        if ($fm[0]["MICROPORE25_UNIT"] != ""){
                            if ($contador > 0){ echo ", "; }
                            echo $fm[0]["MICROPORE25_UNIT"] . " - Micropore 25x10 (cm)";
                            $contador++;
                        }
                        if ($fm[0]["MICROPORE50_UNIT"] != ""){
                            if ($contador > 0){ echo ", "; }
                            echo $fm[0]["MICROPORE50_UNIT"] . " - Micropore 50x10 (cm)";
                            $contador++;
                        }
                        if ($fm[0]["SCALP_UNIT"] != ""){
                            if ($contador > 0){ echo ", "; }
                            echo $fm[0]["SCALP_UNIT"] . " - Scalp (unid)";
                            $contador++;
                        }
                        if ($fm[0]["SERINGA1_UNIT"] != ""){
                            if ($contador > 0){ echo ", "; }
                            echo $fm[0]["SERINGA1_UNIT"] . " - Seringa (unid)";
                            $contador++;
                        }
                        if ($fm[0]["SERINGA2_UNIT"] != ""){
                            if ($contador > 0){ echo ", "; }
                            echo $fm[0]["SERINGA2_UNIT"] . " - Seringa (unid)";
                            $contador++;
                        }
                        if ($fm[0]["SERINGA3_UNIT"] != ""){
                            if ($contador > 0){ echo ", "; }
                            echo $fm[0]["SERINGA3_UNIT"] . " - Seringa (unid)";
                            $contador++;
                        }
                        if ($fm[0]["SERINGA4_UNIT"] != ""){
                            if ($contador > 0){ echo ", "; }
                            echo $fm[0]["SERINGA4_UNIT"] . " - Seringa (unid)";
                            $contador++;
                        }
                        if ($fm[0]["SF_UNIT"] != ""){
                            if ($contador > 0){ echo ", "; }
                            echo $fm[0]["SF_UNIT"] . " - SF 0,9% (unid)";
                            $contador++;
                        }
                        if ($fm[0]["MAT_OUTROS_UNIT"] != ""){
                            if ($contador > 0){ echo ", "; }
                            echo $fm[0]["MAT_OUTROS_UNIT"];
                            $contador++;
                        }
                        if ($fm[0]["ALCOOL_UNIT"] != ""){
                            if ($contador > 0){ echo ", "; }
                            echo $fm[0]["ALCOOL_UNIT"] . " - Álcool (unid)";
                            $contador++;
                        }
                        if ($fm[0]["ATADURA_UNIT"] != ""){
                            if ($contador > 0){ echo ", "; }
                            echo $fm[0]["ATADURA_UNIT"] . " - Atadura (rolo)";
                            $contador++;
                        }
                        if ($contador == 0){
                            echo "SEM USO DE MATERIAL";
                        }

                        ?>
                    </label>
                    <label for="txtPaciente" class="col-sm-6 col-form-label">
                        <b>Medicamento:</b><br/><?php echo $fm[0]["MEDICAMENTOS"] ?>
                    </label>  
                </div>
                
                <div class="row">
                    <label for="txtPaciente" class="col-sm-12 col-form-label">
                        <b>Evolução:</b><br/><?php echo $fm[0]["EVOLUCAO"] ?>
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