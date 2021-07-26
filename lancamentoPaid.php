<?php
    require_once('appConfig.php');

    try {
        include_once('appConnection.php');

        $py = md5('idlancamento');
        $paid = 'T';
        $sql = $pdo->prepare("UPDATE lancamento SET pago = :pago WHERE idlancamento = :idlancamento");
        $sql->bindParam(':pago', $paid, PDO::PARAM_STR);
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