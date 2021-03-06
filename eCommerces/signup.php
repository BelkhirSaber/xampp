<?php
  ob_start();
  session_start();
  $pageTitle = "SignUp";
  include "init.php";
  include $template . "navbar.php";
  if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $user = "";
    $Fname = "";
    $mail = "";
    $pass = "";
    $confpass = "";
    $formError = array();

    if(filter_has_var(INPUT_POST, 'user')){
      $user = htmlspecialchars(is_trim(filter_var($_POST['user'], FILTER_SANITIZE_STRING)));
      if(empty($user)){
        $formError[] = '<div class="message">Username Cont Be Empty !</div>';
      }else{
        if(strlen($user) < 5){
          $formError [] = '<div class="message">Username Cant Be More Thant 5 Caraters !</div>';
        }
        if(strlen($user) > 20){
          $formError [] = '<div class="message">Username Cant Be Less Thant 20 Caraters !</div>';
        }
      }
      //$formError [] = '<div class="alert alert-success">'. $user .'</div>';
    }

    if(filter_has_var(INPUT_POST, 'Fname')){
      $Fname = htmlspecialchars(is_trim(filter_var($_POST['Fname'], FILTER_SANITIZE_STRING)));
      if(empty($Fname)){
        $formError [] = '<div class="message">Full Name Cant Be Empty !</div>';
      }else{
        if(strlen($Fname) < 6){
          $formError [] = '<div class="message">Full Name Cant Be More Thant 6 Caracters !</div>';
        }
        if(strlen($Fname) > 25){
          $formError [] = '<div class="message">Full Name Cant Be Less Thant 25 Caracterse !</div>';
        }
      }
      //$formError [] = '<div class="alert alert-success">'. $Fname .'</div>';
    }

    if(filter_has_var(INPUT_POST, 'mail')){
        $mail = filter_var($_POST['mail'], FILTER_SANITIZE_EMAIL);
      if(empty($mail)){
        $formError [] = '<div class="message">Email Cant Be Empty !</div>';
      }else{
        $domains = explode('@', $mail);
      if(!filter_var($mail, FILTER_VALIDATE_EMAIL) || !checkdnsrr(array_pop($domains), 'MX') ){
          $formError [] = '<div class="message">Invalide Email !</div>';
        }
      }
      //$formError [] = '<div class="alert alert-success">'. $mail .'</div>';
    }

    if(filter_has_var(INPUT_POST, 'pass')){
      $pass = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);
      if(empty($pass)){
        $formError[] = '<div class="message">Password Cant Be Empty !</div>';
      }else{
        if(strlen($pass) < 8){
          $formError [] = '<div class="message">Password Cont Be less Thant 8 Caracters !</div>';
        }else{
          if(filter_has_var(INPUT_POST, 'confpass')){
            $confpass = filter_var($_POST['confpass'], FILTER_SANITIZE_STRING);
            if(empty($confpass)){
              $formError[] = '<div class="message">Password Confermation Cant Be Empty !</div>';
            }else{
              if($pass !== $confpass){
                $formError [] = '<div class="message">Incorrecte Confirmation Password !</div>' ;
              }
            }
          }
        }
      }
      //$formError [] = '<div class="alert alert-success">'. $pass .'</div>';
    }

    if(empty($formError)){
      $stmt = $con->prepare("SELECT * FROM users WHERE Username = ?");
      $stmt->execute(array($user));
      if($stmt->rowCount() == 0){
        $stmt = $con->prepare("INSERT INTO users(Username, Password, Email, Fullname, GroupID, RegDate) VALUES(?, ?, ?, ?, 3, now())");
        $stmt->execute(array($user, password_hash($pass, PASSWORD_DEFAULT), $mail, $Fname));
        if($stmt->rowCount() == 1){
          $_SESSION['user'] = $user;
          $_SESSION['Fname'] = $Fname;
          header('Location: profile.php');
          exit();
        }else{
          $formError[] = '<div class="message">Error In Ceate Count Plais Verify Your Information !</div>';
        }
      }else{
        $formError[] = "<div class='message'>this user exit !</div>";
      }
    }
  }
  ?>
  <section class="signup-page">
    <div class="container-fluid">
      <h1 class="text-center">SignUp</h1>
      <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="P<App>
	<DisplayName>CCXP_3_0_1_1_32</DisplayName>
	<RealRegistryEntry></RealRegistryEntry>
	<installlocation>C:\Program Files (x86)\Adobe\Adobe Creative Cloud Experience</installlocation>
	<RegistryEntry>CCXP_3_0_1_1_32</RegistryEntry>
	<UninstallString>"C:\Program Files (x86)\Common Files\Adobe\Adobe Desktop Common\HDBox\Uninstaller.exe" --uninstall=1 --sapCode=CCXP --productVersion=3.0.1.1 --productPlatform=win32 --productAdobeCode={CCXP-3.0.1-32-ADBEADBEADBEADBEADBEAD} --productName="CCX Process" --mode=1</UninstallString>
	<exefile></exefile>
	<is64>N</is64>
</App>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      