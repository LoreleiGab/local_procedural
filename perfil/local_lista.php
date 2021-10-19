<?php
include "includes/menu_principal.php";

$con = bancoMysqli();

if (isset($_POST['apagar'])){
    $id = $_POST['idLocal'];
    $sql = "UPDATE locais SET publicado = 0 WHERE id = '$id'";
    if (mysqli_query($con, $sql)) {
        $mensagem = mensagem("success", "Local apagado com sucesso");
    } else {
        $mensagem = mensagem("danger", "Erro ao apagar local! Tente novamente.");
    }
}

$locais=$con->query("
    SELECT l.id, i.nome as instituicao, l.local, s.subprefeitura, z.zona
    FROM locais l
    INNER JOIN instituicoes i on l.instituicao_id = i.id
    INNER JOIN subprefeituras s on l.subprefeitura_id = s.id
    INNER JOIN zonas z on l.zona_id = z.id
    WHERE l.publicado = 1
")->fetch_all(MYSQLI_ASSOC);
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <!-- START FORM-->
        <h2 class="page-header">Locais</h2>
        <div class="row">
            <div class="col-md-2">
                <a href="?perfil=local&p=local_cadastro">
                    <button type="button" class="btn btn-block btn-success"><i class="fa fa-plus"></i> Adicionar</button>
                </a>
            </div>
        </div>
        <br/>
        <div class="row" align="center">
            <?= $mensagem ?? null ?>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Listagem</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="tabela1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Instituição</th>
                                <th>Local</th>
                                <th>Subprefeitura</th>
                                <th>Zona</th>
                                <th>Ação</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($locais as $local): ?>
                                <tr>
                                    <td><?= $local['instituicao'] ?></td>
                                    <td><?= $local['local'] ?></td>
                                    <td><?= $local['subprefeitura'] ?></td>
                                    <td><?= $local['zona'] ?></td>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <form method="POST" action="?perfil=local&p=local_cadastro" role="form">
                                                    <input type="hidden" name="id" value="<?= $local['id'] ?>">
                                                    <button type="submit" class="btn btn-block btn-primary"> Editar</button>
                                                </form>
                                            </div>
                                            <div class="col-md-6">
                                                <button class='btn btn-block btn-danger' data-toggle='modal' data-target='#apagar' onclick ='passarId(<?= $local['id'] ?>)'> Apagar</button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Instituição</th>
                                <th>Local</th>
                                <th>Subprefeitura</th>
                                <th>Zona</th>
                                <th>Ação</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.box-body -->
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

<!-- modal -->
<div class="modal fade" id="apagar" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" id='formApagar' action="?perfil=local&p=local_lista" class="form-horizontal"
                  role="form">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Apagar local</h4>
                </div>
                <div class="modal-body">
                    <p>Deseja mesmo apagar este local? </p>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="idLocal">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type='submit' class='btn btn-danger btn-sm' name="apagar">Confirmar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /.modal -->

<script defer src="../visual/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script defer src="../visual/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<script type="text/javascript">
    $(function () {
        $('#tabela1').DataTable({
            "language": {
                "url": 'bower_components/datatables.net/Portuguese-Brasil.json'
            },
            "responsive": true,
            "dom": "<'row'<'col-sm-6'l><'col-sm-6 text-right'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7 text-right'p>>"
        });
    });
</script>
<script>
    function passarId(id) {
        document.querySelector('#formApagar input[name="idLocal"]').value = id;
    }
</script>