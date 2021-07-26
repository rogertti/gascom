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
    <h4 class="modal-title">Relat&oacute;rio das despesas do m&ecirc;s de <?php echo mes_extenso($_GET[''.$getmes.'']); ?></h4>
</div>
<div class="modal-body overing">
<?php
    try {
        include_once('appConnection.php');

        $tipo = 'S';
        $monitor = 'T';
        $sql = $pdo->prepare("SELECT categoria.descricao AS categoria,lancamento.dia,lancamento.tipo,lancamento.descricao,lancamento.valor FROM categoria,lancamento WHERE lancamento.tipo = :tipo AND lancamento.mes = :mes AND lancamento.ano = :ano AND lancamento.categoria_idcategoria = categoria.idcategoria AND lancamento.monitor = :monitor ORDER BY lancamento.datado");
        $sql->bindParam(':mes', $_GET[''.$getmes.''], PDO::PARAM_STR);
        $sql->bindParam(':ano', $_GET[''.$getano.''], PDO::PARAM_STR);
        $sql->bindParam(':tipo', $tipo, PDO::PARAM_STR);
        $sql->bindParam(':monitor', $monitor, PDO::PARAM_STR);
        $sql->execute();
        $ret = $sql->rowCount();

            if($ret > 0) {
                $total = 0;
                                        
                echo'
                <table class="table table-striped table-bordered table-hover table-data-report-despesa dt-responsive nowrap" style="width: 100%;">
                    <thead>
                        <tr>
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
                            /*case 'E':
                                $lin->tipo = 'Entrada';
                                $cor = 'success';
                                $total = $total + $lin->valor;
                                break;*/
                            case 'S':
                                $lin->tipo = 'Sa&iacute;da';
                                $cor = 'danger';
                                $total = $total + $lin->valor;
                                break;  
                        }

                        if(strlen($lin->valor) >= 6) {
                            $lin->valor = number_format($lin->valor, 2, '.', ',');
                        }

                        echo'
                        <tr>
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
                            <th>Dia</th>
                            <th>Tipo</th>
                            <th>Descri&ccedil;&atilde;o</th>
                            <th>Categoria</th>
                            <th class="lead text-danger text-right">R$ '.number_format($total, 2, '.', ',').'</th>
                        </tr>
                    </tfoot>
                </table>';

                unset($lin,$py,$total);
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
                
        $(".table-data-report-despesa").show(function () {
            $(".table-data-report-despesa").DataTable({
                "paging": false,
                //"ordering": false,
                "info": false,
                "filter": false,
                stateSave: true
            });
        });
    })(jQuery);
</script>