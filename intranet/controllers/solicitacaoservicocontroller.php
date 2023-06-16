<?php
require_once("../conexao/conexao.php");
require_once("../models/solicitacaomatmedmodel.php");
require_once("../controllers/usuariocontroller.php");
require_once("../controllers/admissaocontroller.php");
require_once("../helpers/funcoes.php");
require_once("../controllers/basicocontroller.php");

class SolicitacaoServicoController{

    private $conn;
    private $ctrUsuario;
    private $ctrAdmission;
    private $funcao;
    private $ctrBasico;

    public function __construct(){
        $this->conn = Conexao::getInstance();
        $this->ctrUsuario = new UsuarioController();
        $this->ctrAdmission = new AdmissaoController();
        $this->funcao = new Funcoes();
        $this->ctrBasico = new BasicoController();
    }

    public function incluir(SolicitacaoMatMedModel $c){

        try{

            $sql = "INSERT INTO SR_SOLICITACAO_MATMED (
                        IDUSU_SOLIC, DATA_SOLIC, DATA_MAXIMA, IDPACIENTE, OBSERVACAO_SOLIC, 
                        STATUS, PEDIDO_SEMANAL, INCLUSAO_PRESCRICAO, ENFERMEIRA, JUSTIFICATIVA, 
                        STATUS_CASE, TIPO_PEDIDOS, STATUS_ALT_PRESC, TIPO_ALT_PRESC
                    ) VALUES (
                        :IDUSU_SOLIC, TO_DATE('" . $c->getDatasolicitacao() . "','DD/MM/YYYY HH24:MI:SS'), TO_DATE('" . $c->getDatamaxima() . "','DD/MM/YYYY HH24:MI:SS'), :IDPACIENTE, :OBSERVACAO_SOLIC, 
                        :STATUS, :PEDIDO_SEMANAL, :INCLUSAO_PRESCRICAO, :ENFERMEIRA, :JUSTIFICATIVA, 
                        :STATUS_CASE, :TIPO_PEDIDOS, :STATUS_ALT_PRESC, :TIPO_ALT_PRESC
                    )";
            $qry = $this->conn->prepare($sql);
            $qry->bindValue(":IDUSU_SOLIC", $c->getIdusuariosolicitante());
            $qry->bindValue(":IDPACIENTE", $c->getIdpaciente());
            $qry->bindValue(":OBSERVACAO_SOLIC", $c->getObservacao());
            $qry->bindValue(":STATUS", "S");
            $qry->bindValue(":PEDIDO_SEMANAL", $c->getPedidosemanal());
            $qry->bindValue(":INCLUSAO_PRESCRICAO", $c->getInclusaoprescricao());
            $qry->bindValue(":ENFERMEIRA", $c->getIdenfermeiro());
            $qry->bindValue(":JUSTIFICATIVA", $c->getJustificativa());
            $qry->bindValue(":STATUS_CASE", "S");
            $qry->bindValue(":TIPO_PEDIDOS", $c->getTipopedido());
            $qry->bindValue(":STATUS_ALT_PRESC", $c->getStatus());
            $qry->bindValue(":TIPO_ALT_PRESC", $c->getTipo());
            $qry->execute();

            $dadosUsuarioSolicitante = $this->ctrUsuario->buscarPorId($c->getIdusuariosolicitante());
            $dadosAdmissao = $this->ctrAdmission->retornarDadosPorIdPatient($c->getIdpaciente());

            $html = "
            <html>
                <head>
                    <style type='text/css'>
                        .titulo_gg{
                            font-family: 'Myriad Pro' ,Arial, Helvetica, sans-serif;
                            font-size: 25px;
                            font-weight: normal; 
                            letter-spacing: 0.9px; 
                            white-space: nowrap; 
                            color: #0d4362; 
                            text-align: left;
                        }
                        .cor1{ 
                            background: rgb(0, 153, 204); 
                        }
                        .cor2{ 
                            background: rgb(232, 250, 255); 
                        }
                        .fonte1{ 
                            font-family: Tahoma; 
                            color: #FFFFFF; 
                            font-weight: bold; 
                            vertical-align: middle; 
                            font-size: 10px; 
                        }
                        .fonte2{ 
                            font-family: Tahoma; 
                            color: #FFFFFF; 
                            font-weight: bold; 
                            vertical-align: middle; 
                            font-size: 14px; 
                        }
                        .label1{ 
                            font-family: Tahoma; 
                            color: rgb(51, 102, 153); 
                            font-weight: normal; 
                            vertical-align: middle; 
                            font-size: 14px; 
                        }
                    </style>
                </head>
                <body>
                    <table style='width=100%;'>
                        <tr>
                            <td style='width=50%;' class='cor1'>
                                <label class='fonte2'>Solicitante:</label>
                            </td>
                            <td style='width=50%;' class='cor2'>
                                <label class='label1'>" . $dadosUsuarioSolicitante[0]["NOME"]  . "</label>
                            </td>
                        </tr>
                        <tr>
                            <td style='width=50%;' class='cor1'>
                                <label class='fonte2'>Paciente:</label>
                            </td>
                            <td style='width=50%;' class='cor2'>
                                <label class='label1'>" . $dadosAdmissao[0]["NMPACIENTE"] . "</label>
                            </td>
                        </tr>
                        <tr>
                            <td style='width=50%;' class='cor1'>
                                <label class='fonte2'>Tipo da Solicitação:</label>
                            </td>
                            <td style='width=50%;' class='cor2'>
                                <label class='label1'>" . $c->getPedidosemanal() . "</label>
                            </td>
                        </tr>
                        <tr>
                            <td style='width=50%;' class='cor1'>
                                <label class='fonte2'>Inclusão na Prescrição:</label>
                            </td>
                            <td style='width=50%;' class='cor2'>
                                <label class='label1'>" . $c->getInclusaoprescricao() . "</label>
                            </td>
                        </tr>
                        <tr>
                            <td style='width=50%;' class='cor1'>
                                <label class='fonte2'>Data da Solicitação:</label>
                            </td>
                            <td style='width=50%;' class='cor2'>
                                <label class='label1'>" . $c->getDatasolicitacao() . "</label>
                            </td>
                        </tr>
                        <tr>
                            <td style='width=50%;' class='cor1'>
                                <label class='fonte2'>Data Máxima:</label>
                            </td>
                            <td style='width=50%;' class='cor2'>
                                <label class='label1'>" . $c->getDatamaxima() . "</label>
                            </td>
                        </tr>
                        <tr>
                            <td style='width=50%;' class='cor1'>
                                <label class='fonte2'>Observação:</label>
                            </td>
                            <td style='width=50%;' class='cor2'>
                                <label class='label1'>" . $c->getObservacao() . "</label>
                            </td>
                        </tr>
                        <tr>
                            <td style='width=100%;' colspan='2'>
                                <i>Acessar à intranet para dar baixa na solicitação.</i>
                            </td>
                        </tr>
                    </table>
                </body>
            </html>
            ";
            
            $listaEmail = $this->ctrBasico->listarEmailsPorCategoria("SOLICITAÇÃO MAT/MED/EQUIP");
            for ($i = 0; $i < count($listaEmail); $i++){
                $this->funcao->enviarEmail($listaEmail[$i]["EMAIL"], "SOLICITAÇÃO MAT/MED/EQUIP", $html);
            }
            echo "Incluído com sucesso.";
            exit();

        } catch(Exception $e){
            echo "Erro ao adicionar a solicitação. Erro: " . $e->getMessage() . "\n" . $sql;
        }

    }

    public function listar($dataini, $datafim, $idpaciente, $idenfermeiro, $tipo, $inclusaoprescricao, $justificativa, $idsolicitante = ""){

        $sql = "
            SELECT 
                DISTINCT 
                S.ID,
                USUSOLIC.NOME AS NMSOLICITANTE, 
                PF.NAME AS NMPACIENTE, 
                PFPROF.NAME AS NMENFERMEIRA, 
                S.OBSERVACAO_SOLIC, 
                S.OBSERVACAO_BAIXA, 
                TO_CHAR(S.DATA_SOLIC, 'DD/MM/YYYY HH24:MI:SS') AS DATA_SOLIC,
                TO_CHAR(S.DATA_MAXIMA, 'DD/MM/YYYY HH24:MI:SS') AS DATA_MAXIMA,
                TO_CHAR(S.DATA_BAIXA, 'DD/MM/YYYY HH24:MI:SS') AS DATA_BAIXA, 
                (CASE S.PEDIDO_SEMANAL WHEN 'SIM' THEN 'SEMANAL' WHEN 'NAO' THEN 'EXTRA' WHEN 'ROT' THEN 'ROTINA' ELSE '' END) AS PEDIDO_SEMANAL, 
                S.INCLUSAO_PRESCRICAO, 
                S.JUSTIFICATIVA, 
                UB.NOME AS NMUSUBAIXA,
                S.STATUS
            FROM 
                SR_SOLICITACAO_MATMED S 
                INNER JOIN SR_USUARIO USUSOLIC ON USUSOLIC.IDUSUARIO = S.IDUSU_SOLIC 
                INNER JOIN CAPADMISSION ADM ON ADM.IDPATIENT = S.IDPACIENTE 
                INNER JOIN GLBPATIENT PAT ON PAT.ID = ADM.IDPATIENT 
                INNER JOIN GLBPERSON PF ON PF.ID = PAT.IDPERSON 
                INNER JOIN GLBPERSON PFPROF ON PFPROF.ID = S.ENFERMEIRA 
                LEFT JOIN SR_USUARIO UB ON UB.IDUSUARIO = S.IDUSU_BAIXA 
            WHERE 
                S.DATA_SOLIC BETWEEN TO_DATE(:DATAINI, 'DD/MM/YYYY HH24:MI:SS') AND TO_DATE(:DATAFIM, 'DD/MM/YYYY HH24:MI:SS') 
                AND S.IDUSU_EXC IS  NULL
            ";
        if ($idpaciente != ""){
            $sql .= "AND S.IDPACIENTE = :IDPACIENTE ";
        }
        if ($idenfermeiro != ""){
            $sql .= "AND S.ENFERMEIRA = :IDENFERMEIRA ";
        }
        if ($tipo != ""){
            $sql .= "AND S.PEDIDO_SEMANAL = :TIPO ";
        }
        if ($inclusaoprescricao != ""){
            $sql .= "AND S.INCLUSAO_PRESCRICAO = :INCPRESC ";
        }
        if ($justificativa != ""){
            $sql .= "AND S.JUSTIFICATIVA = :JUSTIFICATIVA ";
        }
        if ($idsolicitante != ""){
            $sql .= "AND S.IDUSU_SOLIC = :IDUSUSOLIC ";
        }
        $sql .= "ORDER BY ID";

        $qry = $this->conn->prepare($sql);
        $qry->bindValue(":DATAINI",  $dataini . " 00:00:00");
        $qry->bindValue(":DATAFIM",  $datafim . " 23:59:59");
        if ($idpaciente != ""){
            $qry->bindValue(":IDPACIENTE", $idpaciente);
        }
        if ($idenfermeiro != ""){
            $qry->bindValue(":IDENFERMEIRA", $idenfermeiro);
        }
        if ($tipo != ""){
            $qry->bindValue(":TIPO", $tipo);
        }
        if ($inclusaoprescricao != ""){
            $qry->bindValue(":INCPRESC", $inclusaoprescricao);
        }
        if ($justificativa != ""){
            $qry->bindValue(":JUSTIFICATIVA", $justificativa);
        }
        if ($idsolicitante != ""){
            $qry->bindValue(":IDUSUSOLIC", $idsolicitante);
        }
        $qry->execute();
        $res = $qry->fetchAll(PDO::FETCH_ASSOC);
        return $res;

    }

    public function listarTriagemPrioridade($dataInicio, $dataFim, $situacao, $pedidoSemanal, $idEnfermeira, $justificativa){

        $sql = "SELECT 
                    DISTINCT 
                    S.ID
                    , U.NOME AS NMSOLICITANTE
                    , P.NAME AS NMPACIENTE 
                    , S.TIPO_PEDIDOS 
                    , S.JUSTIFICATIVA 
                    , TO_CHAR(S.DATA_SOLIC,'DD/MM/YYYY HH24:MI:SS') AS DATA_SOLIC 
                    , TO_CHAR(S.DATA_MAXIMA,'DD/MM/YYYY HH24:MI:SS') AS DATA_MAXIMA
                    , UB.NOME AS NMUSUBAIXA
                    , TO_CHAR(S.DATA_BAIXA,'DD/MM/YYYY HH24:MI:SS') AS DATA_BAIXA
                    , (SELECT NOME FROM SR_USUARIO WHERE IDUSUARIO = IDUSU_BAIXA_PRIORIDADE) AS NMPRIORIDADE 
                    , TO_CHAR(S.DATA_BAIXA_PRIORIDADE, 'DD/MM/YYYY HH24:MI:SS') AS DATA_BAIXA_PRIORIDADE 
                    , (SELECT NOME FROM SR_USUARIO WHERE IDUSUARIO = IDUSU_BAIXA_LOGIS) AS NMLOGISTICA 
                    , TO_CHAR(S.DATA_BAIXA_LOGIS, 'DD/MM/YYYY HH24:MI:SS') AS DATA_BAIXA_LOGIS 
                    , (SELECT NOME FROM SR_USUARIO WHERE IDUSUARIO = IDUSU_BAIXA_MOTORISTA) AS NMMOTORISTA 
                    , TO_CHAR(S.DATA_BAIXA_MOTORISTA, 'DD/MM/YYYY HH24:MI:SS') AS DATA_BAIXA_MOTORISTA 
                    , S.STATUS
                    , S.PRIORIDADE 
                    , S.OBSERVACAO_SOLIC 
                    , S.IDMOTATRASO 
                    , S.OBSERVACAO_BAIXA AS OBS_AUTORIZACAO
                    , S.OBS_BAIXA_LOGIS AS OBS_LOGISTICA 
                    , MOT.OBS_INICIOATEND AS OBS_INICIOATENDIMENTOSUPRI 
                    , MOT.OBS_RETORNO AS OBS_FINALATENDIMENTOSUPRI 
                    , S.PEDIDO_SEMANAL
                FROM 
                    SR_SOLICITACAO_MATMED S 
                    INNER JOIN SR_USUARIO U ON U.IDUSUARIO = S.IDUSU_SOLIC 
                    INNER JOIN GLBPATIENT G ON G.ID = S.IDPACIENTE 
                    INNER JOIN GLBPERSON P ON P.ID = G.IDPERSON 
                    LEFT JOIN SR_USUARIO UB ON UB.IDUSUARIO = S.IDUSU_BAIXA 
                    LEFT JOIN SR_ROTA_MOTORISTA MOT ON MOT.IDSOLICITACAO = S.ID 
                WHERE 
                    S.IDUSU_EXC IS NULL ";
        if ($dataInicio != ""){
            $sql .= "AND S.DATA_SOLIC >= TO_DATE(:DATAINICIO, 'DD/MM/YYYY HH24:MI:SS') ";
        }
        if ($dataFim != ""){
            $sql .= "AND S.DATA_SOLIC <= TO_DATE(:DATAFIM, 'DD/MM/YYYY HH24:MI:SS') ";
        }
        if ($situacao != ""){
            $sql .= "AND S.STATUS = :SITUACAO ";
        }
        if ($pedidoSemanal != ""){
            $sql .= "AND S.PEDIDO_SEMANAL = :PEDIDOSEMANAL ";
        }
        if ($idEnfermeira != ""){
            $sql .= "AND S.ENFERMEIRA = :IDENFERMEIRA ";
        }
        if ($justificativa != ""){
            $sql .= "AND S.JUSTIFICATIVA = :JUSTIFICATIVA ";
        }
        $sql .= "
                ORDER BY 
                    S.PRIORIDADE
                    , TO_CHAR(S.DATA_MAXIMA,'DD/MM/YYYY HH24:MI:SS')";
        $qry = $this->conn->prepare($sql);
        if ($dataInicio != ""){
            $qry->bindValue(":DATAINICIO", $dataInicio . " 00:00:00");
        }
        if ($dataFim != ""){
            $qry->bindValue(":DATAFIM", $dataFim . " 23:59:59");
        }
        if ($situacao != ""){
            $qry->bindValue(":SITUACAO", $situacao);
        }
        if ($pedidoSemanal != ""){
            $qry->bindValue(":PEDIDOSEMANAL", $pedidoSemanal);
        }
        if ($idEnfermeira != ""){
            $qry->bindValue(":IDENFERMEIRA", $idEnfermeira);
        }
        if ($justificativa != ""){
            $qry->bindValue(":JUSTIFICATIVA", $justificativa);
        }
        $qry->execute();
        $res = $qry->fetchAll(PDO::FETCH_ASSOC);
        return $res;

    }

    public function excluirSolicitacaoTriagem($id, $motivo, $observacao, $status, $idUsuario){

        $sql = "UPDATE 
                    SR_SOLICITACAO_MATMED 
                SET 
                    STATUS = :STATUS
                    , MOTIVO_EXC = :MOTIVO
                    , OBS_EXC = :OBSERVACAO
                    , IDUSU_EXC = :IDUSUARIO
                    , DATA_EXC = TO_DATE('" . date("d/m/Y H:i:s") . "','DD/MM/YYYY HH24:MI:SS') 
                WHERE 
                    ID = :ID";
        $qry = $this->conn->prepare($sql);
        $qry->bindValue(":STATUS", $status);
        $qry->bindValue(":MOTIVO", $motivo);
        $qry->bindValue(":OBSERVACAO", $observacao);
        $qry->bindValue(":IDUSUARIO", $idUsuario);
        $qry->bindValue(":ID", $id);
        $qry->execute();

        $sql2 = "UPDATE 
                    SR_ROTA_MOTORISTA 
                SET 
                    STATUS = :STATUS
                    , OBSEXC = :OBSERVACAO
                    , IDUSU_EXC = :IDUSUARIO
                    , DATAEXC = TO_DATE('" . date("d/m/Y H:i:s") . "','DD/MM/YYYY HH24:MI:SS') 
                WHERE 
                    IDSOLICITACAO = :ID";
        $qry2 = $this->conn->prepare($sql2);
        $qry2->bindValue(":STATUS", $status);
        $qry2->bindValue(":OBSERVACAO", $observacao);
        $qry2->bindValue(":IDUSUARIO", $idUsuario);
        $qry2->bindValue(":ID", $id);
        $qry2->execute();

    } 
    
    public function realizarBaixaPrioridade($idUsuario, $prioridade, $idSolicitacao){

        $dataSolicitada = date("d/m/Y H:i:s");

        $sql = "UPDATE 
                    SR_SOLICITACAO_MATMED 
                SET 
                    IDUSU_BAIXA_PRIORIDADE = :IDUSUARIO 
                    , DATA_BAIXA_PRIORIDADE = TO_DATE('" . $dataSolicitada . "','DD/MM/YYYY HH24:MI:SS') 
                    , PRIORIDADE = :PRIORIDADE 
                    , STATUS = 'BF' 
                WHERE 
                    ID = :ID";
        $qry = $this->conn->prepare($sql);
        $qry->bindValue(":IDUSUARIO", $idUsuario);
        $qry->bindValue(":IDPRIORIDADE", $prioridade);
        $qry->bindValue(":ID", $idSolicitacao);
        $qry->execute();

        $dataSeparacao = explode(" ", $dataSolicitada);
        $data = $dataSeparacao[0];
        $hora = $dataSeparacao[1];

        // Separa a data em dia, mes e ano
        $arrData = explode("/", $data);
        // Separa a hora em hora, minuto e segundo
        $arrHora = explode(":", $hora);

        // adiciona as horas a data
        

        // Prioridades
        // 1: Vermelho - 2 Horas
        // 2: Laranja - 6 Horas
        // 3: Amarelo - 8 Horas
        // 4: Verde - 24 Horas
        // 5: Azul - Prazo normal (7 DIAS)
        // 6: Rosa - 30min
        // 7: Cinza - 4 horas
        // 8: Lilas - 36 horas
        // 9: Azul Claro - 2 horas

        $addmin = 0;
        if ($prioridade == 1) $add = 2; // Vermelho
        else if ($prioridade == 2) $add = 6; // Laranja
        else if ($prioridade == 3) $add = 8; // Amarelo Chamado n. 3895 - Solicitante pediu para mudar o tempo de 12 para 8
        else if ($prioridade == 4) $add = 24; // Verde
        else if ($prioridade == 5) $add = 168; // Azul
        else if ($prioridade == 6) $addmin = 30; // Rosa
        else if ($prioridade == 7) $add = 6; // Cinza
        else if ($prioridade == 8) $add = 72; // Lilás Chamado n. 12205 - Solicitação de 36 para 72h o prazo.
        else if ($prioridade == 9) $add = 2; // Azul Claro
        else $add = 0;

        $resultado = date("d/m/Y H:i:s", mktime($arrHora[0] + $add, $arrHora[1] + $addmin, $arrHora[2], $data[1], $data[0], $data[2]));

        $sql2 = "UPDATE 
                    SR_SOLICITACAO_MATMED 
                SET 
                    DATA_MAXIMA = TO_DATE('" . $resultado . "','DD/MM/YYYY HH24:MI:SS') 
                WHERE 
                    ID = :ID";
        $qry2 = $this->conn->prepare($sql2);
        $qry2->bindValue(":ID", $idSolicitacao);
        $qry2->execute();


        $sql3 = "UPDATE 
                    SR_ROTA_MOTORISTA 
                SET 
                    DATAMAXIMA = TO_DATE('" . $resultado . "','DD/MM/YYYY HH24:MI:SS') 
                WHERE 
                    IDSOLICITACAO = :ID";
        $qry3 = $this->conn->prepare($sql3);
        $qry3->bindValue(":ID", $idSolicitacao);
        $qry3->execute();

    }

}