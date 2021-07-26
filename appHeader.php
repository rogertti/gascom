<header class="main-header">
    <!-- Logo -->
    <a href="#" title="G&aacute;s.com" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><strong><?php echo $cfg['header_title_mini']; ?></strong></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><strong><?php echo $cfg['header_title']; ?></strong></span>
    </a>
    
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" title="Expandir/Diminuir o menu" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="bg-warning">
                    <a href="backup" title="Back up do programa"><i class="fa fa-database"></i> Back up</a>
                </li>
                <li class="bg-danger">
                    <a href="sair" title="Sair do programa"><i class="fa fa-sign-out"></i> Sair</a>
                </li>
            </ul>
        </div>
    </nav>
</header>