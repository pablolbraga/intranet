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

}