<?php
	$host = 'mysql:host=127.0.0.1;dbname=saber_test';
	$user = 'root';
	$pass = '';
	$option = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8');

    try{
    	$con = new PDO($host, $user, $pass, $option);
    	$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    	echo 'connection successufuly <br/>';
        $stm = $con->prepare("create table if not exists clients(clientID int(11) not null, username varchar(255) not null unique, primary key(clientID))engine = innodb");
        if(is_bool($stm->execute())){
            echo 'table clients created successufuly <br/>';
            $stm = $con->prepare("create table if not exists orders(orderID int(11) not null primary key, name varchar(255) not null unique, clientID int(11) not null, foreign key(clientID) references clients(clientID))");
            $stm->execute();
        }



    }catch(PDOException $e){
    	echo 'failed connection : ' . $e->getMessage();
    }

    
?>