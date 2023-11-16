<?php
require_once("../controllers/financeirocontroller.php");
require_once("../controllers/emailscontroller.php");
require_once("../models/notafiscalmodel.php");
require_once("../helpers/funcoes.php");

$funcao = new Funcoes();
$ctrFinanceiro = new FinanceiroController();
$ctrEmails = new EmailsController();
$c = new NotaFiscalModel();


if ($_REQUEST["tipo"] == "X"){

    try{
        $ctrFinanceiro->excluirSolicitacaoNota($_POST["txtCodigoExc"], $_POST["txtIdUsuarioExc"], $_POST["txtObservacaoExc"]);
        echo "Incluído com sucesso."; exit();
    } catch(Exception $e){
        echo "Erro ao registrar a nota. Erro: " . $e->getMessage();
    }

} else {

    if ($_REQUEST["tipo"] == "N"){

        try{
            $c->setCodigo(date("YmdHisu"));
            $c->setUsuarioSolic($_POST["txtIdUsuario"]);
            $c->setDataSolic(date("d/m/Y H:i:s"));
            $c->setIdPartConv($_POST["txtCodPaciente"]);
            $c->setObsSolic($_POST["txtObservacao"]);
            $c->setValor(str_replace(",", ".", $_POST["txtValor"]));
            $c->setTipo($_REQUEST["tipo"]);
            $ctrFinanceiro->validaDadosNotaFiscal($c);        

        } catch(Exception $e){
            echo "Erro ao registrar a nota. Erro: " . $e->getMessage(); exit();
        }

    } else {

        try{        
            $c->setCodigo($_POST["txtCodigoAlt"]);
            $c->setIdPartConv($_POST["txtCodPacienteAlt"]);
            $c->setObsSolic($_POST["txtObservacaoAlt"]);
            $ctrFinanceiro->validaDadosNotaFiscal($c);

        } catch(Exception $e){
            echo "Erro ao registrar a nota. Erro: " . $e->getMessage(); exit();
        }

    }

    $dadosNota = $ctrFinanceiro->buscarSolicitacaoNotaPorId($c->getCodigo());

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
                    <td colspan='2' style='width=100%;' class='titulo_gg'>
                        <img src='../imgs/logo_completa.png' width='294' height='84' /><br>";
                        if ($dadosNota[0]["TIPO"] == "N" ){
                            $url .= "Solicitação de Recibos e/ou Notas Fiscais<hr>";
                        } else {
                            $url .= "Solicitação de Baixa de Pagamento<hr>";
                        }
                        $url .= "
                    </td>
                </tr>
                <tr>
                    <td style='width=50%;' class='cor1'><label class='fonte2'>Solicitante:</label></td>
                    <td style='width=50%;' class='cor2'><label class='label1'>" . $dadosNota[0]["NMSOLICITANTE"] . "</label></td>
                </tr>
                <tr>
                    <td style='width=50%;' class='cor1'><label class='fonte2'>Data da Solicitação:</label></td>
                    <td style='width=50%;' class='cor2'><label class='label1'>" . $dadosNota[0]["DATA_SOLICITACAO"] . "</label></td>
                </tr>
                <tr>
                    <td style='width=50%;' class='cor1'><label class='fonte2'>Paciente ou Convênio:</label></td>
                    <td style='width=50%;' class='cor2'><label class='label1'>" . $dadosNota[0]["NMPACCONV"] . "</label></td>
                </tr>
                <tr>
                    <td style='width=50%;' class='cor1'><label class='fonte2'>Observação:</label></td>
                    <td style='width=50%;' class='cor2'><label class='label1'>" . $dadosNota[0]["OBS_SOLIC"] . "</label></td>
                </tr>
                <tr>
                    <td style='width=100%;' colspan='2'><i>Acessar à intranet para dar baixa no procedimento.</i></td>
                </tr>
            </table>
        </body>
    </html>
    ";

    $assunto = "";
    $tipoPendencia = 0;
    if ($dadosNota[0]["TIPO"] == "N" ){
        $assunto .= "Solicitação de Recibos e/ou Notas Fiscais<hr>";
        $tipoPendencia = 9;
    } else {
        $assunto .= "Solicitação de Baixa de Pagamento<hr>";
        $tipoPendencia = 11;
    }

    $listaEmail = $ctrEmails->listarEmailsPorTipoPendencia($tipoPendencia);
    for ($i = 0; $i < count($listaEmail); $i++){
        $funcao->enviarEmail($listaEmail[$i]["EMAIL"], $assunto, $url);
    }


    echo "Incluído com sucesso."; exit();

}
?>