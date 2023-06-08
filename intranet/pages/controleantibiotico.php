<?php
require_once("../controllers/ccidcontroller.php");

$ctrCcid = new CcidController();

$arrStatus = array(
    array("ID" => "0", "NOME" => "SELECIONE"),
    array("ID" => "E", "NOME" => "ENCERRADO"),
    array("ID" => "P", "NOME" => "EM PROCESSO"),
    array("ID" => "S", "NOME" => "SUSPENSO")
);

$arrTipoPad = array(
    array("ID" => "", "NOME" => "SELECIONE"),
    array("ID" => "DESLOCAMENTO", "NOME" => "DESLOCAMENTO"),
    array("ID" => "INTERNAÇÃO DOMICILIAR", "NOME" => "INTERNAÇÃO DOMICILIAR"),
    array("ID" => "PLANTÃO 06H", "NOME" => "PLANTÃO 06H"),
    array("ID" => "PLANTÃO 12H", "NOME" => "PLANTÃO 12H"),
    array("ID" => "PLANTÃO 24H", "NOME" => "PLANTÃO 24H")
);

$arrOrigemInfeccao = array(
    array("ID" => "", "NOME" => "SELECIONE"),
    array("ID" => "COMUNITARIA", "NOME" => "COMUNITÁRIA"),
    array("ID" => "COMUNITARIA-SR", "NOME" => "COMUNITÁRIA-SR"),
    array("ID" => "HOSPITALAR", "NOME" => "HOSPITALAR")
);

$arrTipoInfeccao = array(
    array("ID" => "", "NOME" => "SELECIONE"),
    array("ID" => "INFECÇÃO AUDITIVA", "NOME" => "INFECÇÃO AUDITIVA"),
    array("ID" => "INFECÇÃO DE PELE", "NOME" => "INFECÇÃO DE PELE"),
    array("ID" => "INFECÇÃO DO TRATO URINÁRIO", "NOME" => "INFECÇÃO DO TRATO URINÁRIO"),
    array("ID" => "INFECÇÃO GASTRO-INTESTINAL", "NOME" => "INFECÇÃO GASTRO-INTESTINAL"),
    array("ID" => "INFECÇÃO GINECOLOGICA", "NOME" => "INFECÇÃO GINECOLÓGICA"),
    array("ID" => "INFECÇÃO NEOPLASICA", "NOME" => "INFECÇÃO NEOPLÁSICA"),
    array("ID" => "INFECÇÃO NEUROLOGICA", "NOME" => "INFECÇÃO NEUROLÓGICA"),
    array("ID" => "INFECÇÃO OCULAR", "NOME" => "INFECÇÃO OCULAR"),
    array("ID" => "INFECÇÃO OSSEA", "NOME" => "INFECÇÃO OSSEA"),
    array("ID" => "INFECÇÃO RESPIRATÓRIA", "NOME" => "INFECÇÃO RESPIRATÓRIA")
);

$liberaExclusao = "NAO";
if ($_SESSION["UGB_USUARIO"] == "CISID"){
    $liberaExclusao = "SIM";
} else if ($_SESSION["UGB_USUARIO"] == "COORDENAÇÃO DE ENFERMAGEM"){
    $liberaExclusao = "SIM";
} else if ($_SESSION["UGB_USUARIO"] == "ESCALAS"){
    $liberaExclusao = "SIM";
} else if ($_SESSION["UGB_USUARIO"] == "SECRETARIA MEDICA"){
    $liberaExclusao = "SIM";
}  else if ($_SESSION["ADM_USUARIO"] == "S"){
    $liberaExclusao = "SIM";
}
?>

<html lang="pt">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../css/dt/dataTables.bootstrap5.min.css" rel="stylesheet" />
        <link href="../css/dt/buttons.dataTables.min.css" rel="stylesheet" />
        <script>
            function limparPacientePesq(){
                document.getElementById("txtCodPacientePesq").value = "";
                document.getElementById("txtDescPacientePesq").value = "";
            }

            function limparPacienteCad(){
                document.getElementById("txtCodPaciente").value = "";
                document.getElementById("txtDescPaciente").value = "";
            }

            function formatar(src, mask){
                var i = src.value.length;
                var saida = mask.substring(i,i+1);
                var ascii = event.keyCode;
                if (saida == "A"){
                    if ((ascii >=97) && (ascii <= 122)){
                        event.keyCode -= 32;
                    } else {
                        event.keyCode = 0;
                    }
                } else if (saida == "0"){
                    if ((ascii >= 48) && (ascii <= 57)){
                        return
                    } else {
                        event.keyCode = 0
                    }
                } else if (saida == "#"){
                    return;
                } else {
                    src.value += saida;
                    if (saida == "A") {
                        if ((ascii >=97) && (ascii <= 122)) { 
                            event.keyCode -= 32; 
                        }
                    } else { 
                        return; 
                    }
                }
            }
            
        function somentenumero(evt) {
            var theEvent = evt || window.event;
            var key = theEvent.keyCode || theEvent.which;
            key = String.fromCharCode( key );
            //var regex = /^[0-9.,]+$/;
            var regex = /^[0-9.]+$/;
            if( !regex.test(key) ) {
                theEvent.returnValue = false;
                if(theEvent.preventDefault) theEvent.preventDefault();
            }
        }

        </script>
    </head>
    <body>
        <div class="container-fluid">
            <nav class="navbar navbar-extends-lg navbar-dark bg-primary">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">Controle de Antibiótico</a>
                    <div class="btn-group dropstart">
                        <button type="button" class="btn btn-success btn-sm" onclick="abrirSolicitacaoAntibiotico()">Adicionar</button>
                    </div>
                </div>
            </nav>

            <br/>

            <form name="frmSolicitarAntibiotico" id="frmSolicitarAntibiotico" method="POST" action="index.php?pag=10">
                <div class="row">
                    <label for="txtCodPacientePesq" class="col-sm-2 col-form-label">Paciente:</label>
                    <div class="col-sm-2">
                        <div class="input-group">
                            <input type="text" id="txtCodPacientePesq" name="txtCodPacientePesq" class="form-control form-control-sm" aria-label="" aria-describedby="btnPesqMatMedPesq" readonly="readonly" value="<?php echo @$_POST["txtCodPacientePesq"] ?>" style="text-align: right;" required>
                            <button class="btn btn-outline-secondary btn-sm" type="button" id="btnPesqPacientePesq" onclick="window.open('busca.php?tipo=4&campocodigo=txtCodPacientePesq&campodescricao=txtDescPacientePesq&title=Pesquisar Paciente','','width=900, height=500')">...</button>
                        </div>
                    </div>
                    <div class="col-sm-7">
                        <input type="text" id="txtDescPacientePesq" name="txtDescPacientePesq" class="form-control form-control-sm" value="<?php echo @$_POST["txtDescPacientePesq"] ?>" readonly="readonly"/>
                    </div>
                    <div class="col-sm-1">
                        <button type="button" class="btn btn-primary btn-sm" id="btnLimparPacientePesq" name="btnLimparPacientePesq" onclick="limparPacientePesq()">Limpar</button>
                    </div>
                </div>
                <div class="row">
                    <label for="txtDataInicioPesq" class="col-sm-2 col-form-label">Período:</label>
                    <div class="col-sm-2">
                        <input type="text" id="txtDataInicioPesq" name="txtDataInicioPesq" class="form-control form-control-sm" value="<?php echo @$_POST["txtDataInicioPesq"] ?>" placeholder="dd/mm/yyyy" onkeypress="mascaraData(this)" required/>
                    </div>
                    <div class="col-sm-2">
                        <input type="text" id="txtDataFimPesq" name="txtDataFimPesq" class="form-control form-control-sm" value="<?php echo @$_POST["txtDataFimPesq"] ?>" placeholder="dd/mm/yyyy" onkeypress="mascaraData(this)" required/>
                    </div>
                </div>
                <div class="row">
                    <label for="cmbStatusPesq" class="col-sm-2 col-form-label">Status:</label>
                    <div class="col-sm-2">
                        <select class="form-select form-select-sm" id="cmbStatusPesq" name="cmbStatusPesq">
                            <?php
                            for($lt = 0; $lt < count($arrStatus); $lt++){
                                if ($arrStatus[$lt]["ID"] == $_POST["cmbStatusPesq"]){ $selStatusPesq = "selected"; } else { $selStatusPesq = ""; }
                                ?>
                                <option <?php echo $selStatusPesq ?> value="<?php echo $arrStatus[$lt]["ID"] ?>"><?php echo $arrStatus[$lt]["NOME"] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2">
                        <button type="submit" class="btn btn-primary btn-sm" id="btnPesquisar" name="btnPesquisar">Pesquisar</button>
                    </div>
                </div>
                <?php
                if (isset($_POST["btnPesquisar"])){
                    
                    $qry = $ctrCcid->listarControleAtb($_POST["txtDataInicioPesq"], $_POST["txtDataFimPesq"], $_POST["txtCodPacientePesq"], $_POST["cmbStatusPesq"]);
                    $qtd = count($qry);

                    if ($qtd > 0){
                        ?>
                        <br/>
                        <table id="example" class="table table-bordered table-sm" style="width:100%">
                            <thead>
                                <tr class="align-middle">
                                    <th style="display: none;">Codigo</th>
                                    <th style="display: none;">IdAdmission</th>
                                    <th>Paciente</th>
                                    <th>Tipo Pad</th>
                                    <th>Antimicrobiano</th>
                                    <th>Origem Infecção</th>
                                    <th>Justificativa</th>
                                    <th>Obs</th>
                                    <th>Dias</th>
                                    <th>Data Inicio ATB</th>
                                    <th>Data Fim ATB</th>
                                    <th>Exame</th>
                                    <th>Resultado</th>
                                    <th>Particular ou Operadora</th>
                                    <th style="display: none;">Status</th>
                                    <th style="display: none;">Dose</th>
                                    <th style="display: none;">Antimicrobiano</th>
                                    <th style="display: none;">Intervalo</th>
                                    <th style="display: none;">Via</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $atrasado = 0;
                                for ($i = 0; $i < $qtd; $i++){
                                    if ($qry[$i]["STATUS"] == "E"){ // ENCERRADO
                                        if ($qry[$i]["DATA_FINALIZADO_FORMAT"] <= $qry[$i]["DATA_ATB_PRAZO_FORMAT"]){
                                            $classe = "<tr class='align-middle'>";
                                        } else {
                                            $classe = "<tr class='align-middle table-dark'>";
                                            $atrasado++;
                                        }
                                    } else if ($qry[$i]["STATUS"] == "S"){ // SUSPENSO
                                        $classe = "<tr class='align-middle'>";
                                    } else if ($qry[$i]["STATUS"] == "P"){
                                        $hoje = date("YmdHis");
                                        if ($hoje <= $qry[$i]["DATA_ATB_PRAZO_FORMAT"]){
                                            $classe = "<tr class='align-middle table-success'>";
                                        } else {
                                            $classe = "<tr class='align-middle table-dark'>";
                                            $atrasado++;
                                        }
                                    } else if( $qry[$i]["DATA_ATB_FIM_FORMAT"] <=  date("YmdHis") AND $qry[$i]["FINALIZADO"] == "N" ){
                                        //$classe = "corPreto labelwhite";
                                        $classe = "<tr class='align-middle table-dark'>";
                                        $atrasado++;
                                    } else {
                                        $classe = "<tr class='align-middle'>";
                                    }
                                    echo $classe;
                                    ?>
                                        <td style="display: none;"><?php echo $qry[$i]["ID"] ?></td>
                                        <td style="display: none;"><?php echo $qry[$i]["IDADMISSION"] ?></td>
                                        <td><?php echo $qry[$i]["NOME_PACIENTE"] ?></td>
                                        <td><?php echo $qry[$i]["TIPO_PAD"] ?></td>
                                        <td><?php echo $qry[$i]["ANTIMICROBIANO"] . " - " . $qry[$i]["DOSE"] . " - " . $qry[$i]["INTERVALO"] . " - " . $qry[$i]["VIA"] ?></td>
                                        <td><?php echo $qry[$i]["ORIG_INFEC"] ?></td>
                                        <td><?php echo $qry[$i]["MOTIVO"] ?></td>
                                        <td><?php echo $qry[$i]["OBS"] ?></td>
                                        <td><?php echo $qry[$i]["DIAS"] ?></td>
                                        <td><?php echo $qry[$i]["DATA_ATB_INI"] . " " . $qry[$i]["HORA_ATB_INI"] ?></td>
                                        <td><?php echo $qry[$i]["DATA_ATB_FIM"] . " " . $qry[$i]["HORA_ATB_FIM"] ?></td>
                                        <td><?php echo $qry[$i]["EXAME"] ?></td>
                                        <td><?php echo $qry[$i]["RESULTADO"] ?></td>
                                        <td><?php echo $qry[$i]["EMPRESA"] ?></td>
                                        <td style="display: none;"><?php echo $qry[$i]["STATUS"] ?></td>
                                        <td style="display: none;"><?php echo $qry[$i]["DOSE"] ?></td>
                                        <td style="display: none;"><?php echo $qry[$i]["ANTIMICROBIANO"] ?></td>
                                        <td style="display: none;"><?php echo $qry[$i]["INTERVALO"] ?></td>
                                        <td style="display: none;"><?php echo $qry[$i]["VIA"] ?></td>
                                        <?php
                                        if ($liberaExclusao == "SIM"){
                                            ?>
                                            <td>
                                                <a href="#" class="btn btn-success btn-sm" onclick="alterarSolicitacaoAntibiotico(this)">Alterar</a>
                                                <a href="#" class="btn btn-danger btn-sm" onclick="javascript: if (confirm('Deseja excluir o registro?')) abrirExclusaoAntibiotico(this)">Excluir</a>
                                            </td>
                                            <?php
                                        }
                                        ?>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                        <?php
                    } else {
                        ?>
                        <br />
                        <div class="alert alert-danger" role="alert">
                            Nenhum registro encontrado com os parâmetros informados.
                        </div>
                        <?php
                    }
                }
                ?>
            </form>
        </div>

        <div class="modal fade" id="modalSolicitarAntibiotico" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Controle de Antibiótico</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="formAdicionarAntibiotico" method="POST">
                        <input type="hidden" id="txtCodigo" name="txtCodigo" />
                        <div class="modal-body">
                            <div class="row">
                                <label for="txtCodPaciente" class="col-sm-2 col-form-label">Paciente:</label>
                                <div class="col-sm-2">
                                    <div class="input-group">
                                        <input type="text" id="txtCodPaciente" name="txtCodPaciente" class="form-control form-control-sm" aria-label="" aria-describedby="btnPesqPaciente" readonly="readonly" style="text-align: right;" required>
                                        <button class="btn btn-outline-secondary btn-sm" type="button" id="btnPesqPaciente" onclick="window.open('busca.php?tipo=3&campocodigo=txtCodPaciente&campodescricao=txtDescPaciente&title=Pesquisar Paciente','','width=900, height=500')">...</button>
                                    </div>
                                </div>
                                <div class="col-sm-7">
                                    <input type="text" id="txtDescPaciente" name="txtDescPaciente" class="form-control form-control-sm" readonly="readonly"/>
                                </div>
                                <div class="col-sm-1">
                                    <button type="button" class="btn btn-primary btn-sm" id="btnLimparPaciente" name="btnLimparPaciente" onclick="limparPacienteCad()">Limpar</button>
                                </div>
                            </div>
                            <div class="row">
                                <label for="cmbTipoPad" class="col-sm-2 col-form-label">Tipo de PAD:</label>
                                <div class="col-sm-2">
                                    <select class="form-select form-select-sm" id="cmbTipoPad" name="cmbTipoPad">
                                        <?php
                                        for($tp = 0; $tp < count($arrTipoPad); $tp++){
                                            if ($arrTipoPad[$tp]["ID"] == $_POST["cmbTipoPad"]){ $selTipoPad = "selected"; } else { $selTipoPad = ""; }
                                            ?>
                                            <option <?php echo $selTipoPad ?> value="<?php echo $arrTipoPad[$tp]["ID"] ?>"><?php echo $arrTipoPad[$tp]["NOME"] ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <label for="cmbOrigemInfeccao" class="col-sm-2 col-form-label">Origem da Infeção:</label>
                                <div class="col-sm-2">
                                    <select class="form-select form-select-sm" id="cmbOrigemInfeccao" name="cmbOrigemInfeccao">
                                        <?php
                                        for($oi = 0; $oi < count($arrOrigemInfeccao); $oi++){
                                            if ($arrOrigemInfeccao[$oi]["ID"] == $_POST["cmbOrigemInfeccao"]){ $selOrigemInfeccao = "selected"; } else { $selOrigemInfeccao = ""; }
                                            ?>
                                            <option <?php echo $selOrigemInfeccao ?> value="<?php echo $arrOrigemInfeccao[$oi]["ID"] ?>"><?php echo $arrOrigemInfeccao[$oi]["NOME"] ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <label for="cmbStatus" class="col-sm-2 col-form-label">Status:</label>
                                <div class="col-sm-2">
                                    <select class="form-select form-select-sm" id="cmbStatus" name="cmbStatus">
                                        <?php
                                        for($st = 0; $st < count($arrStatus); $st++){
                                            if ($arrStatus[$st]["ID"] == $_POST["cmbStatus"]){ $selStatus = "selected"; } else { $selStatus = ""; }
                                            ?>
                                            <option <?php echo $selStatus ?> value="<?php echo $arrStatus[$st]["ID"] ?>"><?php echo $arrStatus[$st]["NOME"] ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <label for="txtAntimicrobiano" class="col-sm-2 col-form-label">Antimicrobiano:</label>
                                <div class="col-sm-4">
                                    <input type="text" id="txtAntimicrobiano" name="txtAntimicrobiano" class="form-control form-control-sm" />
                                </div> 
                                <label for="cmbTipoInfeccao" class="col-sm-2 col-form-label">Tipo de Infecção:</label>
                                <div class="col-sm-4">
                                    <select class="form-select form-select-sm" id="cmbTipoInfeccao" name="cmbTipoInfeccao">
                                        <?php
                                        for($ti = 0; $ti < count($arrTipoInfeccao); $ti++){
                                            if ($arrTipoInfeccao[$ti]["ID"] == $_POST["cmbTipoInfeccao"]){ $selTipoInfeccao = "selected"; } else { $selTipoInfeccao = ""; }
                                            ?>
                                            <option <?php echo $selTipoInfeccao ?> value="<?php echo $arrTipoInfeccao[$ti]["ID"] ?>"><?php echo $arrTipoInfeccao[$ti]["NOME"] ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>                                    
                            </div>
                            <div class="row">
                                <label for="txtObservacao" class="col-sm-2 col-form-label">Observação:</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control form-control-sm" id="txtObservacao" name="txtObservacao" style="height: 100px" maxlength="500" required></textarea>
                                </div>                                
                            </div>
                            <div class="row">
                                <label for="txtDose" class="col-sm-2 col-form-label">Dose:</label>
                                <div class="col-sm-4">
                                    <input type="text" id="txtDose" name="txtDose" class="form-control form-control-sm" />
                                </div>
                                <label for="txtIntervalo" class="col-sm-2 col-form-label">Intervalo:</label>
                                <div class="col-sm-4">
                                    <input type="text" id="txtIntervalo" name="txtIntervalo" class="form-control form-control-sm" />
                                </div>  
                            </div>
                            <div class="row">
                                <label for="txtVia" class="col-sm-2 col-form-label">Via:</label>
                                <div class="col-sm-4">
                                    <input type="text" id="txtVia" name="txtVia" class="form-control form-control-sm" />
                                </div>
                                <label for="txtDia" class="col-sm-2 col-form-label">Dias:</label>
                                <div class="col-sm-4">
                                    <input type="text" id="txtDia" name="txtDia" class="form-control form-control-sm" onkeypress="return somentenumero()" />
                                </div>  
                            </div>
                            <div class="row">
                                <label for="txtDataInicio" class="col-sm-2 col-form-label">Data/Hora Inicial:</label>
                                <div class="col-sm-4">
                                    <input type="text" id="txtDataInicio" name="txtDataInicio" class="form-control form-control-sm" onkeypress="formatar(this, '##/##/#### ##:##')" maxlength="16" placeholder="DD/MM/YYYY HH:MM" />
                                </div>
                                <label for="txtDataFim" class="col-sm-2 col-form-label">Data/Hora Final:</label>
                                <div class="col-sm-4">
                                    <input type="text" id="txtDataFim" name="txtDataFim" class="form-control form-control-sm" onkeypress="formatar(this, '##/##/#### ##:##')" maxlength="16" placeholder="DD/MM/YYYY HH:MM"/>
                                </div>
                            </div>
                            <div class="row">
                                <label for="txtExame" class="col-sm-2 col-form-label">Exame:</label>
                                <div class="col-sm-4">
                                    <input type="text" id="txtExame" name="txtExame" class="form-control form-control-sm" />
                                </div>
                                <label for="txtResultado" class="col-sm-2 col-form-label">Resultado:</label>
                                <div class="col-sm-4">
                                    <input type="text" id="txtResultado" name="txtResultado" class="form-control form-control-sm" />
                                </div>  
                            </div>
                            <small>
                                <div id="mensagem" align="center"></div>
                            </small>                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="btn-fechar-solicitar" name="btn-fechar-solicitar" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Sair</button>
                            <button type="submit" id="btn-gravar-solicitar" name="btn-gravar-solicitar" class="btn btn-primary btn-sm">Gravar</button>
                        </div>
                    </form>                               
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalExcluirAntibiotico" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Controle de Antibiótico - Exclusão</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="formExcluirAntibiotico" method="POST">
                        <input type="hidden" id="txtCodigoExc" name="txtCodigoExc" />
                        <input type="hidden" id="txtUsuarioExc" name="txtUsuarioExc" value="<?php echo $_SESSION["ID_USUARIO"] ?>" />
                        <div class="modal-body">
                            <div class="row">
                                <label for="txtMotivoExc" class="col-sm-2 col-form-label">Motivo da Exclusão:</label>
                                <div class="col-sm-10">
                                    <input type="text" id="txtMotivoExc" name="txtMotivoExc" class="form-control form-control-sm" />
                                </div>                                
                            </div>
                            <small>
                                <div id="mensagem-exc" align="center"></div>
                            </small>                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="btn-fechar-solicitar-exc" name="btn-fechar-solicitar-exc" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Sair</button>
                            <button type="submit" id="btn-gravar-solicitar-exc" name="btn-gravar-solicitar-esc" class="btn btn-primary btn-sm">Excluir</button>
                        </div>
                    </form>                               
                </div>
            </div>
        </div>
    </body>
</html>

<script>
    function limparCamposCadastro(){
        $("#txtCodigo").val("0");
        $("#txtCodPaciente").val("");
        $("#txtDescPaciente").val("");
        $("#cmbTipoPad").val("");
        $("#cmbOrigemInfeccao").val("");
        $("#cmbStatus").val("");
        $("#txtAntimicrobiano").val("");
        $("#cmbTipoInfeccao").val("");
        $("#txtObservacao").val("");
        $("#txtDose").val("");
        $("#txtIntervalo").val("");
        $("#txtVia").val("");
        $("#txtDia").val("");
        $("#txtDataInicio").val("");
        $("#txtDataFim").val("");
        $("#txtExame").val("");
        $("#txtResultado").val("");
    }

    function abrirSolicitacaoAntibiotico(){
        limparCamposCadastro();
        $("#mensagem").text("");
        $("#mensagem").removeClass();

        var myModal = new bootstrap.Modal(document.getElementById("modalSolicitarAntibiotico"), {});
        myModal.show();
    }

    function alterarSolicitacaoAntibiotico(linha){
        var tableData = $(linha).closest("tr").find("td:not(:last-child)").map(function(){
            return $(this).text().trim();
        }).get();

        //console.log(tableData);
        $("#txtCodigo").val(tableData[0]);
        $("#txtCodPaciente").val(tableData[1]);
        $("#txtDescPaciente").val(tableData[2]);
        $("#cmbTipoPad").val(tableData[3]);
        $("#cmbOrigemInfeccao").val(tableData[5]);
        $("#cmbStatus").val(tableData[14]);
        $("#txtAntimicrobiano").val(tableData[16]);
        $("#cmbTipoInfeccao").val(tableData[6]);
        $("#txtObservacao").val(tableData[7]);
        $("#txtDose").val(tableData[15]);
        $("#txtIntervalo").val(tableData[17]);
        $("#txtVia").val(tableData[18]);
        $("#txtDia").val(tableData[8]);
        $("#txtDataInicio").val(tableData[9]);
        $("#txtDataFim").val(tableData[10]);
        $("#txtExame").val("");
        $("#txtResultado").val("");


        $("#mensagem").text("");
        $("#mensagem").removeClass();

        var myModal = new bootstrap.Modal(document.getElementById("modalSolicitarAntibiotico"), {});
        myModal.show();
    }

    $("#formAdicionarAntibiotico").submit(function(){
        event.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "controleantibiotico_mov.php?tipo=I",
            type: "POST",
            data: formData, 

            success: function(mensagem){
                $("#mensagem").text("");
                $("#mensagem").removeClass();
                if (mensagem.trim() == "Incluído com sucesso."){
                    window.location.reload(true);
                    $("#btn-fechar-solicitar").click();                            
                } else {
                    $("#mensagem").addClass("text-danger")
                    $("#mensagem").text(mensagem);
                }
            },

            cache: false,
            contentType: false,
            processData: false,
        });
    });

    function abrirExclusaoAntibiotico(linha){
        var tableData = $(linha).closest("tr").find("td:not(:last-child)").map(function(){
            return $(this).text().trim();
        }).get();

        $("#txtCodigoExc").val(tableData[0]);
        $("#txtMotivoExc").val("");
        $("#mensagem-exc").text("");
        $("#mensagem-exc").removeClass();

        var myModal = new bootstrap.Modal(document.getElementById("modalExcluirAntibiotico"), {});
        myModal.show();
    }

    $("#formExcluirAntibiotico").submit(function(){
        event.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "controleantibiotico_mov.php?tipo=E",
            type: "POST",
            data: formData, 

            success: function(mensagem){
                $("#mensagem-exc").text("");
                $("#mensagem-exc").removeClass();
                if (mensagem.trim() == "Excluído com sucesso."){
                    window.location.reload(true);
                    $("#btn-fechar-solicitar").click();                            
                } else {
                    $("#mensagem-exc").addClass("text-danger")
                    $("#mensagem-exc").text(mensagem);
                }
            },

            cache: false,
            contentType: false,
            processData: false,
        });
    });

    $(document).ready(function () {
        $('#example').DataTable({
            language: {
                lengthMenu: 'Mostrar _MENU_ registros por página',
                zeroRecords: 'Nada encontrado - desculpe',
                info: 'Mostrando página _PAGE_ de _PAGES_',
                infoEmpty: 'Nenhum registro disponível',
                infoFiltered: '(filtrado de _MAX_ tegistros totais)',
                search: 'Procurar',
                paginate: {
                    "next": "Próximo",
                    "previous": "Anterior",
                    "first": "Primeiro",
                    "last": "Último"
                }
            },
        });
    });
</script>