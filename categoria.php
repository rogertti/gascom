<?php
    require_once('appConfig.php');

        if(empty($_SESSION['key'])) {
            header ('location:./');
        }

    $m = 2;
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <title>G&aacute;s.com</title>
        <link rel="icon" type="image/png" href="img/favicon.png">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="css/ionicons.min.css">
        <link rel="stylesheet" href="css/smoke.min.css">
        <link rel="stylesheet" href="css/icheck.min.css">
        <link rel="stylesheet" href="css/datepicker.min.css">
        <link rel="stylesheet" href="css/select2.min.css">
        <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
        <link rel="stylesheet" href="css/dataTables.responsive.bootstrap.min.css">
        <link rel="stylesheet" href="css/core.css">
        <link rel="stylesheet" href="css/skin-black.min.css">
        <!--[if lt IE 9]><script src="js/html5shiv.min.js"></script><script src="js/respond.min.js"></script><![endif]-->
    </head>
    <body class="hold-transition skin-black sidebar-mini sidebar-collapse">
        <!-- Site wrapper -->
        <div class="wrapper">
            <?php
                include_once('appHeader.php');
                include_once('appSidebar.php');
            ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>Categoria <span class="pull-right lead"><a data-toggle="modal" data-target="#modal-new-categoria" title="Clique para cadastrar uma nova categoria" href="#"><i class="fa fa-tags"></i> Nova categoria</a></span></h1>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="box">
                        <div class="box-body">
                        <?php
                            try {
                                include_once('appConnection.php');
                                
                                //buscando as categorias
                                $monitor = 'T';
                                $sql = $pdo->prepare("SELECT idcategoria,descricao,tipo FROM categoria WHERE monitor = :monitor ORDER BY descricao");
                                $sql->bindParam(':monitor', $monitor, PDO::PARAM_STR);
                                $sql->execute();
                                $ret = $sql->rowCount();

                                    if($ret > 0) {
                                        $py = md5('idcategoria');
                                        
                                        echo'
                                        <table class="table table-striped table-bordered table-hover table-data dt-responsive nowrap">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Descri&ccedil;&atilde;o</th>
                                                    <th>Tipo</th>
                                                </tr>
                                            </thead>
                                            <tbody>';
                                        
                                            while($lin = $sql->fetch(PDO::FETCH_OBJ)) {
                                                switch($lin->tipo) {
                                                    case 'E':
                                                        $lin->tipo = 'Entrada';
                                                        $cor = 'success';
                                                        break;
                                                    case 'S':
                                                        $lin->tipo = 'Sa&iacute;da';
                                                        $cor = 'danger';
                                                        break;    
                                                }
                                                
                                                echo'
                                                <tr>
                                                    <td>
                                                        <span><a class="text-danger a-delete-categoria" id="'.$py.'-'.$lin->idcategoria.'" title="Excluir a categoria" href="#"><i class="fa fa-trash-o"></i></a></span>
                                                        <span><a data-toggle="modal" data-target="#modal-edit-categoria" title="Editar os dados da categoria" href="categoriaEdit.php?'.$py.'='.$lin->idcategoria.'"><i class="fa fa-pencil"></i></a></span>
                                                        <span><a data-toggle="modal" data-target="#modal-report-categoria" title="Lan&ccedil;amentos gerados pela categoria" href="categoriaReport.php?'.$py.'='.$lin->idcategoria.'"><i class="fa fa-pie-chart"></i></a></span>
                                                    </td>
                                                    <td>'.$lin->descricao.'</td>
                                                    <td><span class="label label-'.$cor.'">'.$lin->tipo.'</span></td>
                                                </tr>';
                                            }
                                        
                                        echo'
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th></th>
                                                    <th>Descri&ccedil;&atilde;o</th>
                                                    <th>Tipo</th>
                                                </tr>
                                            </tfoot>
                                        </table>';
                                        
                                        unset($py,$lin,$monitor);
                                    } else {
                                        echo'
                                        <div class="callout">
                                            <h4>Nada encontrado.</h4>
                                            <p>Nenhum registro foi encontrado. <a class="link-new" data-toggle="modal" data-target="#modal-new-categoria" title="Clique para cadastrar uma nova categoria" href="#">Nova categoria</a></p>
                                        </div>';
                                    }
                            }
                            catch(PDOException $e) {
                                echo'Erro ao conectar o servidor '.$e->getMessage();
                            }
                        ?>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
            
            <div class="modal fade" id="modal-new-categoria" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form class="form-new-categoria">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title">Nova categoria</h4>
                            </div><!-- /.modal-header -->
                            <div class="modal-body overing">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="descricao">Descri&ccedil;&atilde;o</label>
                                            <input type="text" name="descricao" id="descricao" class="form-control" maxlength="150" title="Informe a descri&ccedil;&atilde;o da categoria" placeholder="Descri&ccedil;&atilde;o da categoria" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="tipo">Tipo</label>
                                            <div class="input-group">
                                                <span class="form-icheck"><input type="radio" name="tipo" value="E" required> Entrada</span>
                                                <span class="form-icheck"><input type="radio" name="tipo" value="S"> Sa&iacute;da</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal">Fechar</button>
                                <button type="submit" class="btn btn-primary btn-flat btn-new-categoria">Salvar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="modal fade" id="modal-edit-categoria" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content"></div>
                </div>
            </div>
            
            <div class="modal fade" id="modal-report-categoria" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content"></div>
                </div>
            </div>
        </div>
        <!-- ./wrapper -->

        <script src="js/jquery-2.2.3.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/jquery.slimscroll.min.js"></script>
        <script src="js/fastclick.min.js"></script>
        <script src="js/smoke.min.js"></script>
        <script src="js/icheck.min.js"></script>
        <script src="js/maskmoney.min.js"></script>
        <script src="js/datepicker.min.js"></script>
        <script src="js/select2.full.min.js"></script>
        <script src="js/jquery.dataTables.min.js"></script>
        <script src="js/dataTables.bootstrap.min.js"></script>
        <script src="js/dataTables.responsive.min.js"></script>
        <script src="js/dataTables.responsive.bootstrap.min.js"></script>
        <script src="js/core.js"></script>
    </body>
</html>