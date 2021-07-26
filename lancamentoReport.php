<?php
    require_once('appConfig.php');

    $getmes = md5('mes');
    $getano = md5('ano');

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
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">Relat&oacute;rio do m&ecirc;s de <?php echo mes_extenso($_GET[''.$getmes.'']); ?></h4>
</div>
<div class="modal-body overing">
<?php
    try {
        include_once('appConnection.php');

        $monitor = 'T';
        $sql = $pdo->prepare("SELECT categoria.descricao AS categoria,COUNT(*) AS soma,ROUND(SUM(lancamento.valor),2) AS total,lancamento.tipo FROM categoria,lancamento WHERE lancamento.mes = :mes AND lancamento.ano = :ano AND lancamento.categoria_idcategoria = categoria.idcategoria AND lancamento.monitor = :monitor GROUP BY categoria.descricao");
        $sql->bindParam(':mes', $_GET[''.$getmes.''], PDO::PARAM_STR);
        $sql->bindParam(':ano', $_GET[''.$getano.''], PDO::PARAM_STR);
        $sql->bindParam(':monitor', $monitor, PDO::PARAM_STR);
        $sql->execute();
        $ret = $sql->rowCount();

            if($ret > 0) {
                $i = 1;
                $chart = '';
                $tr = '';
                $entrada = 0;
                $saida = 0;

                    while($lin = $sql->fetch(PDO::FETCH_OBJ)) {
                        //aqui o gráfico calcula quanto foi gasto por categoria
                        /*if($i < $ret) {
                            $chart .= '["'.$lin->categoria.'",'.$lin->soma.'],';
                        } else {
                            $chart .= '["'.$lin->categoria.'",'.$lin->soma.']';
                        }*/

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
                            <td>'.$lin->categoria.'</td>
                            <td><span class="label label-'.$cor.'">'.$lin->tipo.'</span></td>
                            <td class="text-right">'.number_format($lin->total, 2, '.', ',').'</td>|';

                        $i++;
                    }
                
                //calculando as porcentagens
                $total = $entrada + $saida;
                $sql2 = $pdo->prepare("SELECT categoria.descricao AS categoria,ROUND(SUM(lancamento.valor),2) AS total FROM categoria,lancamento WHERE lancamento.mes = :mes AND lancamento.ano = :ano AND lancamento.categoria_idcategoria = categoria.idcategoria AND lancamento.monitor = :monitor GROUP BY categoria.descricao");
                $sql2->bindParam(':mes', $_GET[''.$getmes.''], PDO::PARAM_STR);
                $sql2->bindParam(':ano', $_GET[''.$getano.''], PDO::PARAM_STR);
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
                                
                                #$td .= '<td class="text-right">'.round($rulethree).' &#37;</td>|';
                                $td .= '<td class="text-right">'.$cento.' &#37;</td>|';
                                
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
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="info-box bg-green">
                            <span class="info-box-icon"><i class="fa fa-angle-double-up"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Receita &#45; <a data-toggle="modal" data-target="#modal-report-receita" title="Clique para ver todas as receitas do m&ecirc;s" href="lancamentoReportReceita.php?'.$getmes.'='.$_GET[''.$getmes.''].'&'.$getano.'='.$_GET[''.$getano.''].'">Ver todas</a></span>
                                <span class="info-box-number">R$ '.number_format($entrada, 2, '.', ',').'</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="info-box bg-red">
                            <span class="info-box-icon"><i class="fa fa-angle-double-down"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Despesa &#45; <a data-toggle="modal" data-target="#modal-report-despesa" title="Clique para ver todas as despesas do m&ecirc;s" href="lancamentoReportDespesa.php?'.$getmes.'='.$_GET[''.$getmes.''].'&'.$getano.'='.$_GET[''.$getano.''].'">Ver todas</a></span>
                                <span class="info-box-number">R$ '.number_format($saida, 2, '.', ',').'</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped table-bordered table-hover table-data-report dt-responsive nowrap" style="width: 100%;">
                            <thead>
                                <tr>
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
            } else {
                echo'
                <div class="callout">
                    <h4>Par&acirc;mentro incorreto</h4>
                </div>';
            }

        unset($sql,$ret,$py,$i,$monitor,$tr);
    }
    catch(PDOException $e) {
        echo'Falha ao conectar o servidor '.$e->getMessage();
    }

    unset($pdo,$e,$cfg);
?>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Fechar</button>
</div>
<script>
    (function ($) {
        /*  DATATABLES */
                
        $(".table-data-report").show(function () {
            $(".table-data-report").DataTable({
                "paging": false,
                //"ordering": false,
                "info": false,
                "filter": false,
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
    })(jQuery);
</script>