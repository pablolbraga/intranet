<?php
// Tela de pesquisa modal
// Campos obrigatórios
// Tipo: Tipo do relatório
// os sql's que irão ser criados tem que ter como campos retornos ID e NOME obrigatoriamente.
// 1 - COOPERATIVAS
// campocodigo = referente ao campo que vai receber o codigo na pagina pai
// campodescricao = referente ao campo que vai receber a descrição na página pai
// title = Titulo da página
// Exemplo de link
// javascript:window.open('busca.php?tipo=1&campocodigo=txtCodEspecialidade&campodescricao=txtDescEspecialidade&title=Pesquisar Paciente','','width=900, height=500')

require_once("../conexao/conexao.php");

$conexao = Conexao::getInstance();

$_SQL_COOPERATIVAS = "SELECT ID, NAME AS NOME FROM GLBENTERPRISE WHERE PROFPROVIDER = 1 ";
$_SQL_PROFISSIONAIS_TERAPIA = "SELECT PF.ID, PF.NAME AS NOME FROM GLBPROFESSIONAL PROF 
INNER JOIN GLBPERSON PF ON PF.ID = PROF.IDPERSON 
WHERE PROF.SCSPECIALITY IN (167646,167647,316217,316219,167648,167649,124467,137601,137602,
134625,122646,122647,123931,123932,122633) ";
$_SQL_PACIENTES_ATIVOS = "SELECT ADM.ID, (PF.NAME || ' - ' || HP.NAME) AS NOME 
FROM CAPADMISSION ADM 
INNER JOIN GLBPATIENT PAT ON PAT.ID = ADM.IDPATIENT 
INNER JOIN GLBPERSON PF ON PF.ID = PAT.IDPERSON 
INNER JOIN glbhealthprovdep HPD ON HPD.ID = adm.idhealthprovdep 
INNER JOIN glbhealthprovider HP ON HP.ID = hpd.idhealthprovider 
WHERE ADM.STATUS = 1 ";

$_SQL_PACIENTES_GERAL = "SELECT ADM.ID, (PF.NAME || ' - ' || HP.NAME || (CASE ADM.STATUS WHEN 2 THEN ' (ALTA)' ELSE '' END)) AS NOME 
FROM CAPADMISSION ADM 
INNER JOIN GLBPATIENT PAT ON PAT.ID = ADM.IDPATIENT 
INNER JOIN GLBPERSON PF ON PF.ID = PAT.IDPERSON 
INNER JOIN glbhealthprovdep HPD ON HPD.ID = adm.idhealthprovdep 
INNER JOIN glbhealthprovider HP ON HP.ID = hpd.idhealthprovider 
WHERE ADM.STATUS IN (1,2) ";
$_SQL_PROFISSIONAIS_ATIVOS = "SELECT PF.ID, PF.NAME AS NOME FROM GLBPROFESSIONAL PROF INNER JOIN GLBPERSON PF ON PF.ID = PROF.IDPERSON 
WHERE PROF.ACTIVE = 1";
$_SQL_ESPECIALIDADES = "select ID, CODENAME AS NOME from scccode where idtable = 144 and canceled = 0 ORDER BY CODENAME";
$_SQL_PROFISSIONAIS_ENFERMEIRO = "SELECT PF.ID, PF.NAME AS NOME FROM GLBPROFESSIONAL PROF 
INNER JOIN GLBPERSON PF ON PF.ID = PROF.IDPERSON 
WHERE PROF.SCSPECIALITY IN (122632, 243378, 243379, 350292) AND PROF.ACTIVE = 1 ";
$_SQL_PACIENTES_ATIVOS_POR_IDPATIENT = "SELECT ADM.IDPATIENT AS ID, (PF.NAME || ' - ' || HP.NAME) AS NOME 
FROM CAPADMISSION ADM 
INNER JOIN GLBPATIENT PAT ON PAT.ID = ADM.IDPATIENT 
INNER JOIN GLBPERSON PF ON PF.ID = PAT.IDPERSON 
INNER JOIN glbhealthprovdep HPD ON HPD.ID = adm.idhealthprovdep 
INNER JOIN glbhealthprovider HP ON HP.ID = hpd.idhealthprovider 
WHERE ADM.STATUS = 1 ";
$_SQL_SERVICOS = "SELECT ID, NAME AS NOME FROM GLBHEALTHPROVIDER ORDER BY NAME";
$_SQL_MATMED = "SELECT SC.ID, SC.CODENAME AS NOME FROM SCCCODE SC WHERE SC.IDTABLE IN (54,55) ORDER BY SC.CODENAME";
$_SQL_FORNECEDOR = "SELECT ID, NAME AS NOME FROM GLBENTERPRISE WHERE SUPPLIERMAT = 1 ORDER BY NAME";
$_SQL_LISTAPARTCONVENIOGERAL = "SELECT CODIGO AS ID, (NOME || ' - ' || TIPO) AS NOME FROM VW_LISTA_PART_CONVENIO_GERAL ORDER BY NOME";

?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="../css/bs/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script>
            function enviarDados(e){
                var linha = $(e).closest("tr");
                var codigo = linha.find("td:eq(0)").text().trim();
                var nome = linha.find("td:eq(1)").text().trim();

                var campocodigo = document.getElementById("campocodigo").value;
                var campodescricao = document.getElementById("campodescricao").value;

                window.opener.document.getElementById(campocodigo).value = codigo;
                window.opener.document.getElementById(campodescricao).value = nome;

                window.close();
            }
        </script>
    </head>
    <body>
        <div class="container-fluid">
            <nav class="navbar navbar-extends-lg navbar-dark bg-primary">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#"><?php echo $_REQUEST["title"] ?></a>
                </div>
            </nav>
        </div>

        <br>
        <form name="form-pesquisa" id="form-pesquisa" method="POST" action="busca.php?tipo=<?php echo $_REQUEST["tipo"] ?>&campocodigo=<?php echo $_REQUEST["campocodigo"] ?>&campodescricao=<?php echo $_REQUEST["campodescricao"] ?>&title=<?php echo $_REQUEST["title"] ?>">
            <input type="hidden" name="campocodigo" id="campocodigo" value="<?php echo $_REQUEST["campocodigo"] ?>" />
            <input type="hidden" name="campodescricao" id="campodescricao" value="<?php echo $_REQUEST["campodescricao"] ?>" />
            <input type="hidden" name="tipo" id="tipo" value="<?php echo $_REQUEST["tipo"] ?>" />

            <div class="container-fluid">
                <div class="row">
                    <div class="col-auto">
                        <label for="txtPesquisa" class="col-form-label col-form-label-sm">Pesquisar</label>
                    </div>
                    <div class="col-auto">
                        <div class="input-group">
                            <input type="text" name="txtPesquisa" id="txtPesquisa" />
                        </div>
                    </div>
                    <div class="col-auto">
                        <input type="submit" name="btnPesquisar" id="btnPesquisar" class="btn btn-primary btn-sm" value="Pesquisar" />
                    </div>
                </div>
                <?php
                if (isset($_POST["btnPesquisar"])){
                    if ($_POST["tipo"] == 1){
                        $sql = $_SQL_COOPERATIVAS;
                    } else if ($_POST["tipo"] == 2){
                        $sql = $_SQL_PROFISSIONAIS_TERAPIA;
                    }  else if ($_POST["tipo"] == 3){
                        $sql = $_SQL_PACIENTES_ATIVOS;
                    }  else if ($_POST["tipo"] == 4){
                        $sql = $_SQL_PACIENTES_GERAL;
                    }  else if ($_POST["tipo"] == 5){
                        $sql = $_SQL_PROFISSIONAIS_ATIVOS;
                    }  else if ($_POST["tipo"] == 6){
                        $sql = $_SQL_ESPECIALIDADES;
                    }  else if ($_POST["tipo"] == 7){
                        $sql = $_SQL_PROFISSIONAIS_ENFERMEIRO;
                    }  else if ($_POST["tipo"] == 8){
                        $sql = $_SQL_PACIENTES_ATIVOS_POR_IDPATIENT;
                    }  else if ($_POST["tipo"] == 9){
                        $sql = $_SQL_SERVICOS;
                    }  else if ($_POST["tipo"] == 10){
                        $sql = $_SQL_MATMED;
                    }  else if ($_POST["tipo"] == 11){
                        $sql = $_SQL_FORNECEDOR;
                    }  else if ($_POST["tipo"] == 12){
                        $sql = $_SQL_LISTAPARTCONVENIOGERAL;
                    }

                    $sql2 = "SELECT J.ID, J.NOME FROM (";
                    $sql2 .= $sql;
                    $sql2 .= ") J WHERE 1 = 1 ";

                    if ($_POST["txtPesquisa"] != ""){
                        $sql2 .= "AND UPPER(NOME) LIKE '%" . strtoupper($_POST["txtPesquisa"]) . "%' ";
                    }

                    $sql2 .= "ORDER BY J.NOME";

                    $qry = $conexao->prepare($sql2);
                    $qry->execute();
                    $lista = $qry->fetchAll(PDO::FETCH_ASSOC);                    

                    $qtd = count($lista);

                    if ($qtd > 0){
                        ?>
                        <table class="table table-sm">
                            <thead>
                                <th scope="col">Codigo</th>
                                <th scope="col">Descrição</th>
                                <th scope="col"></th>
                            </thead>
                            <tbody>
                                <?php
                                for($i = 0; $i < $qtd; $i++){
                                    ?>
                                    <tr>
                                        <td><?php echo $lista[$i]["ID"] ?></td>
                                        <td><?php echo $lista[$i]["NOME"] ?></td>
                                        <td>
                                            <input type="button" class="btn btn-primary btn-sm" name="btnSelecionar" id="btnSelecionar" value="Selecionar" onclick="enviarDados(this)">
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                        <?php
                    }
                }
                ?>
            </div>
        </form>

        <script src="../js/bs/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    </body>
</html>