<?php
    require_once('appConfig.php');
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">Relat&oacute;rio por categoria</h4>
</div>
<div class="modal-body overing">
<?php
    try {
        include_once('appConnection.php');

        $py = md5('idcategoria');    
        $monitor = 'T';
        
        $sql = $pdo->prepare("SELECT categoria.descricao AS categoria,lancamento.descricao AS lancamento,lancamento.dia,lancamento.mes,lancamento.ano,lancamento.valor FROM lancamento,categoria WHERE lancamento.categoria_idcategoria = categoria.idcategoria AND categoria.idcategoria = :idcategoria AND lancamento.monitor = :monitor ORDER BY lancamento.dia,lancamento.mes");
        $sql->bindParam(':idcategoria', $_GET[''.$py.''], PDO::PARAM_INT);
        $sql->bindParam(':monitor', $monitor, PDO::PARAM_STR);
        $sql->execute();
        $ret = $sql->rowCount();

            if($ret > 0) {
                $tr = '';
                $total = 0;

                    while($lin = $sql->fetch(PDO::FETCH_OBJ)) {
                        $tr .= '
                        <tr>
                            <td><span class="hide">'.$lin->ano.$lin->mes.$lin->dia.'</span>'.$lin->dia.'/'.$lin->mes.'/'.$lin->ano.'</td>
                            <td>'.$lin->categoria.'</td>
                            <td>'.$lin->lancamento.'</td>
                            <td class="text-right">'.number_format($lin->valor, 2, '.', ',').'</td>
                        </tr>';

                        $total = $total + $lin->valor;
                    }

                echo'
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped table-bordered table-hover table-data-report dt-responsive nowrap" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Data</th>
                                    <th>Categoria</th>
                                    <th>Tipo</th>
                                    <th>Total R$</th>
                                </tr>
                            </thead>
                            <tbody>
                                '.$tr.'
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Data</th>
                                    <th>Categoria</th>
                                    <th>Tipo</th>
                                    <th class="lead text-right">R$ '.number_format($total, 2, '.', ',').'</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>';
            } else {
                echo'
                <div class="callout">
                    <h4>Nada encontrado.</h4>
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
    })(jQuery);
</script>