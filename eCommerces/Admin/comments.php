<?php
ob_start();
session_start();
$pageTitle = 'Comments';
include 'init.php';
if(isset($_SESSION['Username']) && !empty($_SESSION['Username'])){
  $act = isset($_GET['act']) && !empty($_GET['act']) ? $_GET['act'] : 'manage';
  if($act == 'manage'){
    $stmt = $con->prepare("SELECT comments.*, users.Username, item.Name FROM comments INNER JOIN users ON users.UserID = comments.userID INNER JOIN item ON item.itemID = comments.itemID");
    $stmt->execute();
    $rows = $stmt->fetchAll();
    if($stmt->rowCount() != 0){?>
      <div class="container">
        <h1 class="text-center">Manage Comments</h1>
        <div class="table-responsive">
          <table class="main-table table table-bordered">
            <tr>
              <th>#ID</th>
              <th>Comment</th>
              <th>Date</th>
              <th>Username</th>
              <th>Item</th>
              <th>Control</th>
            </tr>
            <?php
              foreach($rows as $row){
                echo '<tr>';
                  echo '<th>'. $row['commentID'] .'</th>';
                  echo '<th style="width:450px">'.$row['comment'].'</th>';
                  echo '<th>'.$row['AddDate'].'</th>';
                  echo '<th>'.$row['Username'].'</th>';
                  echo '<th>'.$row['Name'].'</th>';
                  echo '<th>';
                    echo '<a style="margin-right:5px" class="btn btn-sm btn-success" href="?act=edit&commentid='.$row['commentID'].'"><i class="fas fa-edit"></i> Edit</a>';
                    echo '<a style="margin-right:5px" class="btn btn-sm btn-danger confirm" href="?act=delete&commentid='.$row['commentID'].'"><i class="fas fa-window-close"> Delete</i></a>';
                    if($row['status'] == 0){
                      echo '<a class="btn btn-sm btn-info" href="?act=approve&commentid='.$row['commentID'].'"><i class="fas fa-check"></i> Approve</a>';
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
  }elseif($act == 'edit'){
    $commentID = isset($_GET['commentid']) && is_numeric($_GET['commentid']) ? intval($_GET['commentid']) : 0;
    if(checkItem('commentID', 'comments', $commentID)){
      $stmt = $con->prepare("SELECT comments.*, users.Username, item.Name FROM comments INNER JOIN users ON users.UserID = comments.userID INNER JOIN item ON item.itemID = comments.itemID WHERE commentID = ?");
      $stmt->execute(array($commentID));
      $row = $stmt->fetch();
      ?>
      <div class="container">
        <h1 class="text-center">Edit Comment</h1>
        <form class="form-horizontal" action="?act=update" method="POST">
          <input name="commentid" value="<?php echo $commentID; ?>" class="hidden" />
          <div class="form-group">
            <label class="col-sm-2 control-label">Comment</label>
            <div class="col-sm-8">
              <textarea rows="4" name="comment" class="form-control" palceholder="Your Comment" required="required" ><?php echo $row['comment']; ?></textarea>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label">Username</label>
            <dciv class="col-sm-8">
              <select class="form-control" name="userID">
                <?php
                  $statement = $con->prepare("SELECT UserID, Username FROM users ");
                  $statement->execute();
                  $users = $statement->fetchAll();
                  foreach($users as $user){
                    echo '<option value="'.$user['UserID'].'"';
                    if($user['UserID'] == $row['userID']){echo 'selected';}
                    echo '>'.$user['Username'].'</option>';
                  } ?>
              </select>
            </dciv>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label">Item</label>
            <div class="col-sm-8">
              <select name="itemID" class="form-control">
                <?php
                  $statement = $con->prepare("SELECT itemID, Name FROM item");
                  $statement->execute();
                  $items = $statement->fetchAll();
                  foreach($items as $item){
                    echo '<option value="'.$item['itemID'].'"';
                    if($item['itemID'] == $row['itemID']){ echo 'selected'; }
                    echo '>'.$item['Name'].'</option>';
                  }
                 ?>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label">Status</label>
            <div class="col-sm-8">
              <select class="form-control" name="status">
                <option value="0" <?php if($row['status'] == 0){ echo "selected"; } ?>>0</option>
                <option value="1" <?php if($row['status'] == 1){echo 'selected'; } ?>>1</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-8">
              <input type="submit" class="btn btn-sm btn-primary " value="Save" />
            </div>
          </div>

        </form>
      </div>

    <?php
    }else{
      $msg = '<div class="alert alert-danger">Errors Information !</div>';
      redirect($msg);
    }
  }elseif($act == 'update'){
    if($_SERVER['REQUEST_METHOD'] == 'POST' ){
      $commentID = $_POST['commentid'];
      $comment = $_POST['comment'];
      $userID = $_POST['userID'];
      $itemID = $_POST['itemID'];
      $status = $_POST['status'];
      $formError = "";
      if(empty($comment)){
        $formError = '<div class="alert alert-danger">Comment Cont Be Empty !</div>';
        redirect($formError, 'back');
      }else{
        if(checkItem('commentID', 'comments', $commentID)){
          $stmt = $con->prepare("UPDATE comments SET comment = :comment, userID = :userid, itemID = :itemid, status = :status WHERE commentID = :commentid");
          $stmt->execute(array(
            "comment"=>$comment,
            "userid"=>$userID,
            "itemid"=>$itemID,
            "status"=>$status,
            "commentid" =>$commentID
          ));
          $msg = '<div class="alert alert-success">'. $stmt->rowCount() .' Recored Updated !</div>';
          redirect($msg, 'back');
        }
      }
    }else{
      $msg = '<div class="alert alert-danger">Not Authorized To Access In This Page !</div>';
      redirect($msg);
    }
  }elseif($act == 'delete'){
    $commentID = isset($_GET['commentid']) && !empty($_GET['commentid']) ? intval($_GET['commentid']) : 0;
    if(checkItem('commentID', 'comments', $commentID)){
      $statement = $con->prepare("DELETE FROM comments WHERE commentID = ? LIMIT 1");
      $statement->execute(array($commentID));
      $msg = '<div class="alert alert-success">'.$statement->rowCount().' Recored Deleted</div>';
      redirect($msg, 'back');
    }else{
      $msg = '<div class="alert alert-danger">No Sutch Information !</div>';
      redirect($msg);
    }
  }elseif($act == 'approve'){
    $commentID = isset($_GET['commentid']) && !empty($_GET['commentid']) ? intval($_GET['commentid']) : 0 ;
    if(checkItem('commentID', 'comments', $commentID)){
      $stmt = $con->prepare("UPDATE comments SET status = 1 WHERE commentID = ? LIMIT 1");
      $stmt->execute(array($commentID));
      $msg = '<div class="alert alert-success">'. $stmt->rowCount().' Recored Approved</div>';
      redirect($msg, 'back');
    }
  }
}else{
  header('Location:index.php');
  exit();
}
include $template . 'footer.php';
ob_end_flush();
?>
