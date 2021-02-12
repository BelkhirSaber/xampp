<?php
  ob_start();
  session_start();
  $pageTitle = 'Item';
  include 'init.php';
  include $template . 'navbar.php';?>
  <section class="items-page">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-9">
          <?php
            $itemid = isset($_GET['itemid']) && !empty($_GET['itemid']) ? htmlspecialchars(intval($_GET['itemid'])) : 0 ;
          if($itemid !== 0 && checkItem('item', 'itemID', $itemid)){
            $item = checkItem('item', 'itemID', $itemid, 1);?>
            <div class="info">
              <div class="image">
                <img src="https://via.placeholder.com/300" />
              </div>
              <div class="property">
                <h3><?php echo $item['Name']; ?></h3>
                <p class="lead"><?php echo $item['Description']; ?></p>
                <div>
                  <label>country Made: </label><span><?php echo $item['Country_Made']; ?></span>
                </div>
                <div>
                  <label>Marque: </label><span>Marque</span>
                </div>
                <div>
                  <label>Vondeur: </label><span>Nom Vondeur</span>
                </div>
                <div>
                  <label>Price: </label><span><?php echo $item['Price'] ?></span>
                </div>
                <form action="panier.php" method="post">
                  <input type="text" class="hidden" vlaue="" />
                  <input type="submit" value="Acheter" class="btn btn-default btn-block"/>
                </form>
              </div>
              <div class="clearfix"></div>
            </div>
            <div class="details">
                <h3>Details</h3>
                <h4>Qu'est-ce que le Lorem Ipsum?</h4>
                <p class="lead">
                  Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l'imprimerie depuis les années 1500, quand un imprimeur anonyme assembla ensemble des morceaux de texte pour réaliser un livre spécimen de polices de texte. Il n'a pas fait que survivre cinq siècles, mais s'est aussi adapté à la bureautique informatique, sans que son contenu n'en soit modifié. Il a été popularisé dans les années 1960 grâce à la vente de feuilles Letraset contenant des passages du Lorem Ipsum, et, plus récemment, par son inclusion dans des applications de mise en page de texte, comme Aldus PageMaker.
                </p>
                <h4>Pourquoi l'utiliser?</h4>
                <p class="lead">
                  On sait depuis longtemps que travailler avec du texte lisible et contenant du sens est source de distractions, et empêche de se concentrer sur la mise en page elle-même. L'avantage du Lorem Ipsum sur un texte générique comme 'Du texte. Du texte. Du texte.' est qu'il possède une distribution de lettres plus ou moins normale, et en tout cas comparable avec celle du français standard. De nombreuses suites logicielles de mise en page ou éditeurs de sites Web ont fait du Lorem Ipsum leur faux texte par défaut, et une recherche pour 'Lorem Ipsum' vous conduira vers de nombreux sites qui n'en sont encore qu'à leur phase de construction. Plusieurs versions sont apparues avec le temps, parfois par accident, souvent intentionnellement (histoire d'y rajouter de petits clins d'oeil, voire des phrases embarassantes).
                </p>
            </div>
            <div class="avis">
              <h3>Avis Des Utlisateur</h3>
              <hr />
              <?php
                $stmt = $con->prepare("SELECT comments.*, users.Fullname FROM comments INNER JOIN users on comments.userID = users.UserID WHERE comments.itemID = :itemid AND comments.Status = 1");
                $stmt->bindParam(':itemid', $item['itemID']);
                $stmt->execute();
                if($stmt->rowCount() > 0){
                  $comments = $stmt->fetchAll();
                  foreach($comments as $comment){?>
                    <div class="avis-user">
                      <div class="user">
                        <img src="https://via.placeholder.com/64" alt=""/>
                        <span><?php echo $comment['Fullname'] ?></span>
                      </div>
                      <div class="user-comment">
                        <p class="lead"><?php echo $comment['comment'] ?></p>
                      </div>
                      <div class="clearfix"></div>
                    </div>

                <?php
                  }
                }else{
                    echo  '<div class="no-comment"><i class="fas fa-exclamation-triangle fa-2x"></i> No Comment For This Product !</div>';
                }
                 ?>
            </div>
            <div class="add-comment" id="add-comt">
              <h3>Add Comment</h3>
              <form action="<?php echo $_SERVER['PHP_SELF'] . '?itemid=' . $itemid . "&#add-comt"; ?>" method="POST">
                <div class="col-sm-9">
                  <textarea name="comment" rows="5" class="form-control" placeholder="Add Comment" required ></textarea>
                </div>
                <div class="col-sm-3">
                  <?php

                  if(isset($_SESSION['user']) && !empty($_SESSION['user'])){
                    echo '<input style="margin-bottom: 20px;" type="submit" class="btn btn-sm btn-default btn-block" value="ADD"/>';
                  }else{
                    echo '<span class="btn-addComment btn btn-sm btn-default btn-block">ADD</span>';
                  }
                  if($_SERVER['REQUEST_METHOD'] == 'POST'){
                    if(empty($_POST['comment'])){
                      echo '<div class="alert alert-danger">Empty Comment !</div>';
                      $url = 'item.php?itemid=' . $itemid . "&#add-comt";
                      header("refresh:2; url=$url");
                    }else{
                      $comt = filter_var($_POST['comment'], FILTER_SANITIZE_STRING);
                      $stmt = $con->prepare("INSERT INTO comments(comment, AddDate, status, userID, itemID) VALUES(:comment, now(), 0, :userid, :itemid)");
                      $stmt->execute(array(
                        ":comment" => $comt,
                        ":userid" => $_SESSION['identify'],
                        ":itemid" => $itemid));
                      if($stmt->rowCount() == 1){
                          echo '<div class="alert alert-success">Comment Inserted!</div>';
                          $url = "item.php?itemid=" . $itemid . "&#add-comt";
                          header("refresh:2;url=$url" );
                          exit();
                      }else{
                        echo '<div class="alert alert-danger">Errors!</div>';
                      }
                    }
                  }
                   ?>
                </div>
              </form>
            </div>
    <?php
          }else{
            header('location: index.php');
            exit();
          }
          ?>
        </div>
        <div class="col-sm-3">
          <div class="politique-service">
            <h3>Livrison &amp; Routeur</h3>
            <hr />
            <div class="service">
              <i class="fas fa-truck fa-fw fa-2x"></i>
              <div class="livraison">
                <h3>Livraison</h3>
                <p>Pourrait être livré entre mercredi 12 févr. et jeudi 13 févr. . Plus d'informations lors de la finalisation de votre commande.</p>
              </div>
            </div>

            <div class="service">
              <i class="fas fa-undo fa-fw fa-2x"></i>
              <div class="routeur">
                <h3>Routeur</h3>
                <p>Retours gratuit sous condition, 15 jours sur les produits Jumia Mall et 10 jours sur les autres produits.</p>
              </div>
            </div>
          </div>

          <div class="vondeur">
            <h3>Information Sur Vondeur</h3>
            <span class="lead">Nom Vondeur</span>
            <span>Evluation De Vondeur 75%</span>
          </div>

          <div class="inscrit-vondeur">
            <h3>Devenir Vondeur</h3>
            <span>Inscrit Pour Devenir Future Vondeur !</span>
          </div>


        </div>
      </div>
      <div class="confirmDialog">
        <span><a href="login.php">Login</a> Or <a href="signup.php">Sign UP</a> For Added Comments</span>
      </div>
    </div>
  </section>
<?php
  include $template . 'footer.php';
  ob_end_flush();
?>
