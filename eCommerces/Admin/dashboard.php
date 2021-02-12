<?php
  ob_start();
  session_start();
  if(isset($_SESSION['Username'])){
    $pageTitle = 'Dashboard';
    include "init.php";
    ?>
    <div class="dashboard text-center">
      <h1>Dashboard</h1>
      <div class="container ">
        <div class="row">
          <div class="col-md-3">
            <a href="members.php?act=manage">
              <div class="state st-members">
                <h4>Total Members</h4>
                <span><?php echo countItem('UserID', 'users') ?></span>
              </div>
            </a>
          </div>
          <div class="col-md-3">
            <a href="members.php?act=manage&page=pending">
              <div class="state st-pending">
                <h4>Pending Members</h4>
                <span><?php echo countItem('RegStatus', 'users', '0') ?></span>
              </div>
            </a>
          </div>
          <div class="col-md-3">
            <a href="items.php">
              <div class="state st-item">
                <h4>Total Item</h4>
                <span><?php echo countItem('itemID', 'item') ?></span>
              </div>
            </a>
          </div>
          <div class="col-md-3">
            <a href="comments.php">
              <div class="state st-comments">
                <h4>Total Comments</h4>
                <span><?php echo countItem('commentID', 'comments'); ?></span>
              </div>
            </a>
          </div>
        </div>
      </div>
    </div>
    <div class="latest">
      <div class="container">
        <div class="row">

          <div class="col-md-6">
            <div class="panel panel-default">
              <div class="panel-heading">
                <i class="fas fa-user"></i>
                <span class="text-primary">Latest User</span>
                <i class="fas fa-plus pull-right lt-info"></i>
              </div>
              <div class="panel-body">
                <?php
                  $rows = getLatest('*', 'users', 'UserID');
                  echo '<ul class="list-unstyled latest-user">';
                    foreach($rows as $user){
                      echo '<li>';
                        echo '<p>' . $user['Username'] . '</p>';
                        echo '<p>' . $user['RegDate'] . '</p>';
                        echo '<a href="members.php?act=edit&userid='. $user['UserID'] .'" class="pull-right"><span class="btn btn-success"><i class="fas fa-edit"></i>Edit</span></a>';
                        if($user['RegStatus'] == 0){
                          echo "<a class='btn btn-info pull-right' style='margin-left:5px' href='members.php?act=activate&userid=" . $user['UserID'] . "'>Activate</a>";
                        }
                      echo '</li>';
                      //echo '<hr />';
                    }
                  echo '</ul>';
                ?>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="panel panel-default">
              <div class="panel-heading">
                <i class="fas fa-tag"></i>
                <span class="text-primary">Latest Item</span>
                <i class="fas fa-plus pull-right lt-info"></i>
              </div>
              <div class="panel-body">
                <?php
                  $items = getLatest('*', 'item', 'itemID');
                  echo '<ul class="list-unstyled latest-user">';
                  foreach($items as $item){
                    echo '<li>';
                      echo '<span>'. $item['Name'].'</span>';
                      echo '<a class="btn btn-sm btn-success pull-right" href="items.php?act=edit&itemid='. $item['itemID'] .'"><i class="fas fa-edit"></i> Edit</a>';
                      if($item['Approve'] == 0){
                        echo '<a class="btn btn-sm btn-info pull-right" href="items.php?act=approve&itemid='. $item['itemID'] .'"><i class="fas fa-check"> </i>Approve</a>';
                      }
                    echo '</li>';
                  }
                  echo '</ul>';
                ?>
              </div>
            </div>
          </div>

        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="panel panel-default">
              <div class="panel-heading">
                <i class="fas fa-comments"></i>
                <span class="text-primary">Latest Comments</span>
                <span class="fas fa-plus pull-right lt-info"></span>
              </div>
              <div class="panel-body">
                <ul class="list-unstyled">
                  <?php
                    $stmt = $con->prepare("SELECT comments.*, users.Username FROM comments INNER JOIN users ON users.UserID = comments.userID");
                    $stmt->execute();
                    $comments = $stmt->fetchAll();

                    foreach($comments as $comment){
                      echo '<li>';
                        echo '<div class="commenting">';
                          echo '<div class="name text-primary"><span class="text-capitalize">'.$comment['Username'].'</span></div>';
                          echo '<div class="comment"><p>'.$comment['comment'].'</p></div>';
                        echo '</div>';
                      echo '</li>';
                    }
                   ?>
                </ul>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>

<?php
    include $template . "footer.php";
  }else{
    header('Location: index.php');
    exit();
  }
  ob_end_flush();
?>
