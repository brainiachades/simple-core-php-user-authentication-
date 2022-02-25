<?php
define('TITLE', "Log In");
require 'env.php';
include 'layouts/header.php';
check_logged_out();
?>

<!-- ======= Breadcrumbs Section ======= -->
<section class="breadcrumbs">
  <div class="container">

    <div class="d-flex justify-content-between align-items-center">
      <h2>Login</h2>
      <ol>
        <li><a href="home">Home</a></li>
        <li>Login</li>
      </ol>
    </div>

  </div>
</section>
<!-- Breadcrumbs Section -->

<!-- ======= Page Details Section ======= -->
<section id="portfolio-details" class="portfolio-details">
  <div class="container" data-aos="fade-up">

    <div class="section-title">
      <h2>Login</h2>
    </div>

    <div class="row gy-5">

      <form action="includes/login.inc.php" method="post" role="form" class="w-100" data-aos="fade-up">
        <?php
        insert_csrf_token();
        include 'layouts/errors.php';
        ?>

        <div class="form-group py-2">
          <label class="font-weight-bolder" for="username">Username or Email Address</label>
          <input type="text" class="form-control" name="username" id="username" autocapitalize="off" placeholder="Username or Email Address">
        </div>

        <div class="form-group py-2">
          <label class="font-weight-bolder" for="password">Password</label>
          <input type="password" class="form-control" name="password" placeholder="Password">
        </div>

        <div class="form-check py-2">
          <label class="form-check-label font-weight-bolder" for="rememberme">
            <input type="checkbox" class="form-check-input" id="rememberme" name="rememberme" value="">
            Remember Me
          </label>
        </div>

        <div class="py-2">
          <button type="submit" class="btn btn-info" name="login-submit-btn">Log In</button>
        </div>
        <p><a href="forget-password">Forget Password?</a></p>

      </form>

    </div>

  </div>
</section>
<!-- End Page Details Section -->

<?php
include 'layouts/footer.php';
?>