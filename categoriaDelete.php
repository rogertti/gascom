<?php
    require_once('appConfig.php');

    try {
        include_once('appConnection.php');

        $py = md5('idcategoria');
        $monitor = 'F';
        $sql = $pdo->prepare("UPDATE categoria SET monitor = :monitor WHERE idcategoria = :idcategoria");
        $sql->bindParam(':monitor', $monitor, PDO::PARAM_STR);
        $sql->bindParam(':idcategoria', $_GET[''.$py.''], PDO::PARAM_INT);
        $res = $sql->execute();
        
            if(!$res) {
                var_dump($sql->errorInfo());
                exit;
            } else {
                header('location:categoria');
            }

        unset($pdo,$sql,$res,$status,$py);
    }
    catch(PDOException $e) {
        echo'Falha ao conectar o servidor '.$e->getMessage();
    }   
?>