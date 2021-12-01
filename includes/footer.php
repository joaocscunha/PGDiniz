<?php
if (isset($_POST['emailsubscibe'])) {
  $subscriberemail = $_POST['subscriberemail'];
  $sql = "SELECT SubscriberEmail FROM tblsubscribers WHERE SubscriberEmail=:subscriberemail";
  $query = $dbh->prepare($sql);
  $query->bindParam(':subscriberemail', $subscriberemail, PDO::PARAM_STR);
  $query->execute();
  $results = $query->fetchAll(PDO::FETCH_OBJ);
  $cnt = 1;
  if ($query->rowCount() > 0) {
    echo "<script>alert('Already Subscribed.');</script>";
  } else {
    $sql = "INSERT INTO  tblsubscribers(SubscriberEmail) VALUES(:subscriberemail)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':subscriberemail', $subscriberemail, PDO::PARAM_STR);
    $query->execute();
    $lastInsertId = $dbh->lastInsertId();
    if ($lastInsertId) {
      echo "<script>alert('Subscribed successfully.');</script>";
    } else {
      echo "<script>alert('Something went wrong. Please try again');</script>";
    }
  }
}
?>

<footer>
  <div class="footer-top" style="margin-bottom:0;">
    <div class="container">
      <div class="row">

        <div class="col-md-3">
          <ul>
            <li><a href="page.php?type=aboutus">Sobre Nós</a></li>
            <li><a href="admin/">Admin</a></li>
          </ul>
        </div>
        <div class="col-md-3">
          <!--Contact-us-->

          <div class="row">
            <div class="col-md-12">
              <h6 class="text-center">Contactos</h6>
                <?php
                $pagetype = $_GET['type'];
                $sql = "SELECT Address,EmailId,ContactNo from tblcontactusinfo";
                $query = $dbh->prepare($sql);
                $query->bindParam(':pagetype', $pagetype, PDO::PARAM_STR);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_OBJ);
                $cnt = 1;
                if ($query->rowCount() > 0) {
                  foreach ($results as $result) { ?>
                    <ul>
                      <li>
                        <div class="icon_wrap"><i class="fa fa-phone" aria-hidden="true"></i></div>
                        <div class="contact_info_m" style="color:white"><?php echo htmlentities($result->EmailId); ?></a></div>
                      </li>
                      <li>
                        <div class="icon_wrap"><i class="fa fa-envelope-o" aria-hidden="true"></i></div>
                        <div class="contact_info_m" style="color:white"><?php echo htmlentities($result->ContactNo); ?></a></div>
                      </li>
                    </ul>
                <?php }
                } ?>
            </div>
          </div>
          <!-- /Contact-us-->
        </div>

        <div class="col-md-3 col-sm-6">
          <h6>Subscrever Newsletter</h6>
          <div class="newsletter-form">
            <form method="post">
              <div class="form-group">
                <input type="email" name="subscriberemail" class="form-control newsletter-input" required placeholder="Email" />
              </div>
              <button type="submit" name="emailsubscibe" class="btn">Subscrever </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

</footer>