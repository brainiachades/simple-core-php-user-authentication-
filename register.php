<?php
define('TITLE', "Register");
require 'env.php';
include 'layouts/header.php';
check_logged_out();
?>

<!-- ======= Breadcrumbs Section ======= -->
<section class="breadcrumbs">
  <div class="container">

    <div class="d-flex justify-content-between align-items-center">
      <h2>Register</h2>
      <ol>
        <li><a href="home">Home</a></li>
        <li>Register</li>
      </ol>
    </div>

  </div>
</section>
<!-- Breadcrumbs Section -->

<!-- ======= Page Details Section ======= -->
<section id="portfolio-details" class="portfolio-details">
  <div class="container" data-aos="fade-up">

    <div class="section-title">
      <h2>Register</h2>
    </div>

    <div class="row gy-5">

      <form action="includes/register.inc.php" method="post" role="form" class="w-100" data-aos="fade-up">
        <?php
        insert_csrf_token();
        include 'layouts/errors.php';
        ?>

        <div class="form-group py-2">
          <label class="font-weight-bolder" for="username">Username</label>
          <input type="text" class="form-control" name="username" id="username" autocapitalize="off" placeholder="Username">
        </div>

        <div class="form-group py-2">
          <label class="font-weight-bolder" for="email">Email</label>
          <input type="email" class="form-control" name="email" id="email" autocapitalize="off" placeholder="Email">
        </div>

        <div class="form-group py-2">
          <label class="font-weight-bolder" for="password">Password</label>
          <input type="password" class="form-control" name="password" placeholder="Password">
        </div>

        <div class="form-group py-2">
          <label class="font-weight-bolder" for="password">Repeat Password</label>
          <input type="password" class="form-control" name="confirmpassword" placeholder="Password">
        </div>

        <div class="py-2">
          <button type="submit" class="btn btn-info" name="register-submit-btn">Register</button>
        </div>

      </form>

    </div>

  </div>
</section>
<!-- End Page Details Section -->

<?php
include 'layouts/footer.php';
?>