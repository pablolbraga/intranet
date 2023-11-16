<?php
require_once("../controllers/usuariocontroller.php");

$ctrUsuario = new UsuarioController();
?>

<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <div class="container-fluid">
            <nav class="navbar navbar-extends-lg navbar-dark bg-primary">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">Usuários</a>
                    <div class="btn-group dropstart">
                        <button type="button" class="btn btn-success btn-sm" onclick="cadastrarUsuario()">
                            <i class="fa fa-plus-circle"></i>
                            Adicionar
                        </button>
                    </div>
                </div>
            </nav>
            
            <br/>
            
            <form name="frmPesquisarUsuario" id="frmPesquisarUsuario" method="POST" action="index.php?pag=<?php echo @$_GET["pag"] ?>">
                <div class="row">
                    <label for="txtNomePesq" class="col-sm-2 col-form-label">Nome/Login:</label>
                    <div class="col-sm-10">
                        <input type="text" id="txtNomePesq" name="txtNomePesq" class="form-control form-control-sm" value="<?php echo @$_POST["txtNomePesq"] ?>" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2">
                        <button type="submit" class="btn btn-primary btn-sm" id="btnPesquisar" name="btnPesquisar"><i class="fa fa-search" aria-hidden="true"></i>Pesquisar</button>
                    </div>
                </div>
                
                <br/>
                
                <?php
                if (isset($_POST["btnPesquisar"])){
                    if ($_SESSION["ADM_USUARIO"] == "S"){
                        $qry = $ctrUsuario->listarUsuarios($_POST["txtNomePesq"]);
                    } else {
                        $qry = $ctrUsuario->listarUsuariosTerapia($_POST["txtNomePesq"]);
                    }
                    $qtd = count($qry);
                    if ($qtd > 0){
                        ?>
                        <table id="table" name="table" class="table table-bordered">
                            <thead>
                                <tr class="align-middle">
                                    <th scope="col" style="display: none;">Código</th>
                                    <th scope="col">Nome</th>
                                    <th scope="col">Login</th>
                                    <th scope="col">Email</th>
                                    <th scope="col" style="display: none;">IdPerson</th>  
                                    <th scope="col" style="display: none;">NmPerson</th> 
                                    <th scope="col" style="display: none;">IdUgb</th>  
                                    <th scope="col" style="display: none;">NmUgb</th> 
                                    <th scope="col" style="display: none;">Administrador</th>
                                    <th scope="col" style="display: none;">Financeiro</th> 
                                    <th scope="col" style="display: none;">Recebe OS</th> 
                                    <th scope="col" style="display: none;">Adm. OS</th> 
                                    <th scope="col" style="display: none;">Baixa Motorista</th> 
                                    <th scope="col" style="display: none;">Plantonista</th> 
                                    <th scope="col" style="display: none;">Acesso Externo</th> 
                                    <th scope="col" style="display: none;">Modo Mobile</th> 
                                    <th scope="col" style="display: none;">Prof. Externo</th> 
                                    <th scope="col" style="display: none;">Mód. Enfermagem</th> 
                                    <th scope="col" style="display: none;">Realiza Treinamento</th> 
                                    <th scope="col" style="display: none;">Editar Somente Terapia</th> 
                                    <th scope="col" style="text-align: center;">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach($qry as $lista){
                                    ?>
                                    <tr class="align-middle">
                                        <td style="display: none;"><?php echo $lista["IDUSUARIO"]?></td>
                                        <td><?php echo $lista["NOME"]?></td>
                                        <td><?php echo $lista["LOGIN"]?></td>
                                        <td><?php echo $lista["EMAIL"]?></td>
                                        <td style="display: none;"><?php echo $lista["IDPERSON"]?></td>
                                        <td style="display: none;"><?php echo $lista["NMUSUARIOIW"]?></td>
                                        <td style="display: none;"><?php echo $lista["IDUGB"]?></td>
                                        <td style="display: none;"><?php echo $lista["UGB"]?></td>
                                        <td style="display: none;"><?php echo $lista["ADM"]?></td>
                                        <td style="display: none;"><?php echo $lista["TIPOCAIXA"]?></td>
                                        <td style="display: none;"><?php echo $lista["OS"]?></td>
                                        <td style="display: none;"><?php echo $lista["ADM_OS"]?></td>
                                        <td style="display: none;"><?php echo $lista["BAIXASOLMOT"]?></td>
                                        <td style="display: none;"><?php echo $lista["PLANTONISTA"]?></td>
                                        <td style="display: none;"><?php echo $lista["EXTERNO"]?></td>
                                        <td style="display: none;"><?php echo $lista["MOBILE"]?></td>
                                        <td style="display: none;"><?php echo $lista["PROFEXT"]?></td>
                                        <td style="display: none;"><?php echo $lista["MODOENFA"]?></td>
                                        <td style="display: none;"><?php echo $lista["REALIZATREINAMENTO"]?></td>
                                        <td style="display: none;"><?php echo $lista["SOMENTETERAPIA"]?></td>
                                        <td style="text-align: center;">                                            
                                            <a href="#" class="btn btn-success btn-sm" onclick="abrirAlteracaoUsuario(this)"><i class="fa fa-pencil" aria-hidden="true"></i> Alterar</a>
                                            <a href="#" class="btn btn-danger btn-sm" onclick="abrirExclusaoUsuario(this)"><i class="fa fa-trash" aria-hidden="true"></i> Excluir</a>
                                            <a href="#" class="btn btn-primary btn-sm" onclick="abrirAlterarSenhaUsuario(this)"><i class="fa fa-key" aria-hidden="true"></i> Alterar Senha</a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                        <?php
                    } else {
                        ?>
                        <br />
                        <div class="alert alert-danger" role="alert">
                            Nenhum registro encontrado com os parâmetros informados.
                        </div>
                        <?php
                    }
                }
                ?>
            </form>    
        </div>
    </body>
</html>

<!-- Modal de Cadastro -->
<div class="modal fade" id="modalAdicionarUsuario" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Usuario</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formAdicionarUsuario" method="POST">
                <input type="hidden" id="txtCodigo" name="txtCodigo" value="0" />
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="txtNome" class="form-label form-label-sm">Nome</label>
                            <input type="text" class="form-control form-control-sm" id="txtNome" name="txtNome" value="" maxlength="200" required />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="txtLogin" class="form-label form-label-sm">Login</label>
                            <input type="text" class="form-control form-control-sm" id="txtLogin" name="txtLogin" value="" required />
                        </div>
                        <div class="col-md-6">
                            <label for="txtEmail" class="form-label form-label-sm">Email</label>
                            <input type="text" class="form-control form-control-sm" id="txtEmail" name="txtEmail" value="" required />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="txtCodUsuarioIw" class="form-label form-label-sm">Usuário IW</label>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="input-group">
                                        <input type="text" id="txtCodUsuarioIw" name="txtCodUsuarioIw" class="form-control form-control-sm" aria-label="" aria-describedby="btnPesqUsuarioIw" readonly="readonly" style="text-align: right;" required>
                                        <button class="btn btn-outline-secondary btn-sm" type="button" id="btnPesqUsuarioIW" onclick="window.open('busca.php?tipo=13&campocodigo=txtCodUsuarioIw&campodescricao=txtDescUsuarioIw&title=Pesquisar Usuário IW','','width=900, height=500')">...</button>
                                    </div>
                                </div>  
                                <div class="col-sm-9">
                                    <input type="text" id="txtDescUsuarioIw" name="txtDescUsuarioIw" class="form-control form-control-sm" readonly="readonly"/>
                                </div>
                            </div>                                    
                        </div>
                        <?php
                        if ($_SESSION["ADM_USUARIO"] == "S"){
                            ?>
                            <div class="col-md-6">
                                <label for="txtCodUgb" class="form-label form-label-sm">UGB</label>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <input type="text" id="txtCodUgb" name="txtCodUgb" class="form-control form-control-sm" aria-label="" aria-describedby="btnPesqUgb" readonly="readonly" style="text-align: right;" required>
                                            <button class="btn btn-outline-secondary btn-sm" type="button" id="btnPesqUgb" onclick="window.open('busca.php?tipo=14&campocodigo=txtCodUgb&campodescricao=txtDescUgb&title=Pesquisar UGB','','width=900, height=500')">...</button>
                                        </div>
                                    </div>  
                                    <div class="col-sm-9">
                                        <input type="text" id="txtDescUgb" name="txtDescUgb" class="form-control form-control-sm" readonly="readonly"/>
                                    </div>
                                </div>                                    
                            </div>
                            <?php
                        } else {
                            ?>
                            <input type="hidden" name="txtCodUgb" id="txtCodUgb" value="28" />
                            <input type="hidden" name="txtDescUgb" id="txtDescUgb" value="SEM UGB" />
                            <?php
                        }
                        ?>                                
                    </div>
                    <?php
                    if ($_SESSION["ADM_USUARIO"] == "S"){
                        ?>
                        <div class="row">
                            <div class="col-md-3">
                                <label for="cmbAministrador" class="form-label form-label-sm">Administrador</label>
                                <select id="cmbAministrador" name="cmbAministrador" class="form-select form-select-sm" required>
                                    <option value="">Selecione</option>
                                    <option  value="S">SIM</option>
                                    <option  value="N">NÃO</option> 
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="cmbCaixa" class="form-label form-label-sm">Financeiro</label>
                                <select id="cmbCaixa" name="cmbCaixa" class="form-select form-select-sm" required>
                                    <option value="">Selecione</option>
                                    <option  value="N">NÃO</option>
                                    <option  value="C">CAIXA</option>
                                    <option  value="G">GESTOR</option> 
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="cmbRecebeOs" class="form-label form-label-sm">Recebe OS:</label>
                                <select id="cmbRecebeOs" name="cmbRecebeOs" class="form-select form-select-sm" required>
                                    <option value="">Selecione</option>
                                    <option  value="S">SIM</option>
                                    <option  value="N">NÃO</option> 
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="cmbAdmOs" class="form-label form-label-sm">Adm. OS:</label>
                                <select id="cmbAdmOs" name="cmbAdmOs" class="form-select form-select-sm" required>
                                    <option value="">Selecione</option>
                                    <option  value="S">SIM</option>
                                    <option  value="N">NÃO</option> 
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label for="cmbBaixaMoto" class="form-label form-label-sm">Baixa Motorista:</label>
                                <select id="cmbBaixaMoto" name="cmbBaixaMoto" class="form-select form-select-sm" required>
                                    <option value="">Selecione</option>
                                    <option  value="S">SIM</option>
                                    <option  value="N">NÃO</option> 
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="cmbPlantonista" class="form-label form-label-sm">Plantonista:</label>
                                <select id="cmbPlantonista" name="cmbPlantonista" class="form-select form-select-sm" required>
                                    <option value="">Selecione</option>
                                    <option  value="S">SIM</option>
                                    <option  value="N">NÃO</option> 
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="cmbAcesso" class="form-label form-label-sm">Acesso Externo</label>
                                <select id="cmbAcesso" name="cmbAcesso" class="form-select form-select-sm" required>
                                    <option value="">Selecione</option>
                                    <option  value="1">SIM</option>
                                    <option selected value="0">NÃO</option> 
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="cmbMobile" class="form-label form-label-sm">Modo Mobile</label>
                                <select id="cmbMobile" name="cmbMobile" class="form-select form-select-sm" required>
                                    <option value="">Selecione</option>
                                    <option  value="1">SIM</option>
                                    <option selected value="0">NÃO</option> 
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label for="cmbProfExt" class="form-label form-label-sm">Prof. Esp. Externo:</label>
                                <select id="cmbProfExt" name="cmbProfExt" class="form-select form-select-sm" required>
                                    <option value="">Selecione</option>
                                    <option  value="S">SIM</option>
                                    <option  value="N">NÃO</option> 
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="cmbModEnf" class="form-label form-label-sm">Mód. Enfermagem:</label>
                                <select id="cmbModEnf" name="cmbModEnf" class="form-select form-select-sm" required>
                                    <option value="">Selecione</option>
                                    <option  value="S">SIM</option>
                                    <option  value="N">NÃO</option>                            
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="cmbTreinamentoEdContinuada" class="form-label form-label-sm">Realiza Treinamento:</label>
                                <select id="cmbTreinamentoEdContinuada" name="cmbTreinamentoEdContinuada" class="form-select form-select-sm" required>
                                    <option value="">Selecione</option>
                                    <option  value="S">SIM</option>
                                    <option  value="N">NÃO</option> 
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="cmbSomenteTerapia" class="form-label form-label-sm">Editar Somente Terapia:</label>
                                <select id="cmbSomenteTerapia" name="cmbSomenteTerapia" class="form-select form-select-sm" required>
                                    <option value="">Selecione</option>
                                    <option  value="S">SIM</option>
                                    <option  value="N">NÃO</option> 
                                </select>
                            </div>
                        </div>
                        <?php
                    } else {
                        ?>
                        <input type="hidden" name="cmbAministrador" id="cmbAministrador" value="N" />
                        <input type="hidden" name="cmbCaixa" id="cmbCaixa" value="N" />
                        <input type="hidden" name="cmbRecebeOs" id="cmbRecebeOs" value="N" />
                        <input type="hidden" name="cmbAdmOs" id="cmbAdmOs" value="N" />
                        <input type="hidden" name="cmbBaixaMoto" id="cmbBaixaMoto" value="N" />
                        <input type="hidden" name="cmbPlantonista" id="cmbPlantonista" value="N" />
                        <input type="hidden" name="cmbAcesso" id="cmbAcesso" value="0" />
                        <input type="hidden" name="cmbMobile" id="cmbMobile" value="0" />
                        <input type="hidden" name="cmbProfExt" id="cmbProfExt" value="N" />
                        <input type="hidden" name="cmbModEnf" id="cmbModEnf" value="N" />
                        <input type="hidden" name="cmbTreinamentoEdContinuada" id="cmbTreinamentoEdContinuada" value="N" />
                        <input type="hidden" name="cmbSomenteTerapia" id="cmbSomenteTerapia" value="N" />
                        <?php
                    }
                    ?>
                    <small>
                        <div id="mensagem" align="center"></div>
                    </small>                            
                </div>
                <div class="modal-footer">
                    <button type="button" id="btn-fechar-solicitar" name="btn-fechar-solicitar" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="fa fa-sign-out" aria-hidden="true"></i> Sair</button>
                    <button type="submit" id="btn-gravar-solicitar" name="btn-gravar-solicitar" class="btn btn-primary btn-sm"><i class="fa fa-floppy-o" aria-hidden="true"></i> Gravar</button>
                </div>
            </form>                               
        </div>
    </div>
</div>

<div class="modal fade" id="modalExcluirUsuario" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Exclusão</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formExcluirUsuario" method="POST">
                <input type="hidden" id="txtCodigoExc" name="txtCodigoExc" value="0" />
                <div class="modal-body">
                    Deseja excluir o registro?
                    <small>
                        <div id="mensagemExc" align="center"></div>
                    </small>                            
                </div>
                <div class="modal-footer">
                    <button type="button" id="btn-fechar-excluir" name="btn-fechar-excluir" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="fa fa-sign-out" aria-hidden="true"></i> Sair</button>
                    <button type="submit" id="btn-gravar-excluir" name="btn-gravar-excluir" class="btn btn-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i> Excluir</button>
                </div>
            </form>                               
        </div>
    </div>
</div>

<div class="modal fade" id="modalAlterarSenhaUsuario" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Alterar Senha</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formAlterarSenhaUsuario" method="POST">
                <input type="hidden" id="txtCodigoAltSenha" name="txtCodigoAltSenha" value="0" />
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="txtSenha" class="form-label form-label-sm">Senha</label>
                            <input type="password" class="form-control form-control-sm" id="txtSenha" name="txtSenha" value="" maxlength="50" required />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="txtConfirmarSenha" class="form-label form-label-sm">Confirmar Senha</label>
                            <input type="password" class="form-control form-control-sm" id="txtConfirmarSenha" name="txtConfirmarSenha" value="" maxlength="50" required />
                        </div>
                    </div>
                    <small>
                        <div id="mensagemAltSenha" align="center"></div>
                    </small>                            
                </div>
                <div class="modal-footer">
                    <button type="button" id="btn-fechar-altsenha" name="btn-fechar-altsenha" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="fa fa-sign-out" aria-hidden="true"></i> Sair</button>
                    <button type="submit" id="btn-gravar-altsenha" name="btn-gravar-altsenha" class="btn btn-primary btn-sm"><i class="fa fa-floppy-o" aria-hidden="true"></i> Alterar Senha</button>
                </div>
            </form>                               
        </div>
    </div>
</div>

<script>
    function cadastrarUsuario(){
        limparCamposCadastro();
        $("#mensagem").text("");
        $("#mensagem").removeClass();

        var myModal = new bootstrap.Modal(document.getElementById("modalAdicionarUsuario"), {});
        myModal.show();
    }
    
    function limparCamposCadastro(){
        document.getElementById('txtCodigo').value = "0";
        document.getElementById('txtNome').value = "";
        document.getElementById('txtLogin').value = "";
        document.getElementById('txtEmail').value = "";
        document.getElementById('txtCodUsuarioIw').value = "";
        document.getElementById('txtDescUsuarioIw').value = "";
        document.getElementById('txtCodUgb').value = "";
        document.getElementById('txtDescUgb').value = "";
        document.getElementById('cmbAministrador').value = "N";
        document.getElementById('cmbCaixa').value = "N";
        document.getElementById('cmbRecebeOs').value = "N";
        document.getElementById('cmbAdmOs').value = "N";
        document.getElementById('cmbBaixaMoto').value = "N";
        document.getElementById('cmbPlantonista').value = "N";
        document.getElementById('cmbAcesso').value = "0";
        document.getElementById('cmbMobile').value = "0";
        document.getElementById('cmbProfExt').value = "N";
        document.getElementById('cmbModEnf').value = "N";
        document.getElementById('cmbTreinamentoEdContinuada').value = "N";
        document.getElementById('cmbSomenteTerapia').value = "N";
    }
    
    function abrirAlteracaoUsuario(linha){
        var tableData = $(linha).closest("tr").find("td:not(:last-child)").map(function(){
            return $(this).text().trim();
        }).get();

        $("#txtCodigo").val(tableData[0]);
        $("#txtNome").val(tableData[1]);
        $("#txtLogin").val(tableData[2]);
        $("#txtEmail").val(tableData[3]);
        $("#txtCodUsuarioIw").val(tableData[4]);
        $("#txtDescUsuarioIw").val(tableData[5]);
        $("#txtCodUgb").val(tableData[6]);
        $("#txtDescUgb").val(tableData[7]);
        $("#cmbAministrador").val(tableData[8]);
        $("#cmbCaixa").val(tableData[9]);
        $("#cmbRecebeOs").val(tableData[10]);
        $("#cmbAdmOs").val(tableData[11]);
        $("#cmbBaixaMoto").val(tableData[12]);
        $("#cmbPlantonista").val(tableData[13]);
        $("#cmbAcesso").val(tableData[14]);
        $("#cmbMobile").val(tableData[15]);
        $("#cmbProfExt").val(tableData[16]);
        $("#cmbModEnf").val(tableData[17]);
        $("#cmbTreinamentoEdContinuada").val(tableData[18]);
        $("#cmbSomenteTerapia").val(tableData[19]);

        $("#mensagem").text("");
        $("#mensagem").removeClass();

        var myModal = new bootstrap.Modal(document.getElementById("modalAdicionarUsuario"), {});
        myModal.show();
    }
    
    $("#formAdicionarUsuario").submit(function(){
        event.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "usuario_mov.php?tipo=N",
            type: "POST",
            data: formData, 

            success: function(mensagem){
                $("#mensagem").text("");
                $("#mensagem").removeClass();
                if (mensagem.trim() === "Incluído com sucesso."){
                    window.location.reload(true);
                    $("#btn-fechar-solicitar").click(); 
                } else {
                    $("#mensagem").addClass("text-danger");
                    $("#mensagem").text(mensagem);
                }
            },

            cache: false,
            contentType: false,
            processData: false
        });
    });

    function abrirExclusaoUsuario(linha){
        var tableData = $(linha).closest("tr").find("td:not(:last-child)").map(function(){
            return $(this).text().trim();
        }).get();

        $("#txtCodigoExc").val(tableData[0]);

        $("#mensagemExc").text("");
        $("#mensagemExc").removeClass();

        var myModalExc = new bootstrap.Modal(document.getElementById("modalExcluirUsuario"), {});
        myModalExc.show();
    }

    $("#formExcluirUsuario").submit(function(){
        event.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "usuario_mov.php?tipo=X",
            type: "POST",
            data: formData, 

            success: function(mensagem){
                $("#mensagemExc").text("");
                $("#mensagemExc").removeClass();
                if (mensagem.trim() === "Excluído com sucesso."){
                    window.location.reload(true);
                    $("#btn-fechar-excluir").click(); 
                } else {
                    $("#mensagemExc").addClass("text-danger");
                    $("#mensagemExc").text(mensagem);
                }
            },

            cache: false,
            contentType: false,
            processData: false
        });
    });

    function abrirAlterarSenhaUsuario(linha){
        var tableData = $(linha).closest("tr").find("td:not(:last-child)").map(function(){
            return $(this).text().trim();
        }).get();

        $("#txtCodigoAltSenha").val(tableData[0]);
        $("#txtSenha").val("");
        $("#txtConfirmarSenha").val("");

        $("#mensagemAltSenha").text("");
        $("#mensagemAltSenha").removeClass();

        var myModalAltSenha = new bootstrap.Modal(document.getElementById("modalAlterarSenhaUsuario"), {});
        myModalAltSenha.show();
    }

    $("#formAlterarSenhaUsuario").submit(function(){
        event.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "usuario_mov.php?tipo=AS",
            type: "POST",
            data: formData, 

            success: function(mensagem){
                $("#mensagemAltSenha").text("");
                $("#mensagemAltSenha").removeClass();
                if (mensagem.trim() == "Alterado com sucesso."){
                    window.location.reload(true);
                    $("#btn-fechar-altsenha").click(); 
                } else {
                    $("#mensagemAltSenha").addClass("text-danger")
                    $("#mensagemAltSenha").text(mensagem);
                }
            },

            cache: false,
            contentType: false,
            processData: false,
        })
    });
</script>