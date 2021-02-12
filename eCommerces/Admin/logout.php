<?php
  ob_start();
  session_start();
  unset($_SESSION['Username'], $_SESSION['ID']);
  header('Location: index.php');
  exit();
  ob_end_flush();
?>
