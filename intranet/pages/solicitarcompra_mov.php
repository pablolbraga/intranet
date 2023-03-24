<?php
require_once("../controllers/comprascontroller.php");
require_once('../helpers/funcoes.php');
require_once("../models/solicitacaocompramodel.php");

$ctrCompra = new ComprasController();
$funcao = new Funcoes();

if ($_REQUEST["tipo"] == "I"){

    if ($_POST["txtCodMatMedCad"] == ""){
        echo "Produto não selecionado."; exit();
    } else {

        $qrySolic = $ctrCompra->existeSolicitacaoPorStatus($_POST["txtCodMatMedCad"], "PENDENTE");
        $qtdSolic = count($qrySolic);

        if ($qtdSolic > 0){
            echo "Existe uma solicitação para este Item ainda PENDENTE! Favor verificar."; exit();
        } else {
            $qryComp = $ctrCompra->existeSolicitacaoPorStatus($_POST["txtCodMatMedCad"], "COMPRADO");
            $qtdComp = count($qryComp);

            if ($qtdComp > 0){
                echo "Já foi feito uma solicitação para este produto."; exit();
            } else {
                try{
                
                $solCompra = new SolicitacaoCompraModel();
                $solCompra->setFaltante(0);
                $solCompra->setIdmaterial($_POST["txtCodMatMedCad"]);
                $solCompra->setQuantidade($_POST["txtQuantidadeCad"]);
                $solCompra->setDatasolicitacao(date("d/m/Y H:i:s"));
                $solCompra->setDatanecessidadeinicio($_POST["txtDataNecessidadeCad"] == "" ? date('d/m/Y', strtotime("+7 days")) : $_POST["txtDataNecessidadeCad"]);
                $solCompra->setHoraprevista($_POST["txtHoraNecessidadeCad"] == "" ? date('H:i:s') : $_POST["txtHoraNecessidadeCad"] . ":00");
                $solCompra->setStatus("PENDENTE");
                $solCompra->setUrgencia($_POST["CmbUrgenciaCad"]);
                $solCompra->setIdusuario($_POST["txtIdUsuario"]);
                $ctrCompra->inserirSolicitacaoCompra($solCompra);

                $url = "
                <html>
                    <head>
                        <style type='text/css'>
                            .titulo_gg{	font-family: 'Myriad Pro' ,Arial, Helvetica, sans-serif; font-size: 25px; font-weight: normal; letter-spacing: 0.9px; white-space: nowrap; color: #0d4362; text-align: left; }
                            .cor1{ background: rgb(0, 153, 204); }
                            .cor2{ background: rgb(232, 250, 255); }
                            .fonte1{ font-family: Tahoma; color: #FFFFFF; font-weight: bold; vertical-align: middle; font-size: 10px; }
                            .fonte2{ font-family: Tahoma; color: #FFFFFF; font-weight: bold; vertical-align: middle; font-size: 14px; }
                            .label1{ font-family: Tahoma; color: rgb(51, 102, 153); font-weight: normal; vertical-align: middle; font-size: 14px; }
                        </style>
                    </head>
                    <body>
                        <table style='width=100%;'>
                            <tr>
                                <td colspan='2' style='width=100%;' class='titulo_gg'>SOLICITACAO DE COMPRA<hr></td>
                            </tr>
                            <tr>
                                <td style='width=50%;' class='cor1'><label class='fonte2'>Material:</label></td>
                                <td style='width=50%;' class='cor2'><label class='label1'>" . $_POST["txtCodMatMedCad"] ." - ". $_POST["txtDescMatMedCad"] . "</label></td>
                            </tr>      
                            <tr>
                                <td style='width=50%;' class='cor1'><label class='fonte2'>Quantidade:</label></td>
                                <td style='width=50%;' class='cor2'><label class='label1'>" . $_POST["txtQuantidadeCad"] . "</label></td>
                            </tr>
                            <tr>
                                <td style='width=50%;' valign='top' class='cor1'><label class='fonte2'>Data da Necessidade:</label></td>
                                <td style='width=50%;' class='cor2' valign='top'><label class='label1'>" . $_POST["txtDataNecessidadeCad"] == "" ? date('d/m/Y', strtotime("+7 days")) : $_POST["txtDataNecessidadeCad"] . "</label></td>
                            </tr>
                            <tr>
                                <td style='width=100%;' colspan='2'><i>Arquivo gerado em " . date("d/m/Y H:i:s") . "</i></td>
                            </tr>
                        </table>
                    </body>
                </html>";
                $funcao->enviarEmail("eliano@sauderesidence.com.br", "SOLICITACAO DE COMPRA", $url);
                echo "Incluído com sucesso."; exit();

                } catch(Exception $e){
                    echo "Erro ao solicitar a compra. Erro: " . $e->getMessage();
                }

            }
        }

    }

} else if ($_REQUEST["tipo"] == "A"){

    if ($_POST["cbxRecebido"] == "S"){

        $dadosNota = $ctrCompra->confereNotaFiscal($_POST["txtNotaFiscal"], $_POST["txtCodProduto"]);
        $qtdDadosNota = count($dadosNota);

        if ($qtdDadosNota > 0){
            $dadosDuplicata = $ctrCompra->verificarDuplicata($_POST["txtNotaFiscal"], $_POST["txtCodProduto"], $_POST["txtCodFornecedor"]);
            $qtdDadosDuplicata = count($dadosDuplicata);
            if ($qtdDadosDuplicata > 0){
                $ctrCompra->confirmarCompra(
                    $_POST["txtId"], 
                    $dadosDuplicata[0]["DTNOTAFISCAL"], 
                    $_POST["cbxConsignado"],
                    $dadosDuplicata[0]["IDNOTA"],
                    $dadosDuplicata[0]["QTD_TOTAL"]
                );

                $html = "
                <html>
                    <head>
                        <style type='text/css'>
                            .titulo_gg{	font-family: 'Myriad Pro' ,Arial, Helvetica, sans-serif; font-size: 25px; font-weight: normal; letter-spacing: 0.9px; white-space: nowrap; color: #0d4362; text-align: left; }
                            .cor1{ background: rgb(0, 153, 204); }
                            .cor2{ background: rgb(232, 250, 255); }
                            .fonte1{ font-family: Tahoma; color: #FFFFFF; font-weight: bold; vertical-align: middle; font-size: 10px; }
                            .fonte2{ font-family: Tahoma; color: #FFFFFF; font-weight: bold; vertical-align: middle; font-size: 14px; }
                            .label1{ font-family: Tahoma; color: rgb(51, 102, 153); font-weight: normal; vertical-align: middle; font-size: 14px; }
                        </style>
                    </head>
                    <body>
                        <table style='width=100%;'>
                            <tr>
                                <td colspan='2' style='width=100%;' class='titulo_gg'>SOLICITAÇÃO DE COMPRA RECEBIDA<hr></td>
                            </tr>
                            <tr>
                                <td style='width=50%;' class='cor1'><label class='fonte2'>Material:</label></td>
                                <td style='width=50%;' class='cor2'><label class='label1'>" . $_POST["txtDescProduto"] . "</label></td>
                            </tr>      
                            <tr>
                                <td style='width=50%;' class='cor1'><label class='fonte2'>Quantidade:</label></td>
                                <td style='width=50%;' class='cor2'><label class='label1'>" . $_POST["txtQuantidadeComprada"]  . "</label></td>
                            </tr>
                            <tr>
                                <td style='width=50%;' valign='top' class='cor1'><label class='fonte2'>Valor:</label></td>
                                <td style='width=50%;' class='cor2' valign='top'><label class='label1'>" . $_POST["txtValorCompra"] . "</label></td>
                            </tr>
                            <tr>
                                <td style='width=50%;' valign='top' class='cor1'><label class='fonte2'>Fornecedor:</label></td>
                                <td style='width=50%;' class='cor2' valign='top'><label class='label1'>" . $_POST["txtDescFornecedor"] . "</label></td>
                            </tr>
                            <tr>
                                <td style='width=100%;' colspan='2'><i>Arquivo gerado em " . date("d/m/Y H:i:s") . "</i></td>
                            </tr>
                        </table>
                    </body>
                </html>
                ";

                $funcao->enviarEmail("eliano@sauderesidence.com.br", "SOLICITAÇÃO DE COMPRA RECEBIDA", $html);
                echo "Incluído com sucesso."; exit();
            } else {
                echo "Nota fiscal já registrada para este mesmo produto e com mesmo fornecedor. Favor verificar em produtos recebidos."; exit();
            }
        } else {
            echo "Dados não conferem. Favor informar item a ser verificado."; exit();
        }

    } else {

        $ctrCompra->cancelarCompra($_POST["txtId"], $_POST["txtObservacao"]);
        $html = "
        <html>
            <head>
                <style type='text/css'>
                    .titulo_gg{	font-family: 'Myriad Pro' ,Arial, Helvetica, sans-serif; font-size: 25px; font-weight: normal; letter-spacing: 0.9px; white-space: nowrap; color: #0d4362; text-align: left; }
                    .cor1{ background: rgb(0, 153, 204); }
                    .cor2{ background: rgb(232, 250, 255); }
                    .fonte1{ font-family: Tahoma; color: #FFFFFF; font-weight: bold; vertical-align: middle; font-size: 10px; }
                    .fonte2{ font-family: Tahoma; color: #FFFFFF; font-weight: bold; vertical-align: middle; font-size: 14px; }
                    .label1{ font-family: Tahoma; color: rgb(51, 102, 153); font-weight: normal; vertical-align: middle; font-size: 14px; }
                </style>
            </head>
            <body>
                <table style='width=100%;'>
                    <tr>
                        <td colspan='2' style='width=100%;' class='titulo_gg'>SOLICITAÇÃO DE COMPRA NÃO RECEBIDA<hr></td>
                    </tr>
                    <tr>
                        <td style='width=50%;' class='cor1'><label class='fonte2'>Material:</label></td>
                        <td style='width=50%;' class='cor2'><label class='label1'>" . $_POST["txtDescProduto"] . "</label></td>
                    </tr>      
                    <tr>
                        <td style='width=50%;' class='cor1'><label class='fonte2'>Quantidade:</label></td>
                        <td style='width=50%;' class='cor2'><label class='label1'>" . $_POST["txtQuantidadeComprada"]  . "</label></td>
                    </tr>
                    <tr>
                        <td style='width=50%;' valign='top' class='cor1'><label class='fonte2'>Valor:</label></td>
                        <td style='width=50%;' class='cor2' valign='top'><label class='label1'>" . $_POST["txtValorCompra"] . "</label></td>
                    </tr>
                    <tr>
                        <td style='width=50%;' valign='top' class='cor1'><label class='fonte2'>Fornecedor:</label></td>
                        <td style='width=50%;' class='cor2' valign='top'><label class='label1'>" . $_POST["txtDescFornecedor"] . "</label></td>
                    </tr>
                    <tr>
                        <td style='width=100%;' colspan='2'><i>Arquivo gerado em " . date("d/m/Y H:i:s") . "</i></td>
                    </tr>
                </table>
            </body>
        </html>
        ";
        $funcao->enviarEmail("eliano@sauderesidence.com.br", "SOLICITAÇÃO DE COMPRA NÃO RECEBIDA", $html);
        echo "Incluído com sucesso."; exit();
    }
}