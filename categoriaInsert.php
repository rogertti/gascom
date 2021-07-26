<?php
    require_once('appConfig.php');

    //controle de variável
    $msg = "Campo obrigat&oacute;rio vazio.";

        //depuração dos campos
        if(empty($_POST['rand'])) { die("Vari&aacute;vel de controle nula."); }
        if(empty($_POST['descricao'])) { die($msg); } else {
            $filtro = 1;

            $_POST['descricao'] = str_replace("'","&#39;",$_POST['descricao']);
            $_POST['descricao'] = str_replace('"','&#34;',$_POST['descricao']);
            $_POST['descricao'] = str_replace('%','&#37;',$_POST['descricao']);
        }
        if(empty($_POST['tipo'])) { die($msg); } else { $filtro++; }

        if($filtro == 2) {
            try {
                include_once('appConnection.php');

                //verificando duplicata
                $sql = $pdo->prepare("SELECT idcategoria,monitor FROM categoria WHERE descricao = :descricao");
                $sql->bindParam(':descricao', $_POST['descricao'], PDO::PARAM_STR);
                $sql->execute();
                $ret = $sql->rowCount();

                    if($ret > 0) {
                        $lin = $sql->fetch(PDO::FETCH_OBJ);
                        $py = md5('idcategoria');
                        
                        if($lin->monitor == 'T') {
                            die('Essa categoria j&aacute; est&aacute; cadastrada.');    
                        }
                        
                        if($lin->monitor == 'F') {
                            die('Essa categoria j&aacute; est&aacute; cadastrada, mas est&aacute; desativada. <a href="categoriaActivate.php?'.$py.'='.$lin->idcategoria.'" title="Ativar categoria">Clique para ativar.</a>');    
                        }
                    }

                unset($sql,$ret,$lin,$py);
                
                //insere no banco
                $monitor = 'T';
                $sql = $pdo->prepare("INSERT INTO categoria (descricao,tipo,monitor) VALUES (:descricao,:tipo,:monitor)");
                $sql->bindParam(':descricao', $_POST['descricao'], PDO::PARAM_STR);
                $sql->bindParam(':tipo', $_POST['tipo'], PDO::PARAM_STR);
                $sql->bindParam(':monitor', $monitor, PDO::PARAM_STR);
                $res = $sql->execute();

                    if(!$res) {
                        var_dump($sql->errorInfo());
                        exit;
                    } else {
                        echo'true';
                    }

                unset($pdo,$sql,$res,$monitor);
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