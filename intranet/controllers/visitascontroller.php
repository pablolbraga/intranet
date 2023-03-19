<?php
require_once("../conexao/conexao.php");
require_once("../models/consultamodel.php");
require_once("../helpers/funcoes.php");

class VisitasController{

    private $conn;
    private $funcao;

    public function __construct(){
        $this->conn = Conexao::getInstance();
        $this->funcao = new Funcoes();
    }

    public function listarAgendamento($idProfessional, $idEspecialidade, $dataInicio, $dataFim){

        $sql = "select 
                    age.id, age.idprofessional, pfprof.name as nmprofessional, prof.scspeciality as idespecialidade, 
                    scesp.codename as nmespecialidade, age.agendastartdate, cc.idadmission, pfadm.name as nmpaciente, 
                    cc.idevolution, to_char(age.agendastartdate, 'dd/mm/yyyy') as data,  to_char(age.agendastartdate, 'hh24:mi:ss') as hora, 
                    to_char(age.agendastartdate, 'yyyymmdd') as ordenacaodata, cc.id as idcapconsult, 
                    to_char(age.agendastartdate, 'dd/mm/yyyy hh24:mi:ss') as dataagendainicio,  
                    to_char(age.agendaenddate, 'dd/mm/yyyy hh24:mi:ss') as dataagendafim 
                from 
                    capprofagenda age 
                    inner join glbprofessional prof on prof.idperson = age.idprofessional and prof.active = 1
                    inner join glbperson pfprof on pfprof.id = prof.idperson 
                    inner join scccode scesp on scesp.id = prof.scspeciality 
                    left join capconsult cc on cc.idprofagenda = age.id 
                    left join capadmission adm on adm.id = cc.idadmission 
                    left join glbpatient pat on pat.id = adm.idpatient 
                    left join glbperson pfadm on pfadm.id = pat.idperson 
                where
                    age.agendastartdate between TO_DATE(:DATAINICIO, 'DD/MM/YYYY HH24:MI:SS') and TO_DATE(:DATAFIM,'DD/MM/YYYY HH24:MI:SS') ";
        if ($idProfessional != ""){
            $sql .= "AND AGE.IDPROFESSIONAL = :IDPROFESSIONAL ";
        }
        if ($idEspecialidade != ""){
            $sql .= "AND PROF.SCSPECIALITY = :IDESPECIALIDADE ";
        }
        $sql .= "order by 
            ordenacaodata, pfprof.name, hora";
        $qry = $this->conn->prepare($sql);
        $qry->bindValue(":DATAINICIO", $dataInicio . " 00:00:00");
        $qry->bindValue(":DATAFIM", $dataFim . " 23:59:59");
        if ($idProfessional != ""){
            $qry->bindValue(":IDPROFESSIONAL", $idProfessional);
        }
        if ($idEspecialidade != ""){
            $qry->bindValue(":IDESPECIALIDADE", $idEspecialidade);
        }
        $qry->execute();
        $res = $qry->fetchAll(PDO::FETCH_ASSOC);
        return $res;

    }

    public function excluirConsulta($idCapConsult){

        $sql = "DELETE FROM CAPCONSULT WHERE ID = :IDCAPCONSULT";
        $qry = $this->conn->prepare($sql);
        $qry->bindValue(":IDCAPCONSULT", $idCapConsult);
        $qry->execute();        

    }

    public function excluirVisitasProg($idadmission, $dtini, $dtfim, $idprof, $idprofagenda){

        $sqlVP = "DELETE FROM  SR_PROG_VISITASPROG WHERE
            IDADMISSION = :IDADMISSION
            AND PROGRAMMEDSTART = TO_DATE('" . $dtini  . "','DD/MM/YYYY HH24:MI:SS') 
            AND PROGRAMMEDEND = TO_DATE('" . $dtfim  . "','DD/MM/YYYY HH24:MI:SS') , 
            AND IDPROFESSIONAL = :IDPROFESSIONAL 
            AND IDPROFAGENDA = :IDDPROFAGENDA";
        $qryVP = $this->conn->prepare($sqlVP);
        $qryVP->bindValue(":IDADMISSION", $idadmission);
        $qryVP->bindValue(":IDPROFESSIONAL", $idprof);
        $qryVP->bindValue(":IDDPROFAGENDA", $idprofagenda);
        $qryVP->execute();

    }

    public function adicionarConsulta(ConsultaModel $c){

        $sql = "INSERT INTO CAPCONSULT (
                IDADMISSION, IDPROFAGENDA, SCSPECIALITY, LIBERATED, CONSULTTYPE, 
                CLASSIFICATION, PROFCONFIRM, PATIENTCONFIRM, ADDITIONAL, CONSULTRETURN, 
                REALIZED, PAYPROFESSIONAL, CHARGE, CANCELED, AGENDASTARTDATE, 
                AGENDAENDDATE, PROGRAMMEDSTART, PROGRAMMEDEND, COMMENTS, SCCHARGE, 
                EMERGENCY, IDUSERAGENDA
            ) VALUES (
                :IDADMISSION, :IDPROFAGENDA, :SCSPECIALITY, 0, 1, 
                2, 0, 0, 0, 0, 
                0, 1, 1, 0, TO_DATE(:AGENDASTARTDATE, 'DD/MM/YYYY HH24:MI:SS'), 
                TO_DATE(:AGENDAENDDATE, 'DD/MM/YYYY HH24:MI:SS'), TO_DATE(:AGENDASTARTDATE, 'DD/MM/YYYY HH24:MI:SS'), TO_DATE(:AGENDAENDDATE, 'DD/MM/YYYY HH24:MI:SS'), :COMMENTS, :SCSPECIALITY,
                0, :IDUSERAGENDA
            )";
        
        $qry = $this->conn->prepare($sql);
        $qry->bindValue(":IDADMISSION", $c->getIdadmission());
        $qry->bindValue(":IDPROFAGENDA", $c->getIdprofagenda());
        $qry->bindValue(":SCSPECIALITY", $c->getIdespecialidade());
        $qry->bindValue(":AGENDASTARTDATE", $c->getDatainicioagenda());
        $qry->bindValue(":AGENDAENDDATE", $c->getDatafimagenda());
        $qry->bindValue(":COMMENTS", $c->getObservacao());
        $qry->bindValue(":IDUSERAGENDA", $c->getIduseragenda());
        $qry->execute();

        

        // Inserir Visitas Programadas
        $sqlVP = "INSERT INTO SR_PROG_VISITASPROG (
            IDADMISSION, IDUSUARIO, DTCAD, PROGRAMMEDSTART, PROGRAMMEDEND, 
            IDPROFESSIONAL, IDPROFAGENDA
        ) VALUES (
            " . $c->getIdadmission() . ", 
            " . $c->getIdusuario() . ", 
            TO_DATE('" . date("d/m/Y H:i:s") . "', 'DD/MM/YYYY HH24:MI:SS'), 
            TO_DATE('" . $c->getDatainicioagenda() . "', 'DD/MM/YYYY HH24:MI:SS'), 
            TO_DATE('" . $c->getDatafimagenda() . "', 'DD/MM/YYYY HH24:MI:SS'), 
            " . $c->getIdprofessional() . ", 
            " . $c->getIdprofagenda() . "
        )";
        $qryVP = $this->conn->prepare($sqlVP);
        $qryVP->execute();
        
        if ($c->getProcedimento() != ""){
            $sqlProc = "INSERT INTO SR_PROCEDIMENTO (
                PROCEDIMENTO, ID_PROF, IDADMISSION, OBS_AGEND
            ) VALUES (
                :PROCEDIMENTO, :ID_PROF, :IDADMISSION, :OBS_AGEND
            )";           
            $qryProc = $this->conn->prepare($sqlProc);
            $qryProc->bindValue(":PROCEDIMENTO", $c->getProcedimento());
            $qryProc->bindValue(":ID_PROF", $c->getIdprofessional());
            $qryProc->bindValue(":IDADMISSION", $c->getIdadmission());
            $qryProc->bindValue(":OBS_AGEND", $c->getObservacao());
            $qryProc->execute();
        }

        // Se a especialidade for médica gera uma solicitação de motorista
        if ($c->getIdespecialidade() == "148815" || $c->getIdespecialidade() == "335485"){

            require_once("../controllers/rotacontroller.php");
            require_once("../controllers/admissaocontroller.php");
            require_once("../models/rotamodel.php");

            $ctrRota = new RotaController();
            $ctrAdmissao = new AdmissaoController();

            $dadosAdmissao = $ctrAdmissao->retornarDadosPorAdmissao($c->getIdadmission());
            $endereco = @$dadosAdmissao[0]["ENDERECO"] . " " . 
                        @$dadosAdmissao[0]["COMPLEMENTO"] . " " . 
                        @$dadosAdmissao[0]["BAIRRO"] . " " . 
                        @$dadosAdmissao[0]["CIDADE"] . " " . 
                        @$dadosAdmissao[0]["UF"] . " " .
                        @$dadosAdmissao[0]["CEP"];
            $dataSeparada = explode(" ", $c->getDatainicioagenda());
            $textoObservacao =  "VISITA PROGRAMADA PARA O PACIENTE: " . @$dadosAdmissao[0]["NMPACIENTE"] . 
                                " PARA O MÉDICO(A): " . $c->getNmprofessional();

            $rotaModel = new RotaModel();
            $rotaModel->setCodigo(date("YmdHis") . $this->funcao->gerarSenha());
            $rotaModel->setIdusuariosolicitante($c->getIdusuario());
            $rotaModel->setLocal($endereco);
            $rotaModel->setDatasaida(date("d/m/Y H:i:s"));
            $rotaModel->setDatamaxima($dataSeparada[0] . " 23:59:59");
            $rotaModel->setObservacao($textoObservacao);
            $rotaModel->setStatus("S");
            $rotaModel->setExtra("NAO");
            $rotaModel->setJustificativa("Visita Médica");
            $rotaModel->setIdmedicosolicitante($c->getIdprofessional());
            $ctrRota->incluir($rotaModel);
            
        }
    }

    public function listarVisitasProgramadas($dataini, $datafim, $idespecialidade, $idprofissional, $idadmission, $idservico){

        $sql = "
        SELECT 
            J.*, 
            ASS.ASS_PAC AS ASSINATURAPAC,
            ASS.ASS_PROF AS ASSINATURAPROF, 
            FICHA.IMAGEM, 
            FICHA.ID AS IDFICHA, 
            TO_CHAR(VP.DATACANC, 'DD/MM/YYYY HH24:MI:SS') AS DATACANC, 
            VP.MOTIVOCANC AS MOTIVOCANC, 
            VP.JUSTIFICATIVA AS JUSTCANC
        FROM (
            SELECT
                CC.ID AS IDCAPCONSULT,
                ADM.ID AS IDADMISSION, 
                CC.IDPROFAGENDA, 
                PF.NAME AS NMPACIENTE, 
                AGE.IDPROFESSIONAL, 
                PFPROF.NAME AS NMPROFESSIONAL, 
                PROF.SCSPECIALITY AS IDESPECIALIDADE, 
                SCESP.CODENAME AS NMESPECIALIDADE, 
                TO_CHAR(CC.PROGRAMMEDSTART, 'YYYYMMDD') AS ORDENACAODATA, 
                TO_CHAR(CC.PROGRAMMEDSTART, 'HH24MISS') AS ORDENACAOHORA, 
                TO_CHAR(CC.PROGRAMMEDSTART, 'DD/MM/YYYY') AS DATAPROG,
                TO_CHAR(CC.PROGRAMMEDSTART, 'HH24:MI:SS') AS HORAPROG,
                TO_CHAR(CC.PROGRAMMEDEND, 'DD/MM/YYYY') AS DATAPROGFIM, 
                TO_CHAR(CC.PROGRAMMEDEND, 'HH24:MI:SS') AS HORAPROGFIM, 
                CC.IDEVOLUTION, 
                HP.ID AS IDSERVICO,
                HP.NAME AS NMSERVICO, 
                PROF.REGISTRYNUMBER AS REGISTROPROFISSIONAL, 
                PFPROF.SHORTNAME AS APELIDOPROFISSIONAL, 
                (CASE WHEN EVO.IDTEMPLATE IS NULL THEN 0 ELSE EVO.IDTEMPLATE END) AS IDTEMPLATE 
            FROM 
                CAPCONSULT CC 
                INNER JOIN CAPADMISSION ADM ON ADM.ID = CC.IDADMISSION 
                INNER JOIN GLBPATIENT PAT ON PAT.ID = ADM.IDPATIENT 
                INNER JOIN GLBPERSON PF ON PF.ID = PAT.IDPERSON 
                INNER JOIN GLBHEALTHPROVDEP HPD ON HPD.ID = ADM.IDHEALTHPROVDEP 
                INNER JOIN GLBHEALTHPROVIDER HP ON HP.ID = HPD.IDHEALTHPROVIDER 
                INNER JOIN CAPPROFAGENDA AGE ON AGE.ID = CC.IDPROFAGENDA 
                INNER JOIN GLBPROFESSIONAL PROF ON PROF.IDPERSON = AGE.IDPROFESSIONAL 
                INNER JOIN GLBPERSON PFPROF ON PFPROF.ID = PROF.IDPERSON 
                INNER JOIN SCCCODE SCESP ON SCESP.ID = PROF.SCSPECIALITY  
                LEFT JOIN CAPEVOLUTION EVO ON EVO.ID = CC.IDEVOLUTION                
            WHERE 
                CC.PROGRAMMEDSTART BETWEEN TO_DATE(:DATAINI, 'DD/MM/YYYY HH24:MI:SS') AND TO_DATE(:DATAFIM, 'DD/MM/YYYY HH24:MI:SS') 
        ) J 
        LEFT JOIN (
            SELECT DISTINCT K.ID, K.IDEVOLUTION, K.IMAGEM, K.IDREFERENCE AS IDADMISSION FROM TDACENFA K
            UNION ALL 
            SELECT DISTINCT K.ID, K.IDEVOLUTION, K.IMAGEM, K.IDREFERENCE AS IDADMISSION FROM TDACAUX K
            UNION ALL 
            SELECT DISTINCT K.ID, K.IDEVOLUTION, K.IMAGEM, K.IDREFERENCE AS IDADMISSION FROM TDACMEDICO K
            UNION ALL 
            SELECT DISTINCT K.ID, K.IDEVOLUTION, K.IMAGEM, K.IDREFERENCE AS IDADMISSION FROM TDACESPECIALIDADE K
            UNION ALL 
            SELECT DISTINCT K.ID, K.IDEVOLUTION, K.IMAGEM, K.IDREFERENCE AS IDADMISSION FROM TDACNUTRICAO K
            UNION ALL 
            SELECT DISTINCT K.ID, K.IDEVOLUTION, K.IMAGEM, K.IDREFERENCE AS IDADMISSION FROM TDACPSICOLOGIA K
            UNION ALL 
            SELECT DISTINCT K.ID, K.IDEVOLUTION, K.IMAGEM, K.IDREFERENCE AS IDADMISSION FROM TDACMEDICO_TELE K         
        ) FICHA ON FICHA.IDEVOLUTION = J.IDEVOLUTION AND FICHA.IDADMISSION = J.IDADMISSION 
        LEFT JOIN SR_ASSINATURAS ASS ON ASS.IDEVOLUCAO = J.IDEVOLUTION AND ASS.IDADMISSION = J.IDADMISSION AND ASS.IDPROFAGENDA = J.IDPROFAGENDA 
        LEFT JOIN SR_PROG_VISITASPROG VP ON VP.IDADMISSION = J.IDADMISSION AND VP.IDPROFAGENDA = J.IDPROFAGENDA AND VP.CANCELADO = 'S' 
        WHERE 1 = 1 ";
        if ($idespecialidade != ""){
            $sql .= "AND J.IDESPECIALIDADE = :IDESPECIALIDADE ";
        }
        if ($idprofissional != ""){
            $sql .= "AND J.IDPROFESSIONAL = :IDPROFESSIONAL ";
        }
        if ($idadmission != ""){
            $sql .= "AND J.IDADMISSION = :IDADMISSION ";
        }
        if ($idservico != ""){
            $sql .= "AND J.IDSERVICO = :IDSERVICO ";
        }
        $sql .= "
        ORDER BY 
            J.ORDENACAODATA, J.NMESPECIALIDADE, J.NMPROFESSIONAL, J.ORDENACAOHORA
        ";
        //echo $sql; exit();
        $qry = $this->conn->prepare($sql);
        $qry->bindValue(":DATAINI", $dataini . " 00:00:00");
        $qry->bindValue(":DATAFIM", $datafim . " 23:59:59");
        if ($idespecialidade != ""){
            $qry->bindValue(":IDESPECIALIDADE", $idespecialidade);
        }
        if ($idprofissional != ""){
            $qry->bindValue(":IDPROFESSIONAL", $idprofissional);
        }
        if ($idadmission != ""){
            $qry->bindValue(":IDADMISSION", $idadmission);
        }
        if ($idservico != ""){
            $qry->bindValue(":IDSERVICO", $idservico);
        }
        $qry->execute();
        $res = $qry->fetchAll(PDO::FETCH_ASSOC);
        return $res;

    }


    public function validaCancelamentoVisitaProg($idAdmission, $idProfAgenda, $dataInicio, $dataFim, $idProfessional, $idUsuario){

        $sql = "SELECT * FROM SR_PROG_VISITASPROG WHERE IDADMISSION = :IDADMISSION AND IDPROFAGENDA = :IDPROFAGENDA";
        $qry = $this->conn->prepare($sql);
        $qry->bindValue(":IDADMISSION", $idAdmission);
        $qry->bindValue(":IDPROFAGENDA", $idProfAgenda);
        $qry->execute();
        $res = $qry->fetchAll(PDO::FETCH_ASSOC);        
        //echo $sql . "<br>IDADMISSION: {$idAdmission}<br>IDPROFAGENDA: {$idProfAgenda}<br>";

        if (count($res) > 0){
            if ($res[0]["CANCELADO"] == "N"){
                $this->cancelarVisita($idAdmission, $idProfAgenda);
            }
        } else {
            $this->incluirCancelamentoVisita($idAdmission, $idProfAgenda, $dataInicio, $dataFim, $idProfessional, $idUsuario);
        }


    }

    public function cancelarVisita($idAdmission, $idProfAgenda){

        $sql = "UPDATE 
                    SR_PROG_VISITASPROG 
                SET 
                    CANCELADO = 'S', 
                    MOTIVOCANC = 'NAO REGISTRADA', 
                    DATACANC = TO_DATE('" . date("d/m/Y H:i:s") . "','DD/MM/YYYY HH24:MI:SS'), 
                    JUSTIFICATIVA = 'VISITA NÃO REGISTRADA NO SISTEMA' 
                WHERE 
                    IDADMISSION = :IDADMISSION 
                    AND IDPROFAGENDA = :IDPROFAGENDA";
        $qry = $this->conn->prepare($sql);
        $qry->bindValue(":IDADMISSION", $idAdmission);
        $qry->bindValue(":IDPROFAGENDA", $idProfAgenda);
        $qry->execute();
        //echo $sql . "<br>IDADMISSION: {$idAdmission}<br>IDPROFAGENDA: {$idProfAgenda}<br>";
    }

    public function incluirCancelamentoVisita($idAdmission, $idProfAgenda, $dataInicio, $dataFim, $idProfessional, $idUsuario){

        $sql = "INSERT INTO SR_PROG_VISITASPROG (
                    IDADMISSION, 
                    PROGRAMMEDSTART, 
                    PROGRAMMEDEND, 
                    IDPROFESSIONAL, 
                    IDPROFAGENDA, 
                    DTCAD, 
                    IDUSUARIO, 
                    CANCELADO, 
                    MOTIVOCANC, 
                    DATACANC, 
                    JUSTIFICATIVA
                ) VALUES (
                    :IDADMISSION, 
                    TO_DATE(:DATAINI, 'DD/MM/YYYY HH24:MI:SS'), 
                    TO_DATE(:DATAFIM, 'DD/MM/YYYY HH24:MI:SS'),  
                    :IDPROFESSIONAL, 
                    :IDPROFAGENDA, 
                    TO_DATE('" . date("d/m/Y H:i:s") . "', 'DD/MM/YYYY HH24:MI:SS'), 
                    :IDUSUARIO, 
                    'S', 
                    'NAO REGISTRADA', 
                    TO_DATE('" . date("d/m/Y H:i:s") . "', 'DD/MM/YYYY HH24:MI:SS'), 
                    'VISITA NÃO REGISTRADA NO SISTEMA'                                                                
                )";
        $qry = $this->conn->prepare($sql);
        $qry->bindValue(":IDADMISSION", $idAdmission);
        $qry->bindValue(":IDPROFAGENDA", $idProfAgenda);
        $qry->bindValue(":DATAINI", $dataInicio);
        $qry->bindValue(":DATAFIM", $dataFim);
        $qry->bindValue(":IDPROFESSIONAL", $idProfessional);
        $qry->bindValue(":IDUSUARIO", $idUsuario);
        $qry->execute();
        //echo $sql . "<br>IDADMISSION: {$idAdmission}<br>IDPROFAGENDA: {$idProfAgenda}<br>DATA INICIO: {$dataInicio}<br>DATA FIM: {$dataFim}<br>IDPROFESSIONAL: {$idProfessional}<br>IDUSUARIO: {$idUsuario}<br>";
    }

}