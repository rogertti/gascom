<?php
    require_once('appConfig.php');

    try {
        include_once('appConnection.php');
        
        $py = md5('idcategoria');
        $sql = $pdo->prepare("SELECT idcategoria,descricao,tipo FROM categoria WHERE idcategoria = :idcategoria");
        $sql->bindParam(':idcategoria', $_GET[''.$py.''], PDO::PARAM_INT);
        $sql->execute();
        $ret = $sql->rowCount();

            if($ret > 0) {
                $lin = $sql->fetch(PDO::FETCH_OBJ);
?>
<form class="form-edit-categoria">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Editar categoria</h4>
    </div><!-- /.modal-header -->
    <div class="modal-body overing">
        <div class="row">
            <div class="col-md-12">
                <input type="hidden" name="idcategoria" id="idcategoria" value="<?php echo $lin->idcategoria; ?>">
               
                <div class="form-group">
                    <label for="descricao2">Descri&ccedil;&atilde;o</label>
                    <input type="text" name="descricao2" id="descricao2" class="form-control" value="<?php echo $lin->descricao; ?>" maxlength="150" title="Informe a descri&ccedil;&atilde;o da categoria" placeholder="Descri&ccedil;&atilde;o da categoria" required>
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
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal">Fechar</button>
        <button type="submit" class="btn btn-primary btn-flat btn-edit-categoria">Salvar</button>
    </div>
</form>
<script>
    (function ($) {
        var fade = 150, delay = 300;
        
        //icheck

        $("input[type='checkbox'], input[type='radio']").show(function () {
            $("input[type='checkbox'], input[type='radio']").iCheck({
                checkboxClass: 'icheckbox_minimal',
                radioClass: 'iradio_minimal'
            });
        });
        
        //edita categoria
        
        $(".form-edit-categoria").submit(function (e) {
            e.preventDefault();

            $.post("categoriaUpdate.php", { idcategoria: $("#idcategoria").val(), descricao: $("#descricao2").val(), tipo: $("input[name='tipo2']:checked").val(), rand: Math.random()}, function (data) {
                $(".btn-edit-categoria").html('<img src="img/rings.svg" class="loader-svg">').fadeTo(fade, 1);

                switch (data) {
                case 'reload':
                    $.smkAlert({text: 'Nem todos os plugins foram carregados, recarregando...', type: 'danger', time: 2});
                    location.reload();
                    break;

                case 'true':
                    $.smkAlert({text: 'Categoria editada com sucesso.', type: 'success', time: 2});
                    window.setTimeout("location.href='categoria'", delay);
                    break;

                default:
                    $.smkAlert({text: data, type: 'warning', time: 3});
                    break;
                }

                $(".btn-edit-categoria").html('Salvar').fadeTo(fade, 1);
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