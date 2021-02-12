<?php
    $dsn = "mysql:host=localhost;dbname=testingDB";
    $username = "root";
    $pass = "";
    $option = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8");
    global $con;


    try{
        $con = new PDO($dsn, $username, $pass, $option);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "connection sucessefuly";
    }catch(Exception $e){
        echo "connection failed" . $e->getMessage;
    }

?>