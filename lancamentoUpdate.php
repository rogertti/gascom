<?php
    require_once('appConfig.php');

    //controle de variável
    $msg = "Campo obrigat&oacute;rio vazio.";

        //depuração dos campos
        if(empty($_POST['idlancamento'])) { die("reload"); }
        if(empty($_POST['rand'])) { die("Vari&aacute;vel de controle nula."); }
        if(empty($_POST['datado'])) { die($msg); } else {
            $filtro = 1;
            
            $dia = substr($_POST['datado'],0,2);
            $mes = substr($_POST['datado'],3,2);
            $ano = substr($_POST['datado'],6);
            $datado = $ano.'-'.$mes.'-'.$dia;
        }
        if(empty($_POST['tipo'])) { die($msg); } else { $filtro++; }
        if(empty($_POST['valor'])) { die($msg); } else {
            $filtro++;
            
            $_POST['valor'] = str_replace(",", "", $_POST['valor']);
        }
        if(empty($_POST['categoria'])) { die($msg); } else { $filtro++; }
        if(empty($_POST['descricao'])) { die($msg); } else {
            $filtro++;

            $_POST['descricao'] = str_replace("'","&#39;",$_POST['descricao']);
            $_POST['descricao'] = str_replace('"','&#34;',$_POST['descricao']);
            $_POST['descricao'] = str_replace('%','&#37;',$_POST['descricao']);
        }
        if(empty($_POST['pago'])) { die($msg); } else { $filtro++; }

        if($filtro == 6) {
            try {
                include_once('appConnection.php');

                //verificando duplicata
                /*$sql = $pdo->prepare("SELECT idlancamento,monitor FROM lancamento WHERE descricao = :descricao");
                $sql->bindParam(':descricao', $_POST['descricao'], PDO::PARAM_STR);
                $sql->execute();
                $ret = $sql->rowCount();

                    if($ret > 0) {
                        $lin = $sql->fetch(PDO::FETCH_OBJ);
                        $py = md5('idlancamento');
                        
                        if($lin->status == 'O') {
                            die('Essa situa&ccedil;&atilde;o j&aacute; est&aacute; cadastrada.');    
                        }
                        
                        if($lin->status == 'X') {
                            die('Essa situa&ccedil;&atilde;o j&aacute; est&aacute; cadastrada, mas est&aacute; desativada. <a href="lancamentoActivate.php?'.$py.'='.$lin->idlancamento.'" title="Ativar situa&ccedil;&atilde;o">Clique para ativar.</a>');    
                        }
                    }

                unset($sql,$ret,$lin,$py);*/
                
                //atualiza no banco
                $sql = $pdo->prepare("UPDATE lancamento SET categoria_idcategoria = :categoria,dia = :dia,mes = :mes,ano = :ano,datado = :datado,tipo = :tipo,descricao = :descricao,valor = :valor,pago = :pago WHERE idlancamento = :idlancamento");
                $sql->bindParam(':categoria', $_POST['categoria'], PDO::PARAM_INT);
                $sql->bindParam(':dia', $dia, PDO::PARAM_STR);
                $sql->bindParam(':mes', $mes, PDO::PARAM_STR);
                $sql->bindParam(':ano', $ano, PDO::PARAM_STR);
                $sql->bindParam(':datado', $datado, PDO::PARAM_STR);
                $sql->bindParam(':tipo', $_POST['tipo'], PDO::PARAM_STR);
                $sql->bindParam(':descricao', $_POST['descricao'], PDO::PARAM_STR);
                $sql->bindParam(':valor', $_POST['valor'], PDO::PARAM_STR);
                $sql->bindParam(':pago', $_POST['pago'], PDO::PARAM_STR);
                $sql->bindParam(':idlancamento', $_POST['idlancamento'], PDO::PARAM_INT);
                $res = $sql->execute();

                    if(!$res) {
                        var_dump($sql->errorInfo());
                        exit;
                    } else {
                        echo'true';
                    }

                unset($pdo,$sql,$res);
            }
            catch(PDOException $e) {
                echo'Falha ao conectar o servidor '.$e->getMessage();
            }
        } else {
            echo'
            <div class="callout">
                <h4>Algum campo obrigat&oacute;rio ficou vazio</h4>
            </div>';
        }

    unset($msg,$filtro,$cfg,$e);
?>