<?php
    $getmes = md5('mes');
    $getano = md5('ano');
?>
<form class="form-new-lancamento">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Novo lan&ccedil;amento</h4>
    </div>
    <div class="modal-body overing">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="datado">Data</label>
                    <div class="input-group col-md-4">
                        <input type="text" name="datado" id="datado" value="<?php echo date('d').'/'.$_GET[''.$getmes.''].'/'.$_GET[''.$getano.'']; ?>" class="form-control" maxlength="10" title="Informe a data do lan&ccedil;amento" placeholder="Data do lan&ccedil;amento" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="tipo">Tipo</label>
                    <div class="input-group">
                        <span class="form-icheck"><input type="radio" name="tipo" value="E" required> Entrada</span>
                        <span class="form-icheck"><input type="radio" name="tipo" value="S"> Sa&iacute;da</span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="valor">Valor</label>
                    <div class="input-group col-md-4">
                        <input type="text" name="valor" id="valor" class="form-control" maxlength="20" title="Digite o valor do lan&ccedil;amento" placeholder="Valor do lan&ccedil;amento" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="categoria">Categoria</label>
                    <div class="input-group col-md-4">
                        <select name="categoria" id="categoria" class="form-control select2" title="Selecione a categoria do lan&ccedil;amento" required style="width: 100%;">
                            <option value="" selected></option>
                            <?php
                                try {
                                    include_once('appConnection.php');
                                    
                                    //listando as categorias cadastradas
                                    $monitor = 'T';
                                    $sql = $pdo->prepare("SELECT idcategoria,descricao FROM categoria WHERE monitor = :monitor ORDER BY descricao");
                                    $sql->bindParam(':monitor', $monitor, PDO::PARAM_STR);
                                    $sql->execute();
                                    $ret = $sql->rowCount();

                                        if($ret > 0) {
                                            while($lin = $sql->fetch(PDO::FETCH_OBJ)) {
                                                echo'<option value="'.$lin->idcategoria.'">'.$lin->descricao.'</option>';
                                            }

                                            unset($lin);
                                        }

                                    unset($pdo,$sql,$ret,$monitor);
                                }
                                catch(PDOException $e) {
                                    echo 'Erro ao conectar o servidor '.$e->getMessage();
                                }
                            ?>    
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="valor">Descri&ccedil;&atilde;o</label>
                    <input type="text" name="descricao" id="descricao" class="form-control" maxlength="150" title="Digite a descri&ccedil;&atilde;o do lan&ccedil;amento" placeholder="Descri&ccedil;&atilde;o do lan&ccedil;amento" required>
                </div>
                <div class="form-group">
                    <label for="pago">Pago</label>
                    <div class="input-group">
                        <span class="form-icheck"><input type="radio" name="pago" value="T" required> Sim</span>
                        <span class="form-icheck"><input type="radio" name="pago" value="F"> N&atilde;o</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal">Fechar</button>
        <button type="submit" class="btn btn-primary btn-flat btn-submit-lancamento">Salvar</button>
    </div>
</form>
<script>
    (function ($) {
        var fade = 150, delay = 300;
        
        //datepicker
    
        $("#datado").show(function () {
            $("#datado").datepicker({
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
        
        $("#valor").show(function () {
            $("#valor").maskMoney();
        });
        
        //select 2
        
        $("#categoria").show(function () {
            $("#categoria").select2({
                placeholder: "Selecione a categoria do lançamento",
                allowClear: true
            });
        });
        
        /* FORMS */

        //novo lançamento
        
        $(".form-new-lancamento").submit(function (e) {
            e.preventDefault();

            $.post("lancamentoInsert.php", { datado: $("#datado").val(), tipo: $("input[name='tipo']:checked").val(), valor: $("#valor").val(), categoria: $("#categoria").val(), descricao: $("#descricao").val(), pago: $("input[name='pago']:checked").val(), rand: Math.random()}, function (data) {
                $(".btn-submit-lancamento").html('<img src="img/rings.svg" class="loader-svg">').fadeTo(fade, 1);

                switch (data) {
                case 'reload':
                    $.smkAlert({text: 'Nem todos os plugins foram carregados, recarregando...', type: 'danger', time: 2});
                    location.reload();
                    break;
                        
                case 'true':
                    $.smkAlert({text: 'Lan&ccedil;amento registrado com sucesso.', type: 'success', time: 2});
                    window.setTimeout("location.href='inicio'", delay);
                    break;

                default:
                    $.smkAlert({text: data, type: 'warning', time: 3});
                    break;
                }

                $(".btn-submit-lancamento").html('Salvar').fadeTo(fade, 1);
            });

            return false;
        });
    })(jQuery);
</script>