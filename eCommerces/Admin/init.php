<?php
  //gestion de session
  ini_set('session.use_strict_mode', 1);
  include "connect.php";
  // Routes
  $template = "includes/templates/";
  $language = "includes/languages/";
  $function = "includes/functions/";
  $css = "layout/css/";
  $js = "layout/js/";

  include $language . "en.php";
  include $function . "function.php";
  include $template . "header.php";
  if(!isset($noNavbar)){
    include $template . "navbar.php";
  }
