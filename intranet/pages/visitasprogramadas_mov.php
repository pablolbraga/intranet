<?php
require_once("../models/evolucaomodel.php");
require_once("../controllers/evolucaocontroller.php");
require_once("../controllers/fichamanualcontroller.php");
require_once("../controllers/visitascontroller.php");
require_once("../controllers/agendacontroller.php");

if ($_REQUEST["tipo"] == "FM"){ // Ficha Manual

    $destino = "";
    $nomearquivo = "";

    try{
        
        if ( isset( $_FILES['arquivoImportarFicha']['name'] ) && $_FILES['arquivoImportarFicha']['error'] == 0 ){
            $arquivo_tmp = $_FILES[ 'arquivoImportarFicha' ][ 'tmp_name' ];
            $nome = $_FILES[ 'arquivoImportarFicha' ][ 'name' ]; 

            // Pega a extensão
            $extensao = pathinfo ( $nome, PATHINFO_EXTENSION );

            // Converte a extensão para minúsculo
            $extensao = strtolower ( $extensao );

            // Somente imagens, .jpg;.jpeg;.gif;.png
            // Aqui eu enfileiro as extensões permitidas e separo por ';'
            // Isso serve apenas para eu poder pesquisar dentro desta String 
            if ( strstr ( '.jpg;.jpeg;.gif;.png;.pdf', $extensao ) ){
                // Cria um nome único para esta imagem
                // Evita que duplique as imagens no servidor.
                // Evita nomes com acentos, espaços e caracteres não alfanuméricos
                $novoNome = uniqid (time()) . '.' . $extensao;

                // Concatena a pasta com o nome
                $destino = '../fichasimportadas/' . $novoNome;
                $nomearquivo = $novoNome;

                // tenta mover o arquivo para o destino
                if ( @move_uploaded_file ( $arquivo_tmp, $destino ) ){
                    $template = 0;
                    switch ($_POST["txtCodIdEspecialidadeImportarFicha"]){
                        case 122633 : $template = 109; break; // Nutricionista
                        case 122632 : $template = 98; break; // Enfermeiro
                        case 122646 : $template = 108; break; // Fisioterapia
                        case 122647 : $template = 108; break; // Fonoterapia
                        case 123931 : $template = 110; break; // Psicologo
                        case 123932 : $template = 108; break; // Terapeuta Ocupacional
                        case 148815 : $template = 107; break; // Médico
                        case 167646 : $template = 108; break; // Fisioterapia
                        case 171086 : $template = 101; break; // Técnico da Base
                        case 243379 : $template = 98; break; // Enfermeiro(a) (Noturno)
                        case 243378 : $template = 98; break; // Enfermeiro(a) (Diurno)
                        case 334849 : $template = 111; break; // MEDICO TELEMEDICINA
                    }

                    // Inserir Evolução
                    $ctrEvolucao = new EvolucaoController();                
                    $e = new EvolucaoModel();
                    $datainicio = $_POST["txtDataInicioImportarFicha"] . " " . $_POST["txtHoraInicioImportarFicha"] . ":00";
                    $datafim = $_POST["txtDataFimImportarFicha"] . " " . $_POST["txtHoraFimImportarFicha"] . ":00";
                    $datacriacao = date("d/m/Y H:i:s");

                    $e->setIdadmission($_POST["txtCodAdmissaoImportarFicha"]);
                    $e->setIdprofessional($_POST["txtCodIdProfessionalImportarFicha"]);
                    $e->setIdespecialidade($_POST["txtCodIdEspecialidadeImportarFicha"]);
                    $e->setAssinado(0);
                    $e->setProgramado(1);
                    $e->setDataini($datainicio);
                    $e->setDataini($datafim);
                    $e->setDatacriacao($datacriacao);
                    $e->setNmprofessional($_POST["txtNomeProfessionalImportarFicha"]);
                    $e->setRegistroprofessional($_POST["txtRegistroProfessionalImportarFicha"]);
                    $e->setApelidoprofessional($_POST["txtApelidoProfessionalImportarFicha"]);
                    $e->setNmespecialidade($_POST["txtNomeEspecialidadeImportarFicha"]);
                    $e->setIdtemplate($template);
                    $e->setXml(2);
                    $ctrEvolucao->incluir($e);

                    // Pega a evolução registrada
                    $dadosEvolucao = $ctrEvolucao->buscarUltimaEvolucao(
                        $_POST["txtCodAdmissaoImportarFicha"],
                        $_POST["txtCodIdProfessionalImportarFicha"],
                        $_POST["txtCodIdEspecialidadeImportarFicha"],
                        $datainicio,
                        $datafim,
                        $datacriacao);

                    // Atualiza a capconsult
                    $ctrEvolucao->informarIdEvolucaoNoCapConsult($dadosEvolucao[0]["ID"], $_POST["txtIdCapConsultImportarFicha"]);

                    // Registra a informação na tabela da especialidade
                    $textoBase = "FICHA COM IMPORTAÇÃO DE IMAGEM";
                    $ctrFichaManual = new FichaManualController();
                    $ctrFichaManual->inserirFicha(
                        $template, 
                        $_POST["txtCodAdmissaoImportarFicha"],
                        $dadosEvolucao[0]["ID"],
                        $datacriacao,
                        $_POST["txtCodIdProfessionalImportarFicha"],
                        $_POST["txtCodIdEspecialidadeImportarFicha"],
                        $textoBase, 
                        $nomearquivo
                    );

                    // Atualiza SR_PROG_VISITASPROG
                    $ctrFichaManual->atualizarVisitasProg($_POST["txtCodAdmissaoImportarFicha"], $_POST["txtCodProfAgendaImportarFicha"]);
                    
                    echo "Incluído com sucesso."; exit();

                } else {
                    echo "Erro ao salvar o arquivo. Aparentemente você não tem permissão de escrita."; exit();
                }
            } else {
                echo "Você poderá enviar apenas arquivos '*.jpg;*.jpeg;*.gif;*.png,*.pdf'"; exit();
            }
        } else {
            echo "Nenhum arquivo foi selecionado."; exit();
        }

    } catch(Exception $e){
        echo "Erro ao importar a ficha. Erro: " . $e->getMessage(); exit();
    }
} else if ($_REQUEST["tipo"] == "EV"){ // Exclusão de Visitas

    try{
        $ctrVisita = new VisitasController();
        $ctrVisita->excluirConsulta($_POST["txtIdCapConsultExcluirFicha"]);
        $ctrVisita->excluirVisitasProg(
            $_POST["txtCodAdmissaoExcluirFicha"], 
            $_POST["txtDataProgExcluirFicha"] . " " . $_POST["txtHoraProgExcluirFicha"],
            $_POST["txtDataFimExcluirFicha"] . " " . $_POST["txtHoraFimExcluirFicha"],
            $_POST["txtCodIdProfessionalExcluirFicha"],
            $_POST["txtCodProfAgendaExcluirFicha"]
        );

        $ctrAgenda = new AgendaController();
        $ctrAgenda->excluirAgendaPorId($_POST["txtCodProfAgendaExcluirFicha"]);

        echo "Excluído com sucesso."; exit();
    } catch(Exception $e){
        echo "Erro ao excluir o agendamento. Erro: " . $e->getMessage(); exit();
    }

} if ($_REQUEST["tipo"] == "SF"){ // Substituir Ficha

    $destino = "";
    $nomearquivo = "";

    try{
        
        if ( isset( $_FILES['arquivoSubstituirFicha']['name'] ) && $_FILES['arquivoSubstituirFicha']['error'] == 0 ){
            $arquivo_tmp = $_FILES[ 'arquivoSubstituirFicha' ][ 'tmp_name' ];
            $nome = $_FILES[ 'arquivoSubstituirFicha' ][ 'name' ]; 

            // Pega a extensão
            $extensao = pathinfo ( $nome, PATHINFO_EXTENSION );

            // Converte a extensão para minúsculo
            $extensao = strtolower ( $extensao );

            // Somente imagens, .jpg;.jpeg;.gif;.png
            // Aqui eu enfileiro as extensões permitidas e separo por ';'
            // Isso serve apenas para eu poder pesquisar dentro desta String 
            if ( strstr ( '.jpg;.jpeg;.gif;.png;.pdf', $extensao ) ){
                // Cria um nome único para esta imagem
                // Evita que duplique as imagens no servidor.
                // Evita nomes com acentos, espaços e caracteres não alfanuméricos
                $novoNome = uniqid (time()) . '.' . $extensao;

                // Concatena a pasta com o nome
                $destino = '../fichasimportadas/' . $novoNome;
                $nomearquivo = $novoNome;

                // tenta mover o arquivo para o destino
                if ( @move_uploaded_file ( $arquivo_tmp, $destino ) ){
                    $template = 0;
                    switch ($_POST["txtCodIdEspecialidadeSubstituirFicha"]){
                        case 122633 : $template = 109; break; // Nutricionista
                        case 122632 : $template = 98; break; // Enfermeiro
                        case 122646 : $template = 108; break; // Fisioterapia
                        case 122647 : $template = 108; break; // Fonoterapia
                        case 123931 : $template = 110; break; // Psicologo
                        case 123932 : $template = 108; break; // Terapeuta Ocupacional
                        case 148815 : $template = 107; break; // Médico
                        case 167646 : $template = 108; break; // Fisioterapia
                        case 171086 : $template = 101; break; // Técnico da Base
                        case 243379 : $template = 98; break; // Enfermeiro(a) (Noturno)
                        case 243378 : $template = 98; break; // Enfermeiro(a) (Diurno)
                        case 334849 : $template = 111; break; // MEDICO TELEMEDICINA
                    }

                    // Registra a informação na tabela da especialidade
                    $ctrFichaManual = new FichaManualController();
                    $ctrFichaManual->substituirFichaImagem(
                        $template, 
                        $_POST["txtIdFichaSubstituirFicha"],
                        $nomearquivo
                    );

                    // Atualiza SR_PROG_VISITASPROG
                    $ctrFichaManual->atualizarVisitasProg($_POST["txtCodAdmissaoSubstituirFicha"], $_POST["txtCodProfAgendaSubstituirFicha"]);
                    
                    echo "Incluído com sucesso."; exit();

                } else {
                    echo "Erro ao salvar o arquivo. Aparentemente você não tem permissão de escrita."; exit();
                }
            } else {
                echo "Você poderá enviar apenas arquivos '*.jpg;*.jpeg;*.gif;*.png,*.pdf'"; exit();
            }
        } else {
            echo "Nenhum arquivo foi selecionado."; exit();
        }

    } catch(Exception $e){
        echo "Erro ao importar a ficha. Erro: " . $e->getMessage(); exit();
    }
}