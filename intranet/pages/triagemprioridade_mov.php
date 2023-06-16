<?php
require_once("../controllers/solicitacaoservicocontroller.php");
$ctr = new SolicitacaoServicoController();

if ($_REQUEST["tipo"] == "E"){
    // Exclusão da triagem
    try{
        $ctr->excluirSolicitacaoTriagem(
            $_POST["txtCodigoExc"],
            $_POST["cmbMotivoExclusao"], 
            $_POST["txtObservacaoExc"],
            "I",
            $_POST["txtIdUsuarioExc"]
        );
        echo "Excluído com sucesso."; exit();
    } catch(Exception $e){
        echo "Erro ao excluir o registro. Erro: " . $e->getMessage(); exit();
    }
    
} else if ($_REQUEST["tipo"] == "P"){
    // Mudança de Prioridade
    try{
        $ctr->realizarBaixaPrioridade(
            $_POST["txtIdUsuarioAlt"],
            $_POST["cmbPrioridadeAlt"], 
            $_POST["txtCodigoAlt"]
        );
        echo "Alterado com sucesso."; exit();
    } catch(Exception $e){
        echo "Erro ao mudar a triagem. Erro: " . $e->getMessage(); exit();
    }
}