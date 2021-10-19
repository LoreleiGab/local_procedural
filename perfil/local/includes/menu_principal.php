<?php
//geram o insert pro framework da igsis
$pasta = "?perfil=local&p=";
?>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">Local</li>
            <li><a href="<?= $pasta ?>local_cadastro"><i class="fa fa-circle-o"></i> <span>Cadastra local</span></a></li>
            <li><a href="<?= $pasta ?>local_lista"><i class="fa fa-circle-o"></i> <span>Lista local</span></a></li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>