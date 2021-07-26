<?php
    require_once('appConfig.php');

        if(empty($_SESSION['key'])) {
            header ('location:./');
        }

    $m = 3;
    
    function decrypt($data, $k) {
        $l = strlen($k);
        
            if ($l < 16)
                $k = str_repeat($k, ceil(16/$l));
                $data = base64_decode($data);
                $val = openssl_decrypt($data, 'AES-256-OFB', $k, 0, $k);
        
        return $val;
    }

    $lock = base64_encode('cripta');
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
                    <h1>Usu&aacute;rio <span class="pull-right lead"><a data-toggle="modal" data-target="#modal-new-usuario" title="Clique para cadastrar uma novo usu&aacute;rio" href="#"><i class="fa fa-users"></i> Novo usu&aacute;rio</a></span></h1>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="box">
                        <div class="box-body">
                        <?php
                            try {
                                include_once('appConnection.php');
                                
                                //buscando as usuarios
                                $monitor = 'T';
                                $sql = $pdo->prepare("SELECT idlogin,nome,usuario,email FROM login WHERE monitor = :monitor ORDER BY nome");
                                $sql->bindParam(':monitor', $monitor, PDO::PARAM_STR);
                                $sql->execute();
                                $ret = $sql->rowCount();

                                    if($ret > 0) {
                                        $py = md5('idusuario');
                                        
                                        echo'
                                        <table class="table table-striped table-bordered table-hover table-data dt-responsive nowrap">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Nome</th>
                                                    <th>Usu&aacute;rio</th>
                                                    <th>Email</th>
                                                </tr>
                                            </thead>
                                            <tbody>';
                                        
                                            while($lin = $sql->fetch(PDO::FETCH_OBJ)) {
                                                if($_SESSION['key'] == $lin->idlogin) {
                                                    $del = '<span><a class="text-danger" title="Sair do programa" href="sair"><i class="fa fa-sign-out"></i></a></span>';
                                                } else {
                                                    $del = '<span><a class="text-danger a-delete-usuario" id="'.$py.'-'.$lin->idlogin.'" title="Excluir o usu&aacute;rio" href="#"><i class="fa fa-trash-o"></i></a></span>';
                                                }
                                                
                                                echo'
                                                <tr>
                                                    <td>
                                                        '.$del.'
                                                        <span><a data-toggle="modal" data-target="#modal-edit-usuario" title="Editar os dados da usu&aacute;rio" href="usuarioEdit.php?'.$py.'='.$lin->idlogin.'"><i class="fa fa-pencil"></i></a></span>
                                                    </td>
                                                    <td>'.$lin->nome.'</td>
                                                    <td>'.base64_decode(decrypt($lin->usuario, $lock)).'</td>
                                                    <td>'.$lin->email.'</td>
                                                </tr>';
                                                
                                                unset($del);
                                            }
                                        
                                        echo'
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th></th>
                                                    <th>Nome</th>
                                                    <th>Usu&aacute;rio</th>
                                                    <th>Email</th>
                                                </tr>
                                            </tfoot>
                                        </table>';
                                        
                                        unset($py,$lin,$monitor);
                                    } else {
                                        echo'
                                        <div class="callout">
                                            <h4>Nada encontrado.</h4>
                                            <p>Nenhum registro foi encontrado. <a class="link-new" data-toggle="modal" data-target="#modal-new-usuario" title="Clique para cadastrar um novo usu&aacute;rio" href="#">Novo usu&aacute;rio</a></p>
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
            
            <div class="modal fade" id="modal-new-usuario" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form class="form-new-usuario">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title">Novo usu&aacute;rio</h4>
                            </div><!-- /.modal-header -->
                            <div class="modal-body overing">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="nome">Nome</label>
                                            <input type="text" name="nome" id="nome" class="form-control" maxlength="150" title="Informe o nome do usu&aacute;rio" placeholder="Nome do usu&aacute;rio" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="usuario">Usu&aacute;rio</label>
                                            <div class="input-group col-md-4">
                                                <input type="text" name="usuario" id="usuario" class="form-control" maxlength="10" title="Crie o usu&aacute;rio para acessar o programa" placeholder="Usu&aacute;rio para login" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="senha">Senha</label>
                                            <div class="input-group col-md-4">
                                                <input type="password" name="senha" id="senha" class="form-control" maxlength="10" title="Crie a senha para acessar o programa" placeholder="Senha para login" required>
                                                <span class="input-group-addon">
                                                    <a class="a-show-password" href="#"><i class="glyphicon glyphicon-eye-open"></i></a>
                                                    <a class="a-hide-password hide" href="#"><i class="glyphicon glyphicon-eye-close"></i></a>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" name="email" id="email" class="form-control" maxlength="100" title="Digite um email para recupera&ccedil;&atilde;o" placeholder="Email para recupera&ccedil;&atilde;o" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal">Fechar</button>
                                <button type="submit" class="btn btn-primary btn-flat btn-new-usuario">Salvar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="modal fade" id="modal-edit-usuario" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
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