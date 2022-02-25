<?php
define('TITLE', "Reset Password");
require 'env.php';
include 'layouts/header.php';
check_logged_out();
?>

<!-- ======= Breadcrumbs Section ======= -->
<section class="breadcrumbs">
  <div class="container">

    <div class="d-flex justify-content-between align-items-center">
      <h2>Reset Password</h2>
      <ol>
        <li><a href="home">Home</a></li>
        <li>Reset Password</li>
      </ol>
    </div>

  </div>
</section>
<!-- Breadcrumbs Section -->

<!-- ======= Page Details Section ======= -->
<section id="portfolio-details" class="portfolio-details">
  <div class="container" data-aos="fade-up">

    <div class="section-title">
      <h2>Reset Password</h2>
    </div>

    <div class="row gy-5">

      <?php if (isset($_GET['selector']) && isset($_GET['validator'])) { ?>
        <form action="includes/reset.inc.php" method="post" role="form" class="w-100" data-aos="fade-up">
          <?php
          insert_csrf_token();

          $selector = $_GET['selector'];
          $validator = $_GET['validator'];
          include 'layouts/errors.php';
          ?>

          <input type="hidden" name="selector" value="<?php echo $selector; ?>">
          <input type="hidden" name="validator" value="<?php echo $validator; ?>">

          <div class="form-group py-2">
            <label class="font-weight-bolder" for="password">New Password</label>
            <input type="password" class="form-control" name="password" placeholder="Password">
          </div>

          <div class="form-group py-2">
            <label class="font-weight-bolder" for="password">Repeat Password</label>
            <input type="password" class="form-control" name="confirmpassword" placeholder="Password">
          </div>


          <div class="py-2">
            <button type="submit" class="btn btn-info" name="reset-submit-btn">Reset Password</button>
          </div>

        </form>
      <?php } else { ?>

        <form action="includes/sendtoken.inc.php" method="post" role="form" class="w-100" data-aos="fade-up">
          <?php
          insert_csrf_token();
          include 'layouts/errors.php';
          ?>

          <div class="form-group py-2">
            <label class="font-weight-bolder" for="email">Email</label>
            <input type="email" class="form-control" name="email" id="email" autocapitalize="off" placeholder="Email">
          </div>

          <div class="py-2">
            <button type="submit" class="btn btn-info" name="resetsend-submit-btn">Send Password Reset Link</button>
          </div>
          <p><a href="login">Go Back.</a></p>

        </form>

      <?php } ?>
    </div>

  </div>
</section>
<!-- End Page Details Section -->

<?php
include 'layouts/footer.php';
?>