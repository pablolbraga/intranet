<?php
require_once("../controllers/caixacontroller.php");
require_once("../controllers/plantaocontroller.php");
require_once("../controllers/plantaomovimentacaocontroller.php");
require_once("../controllers/caixamovimentacaocontroller.php");
require_once("../models/plantaomovimentacaomodel.php");
require_once("../models/caixamovimentacaomodel.php");

$ctrCaixa = new CaixaController();
$ctrPlantao = new PlantaoController();
$ctrPlantaoMovimentacao = new PlantaoMovimentacaoController();
$ctrCaixaMovimentacao = new CaixaMovimentacaoController();

if ($_REQUEST["tipo"] == "1"){

    try{
        $valor = str_replace(",", '.', str_replace(".", ",", $_POST["txtValorPlantaoCaixaRecepcao"]));
        $ctrCaixa->abrirCaixa(
            $_POST["txtCodUsuarioPlantao"], 
            $_POST["txtDataAberturaPlantaoCaixaRecepcao"], 
            $valor,
            $_POST["txtObservacaoPlantaoCaixaRecepcao"]
        );

        // Buscar o ultimo ID
        $idcaixa = $ctrCaixa->buscarUltimoId($_POST["txtCodUsuarioPlantao"]);
        

        // Iniciar Plantão
        $ctrPlantao->iniciarTrocaPlantao(
            $idcaixa[0]["ID"], 
            $_POST["txtCodUsuarioPlantao"], 
            $_POST["txtDataAberturaPlantaoCaixaRecepcao"]
        );

        echo "Incluído com sucesso."; exit();
    } catch(Exception $e){
        echo "Erro ao abrir o plantão. Erro: " . $e->getMessage(); exit();
    }

} else if ($_REQUEST["tipo"] == "2"){
    
    try{
        $valor = 0;
        $ctrCaixa->abrirCaixa(
            $_POST["txtCodUsuarioPlantao"], 
            $_POST["txtDataAberturaPlantaoCaixa"], 
            $valor,
            $_POST["txtObservacaoPlantaoCaixa"]
        );

        // Buscar o ultimo ID
        $idcaixa = $ctrCaixa->buscarUltimoId($_POST["txtCodUsuarioPlantao"]);
        

        // Iniciar Plantão
        $ctrPlantao->iniciarTrocaPlantao(
            $idcaixa[0]["ID"], 
            $_POST["txtCodUsuarioPlantao"], 
            $_POST["txtDataAberturaPlantaoCaixa"]
        );

        echo "Incluído com sucesso."; exit();
    } catch(Exception $e){
        echo "Erro ao abrir o plantão. Erro: " . $e->getMessage(); exit();
    }

} else if ($_REQUEST["tipo"] == "3"){
    
    try{
        $plantaoAberto = $ctrPlantao->buscarPlantaoAbertoPorUsuario($_POST["txtCodUsuarioMovimentacaoSolicitacao"]);
        $obs = $_POST["txtAtendenteMovimentacaoSolicitacao"] . "<*>" . $_POST["txtProtocoloMovimentacaoSolicitacao"] . "<*>" . $_POST["txtDescricaoMovimentacaoSolicitacao"];

        $pm = new PlantaoMovimentacaoModel();
        $pm->setIdTrocaPlantao($plantaoAberto[0]["ID"]);
        $pm->setIdUsuario($_POST["txtCodUsuarioMovimentacaoSolicitacao"]);
        $pm->setDtCad(date("d/m/Y H:i:s"));
        $pm->setCategoria("Solicitacao");
        $pm->setObs($obs);
        $pm->setBaixa(null);
        $pm->setAnexo(null);
        $ctrPlantaoMovimentacao->inserir($pm);

        echo "Incluído com sucesso."; exit();
    } catch(Exception $e){
        echo "Erro ao abrir o plantão. Erro: " . $e->getMessage(); exit();
    }

} else if ($_REQUEST["tipo"] == "4"){
    
    try{
        $plantaoAberto = $ctrPlantao->buscarPlantaoAbertoPorUsuario($_POST["txtCodUsuarioMovimentacaoEscala"]);
        $obs =  $_POST["txtDescPacienteMovimentacaoEscala"] . "<*>" . 
                $_POST["txtTecnicoFaltaMovimentacaoEscala"] . "<*>" . 
                $_POST["txtTecnicoSubstitutoMovimentacaoEscala"] . "<*>" .
                $_POST["txtDescricaoMovimentacaoEscala"];

        $pm = new PlantaoMovimentacaoModel();
        $pm->setIdTrocaPlantao($plantaoAberto[0]["ID"]);
        $pm->setIdUsuario($_POST["txtCodUsuarioMovimentacaoEscala"]);
        $pm->setDtCad(date("d/m/Y H:i:s"));
        $pm->setCategoria("Escala");
        $pm->setObs($obs);
        $pm->setBaixa(null);
        $pm->setAnexo(null);
        $ctrPlantaoMovimentacao->inserir($pm);

        echo "Incluído com sucesso."; exit();
    } catch(Exception $e){
        echo "Erro ao abrir o plantão. Erro: " . $e->getMessage(); exit();
    }

} else if ($_REQUEST["tipo"] == "5"){
    
    try{
        $caixaAberto = $ctrCaixa->retornarDadosCaixaAberto($_POST["txtCodUsuarioMovimentacaoCaixa"]);
        $saldo = $ctrCaixa->retornarSaldoMovimentacao($_POST["txtCodUsuarioMovimentacaoCaixa"]);

        $valor = str_replace(",", ".", str_replace(".", "", $_POST["txtValorMovimentacaoCaixa"]));


        if (($saldo < $valor) && ($_POST["cmbTipoMovimentacaoCaixa"] == "S")){
            echo "O saldo é menor que o valor de saída."; exit();
        } else {
            $c = new CaixaMovimentacaoModel();
            $c->setUsuario($_POST["txtCodUsuarioMovimentacaoCaixa"]);
            $c->setCaixa($caixaAberto[0]["ID"]);
            $c->setTipo($_POST["cmbTipoMovimentacaoCaixa"]);
            $c->setDescricao($_POST["txtDescricaoMovimentacaoCaixa"]);
            $c->setValor($valor);            
            $c->setData(date("d/m/Y H:i:s"));
            $ctrCaixaMovimentacao->incluir($c);
            echo "Incluído com sucesso."; exit();
        }

        echo "Incluído com sucesso."; exit();
    } catch(Exception $e){
        echo "Erro ao abrir o plantão. Erro: " . $e->getMessage(); exit();
    }

} else if ($_REQUEST["tipo"] == "6"){
    
    try{
        $destino = "";
        $nomeArquivo = "";

        // Verificar se tem anexo
        if ( isset( $_FILES['arquivoMovimentacaoPendencia']['name'] ) && $_FILES['arquivoMovimentacaoPendencia']['error'] == 0 ){
            $arquivo_tmp = $_FILES[ 'arquivoMovimentacaoPendencia' ][ 'tmp_name' ];
            $nome = $_FILES[ 'arquivoMovimentacaoPendencia' ][ 'name' ];
            // Pega a extensão
            $extensao = pathinfo ( $nome, PATHINFO_EXTENSION );

            // Converte a extensão para minúsculo
            $extensao = strtolower ( $extensao );

            // Somente imagens, .jpg;.jpeg;.gif;.png
            // Aqui eu enfileiro as extensões permitidas e separo por ';'
            // Isso serve apenas para eu poder pesquisar dentro desta String 
            if ( strstr ( '.jpg;.jpeg;.gif;.png', $extensao ) ){
                // Cria um nome único para esta imagem
                // Evita que duplique as imagens no servidor.
                // Evita nomes com acentos, espaços e caracteres não alfanuméricos
                $novoNome = uniqid (time()) . '.' . $extensao;

                // Concatena a pasta com o nome
                $destino = '../imgs/' . $novoNome;
                $nomearquivo = $novoNome;

                // tenta mover o arquivo para o destino
                if ( @move_uploaded_file ( $arquivo_tmp, $destino ) ) {
                    
                } else {
                    echo "Erro ao salvar o arquivo. Aparentemente você não tem permissão de escrita."; exit();
                }
            } else {
                echo "Você poderá enviar apenas arquivos '*.jpg;*.jpeg;*.gif;*.png'"; exit();
            }
        }
        $plantaoAberto = $ctrPlantao->buscarPlantaoAbertoPorUsuario($_POST["txtCodUsuarioMovimentacaoPendencia"]);
        
        $pm = new PlantaoMovimentacaoModel();
        $pm->setIdTrocaPlantao($plantaoAberto[0]["ID"]);
        $pm->setIdUsuario($_POST["txtCodUsuarioMovimentacaoPendencia"]);
        $pm->setDtCad(date("d/m/Y H:i:s"));
        $pm->setCategoria("Pendencia");
        $pm->setObs($_POST["txtDescricaoMovimentacaoPendencia"]);
        $pm->setBaixa("S");
        $pm->setAnexo($destino);
        $ctrPlantaoMovimentacao->inserir($pm);

        echo "Incluído com sucesso."; exit();
    } catch(Exception $e){
        echo "Erro ao abrir o plantão. Erro: " . $e->getMessage(); exit();
    }

} else if ($_REQUEST["tipo"] == "7"){
    
    try{
        $destino = "";
        $nomeArquivo = "";

        // Verificar se tem anexo
        if ( isset( $_FILES['arquivoMovimentacaoFarmacia']['name'] ) && $_FILES['arquivoMovimentacaoFarmacia']['error'] == 0 ){
            $arquivo_tmp = $_FILES[ 'arquivoMovimentacaoFarmacia' ][ 'tmp_name' ];
            $nome = $_FILES[ 'arquivoMovimentacaoFarmacia' ][ 'name' ];
            // Pega a extensão
            $extensao = pathinfo ( $nome, PATHINFO_EXTENSION );

            // Converte a extensão para minúsculo
            $extensao = strtolower ( $extensao );

            // Somente imagens, .jpg;.jpeg;.gif;.png
            // Aqui eu enfileiro as extensões permitidas e separo por ';'
            // Isso serve apenas para eu poder pesquisar dentro desta String 
            if ( strstr ( '.jpg;.jpeg;.gif;.png', $extensao ) ){
                // Cria um nome único para esta imagem
                // Evita que duplique as imagens no servidor.
                // Evita nomes com acentos, espaços e caracteres não alfanuméricos
                $novoNome = uniqid (time()) . '.' . $extensao;

                // Concatena a pasta com o nome
                $destino = '../imgs/' . $novoNome;
                $nomearquivo = $novoNome;

                // tenta mover o arquivo para o destino
                if ( @move_uploaded_file ( $arquivo_tmp, $destino ) ) {
                    
                } else {
                    echo "Erro ao salvar o arquivo. Aparentemente você não tem permissão de escrita."; exit();
                }
            } else {
                echo "Você poderá enviar apenas arquivos '*.jpg;*.jpeg;*.gif;*.png'"; exit();
            }
        }
        $plantaoAberto = $ctrPlantao->buscarPlantaoAbertoPorUsuario($_POST["txtCodUsuarioMovimentacaoFarmacia"]);
        
        $pm = new PlantaoMovimentacaoModel();
        $pm->setIdTrocaPlantao($plantaoAberto[0]["ID"]);
        $pm->setIdUsuario($_POST["txtCodUsuarioMovimentacaoFarmacia"]);
        $pm->setDtCad(date("d/m/Y H:i:s"));
        $pm->setCategoria("Farmacia");
        $pm->setObs($_POST["txtDescricaoMovimentacaoFarmacia"]);
        $pm->setBaixa("N");
        $pm->setAnexo($destino);
        $ctrPlantaoMovimentacao->inserir($pm);

        echo "Incluído com sucesso."; exit();
    } catch(Exception $e){
        echo "Erro ao abrir o plantão. Erro: " . $e->getMessage(); exit();
    }

} else if ($_REQUEST["tipo"] == "8"){
    
    try{
        $dadosCaixa = $ctrCaixa->retornarDadosCaixaAberto($_POST["txtCodUsuarioEncerrarPlantao"]);
        $plantaoAberto = $ctrPlantao->buscarPlantaoAbertoPorUsuario($_POST["txtCodUsuarioEncerrarPlantao"]);
        //echo "IdPlantao: " . $plantaoAberto[0]["ID"] . ", IDCAIXA: " . $dadosCaixa[0]["ID"]; exit();

        $ctrPlantao->finalizarPlantao($_POST["txtCodUsuarioEncerrarPlantao"], date("d/m/Y H:i:s"), $plantaoAberto[0]["ID"]);
        
        if ($_POST["txtUgbEncerrarPlantao"] == "RECEPCAO"){
            $valorFechamento = str_replace(",", ".", str_replace(".", "", $_POST["txtSaldoEncerrarPlantao"]));
        } else {
            $valorFechamento = 0;
        }

        $ctrCaixa->fecharCaixa($dadosCaixa[0]["ID"], $_POST["txtCodUsuarioEncerrarPlantao"], $valorFechamento, $_POST["txtDescricaoEncerrarPlantao"]);

        echo "Incluído com sucesso."; exit();
    } catch(Exception $e){
        echo "Erro ao abrir o plantão. Erro: " . $e->getMessage(); exit();
    }

}