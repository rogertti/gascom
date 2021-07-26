<?php
    require_once('appConfig.php');

        if(empty($_SESSION['key'])) {
            header ('location:./');
        }

    $m = 1;

    $getmes = md5('mes');
    $getano = md5('ano');

        //essas 2 variáveis, são criadas no lancamentoInsert
        if((isset($_SESSION['mm'])) or (isset($_SESSION['yy']))) {
            $mes = $_SESSION['mm'];
            $ano = $_SESSION['yy'];
        } else {
            if(isset($_GET[''.$getmes.''])) {
                $mes = $_GET[''.$getmes.''];
            } else {
                $mes = date('m');
            }

            if(isset($_GET['left'])) {
                if($mes == '12') {
                    $ano = $_GET[''.$getano.''] - 1;
                } else {
                    $ano = $_GET[''.$getano.''];
                }
            }

            if(isset($_GET['right'])) {
                if($mes == '01') {
                    $ano = $_GET[''.$getano.''] + 1;
                } else {
                    $ano = $_GET[''.$getano.''];
                }
            }

            if ((!isset($_GET['left'])) and (!isset($_GET['right']))) {
                $ano = date('Y');
            }    
        }
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
        <link rel="stylesheet" href="css/daterangepicker.min.css">
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
                <!-- Content Header (Page header) 
                <section class="content-header">
                    <h1>In&iacute;cio</h1>
                </section>-->

                <!-- Main content -->
                <section class="content">
                    <div class="box">
                        <div class="box-body">
                        <!-- aqui carrega o arquivo appHomeAsync.php -->
                        <?php
                            function mes_extenso ($fmes) {
                                switch ($fmes) {
                                    case '01': $fmes = 'Janeiro'; break;
                                    case '02': $fmes = 'Fevereiro'; break;
                                    case '03': $fmes = 'Mar&ccedil;o'; break;
                                    case '04': $fmes = 'Abril'; break;
                                    case '05': $fmes = 'Maio'; break;
                                    case '06': $fmes = 'Junho'; break;
                                    case '07': $fmes = 'Julho'; break;
                                    case '08': $fmes = 'Agosto'; break;
                                    case '09': $fmes = 'Setembro'; break;
                                    case '10': $fmes = 'Outubro'; break;
                                    case '11': $fmes = 'Novembro'; break;
                                    case '12': $fmes = 'Dezembro'; break;
                                }

                                return $fmes;
                            }
                            
                            $mesleft = $mes - 1;
                            $mesright = $mes + 1;

                                if(strlen($mesleft) == 1) {
                                    $mesleft = '0'.$mesleft;

                                        if($mesleft == '00') {
                                            $mesleft = '12';
                                        }
                                }

                                if(strlen($mesright) == 1) {
                                    $mesright = '0'.$mesright;

                                        if($mesright == '13') {
                                            $mesright = '01';
                                        }
                                } else {
                                    if($mesright == '13') {
                                        $mesright = '01';
                                    }
                                }
                            
                            echo'
                            <div class="div-time">
                                <div class="div-time-left text-center">
                                    <a class="lead" href="inicio?'.$getmes.'='.$mesleft.'&'.$getano.'='.$ano.'&left=1" title="M&ecirc;s anterior">
                                        <i class="fa fa-arrow-left"></i>
                                    </a>
                                </div>
                                <div class="div-time-center">
                                    <p class="lead">
                                        <span class="pull-left text-bold text-uppercase">'.mes_extenso($mes).' de '.$ano.'</span>
                                        <span class="pull-right list-altmenu">
                                            <a data-toggle="modal" data-target="#modal-new-lancamento" title="Clique para lan&ccedil;ar um registro" href="lancamentoNew.php?'.$getmes.'='.$mes.'&'.$getano.'='.$ano.'">
                                                <i class="fa fa-usd"></i> Novo lan&ccedil;amento
                                            </a>
                                            <a data-toggle="modal" data-target="#modal-report-lancamento" title="Clique para gerar o relat&oacute;rio do m&ecirc;s" href="lancamentoReport.php?'.$getmes.'='.$mes.'&'.$getano.'='.$ano.'">
                                                <i class="fa fa-pie-chart"></i> Relat&oacute;rio
                                            </a>
                                        </span>
                                    </p>
                                </div>
                                <div class="div-time-right text-center">
                                    <a class="lead" href="inicio?'.$getmes.'='.$mesright.'&'.$getano.'='.$ano.'&right=1" title="Pr&oacute;ximo m&ecirc;s">
                                        <i class="fa fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                            
                            <hr>
                            
                            <div class="form-inline form-range-date-report">
                                <div class="form-group">
                                    <input type="text" name="periodo" id="periodo" class="form-control" placeholder="Gerar relat&oacute;rio dos lan&ccedil;amentos por per&iacute;odo">
                                </div>
                                <button type="button" class="btn btn-primary btn-flat btn-rangedate-report-categoria">Gerar</button>
                            </div>
                            
                            <div class="btn-back-home hide">
                                <a class="lead" title="Voltar para os lan&ccedil;amentos" href="inicio">Voltar para os lan&ccedil;amentos</a>
                            </div>

                            <hr>';
                            
                            try {
                                include_once('appConnection.php');
                                
                                //buscando os lançamentos do mês
                                $monitor = 'T';
                                $sql = $pdo->prepare("SELECT lancamento.idlancamento,categoria.descricao AS categoria,lancamento.dia,lancamento.tipo,lancamento.descricao,lancamento.valor,lancamento.pago FROM lancamento INNER JOIN categoria ON lancamento.categoria_idcategoria = categoria.idcategoria WHERE lancamento.mes = :mes AND lancamento.ano = :ano AND lancamento.monitor = :monitor ORDER BY lancamento.dia,lancamento.mes,lancamento.ano,lancamento.descricao");
                                $sql->bindParam(':mes', $mes, PDO::PARAM_STR);
                                $sql->bindParam(':ano', $ano, PDO::PARAM_STR);
                                $sql->bindParam(':monitor', $monitor, PDO::PARAM_STR);
                                $sql->execute();
                                $ret = $sql->rowCount();

                                    if($ret > 0) {
                                        $py = md5('idlancamento');
                                        $total = 0;
                                        
                                        echo'
                                        <div class="list-main">
                                        <table class="table table-striped table-bordered table-hover table-data dt-responsive nowrap">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Dia</th>
                                                    <th>Tipo</th>
                                                    <th>Descri&ccedil;&atilde;o</th>
                                                    <th>Categoria</th>
                                                    <th>Valor R$</th>
                                                </tr>
                                            </thead>
                                            <tbody>';
                                        
                                            while($lin = $sql->fetch(PDO::FETCH_OBJ)) {
                                                switch($lin->tipo) {
                                                    case 'E':
                                                        $lin->tipo = 'Entrada';
                                                        $cor = 'success';
                                                        $total = $total + $lin->valor;
                                                        break;
                                                    case 'S':
                                                        $lin->tipo = 'Sa&iacute;da';
                                                        $cor = 'danger';
                                                        $total = $total - $lin->valor;
                                                        break;    
                                                }
                                                
                                                switch($lin->pago) {
                                                    case 'T':
                                                        $paid = '<span><a class="text-success" title="Lan&ccedil;amento pago" href="#"><i class="fa fa-check"></i></a></span>';
                                                        break;
                                                    case 'F':
                                                        $paid = '<span><a class="a-paid-lancamento" id="'.$py.'-'.$lin->idlancamento.'" title="Marcar o lan&ccedil;amento como pago" href="#"><i class="fa fa-check-square-o"></i></a></span>';
                                                        break;    
                                                }
                                                
                                                if(strlen($lin->valor) >= 6) {
                                                    $lin->valor = number_format($lin->valor, 2, '.', ',');
                                                }
                                                
                                                echo'
                                                <tr>
                                                    <td class="td-action">
                                                        <span><a class="text-danger a-delete-lancamento" id="'.$py.'-'.$lin->idlancamento.'" title="Excluir o lan&ccedil;amento" href="#"><i class="fa fa-trash-o"></i></a></span>
                                                        <span><a data-toggle="modal" data-target="#modal-edit-lancamento" title="Editar os dados do lan&ccedil;amento" href="lancamentoEdit.php?'.$py.'='.$lin->idlancamento.'"><i class="fa fa-pencil"></i></a></span>
                                                        '.$paid.'
                                                    </td>
                                                    <td>'.$lin->dia.'</td>
                                                    <td><span class="label label-'.$cor.'">'.$lin->tipo.'</span></td>
                                                    <td>'.$lin->descricao.'</td>
                                                    <td>'.$lin->categoria.'</td>
                                                    <td class="text-right">'.$lin->valor.'</td>
                                                </tr>';
                                                
                                                unset($paid,$line);
                                            }
                                        
                                        echo'
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th></th>
                                                    <th>Dia</th>
                                                    <th>Tipo</th>
                                                    <th>Descri&ccedil;&atilde;o</th>
                                                    <th>Categoria</th>';
                                        
                                            if($total > 0) {
                                                echo'<th class="lead text-success text-right">R$ '.number_format($total, 2, '.', ',').'</th>';
                                            } else {
                                                echo'<th class="lead text-danger text-right">R$ '.number_format($total, 2, '.', ',').'</th>';
                                            }
                                        
                                                echo'    
                                                </tr>
                                            </tfoot>
                                        </table>
                                        </div>';

                                        unset($lin,$py,$total);
                                    } else {
                                        echo'
                                        <div class="callout callout-1">
                                            <h4>Nada encontrado.</h4>
                                            <p>Nenhum registro foi encontrado. <a class="link-new" data-toggle="modal" data-target="#modal-new-lancamento" title="Clique para lan&ccedil;ar um registro" href="lancamentoNew.php?'.$getmes.'='.$mes.'&'.$getano.'='.$ano.'">Novo lan&ccedil;amento</a></p>
                                        </div>';
                                    }

                                unset($sql,$ret);
                                
                                $py1 = md5('data1');
                                $py2 = md5('data2');
                                
                                if((isset($_GET[''.$py1.''])) and (isset($_GET[''.$py2.'']))) {
                                    $dia1 = substr($_GET[''.$py1.''], 0, 2);
                                    $mes1 = substr($_GET[''.$py1.''], 3, 2);
                                    $ano1 = substr($_GET[''.$py1.''], 6);
                                    $datado1 = $ano1.'-'.$mes1.'-'.$dia1;
                                    
                                    $dia2 = substr($_GET[''.$py2.''], 0, 2);
                                    $mes2 = substr($_GET[''.$py2.''], 3, 2);
                                    $ano2 = substr($_GET[''.$py2.''], 6);
                                    $datado2 = $ano2.'-'.$mes2.'-'.$dia2;
                                    
                                    $monitor = 'T';
                                    //essa consulta gera a lista geral dos períodos
                                    $sql = $pdo->prepare("SELECT categoria.descricao AS categoria,lancamento.valor AS total,lancamento.tipo,lancamento.dia,lancamento.mes,lancamento.ano FROM categoria,lancamento WHERE lancamento.datado BETWEEN :datado1 AND :datado2 AND lancamento.categoria_idcategoria = categoria.idcategoria AND lancamento.monitor = :monitor ORDER BY lancamento.datado");
                                    $sql->bindParam(':datado1', $datado1, PDO::PARAM_STR);
                                    $sql->bindParam(':datado2', $datado2, PDO::PARAM_STR);
                                    $sql->bindParam(':monitor', $monitor, PDO::PARAM_STR);
                                    $sql->execute();
                                    $ret = $sql->rowCount();

                                        if($ret > 0) {
                                            $tr = '';
                                            $entrada = 0;
                                            $saida = 0;

                                                while($lin = $sql->fetch(PDO::FETCH_OBJ)) {
                                                    switch($lin->tipo) {
                                                        case 'E':
                                                            $lin->tipo = 'Entrada';
                                                            $cor = 'success';
                                                            $entrada = $entrada + $lin->total;
                                                            break;
                                                        case 'S':
                                                            $lin->tipo = 'Sa&iacute;da';
                                                            $cor = 'danger';
                                                            $saida = $saida + $lin->total;
                                                            break;    
                                                    }

                                                    $tr .= '
                                                    <tr>
                                                        <td><span class="hide">'.$lin->ano.$lin->mes.$lin->dia.'</span>'.$lin->dia.'/'.$lin->mes.'/'.$lin->ano.'</td>
                                                        <td>'.$lin->categoria.'</td>
                                                        <td><span class="label label-'.$cor.'">'.$lin->tipo.'</span></td>
                                                        <td class="text-right">'.number_format($lin->total, 2, '.', ',').'</td>|';
                                                }

                                            //calculando as porcentagens
                                            $total = $entrada + $saida;
                                            $sql2 = $pdo->prepare("SELECT categoria.descricao AS categoria,lancamento.valor AS total FROM categoria,lancamento WHERE lancamento.datado BETWEEN :datado1 AND :datado2 AND lancamento.categoria_idcategoria = categoria.idcategoria AND lancamento.monitor = :monitor ORDER BY lancamento.datado");
                                            $sql2->bindParam(':datado1', $datado1, PDO::PARAM_STR);
                                            $sql2->bindParam(':datado2', $datado2, PDO::PARAM_STR);
                                            $sql2->bindParam(':monitor', $monitor, PDO::PARAM_STR);
                                            $sql2->execute();
                                            $ret2 = $sql2->rowCount();

                                                if($ret2 > 0) {
                                                    $td = '';
                                                    $i = 1;

                                                        while($lin2 = $sql2->fetch(PDO::FETCH_OBJ)) {
                                                            $rulethree = $lin2->total * 100;
                                                            $rulethree = $rulethree / $total;
                                                            $cento = substr($rulethree, 0, 4);
                                                            
                                                            $td .= '<td class="text-right">'.$cento.' &#37;</td>|';
                                                            #$td .= '<td class="text-right">'.round($rulethree).' &#37;</td>|';
                                                            
                                                                //gráfico calculado em cima do valor
                                                                if($i < $ret2) {
                                                                    $chart .= '["'.$lin2->categoria.'",'.$rulethree.'],';
                                                                } else {
                                                                    $chart .= '["'.$lin2->categoria.'",'.$rulethree.']';
                                                                }
                                                            
                                                            $i++;
                                                        }    
                                                }

                                            $tr = explode('|', $tr);
                                            $td = explode('|', $td);
                                            $tb = '';

                                                if(count($tr) == count($td)) {
                                                    $t = count($tr);
                                                    $i = 0;

                                                        while($i < $t) {
                                                            $tb .= $tr[$i].$td[$i].'</tr>';
                                                            $i++;
                                                        }
                                                }
                                            
                                            echo'
                                            <h3>Relat&oacute;rio do per&iacute;odo entre '.$_GET[''.$py1.''].' e '.$_GET[''.$py2.''].'</h3>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <div class="info-box bg-green">
                                                        <span class="info-box-icon"><i class="fa fa-angle-double-up"></i></span>

                                                        <div class="info-box-content">
                                                            <span class="info-box-text">Receita</span>
                                                            <span class="info-box-number">R$ '.number_format($entrada, 2, '.', ',').'</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <div class="info-box bg-red">
                                                        <span class="info-box-icon"><i class="fa fa-angle-double-down"></i></span>

                                                        <div class="info-box-content">
                                                            <span class="info-box-text">Despesa</span>
                                                            <span class="info-box-number">R$ '.number_format($saida, 2, '.', ',').'</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <table class="table table-striped table-bordered table-hover table-data-range-date dt-responsive nowrap">
                                                        <thead>
                                                            <tr>
                                                                <th>Data</th>
                                                                <th>Categoria</th>
                                                                <th>Tipo</th>
                                                                <th>Total R$</th>
                                                                <th>Porcentagem</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            '.$tb.'
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th>Data</th>
                                                                <th>Categoria</th>
                                                                <th>Tipo</th>
                                                                <th>Total R$</th>
                                                                <th>Porcentagem</th>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="chart-pie"></div>
                                                </div>
                                            </div>';

                                            //essa consulta agrupa por categoria para gerar o gráfico
                                            /*$sql2 = $pdo->prepare("SELECT categoria.descricao AS categoria,COUNT(*) AS soma,ROUND(SUM(lancamento.valor),2) AS total,lancamento.tipo,lancamento.dia,lancamento.mes,lancamento.ano FROM categoria,lancamento WHERE (lancamento.datado BETWEEN :datado1 AND :datado2) AND lancamento.categoria_idcategoria = categoria.idcategoria AND lancamento.monitor = :monitor GROUP BY categoria.descricao ORDER BY lancamento.dia,lancamento.mes,lancamento.ano");
                                            $sql2->bindParam(':datado1', $datado1, PDO::PARAM_STR);
                                            $sql2->bindParam(':datado2', $datado2, PDO::PARAM_STR);
                                            $sql2->bindParam(':monitor', $monitor, PDO::PARAM_STR);
                                            $sql2->execute();
                                            $ret2 = $sql2->rowCount();
                                            
                                                if($ret2 > 0) {
                                                    $i = 1;
                                                    $chart = '';
                                                    
                                                    while($lin2 = $sql2->fetch(PDO::FETCH_OBJ)) {
                                                        if($i < $ret2) {
                                                            $chart .= '["'.$lin2->categoria.'",'.$lin2->soma.'],';
                                                        } else {
                                                            $chart .= '["'.$lin2->categoria.'",'.$lin2->soma.']';
                                                        }
                                                        
                                                        $i++;
                                                    }
                                                    
                                                    echo'
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="chart-pie"></div>
                                                        </div>
                                                    </div>';
                                                }*/
                                        } else {
                                            echo'
                                            <div class="callout">
                                                <h4>Nada encontrado nesse intervalo de tempo. <a class="link-new" title="Voltar para os lan&ccedil;amentos" href="inicio">Voltar para os lan&ccedil;amentos</a></h4>
                                            </div>';
                                        }
                                    
                                    unset($sql,$ret,$py,$i,$monitor,$tr,$dia1,$mes1,$ano1,$dia2,$mes2,$ano2,$sql2,$ret2,$lin2);
                                }
                            }
                            catch(PDOException $e) {
                                echo'Erro ao conectar o servidor '.$e->getMessage();
                            }
                            
                            unset($pdo,$e,$cfg);
                        ?>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
            
            <div class="modal fade" id="modal-new-lancamento" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content"></div>
                </div>
            </div>
            
            <div class="modal fade" id="modal-edit-lancamento" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content"></div>
                </div>
            </div>
            
            <div class="modal fade" id="modal-report-lancamento" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content"></div>
                </div>
            </div>
            
            <div class="modal fade" id="modal-report-receita" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content"></div>
                </div>
            </div>
            
            <div class="modal fade" id="modal-report-despesa" role="dialog" aria-hidden="true">
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
        <script src="js/moment.min.js"></script>
        <script src="js/daterangepicker.min.js"></script>
        <script src="js/select2.full.min.js"></script>
        <script src="js/jquery.dataTables.min.js"></script>
        <script src="js/dataTables.bootstrap.min.js"></script>
        <script src="js/dataTables.responsive.min.js"></script>
        <script src="js/dataTables.responsive.bootstrap.min.js"></script>
        <script src="js/highcharts.min.js"></script>
        <script src="js/core.js"></script>
        <script>
            (function ($) {
                
                <?php
                    if(isset($chart)) {
                ?>
                $(".form-inline").addClass('hide');
                $(".list-main").addClass('hide');
                $(".callout-1").addClass('hide');
                $(".btn-back-home").removeClass('hide');
                
                /*  DATATABLES */
                
                $(".table-data-range-date").show(function () {
                    $(".table-data-range-date").DataTable({
                        "lengthMenu": [ 10, 25, 50, 75, 100 ],
                        "pageLength": 50,
                        stateSave: true
                    });
                });
                
                /*  HIGHCHART 

                $(".chart-pie").show(function() {
                    $('.chart-pie').highcharts({
                        chart: {
                            plotBackgroundColor: null,
                            plotBorderWidth: 1,
                            plotShadow: false
                        },
                        title: {
                            text: ''
                        },
                        tooltip: {
                            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                        },
                        plotOptions: {
                            pie: {
                                allowPointSelect: true,
                                cursor: 'pointer',
                                dataLabels: {
                                    enabled: true,
                                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                                    style: {
                                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                                    }
                                }
                            }
                        },
                        series: [{
                            type: 'pie',
                            name: 'Lançamentos por categoria',
                            data: [ <?php echo $chart; ?> ]
                        }]
                    });
                });*/
                <?php
                    }
                
                    unset($chart);
                ?>
                
                /* REQUEST AJAX ASYNC */
                
                var callPanel = function() {
                    $.ajax({
                        url: 'appHomeAsync.php',
                        async: true,
                        beforeSend : function() {
                            $.smkAlert({text: '<img src="img/rings.svg" style="width: 25px;position: relative;top: 0;"> Carregando', type: 'info', time: 2});
                        }
                    }).done(function(data) {
                       $(".box-body").html(data);
                    });    
                }
                
                //setTimeout(callPanel, 100); //executado apenas uma vez
                //setInterval(callPanel, 15000); //executado de 15 em 15 segundos
            })(jQuery);
        </script>
    </body>
</html>