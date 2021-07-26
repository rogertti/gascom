<?php
    require_once('appConfig.php');

    try {
        include_once('appConnection.php');

        $py = md5('idlancamento');
        $monitor = 'F';
        $sql = $pdo->prepare("UPDATE lancamento SET monitor = :monitor WHERE idlancamento = :idlancamento");
        $sql->bindParam(':monitor', $monitor, PDO::PARAM_STR);
        $sql->bindParam(':idlancamento', $_GET[''.$py.''], PDO::PARAM_INT);
        $res = $sql->execute();
        
            if(!$res) {
                var_dump($sql->errorInfo());
                exit;
            } else {
                header('location:inicio');
            }

        unset($pdo,$sql,$res,$status,$py);
    }
    catch(PDOException $e) {
        echo'Falha ao conectar o servidor '.$e->getMessage();
    }   
?>