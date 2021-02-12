<?php
    include_once "includes/header.php";
    require_once "connexion.php";
    require_once "vendor/autoload.php";
    require_once "vendor/phpmailer/phpmailer/src/PHPMailer.php";
    require_once "vendor/phpmailer/phpmailer/src/Exception.php";
    require_once "functions/function.php";

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use connection\Connexion;
use tool\Functions;

$connexion = new Connexion();
    $con = $connexion->con;
    if(isset($_POST['reset'])){
        $useremail;
        $formError = array();
        if(!empty($_POST['useremail'])){
            $useremail = filter_var(filter_var($_POST['useremail'], FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL);
        }else{
            $formError[] = "<div class='alert alert-danger'>empty email !</div>";
        }

        if(empty($formError)){
            
            $query = "SELECT * FROM users WHERE user_email = :useremail AND confirmation_email = 1";
            $stmt = $con->prepare($query);
            $stmt->bindParam(":useremail", $useremail);
            $stmt->execute();
            if($stmt->rowCount() > 0){
                $row = $stmt->fetch();
                $mail = new PHPMailer(true);
                // config serveur smtp
                $mail->isSMTP(true);
                // $mail->SMTPDebug = 2;
                $mail->SMTPAuth = true;
                $mail->SMTPSecure = "ssl";
                $mail->Host = "smtp.gmail.com";
                $mail->Port = 465;
                // config sender mail
                $mail->Username = "contact.healthfitness824@gmail.com";
                $mail->Password = "belkhir1994*/";

                //config recever mail
                $mail->From = "contact.healthfitness824@gmail.com";
                $mail->FromName = "souq bazaar online";
                $mail->addReplyTo("contact.healthfitness824@gmail.com");
                $mail->addAddress($row['user_email'], $row['user_name']);

                // config mail body
                $mail->isHTML(true);
                $mail->Subject = "Reset Password";
                $mail->Body = "
                <p class='lead'>Please Reset Your Password From This Link</p>
                <a href='localhost/mailverification/resetpassword.php?id=reset&email=".$row['user_email']."' class='text-capitalize'>click here</a>";

                $mail->SMTPOptions = array("ssl"=>array(
                    "verify_peer" => false,
                    "verify_peer_name" => false,
                    "allow_self_signed" => true
                ));
                try{
                    $mail->send();
                    $query = "UPDATE users SET confirmation_email = 0, user_password = '' WHERE user_email = :useremail";
                    $stmt = $con->prepare($query);
                    $stmt->bindParam(":useremail", $row['user_email']);
                    $stmt->execute();
                    if($stmt->rowCount() > 0){
                        header('Location:confirm.php?id=reset');
                        exit;
                    }else{
                        echo "<h2 class='text-center text-danger text-capitalize'>Error please try again</h2>";
                    }
                    
                }catch(Exception $e){
                    echo "failed send email verification" . $mail->ErrorInfo;
                }



            }else{
                echo "<div class='container'>"; 
                    echo "<div class='row'>";
                        echo "<div class='alert alert-danger'>not sutch user !</div>";
                    echo"</div>";
                echo"</div>";    
                $fn = new Functions();
                $fn->refresh("reset.php", 5);
            }

        }else{
            echo "<div class='container'>"; 
                echo "<div class='row'>";
                    foreach ($formError as $error) {
                        echo $error;
                    }
                echo"</div>";
            echo"</div>";
        }
    }
?>
    
    <div class="container">
        <div class="row">
            <div class="reset">
                <div class="content">
                    <div class="text-muted text-capitalize text-center">reset password</div>
                    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" class="form-horizontal">
                        <div class="form-group">
                            <div class="col-md-offset-3 col-md-6">
                                <input type="email" name="useremail" class="form-control" placeholder="E-mail">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-3 col-md-2">
                                <input type="submit" name="reset" class="form-control btn-primary" value="verify">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php
    include_once "includes/footer.php";
?>