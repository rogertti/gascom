<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
        <?php
            switch($m) {
                case 1:
                    echo'
                    <li class="active">
                        <a href="inicio" title="In&iacute;cio"><i class="fa fa-window-maximize"></i> <span>In&iacute;cio</span></a>
                    </li>
                    <li>
                        <a href="categoria" title="Gerencie as categorias"><i class="fa fa-tags"></i> <span>Categoria</span></a>
                    </li>
                    <li>
                        <a href="usuario" title="Gerencie os usu&aacute;rios"><i class="fa fa-users"></i> <span>Usu&aacute;rio</span></a>
                    </li>';
                    break;
                
                case 2:
                    echo'
                    <li>
                        <a href="inicio" title="In&iacute;cio"><i class="fa fa-window-maximize"></i> <span>In&iacute;cio</span></a>
                    </li>
                    <li class="active">
                        <a href="categoria" title="Gerencie as categorias"><i class="fa fa-tags"></i> <span>Categoria</span></a>
                    </li>
                    <li>
                        <a href="usuario" title="Gerencie os usu&aacute;rios"><i class="fa fa-users"></i> <span>Usu&aacute;rio</span></a>
                    </li>';
                    break;
                
                case 3:
                    echo'
                    <li>
                        <a href="inicio" title="In&iacute;cio"><i class="fa fa-window-maximize"></i> <span>In&iacute;cio</span></a>
                    </li>
                    <li>
                        <a href="categoria" title="Gerencie as categorias"><i class="fa fa-tags"></i> <span>Categoria</span></a>
                    </li>
                    <li class="active">
                        <a href="usuario" title="Gerencie os usu&aacute;rios"><i class="fa fa-users"></i> <span>Usu&aacute;rio</span></a>
                    </li>';
                    break;
            }
        ?>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>