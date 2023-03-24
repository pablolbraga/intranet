<?php

class Constantes{

    static $DADOS_EMAIL_USERNAME = "email@sauderesidence.com.br";
    static $DADOS_EMAIL_PWD = "17509036";
    static $DADOS_EMAIL_SMTPSECURE = "ssl";
    static $DADOS_EMAIL_HOST = "smtp.gmail.com";
    static $DADOS_EMAIL_PORT = 465;


    static $arrTipoSolicitacaoMatMed = array(
        array("ID" => "SIM", "NOME" => "SEMANAL"),
        array("ID" => "NAO", "NOME" => "EXTRA"),
        array("ID" => "ROT", "NOME" => "ROTINA")
    );

    static $arrSimNao = array(
        array("ID" => "SIM", "NOME" => "SIM"),
        array("ID" => "NAO", "NOME" => "NÃO")
    );

    static $arrEntradaSaida = array(
        array("ID" => "E", "NOME" => "ENTRADA"),
        array("ID" => "S", "NOME" => "SAÍDA")
    );

    static $arrJustificativaMatMed = array(
        array("ID" => "Admissão", "NOME" => "ADMISSÃO"),
        array("ID" => "Alteração no estado clínico", "NOME" => "ALTERAÇÃO DO ESTADO CLÍNICO"),
        array("ID" => "Aplicação de equipamentos", "NOME" => "APLICAÇÃO DE EQUIPAMENTOS"),
		array("ID" => "Autorização da operadora", "NOME" => "AUTORIZAÇÃO DA OPERADORA"),
        array("ID" => "Empréstimos/Manutenção de equipamentos", "NOME" => "EMPRÉSTIMOS/MANUTENÇÃO DE EQUIPAMENTOS"),
        array("ID" => "Falha na autorização", "NOME" => "FALHA NA AUTORIZAÇÃO"),
		array("ID" => "Falha da recepção", "NOME" => "FALHA NA RECEPCAO"),
        array("ID" => "Falha na solicitação(admissão)", "NOME" => "FALHA NA SOLICITAÇÃO (ADMISSÃO)"),
        array("ID" => "Falha na solicitação (Enfermeira)", "NOME" => "FALHA NA SOLICITAÇÃO (ENFERMEIRA)"),		
		array("ID" => "Falha Suprimentos (Pedidos, Separação, Conferencia e Dispensação)", "NOME" => "FALHA SUPRIMENTOS (PEDIDOS, SEPARAÇÃO, CONFERÊNCIA E DISPENSAÇÃO)"),
		array("ID" => "Pedido mensal", "NOME" => "PEDIDO MENSAL"),
        array("ID" => "Pedido quinzenal", "NOME" => "PEDIDO QUINZENAL"),
        array("ID" => "Pedido semanal", "NOME" => "PEDIDO SEMANAL"),
        array("ID" => "Pendências Mat / Med / Equipamento (Compra)", "NOME" => "PENDÊNCIA MAT/MED/EQUIPAMENTO (COMPRA)"),
		array("ID" => "Plantão de Cuidador", "NOME" => "PLANTÃO DE CUIDADOR"),
        array("ID" => "Procedimentos de enfermagem", "NOME" => "PROCEDIMENTOS DE ENFERMAGEM"),
        array("ID" => "Prorrogação de serviço", "NOME" => "PRORROGAÇÃO DE SERVIÇOS"),
        array("ID" => "Recolhimento de Serviço",  "NOME" => "RECOLHIMENTO DE SERVIÇOS"),
        array("ID" => "Recolhimentos (Equipamentos / Mat /Med)", "NOME" => "RECOLHIMENTOS (EQUIPAMENTOS/MAT/MED)"),
        array("ID" => "Reposição de mat do(a) enfermeiro(a) e tecnico da base", "NOME" => "REPOSIÇÃO DE MATERIAIS DO(A) ENFERMEIRO(A) E TÉCNICO DE BASE"),
        array("ID" => "Teste de rotina", "NOME" => "TESTE DE ROTINA"),
        array("ID" => "Troca de mat/med/equip", "NOME" => "TROCA DE MAT/MED/EQUIP"),
        array("ID" => "Uso indevido em domicílio", "NOME" => "USO INDEVIDO EM DOMICÍLIO"),	
        array("ID" => "Visita Médica", "NOME" => "VISITA MÉDICA")
    );

    static $arrAtividadeFisicaDiaria = array(
        array("ID" => 0, "NOME" => "SELECIONE"),
        array("ID" => 1, "NOME" => "INDEPENDÊNCIA"),
        array("ID" => 2, "NOME" => "DEPENDÊNCIA PARCIAL"),
        array("ID" => 3, "NOME" => "DEPENDÊNCIA TOTAL")
    );

    static $arrVentilacaoMecanica = array(
        array("ID" => 0, "NOME" => "NÃO POSSUÍ"),
        array("ID" => 1, "NOME" => "INTERMITENTE"),
        array("ID" => 2, "NOME" => "CONTÍNUA")
    );

    static $arrSimNao2 = array(
        array("ID" => 0, "NOME" => "NÃO INFORMADO"),
        array("ID" => 2, "NOME" => "SIM"),
        array("ID" => 1, "NOME" => "NÃO")
    );

    static $arrAcessoVenoso = array(
        array("ID" => 0, "NOME" => "NÃO POSSUÍ"),
        array("ID" => 1, "NOME" => "PERIFÉRICO"),
        array("ID" => 2, "NOME" => "PROFUNDO")
    );

    static $arrOxigenoterapia = array(
        array("ID" => 0, "NOME" => "NÃO POSSUÍ"),
        array("ID" => 1, "NOME" => "INTERMITENTE"),
        array("ID" => 2, "NOME" => "CONTÍNUA")
    );

    static $arrDiagnosticoEnfermagem = array(
        array("ID" => 0, "NOME" => ""),
        array("ID" => 1, "NOME" => "Risco de Aspiração"),
        array("ID" => 2, "NOME" => "Nutrição Alterada"),
        array("ID" => 3, "NOME" => "Memória prejudicada"),
        array("ID" => 4, "NOME" => "Incontinência urinária"),
        array("ID" => 5, "NOME" => "Risco para quedas"),
        array("ID" => 6, "NOME" => "Risco para integridade de pele prejudicada"),
        array("ID" => 7, "NOME" => "Controle ineficaz do regime terapêutico"),
        array("ID" => 8, "NOME" => "Deglutição prejudicada"),
        array("ID" => 9, "NOME" => "Padrão de sono perturbado"),
        array("ID" => 10, "NOME" => "Interação social prejudicada"),
        array("ID" => 11, "NOME" => "Risco de constipação"),
        array("ID" => 12, "NOME" => "Comunicação verbal prejudicada"),
        array("ID" => 13, "NOME" => "Mobilidade física prejudicada"),
        array("ID" => 14, "NOME" => "Eliminação urinária prejudicada"),
        array("ID" => 15, "NOME" => "Risco para infecção")
    );

    static $arrPlanoCuidado = array(
        array("ID" => 0, "NOME" => ""),
        array("ID" => 1, "NOME" => "Elevar a cabeceira a 45 graus, no mínimo, para administrar a dieta ou ofertar a alimentação por via oral."),
        array("ID" => 2, "NOME" => "Para a dieta enteral, se houver necessidade de aspiração de vias aéreas durante a aspiração."),
        array("ID" => 3, "NOME" => "Realizar higiene íntima, com troca de fraldas (se necessário), após urinar ou evacuar."),
        array("ID" => 4, "NOME" => "Realizar mudanças de decúbito(de posição) a cada 02 a 03 horas."),
        array("ID" => 5, "NOME" => "Fazer uso de almofadas, travesseiros, rolos para apoiar e dar conforto ao paciente."),
        array("ID" => 6, "NOME" => "Fazer uso do AGE(óleo com ácidos graxos essenciais)nos locais com maior predisposição para o desenvolvimento de úlceras, como região sacra, maleolar, trocantórica e calcânea."),
        array("ID" => 7, "NOME" => "Lavar cateter nasoenteral, nasogástrico ou de gastrostomia, SEMPRE, antes e após administração de dieta ou medicação."),
        array("ID" => 8, "NOME" => "Antes de administrar medicação em comprimidos por cateres(nasoenteral ou nasogástrico), macerar, colocar de molho e administrar a medicação.")        
    );

    static $arrBradenPercepcao = array(
        array("ID" => 0, "NOME" => ""),
        array("ID" => 1, "NOME" => "Completamente Limitado"),
        array("ID" => 2, "NOME" => "Muito Limitado"),
        array("ID" => 3, "NOME" => "Levemente Limitado"),
        array("ID" => 4, "NOME" => "Nenhuma Limitação")
    );

    static $arrBradenUmidade = array(
        array("ID" => 0, "NOME" => ""),
        array("ID" => 1, "NOME" => "Constantemente Úmida"),
        array("ID" => 2, "NOME" => "Muito Úmida"),
        array("ID" => 3, "NOME" => "Ocasionamente Úmida"),
        array("ID" => 4, "NOME" => "Raramente Úmida")
    );

    static $arrBradenAtividade = array(
        array("ID" => 0, "NOME" => ""),
        array("ID" => 1, "NOME" => "Acamado"),
        array("ID" => 2, "NOME" => "Restrito à Cadeira"),
        array("ID" => 3, "NOME" => "Caminha Ocasionalmente"),
        array("ID" => 4, "NOME" => "Caminha Frequêntemente")
    );

    static $arrBradenMobilidade = array(
        array("ID" => 0, "NOME" => ""),
        array("ID" => 1, "NOME" => "Completamente Imóvel"),
        array("ID" => 2, "NOME" => "Muito Limitado"),
        array("ID" => 3, "NOME" => "Levemente Limitado"),
        array("ID" => 4, "NOME" => "Nenhuma Limitação")
    );

    static $arrBradenNutricao = array(
        array("ID" => 0, "NOME" => ""),
        array("ID" => 1, "NOME" => "Muito Pobre"),
        array("ID" => 2, "NOME" => "Provavelmente Inadequado"),
        array("ID" => 3, "NOME" => "Adequado"),
        array("ID" => 4, "NOME" => "Excelente")
    );

    static $arrBradenFiccao = array(
        array("ID" => 0, "NOME" => ""),
        array("ID" => 1, "NOME" => "Problema"),
        array("ID" => 2, "NOME" => "Potencial para Problemas"),
        array("ID" => 3, "NOME" => "Nenhum Problema Aparente")
    );

    static $arrFichaNutricaoNutricao = array(
        array("ID" => 0, "NOME" => ""),
        array("ID" => 1, "NOME" => "ORAL"),
        array("ID" => 2, "NOME" => "ENTERAL")
    );

    static $arrFichaNutricaoNutricaoEnteral = array(
        array("ID" => 0, "NOME" => ""),
        array("ID" => 1, "NOME" => "SNE"),
        array("ID" => 2, "NOME" => "GASTROSTOMIA")
    );

    static $arrFichaNutricaoDietaEnteral = array(
        array("ID" => 0, "NOME" => ""),
        array("ID" => 1, "NOME" => "ARTESANAL"),
        array("ID" => 2, "NOME" => "INDUSTRIALIZADA"),
        array("ID" => 3, "NOME" => "AMBAS")
    );

    static $arrFichaNutricaoDietaEnteralIndustForn = array(
        array("ID" => 0, "NOME" => ""),
        array("ID" => 1, "NOME" => "BENEFICIÁRIO"),
        array("ID" => 2, "NOME" => "PLANO"),
        array("ID" => 3, "NOME" => "AMBOS")
    );

    static $arrFichaNutricaoAvalSubjIngesta = array(
        array("ID" => 0, "NOME" => ""),
        array("ID" => 1, "NOME" => "AUMENTADA"),
        array("ID" => 2, "NOME" => "DIMINUÍDA"),
        array("ID" => 3, "NOME" => "NORMAL")
    );

    static $arrFichaNutricaoAvalSubjPeso = array(
        array("ID" => 0, "NOME" => ""),
        array("ID" => 1, "NOME" => "PERDA DE PESO"),
        array("ID" => 2, "NOME" => "GANHO DE PESO"),
        array("ID" => 3, "NOME" => "SEM ALTERAÇÕES")
    );

    static $arrFichaNutricaoDiagNutriAbaixo65 = array(
        array("ID" => 0, "NOME" => ""),
        array("ID" => 1, "NOME" => "NÃO ATRIBUÍDO"),
        array("ID" => 2, "NOME" => "BAIXO PESO"),
        array("ID" => 3, "NOME" => "EUTROFIA"),
        array("ID" => 4, "NOME" => "PRÉ-OBESIDADE"),
        array("ID" => 5, "NOME" => "OBESIDADE I"),
        array("ID" => 6, "NOME" => "OBESIDADE II"),
        array("ID" => 7, "NOME" => "OBESIDADE III")
    );

    static $arrFichaNutricaoDiagNutriAcima65 = array(
        array("ID" => 0, "NOME" => ""),
        array("ID" => 1, "NOME" => "NÃO ATRIBUÍDO"),
        array("ID" => 2, "NOME" => "BAIXO PESO"),
        array("ID" => 3, "NOME" => "EUTROFIA"),
        array("ID" => 4, "NOME" => "OBESIDADE")
    );

    static $arrFichaTecBaseTipoChamada = array(
        array("ID" => 0, "NOME" => ""),
        array("ID" => 1, "NOME" => "PROCEDIMENTO"),
        array("ID" => 2, "NOME" => "ENTREGA")
    );

    static $arrStatusSolicitacaoCompra = array(
        array("ID" => "", "NOME" => "SELECIONE"),
        array("ID" => "PENDENTE", "NOME" => "PENDENTE"),
        array("ID" => "COMPRADO", "NOME" => "COMPRADO"),
        array("ID" => "RECEBIDO", "NOME" => "RECEBIDO")
    );

    static $arrUrgenciaSolicitacaoCompra = array(
        array("ID" => "", "NOME" => "NÃO É URGÊNCIA"),
        array("ID" => "Alteração da condição clínica", "NOME" => "Alteração da condição clínica"),
        array("ID" => "Alteração do estado clínico", "NOME" => "Alteração do estado clínico"),
        array("ID" => "Alteração na prescrição médica", "NOME" => "Alteração na prescrição médica"),
        array("ID" => "Aumento de consumo", "NOME" => "Aumento de consumo"),
        array("ID" => "Consumo acima do previsto", "NOME" => "Consumo acima do previsto"),
        array("ID" => "Consumo excessivo", "NOME" => "Consumo excessivo"),
        array("ID" => "Extravio", "NOME" => "Extravio"),
        array("ID" => "Erro de contagem", "NOME" => "Erro de contagem"),
        array("ID" => "Erro na Integração", "NOME" => "Erro na Integração"),
        array("ID" => "Estoque Zerado", "NOME" => "Estoque Zerado"),
        array("ID" => "Falha na dispensação", "NOME" => "Falha na dispensação"),
        array("ID" => "Falha no plano terapêutico", "NOME" => "Falha no plano terapêutico"),
        array("ID" => "Falha na utilização", "NOME" => "Falha na utilização"),
        array("ID" => "Falha na solic. da secretaria", "NOME" => "Falha na solic. da secretaria"),
        array("ID" => "Falha na solic. da enfermeira", "NOME" => "Falha na solic. da enfermeira"),
        array("ID" => "Internação incompleta", "NOME" => "Internação incompleta"),
        array("ID" => "Não foi enviado pela fármacia", "NOME" => "Não foi enviado pela fármacia"),
        array("ID" => "Não pediu no consumo semanal", "NOME" => "Não pediu no consumo semanal"),
        array("ID" => "Não solicitado pedido semanal", "NOME" => "Não solicitado pedido semanal"),
        array("ID" => "Não solicitado pela secretaria", "NOME" => "Não solicitado pela secretaria"),
        array("ID" => "Perda na utilização", "NOME" => "Perda na utilização"),
        array("ID" => "Pedidos Semanais", "NOME" => "Pedidos Semanais"),
        array("ID" => "Reposição de Estoque", "NOME" => "Reposição de Estoque"),
        array("ID" => "Reposição incompleta", "NOME" => "Reposição incompleta"),
        array("ID" => "Troca de produto", "NOME" => "Troca de produto"),
        array("ID" => "Outros", "NOME" => "Outros"),
    );

}