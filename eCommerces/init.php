<?php
  //inaccepted session id empty
  ini_set('session.use_strict_mode', 1);
  //Reporting Errors
  ini_set('display_errors', 'On');
  error_reporting(E_ALL);
  // Routes For Frent-end
  $template = "includes/templates/";
  $language = "includes/languages/";
  $function = "includes/functions/";
  $image = "layout/images/";
  $css = "Layout/css/";
  $js = "Layout/js/";
  //Important Includes
  include "Admin/connect.php";
  include $function . "functions.php";
  include $template . "header.php";
