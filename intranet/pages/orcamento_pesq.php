<?php
require_once("../controllers/orcamentocontroller.php");
require_once("../controllers/textocontroller.php");
$ctrOrcamento = new OrcamentoController();
$ctrTexto = new TextoController();

$idOrcamento = $_POST["txtCodOrcamento"];
$qry = $ctrOrcamento->buscarPorId($idOrcamento);

if (count($qry) > 0){
    $idConvenio = $qry[0]["IDCONVENIO"];
    ?>
    <html>
        <head>
        </head>
        <body>
            <form name="form1" id="form1" method="POST" action="orcamento_imp.php">
                <table style="width: 100%">
                    <tr>
                        <td style="width: 15%; text-align: center">
                            <img src="../imgs/logo_completa.png" width="200" height="80" />
                        </td>
                        <td style="width: 70%; text-align: center; font-size: 20;">
                            <b>Orçamento</b>
                            <?php
                            if ($qry[0]["TIPO"] == "ADT"){
                                echo "<b> - Aditivo</b>";
                            }
                            ?>
                            <br>
                            <b>Convênio: <?php echo $qry[0]["NMCONVENIO"] ?></b>  
                        </td>
                        <td style="width: 15%; text-align: center; font-size: 20;">
                            <input type="hidden" name="cbxAditivo" value="<?php echo $qry[0]["TIPO"] == "ADT" ? "S" : "N" ?>" />
                            <input type="hidden" name="txtOrcamento" value="<?php echo $_POST["txtCodOrcamento"] ?>" />
                        </td>
                    </tr>
                </table>

                <br />
                <br />

                <table style="width: 100%;">
                    <tr>
                        <td style="width: 100%;">
                            <b>Paciente: <?php echo $qry[0]["NMPACIENTE"] ?></b>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 100%;">
                            <b>Endereco: <?php echo $qry[0]["ENDERECO"] ?></b>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 100%;">
                            <b>Convênio: <?php echo $qry[0]["NMCONVENIO"] ?> - Nível de Complexidade: <?php echo $qry[0]["NIVELCOMPLEXIDADE"] ?></b>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 100%;">
                            <b>Período: <?php echo $qry[0]["DIAS"] ?> dia(s), de <?php echo $qry[0]["DTINICIOORC"] ?> até <?php echo $qry[0]["DTFIMORC"] ?></b>
                        </td>
                    </tr>
                </table>

                <br />
                <br />

                <?php
                if ($qry[0]["TIPO"] == "ADT"){
                    ?>
                    <table style="width: 100%;">
                        <tr>
                            <td style="width: 100%;">
                                <b>PLANO DE ATENÇÃO DOMICILIAR<br/>
                                <?php
                                $descritivo = $ctrTexto->retornarTextoLongoIw($qry[0]["IDTEXT"]);
                                echo nl2br($descritivo); 
                                ?>
                            </td>
                        </tr>
                    </table>

                    <br />
                    <br />
                    <?php
                } else {
                    ?>
                    <table style="width: 100%;">
                        <tr>
                            <td style="width: 100%;">
                                <b>PLANO DE ATENÇÃO DOMICILIAR<br/>
                                <?php
                                echo nl2br($qry[0]["OBS"]);
                                ?>
                                </b>
                            </td>
                        </tr>
                    </table>
                    <br />
                    <br />
                    <?php
                }
                ?>
                <table style="width: 100%;">
                    <tr>
                        <td style="width: 100%; text-align: center;">
                            Paciente: <?php echo $qry[0]["NMPACIENTE"] ?> - Orçamento: <?php echo $_POST["txtCodOrcamento"] ?> - Nro. Atend: <?php echo $qry[0]["IDADMISSION"] ?>
                        </td>
                    </tr>
                </table>

                <table style="width: 100%;" border="1">
                    <tr style="background: silver; font-weight: bold; font-size: 12;">
                        <td style="text-align: center;"></td>
                        <td style="text-align: center;">Nome do Item</td>
                        <td style="text-align: center;">Qtde</td>
                        <td style="text-align: center;">Valor Unitário</td>
                        <td style="text-align: center;">Incluso na Diária</td>
                        <td style="text-align: center;">Desconto %</td>
                        <td style="text-align: center;">Total R$</td>
                        <td style="text-align: center;">Tabela Preço</td>
                        <td style="text-align: center;">TUSS</td>
                        <td style="text-align: center;">TISS</td>
                    </tr>
                    <?php
                    $categoria = "";
                    $subtotal = 0;
                    $submedia = 0;
                    $somatotal = 0;
                    $somamedia = 0;

                    for($i = 0; $i < count($qry); $i++){
                        $subtotal = $subtotal + ($qry[$i]["VRTOTAL"] - ($qry[$i]["VRTOTAL"] * ($qry[$i]["VRDESCONTO"] / 100)));
                        $submedia = $submedia + $qry[$i]["VRTOTALDIA"];

                        if ($qry[$i]["IDCONVENIO"] == ""){
                            $idConvenio = 0;
                        } else {
                            $idConvenio = $qry[$i]["IDCONVENIO"];
                        }

                        if ($categoria != $qry[$i]["NMTABLE"]){
                            // Verifica Se Tem codigo Especifico para o grupo
                            $tissGrupo = "";
                            if ( $qry[$i]["IDTABLE"] == 55  && $qry[$i]["TISSGRPMED"] != ""){ // Medicamento
                                $tissGrupo = " (" . $qry[$i]["TISSGRPMED"] . ") ";
                            } else if ( $qry[$i]["IDTABLE"] == 56  && $qry[$i]["TISSGRPMAT"] != ""){ // Material
                                $tissGrupo = " (" . $qry[$i]["TISSGRPMAT"] . ") ";
                            } else {
                                $tissGrupo = "";
                            }

                            ?>
                            <tr style="background: #DADADA; font-weight: bold; font-size: 12; ">
                                <td colspan="10"><?php echo $qry[$i]["NMTABLE"] . $tissGrupo ?></td>
                            </tr>
                            <?php
                        }

                        $qryTissTuss = $ctrOrcamento->buscarCodigoTissTuss($qry[$i]["CODPRODUTO"], $qry[$i]["IDCONVENIO"]);
                        $tiss = "";
                        $tuss = "";
                        for($t = 0; $t < count($qryTissTuss); $t++){
                            if ($qryTissTuss[$t]["TISS"] != ""){
                                $tiss .= $qryTissTuss[$t]["TISS"] . " ";
                            }

                            if ($qryTissTuss[$t]["TUSS"] != ""){
                                $tuss .= $qryTissTuss[$t]["TUSS"] . " ";
                            }
                        }

                        ?>
                        <tr style="font-size: 8;">
                            <td style="text-align: center">
                                <?php
                                if ($qry[$i]["AUTORIZACAOINTERNA"] == 1 ){
                                    ?>
                                    <input type="checkbox" name="cbxSelecionado<?php echo $i ?>" value="S" />
                                    <input type="hidden" name="txtSelecionado<?php echo $i ?>" value="S" />
                                    <?php
                                } else {
                                    ?>
                                    <input type="hidden" name="txtSelecionado<?php echo $i ?>" value="N" />
                                    &nbsp;
                                    <?php
                                }
                                ?>
                            </td>
                            <td><?php echo $qry[$i]["NMPRODUTO"] ?></td>
                            <td style="text-align: center;"><?php echo $qry[$i]["QTDE"] . " " . $qry[$i]["UNIDMED"] ?></td>
                            <td style="text-align: right;"><?php echo number_format($qry[$i]["VRUNITARIO"], 2, ',', '.') ?></td>
                            <td style="text-align: center;"><?php echo $qry[$i]["QTDENOPACOTE"] ?></td>
                            <td style="text-align: right;"><?php echo number_format($qry[$i]["VRDESCONTO"], 2, ',', '.') ?></td>                                
                            <td style="text-align: right;"><?php echo number_format($qry[$i]["VRTOTAL"] - ($qry[$i]["VRTOTAL"] * ($qry[$i]["VRDESCONTO"] / 100)), 2, ',', '.') ?></td>
                            <td style="text-align: center;"><?php echo $qry[$i]["NMTABPRECO"] ?></td>
                            <td style="text-align: center;"><?php echo $tuss ?></td>
                            <td style="text-align: center;"><?php echo $tiss ?></td>
                        </tr>
                        <?php
                        @$categoria = $qry[$i]["NMTABLE"];
                        if (@$categoria != @$qry[$i+1]["NMTABLE"]){
                            ?>
                            <tr style="background: #DADADA; font-weight: bold; font-size: 12;">
                                <td colspan="10">
                                    Subtotal: <?php echo $qry[$i]["NMTABLE"] . " R$ = " . number_format($subtotal, 2, ',', '.') . " - Média / Diária R$ = " . number_format(($subtotal / $qry[0]["DIAS"]), 2, ',', '.') ?>                                        
                                </td>
                            </tr>                                
                            <?php
                            $subtotal = 0;
                            $submedia = 0;
                        }
                        $somatotal = $somatotal + ($qry[$i]["VRTOTAL"] - ($qry[$i]["VRTOTAL"] * ($qry[$i]["VRDESCONTO"] / 100)));
                        $somamedia = $somamedia + $qry[$i]["VRTOTALDIA"];
                    }
                    ?>
                </table>

                <br />
                <br />

                <table style="width: 100%;" border="1">
                    <tr>
                        <td style="width: 100%;">
                            <br />
                            *Custo médio diário: R$ <?php echo number_format(($somatotal / $qry[0]["DIAS"]), 2, ',', '.') ?>
                            <br />
                            <br />
                            *Valor total do orçamento para <?php echo $qry[0]["DIAS"] ?> dias = R$ <?php echo number_format($somatotal, 2, ',', '.') ?>
                            <br />
                            <br />
                            <br /> 
                            <br />
                            <table style="width: 100%;">
                                <tr>
                                    <td style="width: 50%; text-align: center;">
                                        <b>Maria Elisangela Matos de Sousa<br />Gerente de Enfermagem - COREN 73670</b> 
                                    </td>
                                    <td style="width: 50%; text-align: center;">
                                        <b>Marcelo Maranhão Filho<br />Diretor Técnico - CREMEC 12742</b> 
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <table style="width: 100%">
                    <tr>
                        <td style="width: 100%; text-align: center;">
                            <input type="submit" name="btnImprimir" value="Imprimir" class="botao" />
                        </td>
                    </tr>
                </table>
            </form>
        </body>
    </html>
    <?php
} else {
    ?>
    <script>
        alert('Código do orçamento/anexo não encontrado.');
        location.href='index.php?pag=6';
    </script>
    <?php
}
?>
