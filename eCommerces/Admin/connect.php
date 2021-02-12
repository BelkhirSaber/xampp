<?php
  $data_source_name = "mysql:host=localhost;dbname=shop";
  $user = "root";
  $pass = "";
  $option = array( PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
  try{
    $con = new PDO($data_source_name, $user, $pass, $option);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo 'you are connected with database ecom_shop';
  }catch(PDOException $e){
    echo 'Failed to connect with database' . $e->getMessage();
  }
