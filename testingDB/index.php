<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/web.css">
</head>
<body>

    <?php
        include_once "connection.php";
        if(isset($_POST['firstname'], $_POST['lastname'], $_POST['useremail'])){
            
            $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_STRING);
            $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_STRING);
            $useremail = filter_var($_POST['useremail'], FILTER_VALIDATE_EMAIL);

            $query = "INSERT INTO users(firstname, lastname, email) VALUES(:firstname, :lastname, :useremail)";
            $stmt = $con->prepare($query);
            $stmt->execute(array(
                ":firstname" => $firstname,
                ":lastname" => $lastname,
                ":useremail" => $useremail
            ));

            if($stmt->rowCount() > 0){
                echo "information insert successefuly";
            }

        }
    ?>
    
    <div class="container">
        <div class="row">
            <div class="content">
    
                <form class="form-horizontal" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                    <h2 class="lead text-center text-capitalize">Insert Your Data</h2>
                    <div class="form-group">
                        <label class="col-md-2 label-control">First Name</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="firstname" placeholder="First Name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 label-control">Last Name</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="lastname" placeholder="Last Name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 label-control">Email</label>
                        <div class="col-md-10">
                            <input type="email" class="form-control" name="useremail" placeholder="Email">
                        </div>
                    </div>

                    <div class="form-group">                    
                        <div class="col-md-2 col-md-offset-2">
                            <input type="submit" class="form-control" value="Insert">
                        </div>
                    </div>
                </form>                
            </div>
        </div>
    </div>


    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>