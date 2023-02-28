<?php
require_once("../controllers/visitascontroller.php");

$ctrVisita = new VisitasController();

if ($_REQUEST["tipo"] == "E"){

    try{
        $ctrVisita->excluirConsulta(
            @$_POST["txtIdCapConsult"],
            @$_POST["txtIdAdmission"],
            @$_POST["txtDtIni"],
            @$_POST["txtDtFim"],
            @$_POST["txtIdProfExc"],
            @$_POST["txtIdProfAgeExc"]
        );

        

        echo "Excluído com sucesso.";
    } catch(Exception $e){
        echo "Erro ao excluir o registro. Erro:" . $e->getMessage();
    }

} else if ($_REQUEST["tipo"] == "I"){

    try{
        require_once("../models/consultamodel.php");
        $consultaModel = new ConsultaModel();

        $consultaModel->setIdadmission($_POST["txtCodPaciente"]);
        $consultaModel->setIdprofagenda($_POST["idprofagenda"]);
        $consultaModel->setIdespecialidade($_POST["idespecialidade"]);
        $consultaModel->setDatainicioagenda($_POST["dataagendainicio"]);
        $consultaModel->setDatafimagenda($_POST["dataagendafim"]);
        $consultaModel->setProcedimento($_POST["txtProcedimento"]);
        $consultaModel->setObservacao($_POST["txtObservacao"]);
        $consultaModel->setIduseragenda($_POST["secuser"]);
        $consultaModel->setIdusuario($_POST["idusuario"]);
        $consultaModel->setIdprofessional($_POST["idprofessional"]);
        $consultaModel->setNmprofessional($_POST["nmprofessional"]);

        $ctrVisita->adicionarConsulta($consultaModel);
        echo "Incluído com sucesso.";
    } catch(Exception $e){
        echo "Erro ao incluir o registro. Erro:" . $e->getMessage();
    }

}