<?php
    include "includes/header.php";
    include "connexion.php";

    use connection\Connexion;
    $connexion = new Connexion();
    $con = $connexion->con;
    if(isset($_POST['login'])){
        $useremail = filter_var(filter_var($_POST['useremail'], FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL);
        $userpass = $_POST['userpass'];

        $query = "SELECT user_email, user_password FROM users WHERE confirmation_email = 1 AND user_email = ?";
        $stmt = $con->prepare($query);
        $stmt->execute(array($useremail));
        if($stmt->rowCount() > 0){
            $rows = $stmt->fetch();
            echo "<pre>";
            var_dump($rows);
            echo "</pre>";
            if($rows['user_email'] == $useremail && password_verify($userpass, $rows['user_password'])){
                header('location:dashboared.php');
                exit;
            }else{
                echo "<div class='container'>";
                    echo "<div class='row'>";
                        echo "<div class='alert alert-danger text-center text-capitalize'>error login ! email or password incorrect</div>";
                    echo "</div>";
                echo "</div>";
                
            }
        }else{
            echo "<div class='container'>";
                echo "<div class='row'>";
                    echo "<div class='alert alert-danger text-center text-capitalize'>not sutch user or not confirmed user !</div>";
                echo "</div>";
            echo "</div>";
        }
    }
    ?>
    <div class="container">
        <div class="row">
            <div class="login">            
                <div class="content">
                    <div class="text-center text-muted lead text-capitalize">Login</div>
                    <form class="form-horizontal" action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
                        <div class="form-group">
                            <div class="col-md-offset-3 col-md-6">
                                <input type="email" name="useremail" class="form-control" placeholder="E-mail">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-3 col-md-6">
                                <input type="password" name="userpass" class="form-control" placeholder="Password" autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-3 col-md-6">
                                <a href="reset.php" class="text-capitalize text-primary">forgot password</a>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-3 col-md-2">
                                <input type="submit" name="login" class="form-control btn-primary" value="sign up">
                            </div>
                        </div>
                    </form>
                </div>          
            </div>
        </div>
    </div>
    <?php
    include "includes/footer.php";
?>