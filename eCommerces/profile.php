<?php
  ob_start();
  session_start();
  $pageTitle = "My Profile";
  include 'init.php';
  include $template . 'navbar.php';
  $act = isset($_GET['act']) && !empty($_GET['act']) ? $_GET['act'] : 'manage';?>
  <section class="profile">
    <div class="container-fluid">
  <?php
  if($act == 'manage'){
    if(isset($_SESSION['user']) && !empty($_SESSION['user'])){
      $stmt = $con->prepare("SELECT * FROM users WHERE Username = ? AND GroupID = 3");
      $stmt->execute(array($_SESSION['user']));
      $userProfil = $stmt->fetch();
      /*echo '<pre>';
        print_r($userProfil);
      echo '</pre>';*/
      ?>
      <h2 class="text-capitalize">Profile: <?php  echo $_SESSION['user'];?></h2>
      <div class="info">
        <?php include $template . "profileinfoheading.php"; ?>
        <div class="info-body">

          <div class="container-fluid">
            <div class="row">

              <div class="col-sm-3">
                <img src="https://via.placeholder.com/260x340/877" alt="saberbelkhir"/>
              </div>

              <div class="col-sm-9">

                <div class="panel panel-primary">
                  <div class="panel-heading">Informations</div>
                  <div class="panel-body">
                    <div class="myInfo">
                      <div>
                        <label><i class="fas fa-unlock fa-fw"></i> Username :</label><span><?php echo $userProfil['Username']; ?></span>
                      </div>
                      <div>
                        <label><i class="fas fa-user-tag fa-fw"></i> Full Name :</label><span><?php echo $userProfil['Fullname']; ?></span>
                      </div>
                      <div>
                        <label><i class="fas fa-envelope fa-fw"></i> Email : </label><span><?php echo $userProfil['Email']; ?></span>
                      </div>
                      <div>
                        <label><i class="fas fa-calendar-alt fa-fw"></i> Regestration Date: </label><span><?php echo $userProfil['RegDate']; ?></span>
                      </div>
                      <div>
                        <label><i class="fas fa-tags fa-fw"></i> Status :</label><?php if($userProfil['RegStatus'] == 1){
                          echo '<span class="text-success">Activated</span>';
                        }else{
                          echo '<span class="text-danger">Not Activated</span>';
                        } ?>
                      </div>

                    </div>
                  </div>
                </div>

                <div class="panel panel-primary">
                  <div class="panel-heading">Address</div>
                  <div class="panel-body">
                    <div class="address">
                      <span class="text-capitalize">zroau nouvelle </span>
                      <span>6024</span>
                      <span class="text-capitalize" style="display: block;">Gabes Tunis</span>
                    </div>
                    <div class="link">
                      <a href="#" class="btn btn-sm text-primary pull-right">New Address</a>
                      <a href="#" class="btn btn-sm text-primary pull-right">Edit Address</a>
                    </div>
                    <div class="clearfix"></div>
                  </div>
                </div>

                <div class="panel panel-primary">
                  <div class="panel-heading">Last Commande</div>
                  <div class="panel-body">
                    <div class="commande">
                      <div class="img">
                        <img src="https://via.placeholder.com/100" al=""/>
                      </div>
                      <div class="info-product">
                        <span>Description</span>
                        <span>Date Livriason</span>
                        <a href="#" class="text-primary pull-right">Detaille</a>
                      </div>
                      <div class="clearfix"></div>
                    </div>
                    <hr />

                    <div class="commande">
                      <div class="img">
                        <img src="https://via.placeholder.com/100" al=""/>
                      </div>
                      <div class="info-product">
                        <span>Description</span>
                        <span>Date Livriason</span>
                        <a href="#" class="text-primary pull-right">Detaille</a>
                      </div>
                      <div class="clearfix"></div>
                    </div>
                    <hr />
                    <div class="commande">
                      <div class="img">
                        <img src="https://via.placeholder.com/100" al=""/>
                      </div>
                      <div class="info-product">
                        <span>Description</span>
                        <span>Date Livriason</span>
                        <a href="#" class="text-primary pull-right">Detaille</a>
                      </div>
                      <div class="clearfix"></div>
                    </div>
                  </div>
                </div>

              </div>

            </div>
          </div>
        </div>
      </div>
    <?php
    }else{
      header('Location: index.php');
      exit();
    }
  }elseif($act == 'edit'){
    if(isset($_SESSION['user']) && !empty($_SESSION['user'])){
      $stmtUser = $con->prepare("SELECT * FROM users WHERE Username = :username AND GroupID = 3");
      $stmtUser->bindParam(":username", $_SESSION['user']);
      $stmtUser->execute();
      if($stmtUser->rowCount() == 1){
        $userProf = $stmtUser->fetch();
        ?>
        <h2 class="text-capitalize">Profile: <?php  echo $_SESSION['user'];?></h2>
        <div class="edit-profile">
          <?php include $template . "profileinfoheading.php"; ?>

          <div class="info-body">
            <div class="panel panel-primary">
              <div class="panel-heading">
                <h3>Edit Profile : <?php echo $_SESSION['Fname']; ?></h3>
              </div>
              <div class="panel-body">
                <div class="row">
                  <div class="col-sm-8">
                    <div class="info">

                      <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'] . "?act=update"; ?>" method="POST" enctype="multipart/form-data">

                        <div class="form-group">
                          <label class="col-sm-3 control-label">Username</label>
                          <div class="col-sm-9">
                            <input type="text" name="user" value="<?php echo $userProf['Username']; ?>" class="form-control" placeholder="Username To Login" />
                            <!--title="username length between 5 and 10 caracters !" maxlength="10" pattern="{5,}" required -->
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="col-sm-3 control-label">Fulle Name</label>
                          <div class="col-sm-9">
                            <input class="form-control" type="text" name="Fname" value="<?php echo $userProf['Fullname']; ?>" placeholder="Full Name" />
                            <!--title="name lenght between 7 and 25 caracters" maxlength="25" pattern="{7,}" required -->
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="col-sm-3 control-label">Email</label>
                          <div class="col-sm-9">
                            <input class="form-control" type="email" name="email" value="<?php echo $userProf['Email']; ?> " placeholder="Email To Registration" />
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="col-sm-3 control-label">Password</label>
                          <div class="col-sm-9">
                            <input class="form-control" type="password" name="pass" autocomplete="new-password" placeholder="password" />
                            <!-- title="minimum length 8 caracters !" pattern="{8,}" required  -->
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="col-sm-3 control-label">Confirmation Password</label>
                          <div class="col-sm-9">
                            <input class="form-control" type="password" name="confpass" placeholder="confirmation password" />
                            <!-- title="match on password !" pattern="{8,}" required -->
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="col-sm-3 control-label">Photo De Profile </label>
                          <div class="col-sm-9">
                            <input class="form-control" type="file" name="photoprofile" required />
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="col-sm-offset-3 col-sm-9">
                            <input type="submit" value="save" class="btn btn-sm btn-primary" />
                          </div>
                        </div>

                      </form>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="show">
                      <div class="thumbnail">
                        <div class="heading-show">
                          <img class="img-responsive" style="height: 200px; width: 300px;" src="<?php if(empty($userProf['img_profile'])){
                            echo "uploades/profilesIMG/default.jpg";
                          }else{
                            echo "uploades/profilesIMG/" . $userProf['img_profile'] ;
                          } ?>" alt="" />
                          <div class="layer">
                            <i class="fas fa-camera-retro fa-3x"></i>
                          </div>
                        </div>
                        <div class="caption">
                          <span class="user">user</span>
                          <span class="Fname">fulle name</span>
                          <span class="email">email</span>
                        </div>

                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
      <?php
      }else{
        echo 'errors';
      }
    }else{
      header('Location: login.php');
      exit();
    }
  }elseif($act == 'update'){
    if(isset($_SESSION['user']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
      $userProf = htmlspecialchars(filter_var($_POST['user'], FILTER_SANITIZE_STRING));
      $nameProf = htmlspecialchars(filter_var($_POST['Fname'], FILTER_SANITIZE_STRING));
      $emailProf = htmlspecialchars(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
      $passProf = $_POST['pass'];
      $hashconfpassProf = password_hash($_POST['confpass'], PASSWORD_DEFAULT);
      $imageProfile = $_FILES['photoprofile'];
      $img_profile_name = $_FILES['photoprofile']['name'];
      $img_profile_type = $_FILES['photoprofile']['type'];
      $img_profile_tmp_dir = $_FILES['photoprofile']['tmp_name'];
      $img_profile_size = $_FILES['photoprofile']['size'];
      /*echo $img_profile_name . '<br />' . $img_profile_size . '<br />' . $img_profile_type . '<br />' . $img_profile_tmp_dir . '<br />' ;
      print_r($imageProfile);*/
      $formError = array();

      if(!empty($userProf)){
        if(strlen($userProf) < 5 ){
          $formError[] = '<div class="alert alert-danger">username cont be length more thant 5 caracters !</div>';
        }elseif(strlen($userProf) > 15 ){
            $formError[] = '<div class="alert alert-danger">username cont be length less or equal thant 10 caracters !</div>';
        }elseif(strpos($userProf, " ")){
          $formError[] = '<div class="alert alert-danger">Not space in username !</div>';
        }else{
          $stmtverify = $con->prepare("SELECT * FROM users WHERE UserID != ? AND Username = ? LIMIT 1");
          $stmtverify->execute(array($_SESSION['identify'], $userProf));
          if($stmtverify->rowCount() == 1){
            $formError[] = '<div class="alert alert-danger">Username Exit Plais Chose other One !</div>';
          }
        }
      }else{
        $formError[] = '<div class="alert alert-danger">Username cant be empty !</div>';
      }

      if(!empty($nameProf)){
        if(strlen($nameProf) < 7 ){
          $formError[] = '<div class="alert alert-danger">fulle name cont be length more thant 7 caracters !</div>';
        }elseif(strlen($nameProf) > 20 ){
            $formError[] = '<div class="alert alert-danger">username cont be length less or equal thant 20 caracters !</div>';
        }
      }else{
        $formError[] = '<div class="alert alert-danger">Fulle name cant be empty !</div>';
      }

      if(!empty($emailProf)){
        $domaine = explode('@', $emailProf);
        if(!filter_var($emailProf, FILTER_VALIDATE_EMAIL)){
          $formError[] = '<div class="alert alert-danger">Invalid Email !</div>';
        }elseif(!checkdnsrr(array_pop($domaine), 'MX')){
          $formError[] = '<div class="alert alert-danger">Invalid Email Domaine!</div>';
        }
      }else{
        $formError[] = '<div class="alert alert-danger">Email cant be empty !</div>';
      }

      if(!empty($passProf)){
        if(strlen($passProf) < 8){
          $formError[] = '<div class="alert alert-danger">Password minimum length 8 caracters !</div>';
        }elseif(!password_verify($passProf, $hashconfpassProf)){
          $formError[] = '<div class="alert alert-danger">password confirmation Not mutch to password !</div>';
        }
      }else{
        $formError[] = '<div class="alert alert-danger">Passowrd cant be empty !</div>';
      }

      $img_type = array('jpg', 'jpeg', 'png', 'gif');
      $type = explode('.', $img_profile_name);
      $img_max_size = 16777219;
      $faniant_depart = random_int(0, 1000000000);

      if(!empty($imageProfile)){
        if(!in_array(strtolower(end($type)), $img_type)){
          $formError [] = '<div class="alert alert-danger">image type Not Recommended / type recommended jpg /jpeg /png /gif </div>';
        }
        if($img_profile_size > $img_max_size){
          $formError [] = '<div class="alert alert-danger">image size Not depassed 2MB !</div>';
        }
      }else{
        $formError [] =  '<div class="alert alert-danger">Photo de profile cant be empty !</div>';
      }
    if(empty($formError)){
      $img_profile_name_custom = $faniant_depart."_".$img_profile_name;
      move_uploaded_file($img_profile_tmp_dir, "C:\\xampp\htdocs\\eCommerce\uploades\profilesIMG\\".$img_profile_name_custom);
      $stmtprof = $con->prepare("UPDATE users SET Username = ?, Fullname = ?, Email = ?, Password = ?, img_profile = ? WHERE UserID = ?");
      $stmtprof->execute(array($userProf, $nameProf, $emailProf, $hashconfpassProf, $img_profile_name_custom, $_SESSION['identify']));
      if($stmtprof->rowCount() == 1){
        $_SESSION['user'] = $userProf;
        echo '<div style="margin-top: 30px;" class="alert alert-success">succesfuly update !</div>';
        header('refresh:5; url= profile.php?act=edit');
        exit();
      }else{
        echo '<div class="alert alert-danger">Error Update !</div>';
        header('refresh:5; url= profile.php?act=edit');
        exit();
      }
    }else{
      echo '<div style="margin-top: 30px;">';
        foreach($formError as $error){
          echo $error;
        }
        echo '<div class="alert alert-info">redirect after 5 second !</div>';
      echo '</div>';
      header("refresh:5; url = profile.php?act=edit");
      exit();
    }

    }else{
      header('Location: index.php');
      exit();
    }
  }
  include $template . 'footer.php';
  ob_end_flush();
?>

  </div>
</section>
