<?php
    require_once('appConfig.php');

    try {
        include_once('appConnection.php');
        
        $py = md5('idlancamento');
        $sql = $pdo->prepare("SELECT lancamento.idlancamento,categoria.descricao AS categoria,lancamento.dia,lancamento.mes,lancamento.ano,lancamento.tipo,lancamento.descricao,lancamento.valor,lancamento.pago FROM lancamento INNER JOIN categoria ON lancamento.categoria_idcategoria = categoria.idcategoria WHERE lancamento.idlancamento = :idlancamento");
        $sql->bindParam(':idlancamento', $_GET[''.$py.''], PDO::PARAM_INT);
        $sql->execute();
        $ret = $sql->rowCount();

            if($ret > 0) {
                $lin = $sql->fetch(PDO::FETCH_OBJ);
                $datado = $lin->dia.'/'.$lin->mes.'/'.$lin->ano;
?>
<form class="form-edit-lancamento">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Editar lan&ccedil;amento</h4>
    </div>
    <div class="modal-body overing">
        <div class="row">
            <div class="col-md-12">
                <input type="hidden" name="idlancamento" id="idlancamento" value="<?php echo $lin->idlancamento; ?>">
                
                <div class="form-group">
                    <label for="datado2">Data</label>
                    <div class="input-group col-md-4">
                        <input type="text" name="datado2" id="datado2" class="form-control" value="<?php echo $datado; ?>" maxlength="10" title="Informe a data do lan&ccedil;amento" placeholder="Data do lan&ccedil;amento" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="tipo2">Tipo</label>
                    <div class="input-group">
                    <?php
                        switch($lin->tipo) {
                            case 'E':
                                echo'
                                <span class="form-icheck"><input type="radio" name="tipo2" value="E" checked> Entrada</span>
                                <span class="form-icheck"><input type="radio" name="tipo2" value="S"> Sa&iacute;da</span>';
                                break;
                                
                            case 'S':
                                echo'
                                <span class="form-icheck"><input type="radio" name="tipo2" value="E"> Entrada</span>
                                <span class="form-icheck"><input type="radio" name="tipo2" value="S" checked> Sa&iacute;da</span>';
                                break;
                        }
                    ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="valor2">Valor</label>
                    <div class="input-group col-md-4">
                        <input type="text" name="valor2" id="valor2" class="form-control" value="<?php echo $lin->valor; ?>" maxlength="20" title="Digite o valor do lan&ccedil;amento" placeholder="Valor do lan&ccedil;amento" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="categoria2">Categoria</label>
                    <div class="input-group col-md-4">
                        <select name="categoria2" id="categoria2" class="form-control select2" title="Selecione a categoria do lan&ccedil;amento" required style="width: 100%;">
                            <?php
                                try {
                                    //listando as categorias cadastradas
                                    $monitor = 'T';
                                    $sql2 = $pdo->prepare("SELECT idcategoria,descricao AS categoria FROM categoria WHERE monitor = :monitor ORDER BY descricao");
                                    $sql2->bindParam(':monitor', $monitor, PDO::PARAM_STR);
                                    $sql2->execute();
                                    $ret2 = $sql2->rowCount();

                                        if($ret2 > 0) {
                                            while($lin2 = $sql2->fetch(PDO::FETCH_OBJ)) {
                                                if($lin->categoria == $lin2->categoria) {
                                                    echo'<option value="'.$lin2->idcategoria.'" selected>'.$lin2->categoria.'</option>';    
                                                } else {
                                                    echo'<option value="'.$lin2->idcategoria.'">'.$lin2->categoria.'</option>';
                                                }
                                            }

                                            unset($lin2);
                                        }

                                    unset($sql2,$ret2,$monitor);
                                }
                                catch(PDOException $e) {
                                    echo 'Erro ao conectar o servidor '.$e->getMessage();
                                }
                            ?>    
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="descricao2">Descri&ccedil;&atilde;o</label>
                    <input type="text" name="descricao2" id="descricao2" class="form-control" value="<?php echo $lin->descricao; ?>" maxlength="150" title="Digite a descri&ccedil;&atilde;o do lan&ccedil;amento" placeholder="Descri&ccedil;&atilde;o do lan&ccedil;amento" required>
                </div>
                <div class="form-group">
                    <label for="pago2">Pago</label>
                    <div class="input-group">
                    <?php
                        switch($lin->pago) {
                            case 'T':
                                echo'
                                <span class="form-icheck"><input type="radio" name="pago2" value="T" checked> Sim</span>
                                <span class="form-icheck"><input type="radio" name="pago2" value="F"> N&atilde;o</span>';
                                break;
                            
                            case 'F':
                                echo'
                                <span class="form-icheck"><input type="radio" name="pago2" value="T"> Sim</span>
                                <span class="form-icheck"><input type="radio" name="pago2" value="F" checked> N&atilde;o</span>';
                                break;
                        }
                    ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal">Fechar</button>
        <button type="submit" class="btn btn-primary btn-flat btn-edit-lancamento">Salvar</button>
    </div>
</form>
<script>
    (function ($) {
        var fade = 150, delay = 300;
        
        //datepicker
    
        $("#datado2").show(function () {
            $("#datado2").datepicker({
                format: 'dd/mm/yyyy',
                todayHighlight: true,
                autoclose: true
            });
        });
        
        //icheck

        $("input[type='checkbox'], input[type='radio']").show(function () {
            $("input[type='checkbox'], input[type='radio']").iCheck({
                checkboxClass: 'icheckbox_minimal',
                radioClass: 'iradio_minimal'
            });
        });
        
        //mask
        
        $("#valor2").show(function () {
            $("#valor2").maskMoney();
        });
        
        //select 2
        
        $("#categoria2").show(function () {
            $("#categoria2").select2({
                placeholder: "Selecione a categoria do lançamento",
                allowClear: true
            });
        });
        
        /* FORMS */

        //edita lançamento
        
        $(".form-edit-lancamento").submit(function (e) {
            e.preventDefault();

            $.post("lancamentoUpdate.php", { idlancamento: $("#idlancamento").val(), datado: $("#datado2").val(), tipo: $("input[name='tipo2']:checked").val(), valor: $("#valor2").val(), categoria: $("#categoria2").val(), descricao: $("#descricao2").val(), pago: $("input[name='pago2']:checked").val(), rand: Math.random()}, function (data) {
                $(".btn-edit-lancamento").html('<img src="img/rings.svg" class="loader-svg">').fadeTo(fade, 1);

                switch (data) {
                case 'reload':
                    $.smkAlert({text: 'Nem todos os plugins foram carregados, recarregando...', type: 'danger', time: 2});
                    location.reload();
                    break;
                        
                case 'true':
                    $.smkAlert({text: 'Dados do lan&ccedil;amento editados com sucesso.', type: 'success', time: 2});
                    window.setTimeout("location.href='inicio'", delay);
                    break;

                default:
                    $.smkAlert({text: data, type: 'warning', time: 3});
                    break;
                }

                $(".btn-edit-lancamento").html('Salvar').fadeTo(fade, 1);
            });

            return false;
        });
    })(jQuery);
</script>
<?php
            } else {
                echo'
                <div class="callout">
                    <h4>Par&acirc;mentro incorreto</h4>
                </div>';
            }

        unset($sql,$ret,$py);
    }
    catch(PDOException $e) {
        echo'Falha ao conectar o servidor '.$e->getMessage();
    }

    unset($pdo,$e,$cfg);
?>