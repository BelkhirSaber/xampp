<?php
  ob_start();
  session_start();
  if(isset($_SESSION['user']) && !empty($_SESSION['user'])){
    unset($_SESSION['identify'], $_SESSION['user'], $_SESSION['Fname']);
    header("Location: index.php");
    exit();
  }else{
    header("Location: login.php");
    exit();
  }
  ob_end_flush();
?>
