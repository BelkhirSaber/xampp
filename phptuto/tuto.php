<?php
    $dsn = "mysql:host=localhost;dbname=saber";
    $user = "root";
    $pass = "";
    $query = "INSERT INTO `users` (`id`, `name`, `lastName`) VALUES ('2', 'mohammed', 'brahim')";
    try{
        $db = new PDO($dsn, $user, $pass);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->exec($query);
        echo "true";
        
    }catch(PDOException $e){
        echo $e->getMessage();
    }
?>