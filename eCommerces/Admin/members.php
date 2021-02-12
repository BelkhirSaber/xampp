<?php
  /*
  ===========================================================
  === Manage Members
  === Pages For Manage Member Add | Edit | Delete | Activate
  ===========================================================
  */
  ob_start();
  session_start();
  if(isset($_SESSION['Username'])){
    $pageTitle = 'Members';
    include 'init.php';

    $act = isset($_GET['act']) && !empty($_GET['act']) ? $_GET['act'] : 'manage';
    if($act == 'manage'){
      $query = '';
      if(isset($_GET['page']) && $_GET['page'] == 'pending'){
        $query = 'AND RegStatus = 0';
      }

      $stmt = $con->prepare("SELECT UserID, Username, Email, Fullname, RegStatus, RegDate FROM users WHERE GroupID != 1 $query");
      $stmt->execute();
      $rows = $stmt->fetchAll();
      if($stmt->rowCount() != 0){
      ?>
        <h1 class="text-center">Add New Member</h1>
        <div class="container">
          <div class="table-responsive">
            <table class="main-table table table-bordered table-responsive text-center">
              <tr>
                <td>#ID</td>
                <td>Username</td>
                <td>Email</td>
                <td>Full Name</td>
                <td>Date Registration</td>
                <td>Control</td>
              </tr>
              <?php
                foreach ($rows as $row) {
                  echo "<tr>";
                    echo "<td>" . $row['UserID'] . "</td>";
                    echo "<td>" . $row['Username'] . "</td>";
                    echo "<td>" . $row['Email'] . "</td>";
                    echo "<td>" . $row['Fullname'] . "</td>";
                    echo "<td>" . $row['RegDate'] . "</td>";
                    echo "<td>
                            <a class='btn btn-success' href='?act=edit&userid=" . $row['UserID'] . "'>Edit <i class='fas fa-edit'></i></a>
                            <a class='btn btn-danger confirm' style='margin-left:5px' href='?act=delete&userid=" . $row['UserID'] . "'>Delete <i class='far fa-window-close'></i></a>";
                            if($row['RegStatus'] == 0){
                              echo "<a class='btn btn-info' style='margin-left:5px' href='?act=activate&userid=" . $row['UserID'] . "'>Activate</a>";
                            }
                    echo "</td>";
                  echo "</tr>";
                }
               ?>
            </table>

          </div>
          <a class="btn btn-primary <?php if(isset($_GET['page']) && $_GET['page'] == 'pending'){
            echo 'hidden';} ?>" style="margin:20px 0" href="?act=add">New Member <i class="fas fa-plus" style="margin-left:10px"></i></a>

        </div>

<?php
      }else{
        ?>
          <div class="container">
            <div class="message text-center">
              <p>No Member In This Section !</p>
            </div>
            <a class="btn btn-primary <?php if(isset($_GET['page']) && $_GET['page'] == 'pending'){
              echo 'hidden';} ?>" style="margin:20px 0" href="?act=add">New Member <i class="fas fa-plus" style="margin-left:10px"></i></a>
          </div>
        <?php
      }
    }elseif($act == 'add'){?>
      <div class="container">
        <h1 class="text-center">Add New Member</h1>
        <form class="form-horizontal" action="?act=insert" method="POST">

          <div class="form-group">
            <label class="col-sm-2 control-label">Username</label>
            <div class=" col-sm-9">
              <input type="text" name="username" class="form-control" autocomplete="off" placeholder="Username To Login" required="required" />
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label">Password</label>
            <div class=" col-sm-9">
              <input type="password" name="password" class="password form-control" autocomplete="new-password" placeholder="Password To Login" required="required" />
              <i class="fas fa-eye-slash show-pass"></i>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label">Email</label>
            <div class=" col-sm-9">
              <input type="email" name="email" class="form-control" autocomplete="off" placeholder="exemple@mail.com" required="required" />
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label">FullName</label>
            <div class=" col-sm-9">
                <input type="text" name="fullname" class="form-control" autocomplete="off" placeholder="Your Name In Home Page" required="required" />
            </div>
          </div>

          <div class="form-group">
            <div class=" col-sm-offset-2 col-sm-9">
                <button type="submit" class="btn btn-primary"><i class='fa fa-plus'></i> Add New Member</button>
            </div>
          </div>
        </form>
      </div>
<?php
    }elseif($act == 'insert'){

      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        echo "<h1 class='text-center'>Add New Member</h1>";
        echo "<div class='container'>";
        $username = $_POST['username'];
        $pass = $_POST['password'];
        $email = $_POST['email'];
        $fullName = $_POST['fullname'];
        $hashPassword = sha1($pass);

        $formErrors = array();
        if(strlen($username) < 5){
          $formErrors[] = "Username Can't Be <strong>Less Thant < 5 Characters</strong>";
        }

        if(strlen($username) > 20){
          $formErrors[] = "Username Can't Thant Be <strong>more Thant > 20 Characters</strong>";
        }

        if(empty($username)){
          $formErrors[] = "Username Can't Thant Be <strong>Empty</strong>";
        }

        if(empty($pass)){
          $formErrors[] = "Password Can't Thant Be <strong>Empty</strong>";
        }

        if(empty($email)){
          $formErrors[] = "Email Can't Thant Be <strong>Empty</strong>";
        }

        if(empty($fullName)){
          $formErrors[] = "Full Name Can't Thant Be <strong>Empty</strong>";
        }

        if(empty($formErrors)){

          if(!checkItem('Username', 'users', $username)){
            $stmt = $con->prepare("INSERT INTO users(Username, Password, Email, Fullname, RegDate) VALUES (:username, :password, :email, :fullname, now())");
            $stmt->execute(array('username' => $username, 'password' => $hashPassword, 'email' => $email, 'fullname' => $fullName));
            $Msg = "<div class='alert alert-success'>". $stmt->rowCount() . " Record Inserted succesfuly !</div>";
            redirect($Msg, 'back');
          }else{
            $Msg = "<div class='alert alert-danger'>This Record Exit You Cant Not Registred By This Username !</div>";
            redirect($Msg, 'back');
          }
        }else{
          foreach($formErrors as $error){
            echo "<div class='alert alert-danger'>" . $error . "</div>";
          }
          redirect(null, 'back', 6);
        }
        echo "</div>";
      }else{
        echo '<div class="container">';
        $Msg = '<div class="alert alert-danger">You Can\'t Not Authorized To access On This Page !</div>';
        redirect($Msg);
        echo '</div>';
      }
    }elseif($act == 'edit'){
      $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
      $stmt1 = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");
      $stmt1->execute(array($userid));
      $row = $stmt1->fetch();

      $stmt = $con->prepare("SELECT comments.*, item.Name FROM comments INNER JOIN item ON item.itemID = comments.itemID WHERE comments.userID = ?");
      $stmt->execute(array($userid));
      $rows = $stmt->fetchAll();


      if($stmt1->rowCount() > 0){?>
        <div class="container">
          <h1 class="text-center">Edit Member</h1>
          <form class="form-horizontal" action="?act=update" method="POST">

            <input class="hidden" type="number" name="id" value="<?php echo $row['UserID']; ?>" />
            <div class="form-group">
              <label class="col-sm-2 control-label">Username</label>
              <div class=" col-sm-9">
                <input type="text" name="username" value="<?php echo $row['Username'] ?>" class="form-control" autocomplete="off" required="required" />
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label">Password</label>
              <div class=" col-sm-9">
                <input type="password" name="oldPassword" class="hidden" value="<?php echo $row['Password']?>"/>
                <input type="password" name="newPassword" class="password form-control" autocomplete="new-password" placeholder="Leave Blank With Not Change Password"/>
                <i class="fas fa-eye-slash show-pass"></i>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label">Email</label>
              <div class=" col-sm-9">
                <input type="email" name="email" value="<?php echo $row['Email'] ?>" class="form-control" autocomplete="off" required="required" />
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label">FullName</label>
              <div class=" col-sm-9">
                  <input type="text" name="fullname" value="<?php echo $row['Fullname'] ?>" class="form-control" autocomplete="off" required="required" />
              </div>
            </div>

            <div class="form-group">
              <div class=" col-sm-offset-2 col-sm-9">
                  <input type="submit" value="Save" class="btn btn-primary" />
              </div>
            </div>
          </form>
        <?php
          if($stmt->rowCount() != 0){?>
            <h1 class="text-center">Comments [ <?php echo $row['Username']; ?> ]</h1>
            <div class="table-responsive">
              <table class="main-table table table-bordered">
                <tr>
                  <th>#ID</th>
                  <th>Comment</th>
                  <th>Date</th>
                  <th>Item</th>
                  <th>Control</th>
                </tr>
                <?php
                  foreach($rows as $row){
                    echo '<tr>';
                      echo '<th>'. $row['commentID'] .'</th>';
                      echo '<th style="width:450px">'.$row['comment'].'</th>';
                      echo '<th>'.$row['AddDate'].'</th>';
                      echo '<th>'.$row['Name'].'</th>';
                      echo '<th>';
                        echo '<a style="margin-right:5px" class="btn btn-sm btn-success" href="comments.php?act=edit&commentid='.$row['commentID'].'"><i class="fas fa-edit"></i> Edit</a>';
                        echo '<a style="margin-right:5px" class="btn btn-sm btn-danger confirm" href="comments.php?act=delete&commentid='.$row['commentID'].'"><i class="fas fa-window-close"> Delete</i></a>';
                        if($row['status'] == 0){
                          echo '<a class="btn btn-sm btn-info" href="comments.php?act=approve&commentid='.$row['commentID'].'"><i class="fas fa-check"></i> Approve</a>';
                        }
                      echo '</th>';
                    echo '</tr>';
                  }
                ?>
              </table>
            </div>
        </div>
          <?php
          }else{?>
            <div class="container text-center">
              <div class="message">
                <p>No Comments About Your Items !</p>
              </div>
            </div>
          <?php
          }
      }else{
        echo '<div class="container">';
        $Msg = '<div class="alert alert-danger">Invalid User !</div>';
        redirect($Msg);
        echo '</div>';
      }
    }elseif($act == 'update'){

      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        echo "<h1 class='text-center'>Update Member</h1>";
        echo "<div class='container'>";
        $id = $_POST['id'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $fullName = $_POST['fullname'];

        if(empty($_POST['newPassword'])){
          $pass = $_POST['oldPassword'];
        }else{
          $pass = sha1($_POST['newPassword']);
        }

        $formErrors = array();
        if(strlen($username) < 5){
          $formErrors[] = "Username Can't Be <strong>Less Thant < 5 Characters</strong>";
        }

        if(strlen($username) > 20){
          $formErrors[] = "Username Can't Thant Be <strong>more Thant > 20 Characters</strong>";
        }

        if(empty($username)){
          $formErrors[] = "Username Can't Thant Be <strong>Empty</strong>";
        }

        if(empty($email)){
          $formErrors[] = "Email Can't Thant Be <strong>Empty</strong>";
        }

        if(empty($fullName)){
          $formErrors[] = "Full Name Can't Thant Be <strong>Empty</strong>";
        }

        if(empty($formErrors)){
          $check  = $con->prepare("SELECT Username FROM users WHERE UserID != ? AND Username = ?");
          $check->execute(array($id, $username));
          if($check->rowCount() == 0){
            $stmt = $con->prepare("UPDATE users SET Username = ?, Password = ?, Email = ?, Fullname = ? WHERE UserID = ?");
            $stmt->execute(array($username, $pass, $email, $fullName, $id));
            $msg = "<div class='alert alert-success'>". $stmt->rowCount() . " Record Updated succesfuly !</div>";
            redirect($msg, 'back');
          }else{
            $msg = '<div class="alert alert-danger">Username Exist Plais Change Your Username !</div>';
            redirect($msg, 'back');
          }

        }else{
          foreach($formErrors as $error){
            echo "<div class='alert alert-danger'>" . $error . "</div>";
          }
          redirect(null, 'back');
        }
        echo "</div>";
      }else{
        echo '<div class="container">';
        $Msg = '<div class="alert alert-danger">You Can\'t Not Authorized To access On This Page !</div>';
        redirect($Msg);
        echo '</div>';
      }

    }elseif($act == 'delete'){

      echo "<h1 class='text-center'>Delete Member</h1>";
      echo "<div class='container'>";
      $userid = (isset($_GET['userid'])) && (is_numeric($_GET['userid'])) ? intval($_GET['userid']) : 0;
      if(checkItem('UserID', 'users', $userid)){
        $stmt = $con->prepare("DELETE FROM users WHERE UserID = :userid");
        $stmt->bindParam(":userid", $userid);
        $stmt->execute();
        $Msg = "<div class='alert alert-success'>" . $stmt->rowCount() . " Record Deleted</div>";
        redirect($Msg,'back');
      }else{
        $Msg = "<div class='alert alert-danger'>No User For This ID</div>";
        redirect($Msg,'back');
      }
      echo '</div>';
    }elseif($act == 'activate'){
      echo "<h1 class='text-center'>Delete Member</h1>";
      echo "<div class='container'>";
      $userid = (isset($_GET['userid'])) && (is_numeric($_GET['userid'])) ? intval($_GET['userid']) : 0;
      if(checkItem('UserID', 'users', $userid)){
        $stmt = $con->prepare("UPDATE users SET RegStatus = 1 WHERE UserID = ?");
        $stmt->execute(array($userid));
        $Msg = "<div class='alert alert-success'>" . $stmt->rowCount() . " Record Updated</div>";
        redirect($Msg,'back');
      }else{
        $Msg = "<div class='alert alert-danger'>No User For This ID</div>";
        redirect($Msg,'back');
      }
      echo '</div>';
    }
    include $template . 'footer.php';
  }else{
    header('Location: index.php');
    exit();
  }
  ob_end_flush();
?>
