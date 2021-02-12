<?php
    include "includes/header.php";
    include "connexion.php";
    use connection\Connexion;


    if(isset($_GET['id']) && $_GET['id'] == 'reset'){
        $useremail = $_GET['email'];
        ?>

        <div class="container">
            <div class="row">
                <h2 class="text-capitalize text-center text-muted">new password</h2>
                <form action="resetpassword.php" method="POST" class="form-horizontal">
                    <input type="hidden" name="email" value="<?php echo $useremail; ?>">
                    <div class="form-group">
                        <div class="col-md-offset-3 col-md-6">
                            <input type="password" class="form-control" name="pass" placeholder="new password" autocomplete="new-password">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-offset-3 col-md-6">
                            <input type="password" class="form-control" name="confpass" placeholder="confirm password" autocomplete="new-password">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-offset-3 col-md-2">
                            <input type="submit" class="form-control btn-primary" name="resetpass" value="reset" >
                        </div>
                    </div>

                </form>
            </div>
        </div>
<?php
    }elseif($_POST['resetpass']){
        $userpass = $_POST['pass'];
        $userconfpass = $_POST['confpass'];
        $useremail = $_POST['email'];
        if($userpass === $userconfpass){
            $connexion = new Connexion();
            $con = $connexion->con;
            $hash_password = password_hash($userpass, PASSWORD_DEFAULT);
            $query = "UPDATE users SET user_password = :userpass, confirmation_email = 1 WHERE user_email = :useremail";
            $stmt = $con->prepare($query);
            $stmt->execute(array(
                ':userpass' => $hash_password,
                ':useremail' => $useremail
            ));
            if($stmt->rowCount() > 0){
                header('Location:confirm.php?id=reset_password');
                exit;
            }
        }else{
            echo "<div class='alert alert-danger text-center'>confirmation password not correct!</div>";
        }
    }

include "includes/footer.php";
?>