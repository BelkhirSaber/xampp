<?php
    include "includes/header.php";
    include "functions/function.php";
    include "connexion.php";
    require_once "vendor/autoload.php";
    require_once "vendor/phpmailer/phpmailer/src/PHPMailer.php";
    require_once "vendor/phpmailer/phpmailer/src/Exception.php";
    

    use tool\Functions;
    use connection\Connexion;
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    $msg;
    $fromError = array();
    $connexion = new Connexion();
    
    // echo "<pre>";
    // var_dump($connexion);
    // echo "</pre>";
    if(isset($_POST['username'], $_POST['email'], $_POST['pass'], $_POST['confPass'])){

        $con = $connexion->con;
        $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
        $useremail = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        $userpass = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);
        $userconfpass = filter_var($_POST['confPass'], FILTER_SANITIZE_STRING);
        $hash_pass = password_hash($userpass, PASSWORD_DEFAULT);

        $query = "SELECT * FROM users WHERE user_name = ? OR user_email = ?";
        $stmt = $con->prepare($query);
        $stmt->execute(array($username, $useremail));

        if($stmt->rowCount() > 0){
            $fromError[] = "<div class='alert alert-danger'>user already exist</div>";
        }else{
            if(empty($username)){
                $fromError[] = "<div class='alert alert-danger'> empty username !</div>";
            }
            if(empty($useremail)){
                $fromError[] = "<div class='alert alert-danger'> empty email !</div>";
            }
            if(empty($userpass)){
                $fromError[] = "<div class='alert alert-danger'> empty password !</div>";
            }else if($userpass != $userconfpass){
                $fromError[] = "<div class='alert alert-danger'> invalide password confirmation !</div>";
            }
        }
        
        

        if(!empty($fromError)){
            echo '<div class="container">';
                foreach ($fromError as $error) {
                    echo $error;
                }
            echo '</div>';
                
        }else{
            $str_token = "AZERTYUIOPQSDFGHJKLMWXCVBN?%*)(31234567890azertyuiopqsdfghjklmwxcvbn";
            $token = str_shuffle($str_token);
            $token = substr($token, 10, 20);

            $query = "INSERT INTO users(user_name, user_email, user_password, user_token) VALUES(:username, :useremail, :userpass, :usertoken)";

            $stmt = $con->prepare($query);

            $stmt->execute(array(
                ':username'  => $username,
                ':useremail' => $useremail,
                ':userpass'  => $hash_pass,
                ':usertoken' => $token
            ));

            if($stmt->rowCount() > 0){
                $msg = "thank you for registration please check your email !";

                $mail = new PHPMailer(true);

                //config serveur smtp
                $mail->isSMTP();
                // $mail->SMTPDebug = 2;
                $mail->SMTPAuth = true;
                $mail->SMTPSecure = "ssl";
                $mail->Host = "smtp.gmail.com";
                $mail->Port = 465;
                $mail->Username = "contact.healthfitness824@gmail.com";
                $mail->Password = "belkhir1994*/";

                $mail->From = "contact.healthfitness824@gmail.com";
                $mail->FromName = "saber belkhir";
                $mail->addReplyTo("contact.healthfitness824@gmail.com");
                $mail->addAddress($useremail, $username);


                $mail->isHTML(true);
                $mail->Subject = "confiramtion email";
                $mail->Body = "
                    <b>confirm your email address</b>
                    <br>
                    <a class='text-uppercase' href='localhost/mailverification/confirm.php?id=mail_confirm&token=".$token."'> click here </a>";

                $mail->SMTPOptions = array(
                    "ssl"=>array(
                        "verify_peer" => false,
                        "verify_peer_name" => false,
                        "allow_self_signed" => true
                    ));
                try{
                    $mail->send();
                    // echo 'email sending';
                    $redirect = new Functions();
                    $redirect->redirect("confirm.php?id=register", $msg);
                }catch(Exception $e){
                    echo 'error send email' . $mail->ErrorInfo;
                }

                
                // header("Location:confirm.php?msg=$msg");
                // exit;
                /*$mail = new PHPMailer();
                $mail->setFrom("contact.noreplay@gmail.com");
                $mail->addAddress($useremail, $username);
                $mail->isHTML(true);
                $mail->Subject = "please verify your email";
                $mail->body = "
                    please in this link below to verify your account ! </br></br>
                    <a href='http://belkhirsaber.epizy.com/MAILVERIFICATION/confirmemail.php?email=<?php echo $useremail?>&token=<?php echo token?>'>click here</a>
                ";
                $result = $mail->send();
                echo $result;*/
                // if($mail->send()){
                //     $redirect = new Functions();
                //     $redirect->redirect("confirm.php", $msg);
                // }else{
                //     echo '<div class="container"><div class="row">';
                //         echo "<div class='alert alert-danger'>something problem wrong please aigen !</div>";
                //     echo '</div></div>';
                    
                // }
                
            }
        }
    }
?>
    <div class="container">
        <div class="row">
            <div class="register">
                <div class="content">
                    <?php 
                        $item = new Functions();
                        $item->namePost("saber", ["this", "saber"]);
                        $item->nameGet("saber", [1,2,3]);
                    ?>
                    <div class="text-center text-muted text-capitalize">register</div>
                    <form class="form-horizontal" action="<?php $_SERVER['PHP_SELF'];?>" method="POST">
                        
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <input class="form-control" type="text" name="username" placeholder="username">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <input class="form-control" type="email" name="email" placeholder="E-mail">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <input class="form-control" type="password" name="pass" placeholder="password" autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <input class="form-control" type="password" name="confPass" placeholder="confirmation password" autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <input class="form-control btn btn-primary" type="submit" name="submit" value="register">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php include "includes/footer.php"; ?>