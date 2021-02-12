<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/bootstrap.min.js">
</head>
<body>
    <?php
        require_once "vendor/autoload.php";

        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\Exception;

        if(isset($_POST['send'])){
            $mail = new PHPMailer(true);

            $mail->isSMTP(); // enable SMTP
            // $mail->SMTPDebug = 2;  // debugging: 1 = errors and messages, 2 = messages only
            $mail->SMTPAuth = true;  // authentication enabled
            $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
            $mail->Host = 'smtp.gmail.com'; //Host SMTP pour gmail c'est celui là
            $mail->Port = 465; //Port 25 ou 465 (SSL) pour Gmail / 587 (TLS) pour gmail 
            $mail->Username = "contact.healthfitness824@gmail.com"; //compte mail
            $mail->Password = "belkhir1994*/"; //pass compte mail

            $mail->From = "contact.healthfitness824@gmail.com";
            $mail->FromName = "saber belkhir";
            $mail->addReplyTo("contact.healthfitness824@gmail.com");
            $mail->addAddress("saber.forexzw@gmail.com", "belkhir saber");

            $mail->isHTML(true);
            $mail->Subject = "this content for testing send email";
            $mail->Body = "<i>mailing for testing with phpmailer librarie</i>";

            // $mail->SMTPOptions = array(
            //     'ssl' => array(
            //         'verify_peer' => false,
            //         'verify_peer_name' => false,
            //         'allow_self_signed' => true
            // ));

            try{
                $mail->send();
                echo "mail send successfuly";
            }catch(Exception $e){
                echo 'error send mail' . $mail->ErrorInfo;
            }

        }

    ?>
    

    <div class="container">
        <div class="row">
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" class="horizontal">
                <input class="btn-success" type="submit" value="send email" name="send">
            </form>   
        </div>
    </div>

    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>