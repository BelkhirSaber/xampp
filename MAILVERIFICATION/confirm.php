<?php
    include "includes/header.php";
    include "functions/function.php";
    require_once "connexion.php";

    use connection\Connexion;
    use tool\Functions;

    $GET_ID = (isset($_GET['id']) && !empty($_GET['id']))? $_GET['id']: 'invalid';
    $fn = new Functions();
    if($GET_ID == 'register'){
        $msg = $_GET['msg'];
        
        echo '<div class="container">';
            echo '<div class="row">';
                echo '<div class="confText lead text-center text-success text-capitalize">' .$msg . '</div>';
                $fn->refresh("login.php", 5);
                // echo dirname(__FILE__);
            echo '</div>';
        echo '</div>';
    }elseif($GET_ID == 'mail_confirm'){
        $token = $_GET['token'];
        $connexion = new Connexion;
        $con = $connexion->con;
        $query = "SELECT id FROM users WHERE user_token = ?";
        $statment = $con->prepare($query);
        $statment->execute(array($token));
        // echo $token;
        // echo $statment->rowCount();
        ?>
        
        <div class="container">
            <div class="row">
                <?php
                    if($statment->rowCount() > 0){
                        $query = " UPDATE users SET confirmation_email = 1, user_token = '' WHERE user_token = ?";
                        $stmt = $con->prepare($query);
                        $stmt->execute(array($token));
                        if($stmt->rowCount() > 0){
                            echo "<div class='alert alert-success text-capitalize text-center'>your email confirm with success</div>";
                            $fn->refresh("login.php", 5);
                        }else{
                            echo "<div class='alert alert-success text-capitalize text-center'>your email confirm with success</div>";
                            
                        }
                    }else{
                        echo "<div class='alert alert-danger text-center text-capitalize'>user not found</div>";
                        $fn->refresh("index.php", 3);
                    }
                ?>
            </div>
        </div>
    <?php  
    }elseif($GET_ID == "reset"){
        echo "<h2 class='text-center text-success text-capitalize'>please check your email for reset password</h2>";
        $fn->refresh('login.php', 5);
    }elseif($GET_ID == 'reset_password'){


        echo "<h2 class='text-center text-seccus text-capitalize'>your password changed with success !</h2>";
        $fn->refresh('login.php', 5);

        
    }elseif($GET_ID == 'invalid'){
        header('Location: index.php');
        exit;
    }
    include "includes/footer.php";
?>