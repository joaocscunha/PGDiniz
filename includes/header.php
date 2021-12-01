<header>

  <!-- Navigation -->
  <nav id="navigation_bar" class="navbar navbar-default">
    <div class="container">
      <div class="navbar-header">
      </div>



      <?php
      $email = $_SESSION['login'];
      $sql = "SELECT FullName FROM tblusers WHERE EmailId=:email ";
      $query = $dbh->prepare($sql);
      $query->bindParam(':email', $email, PDO::PARAM_STR);
      $query->execute();
      $results = $query->fetchAll(PDO::FETCH_OBJ);
      ?>


      <div class="header_wrap">
        <div class="user_login" style="border:none">

          <?php if ($_SESSION['login']) { ?>


            <ul>
              <li class="dropdown"> <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user-circle" aria-hidden="true"></i>

                  <?php
                  if ($query->rowCount() > 0) {
                    foreach ($results as $result) {

                      echo htmlentities($result->FullName);
                    }
                  } ?><i class="fa fa-angle-down" aria-hidden="true"></i></a>

                <ul class="dropdown-menu">
                  <li><a href="profile.php">Perfil</a></li>
                  <li><a href="update-password.php">Mudar Password</a></li>
                  <li><a href="my-booking.php">Meus Bookings</a></li>
                  <li><a href="logout.php">Logout</a></li>
                </ul>


              <?php } else { ?>
                <div class="login_btn"> <a href="#loginform" class="btn btn-xs uppercase" data-toggle="modal" data-dismiss="modal">Login / Register</a> </div>
              <?php } ?>

              </li>
            </ul>
        </div>
      </div>





      <div class="collapse navbar-collapse" id="navigation">
        <ul class="nav navbar-nav">
          <li><a href="index.php">Home</a> </li>

          <li><a href="page.php?type=aboutus">About Us</a></li>
          <li><a href="car-listing.php">Car Listing</a>
          <li><a href="contact-us.php">Contact Us</a></li>


        </ul>
      </div>
    </div>
  </nav>
  <!-- Navigation end -->

</header>