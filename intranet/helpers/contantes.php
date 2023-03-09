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

}