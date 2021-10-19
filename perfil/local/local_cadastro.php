<?php
include "includes/menu_principal.php";

$con = bancoMysqli();

if (isset($_POST['cadastrar']) || isset($_POST['editar'])){
    $idInstituicao = $_POST['instituicao'];
    $local = addslashes($_POST['local']);
    $cep = $_POST['cep'];
    $logradouro = addslashes($_POST['rua']);
    $numero = $_POST['numero'];
    $complemento = $_POST['complemento'] ?? NULL;
    $bairro = addslashes($_POST['bairro']);
    $cidade = addslashes($_POST['cidade']);
    $estado = addslashes($_POST['estado']);
    $zona = addslashes($_POST['zona']);
    $subprefeitura_id = $_POST['subprefeitura'];
}

if (isset($_POST['cadastrar'])){
    $sql = "
        INSERT INTO locais (instituicao_id, local, logradouro, numero, complemento, bairro, cidade, uf, cep, zona_id, publicado, subprefeitura_id)
        VALUES ('$idInstituicao', '$local', '$logradouro', '$numero', '$complemento', '$bairro', '$cidade', '$estado', '$cep', '$zona', 1, '$subprefeitura_id')";

    if (mysqli_query($con, $sql)) {
        $id = recuperaUltimo("locais");
        $mensagem = mensagem("success", "Local cadastrado com sucesso");
    } else {
        $mensagem = mensagem("danger", "Erro na adição de local! Tente novamente.");
    }
}

if (isset($_POST['editar'])){
    $id = $_POST['id'];
    $sql = "UPDATE locais SET instituicao_id = '$idInstituicao', local = '$local', logradouro = '$logradouro', numero = '$numero', complemento = '$complemento', bairro = '$bairro', cidade = '$cidade', uf = '$estado', cep = '$cep', zona_id = '$zona' , subprefeitura_id = 'subprefeitura_id' WHERE id = '$id'";

    if (mysqli_query($con, $sql)) {
        $mensagem = mensagem("success", "Local editado com sucesso");
    } else {
        $mensagem = mensagem("danger", "Erro na edição de local! Tente novamente.");
    }
}

if (isset($_POST['carregar'])){
    $id = $_POST['id'];
}

if (!isset($id)){
    $id = null;
}

$local = $con->query("SELECT * FROM locais WHERE id = '$id'")->fetch_array(MYSQLI_ASSOC);
?>
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <!-- START FORM-->
        <h2 class="page-header">Cadastro de local</h2>
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Local</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="row" align="center">
                        <?= $mensagem ?? null ?>
                    </div>
                    <!-- form start -->
                    <form method="POST" action="?perfil=local&p=local_cadastro" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="instituicao">Instituição: *</label>
                                    <select name="instituicao" id="instituicao" class="form-control" required>
                                        <option value="">Selecione...</option>
                                        <?php
                                        geraOpcao('instituicoes', $local['instituicao_id'] ?? null);
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="cep">CEP: *</label>
                                    <input type="text" class="form-control" name="cep" id="cep" maxlength="9"
                                           placeholder="Digite o CEP" required data-mask="00000-000" value="<?= $local['cep'] ?? null ?>">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="local">Local: *</label>
                                    <input type="text" class="form-control" name="local" id="local" required value="<?= $local['local'] ?? null ?>">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-5">
                                    <label for="rua">Rua: *</label>
                                    <input type="text" class="form-control" name="rua" id="rua"
                                           placeholder="Digite a rua" maxlength="200" required value="<?= $local['logradouro'] ?? null ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="numero">Número:*</label>
                                    <input type="number" id="numero" name="numero" class="form-control" placeholder="Ex.: 10" required min="0" value="<?= $local['numero'] ?? null ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="zona">Zona: *</label>
                                    <select class="form-control" id="zona" name="zona">
                                        <option value="">Selecione...</option>
                                        <?php
                                        geraOpcao('zonas', $local['zona_id'] ?? null);
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="complemento">Complemento:</label>
                                    <input type="text" name="complemento" id="complemento" class="form-control" maxlength="20" placeholder="Digite o complemento" value="<?= $local['complemento'] ?? null ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="bairro">Bairro: *</label>
                                    <input type="text" class="form-control" name="bairro" id="bairro"
                                           placeholder="Digite o Bairro" maxlength="80" required value="<?= $local['bairro'] ?? null ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="cidade">Cidade: *</label>
                                    <input type="text" class="form-control" name="cidade" id="cidade"
                                           placeholder="Digite a cidade" maxlength="50" required value="<?= $local['cidade'] ?? null ?>">
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="estado">Estado: *</label>
                                    <input type="text" class="form-control" name="estado" id="estado" maxlength="2"
                                           placeholder="Ex.: SP" required value="<?= $local['uf'] ?? null ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="subprefeitura">Subprefeitura: *</label>
                                    <select class="form-control" id="subprefeitura" name="subprefeitura" required>
                                        <option value="">Selecione...</option>
                                        <?php
                                        geraOpcao('subprefeituras', $local['subprefeitura_id'] ?? null);
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="box-footer">
                            <?php if ($id): ?>
                                <input type="hidden" name="id" value="<?= $local['id'] ?>">
                            <?php endif; ?>
                            <button type="submit" name="<?= $id == null ? 'cadastrar' : 'editar' ?>" class="btn btn-primary pull-right">
                                Gravar
                            </button>
                        </div>
                    </form>
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
        <!-- END ACCORDION & CAROUSEL-->

    </section>
    <!-- /.content -->
</div>
