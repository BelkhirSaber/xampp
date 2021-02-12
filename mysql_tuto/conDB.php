<?php
    $host = "mysql:host=localhost;dbname=ecoms_shop";
    $user = "root";
    $pass = "";
    $option = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8");
    try{
        $con = new PDO($host, $user, $pass, $option);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo 'connection succefuly';

    }catch(PDOException $e){
        echo 'connection failed' . $e->getMessage();
    }

?>
