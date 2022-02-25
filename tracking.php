<?php
define('TITLE', "Track");
require 'env.php';
include 'layouts/header.php';
?>

<!-- ======= Breadcrumbs Section ======= -->
<section class="breadcrumbs">
  <div class="container">

    <div class="d-flex justify-content-between align-items-center">
      <h2>Track</h2>
      <ol>
        <li><a href="home">Home</a></li>
        <li>Track</li>
      </ol>
    </div>

  </div>
</section>
<!-- Breadcrumbs Section -->

<!-- ======= Page Details Section ======= -->
<section id="portfolio-details" class="portfolio-details">
  <div class="container" data-aos="fade-up">

    <div class="section-title">
      <h2>Track</h2>
    </div>

    <div class="row gy-5">

      <form method="post" action="includes/track.inc.php" role="form" class="w-100" data-aos="fade-up">
        <input type="hidden" id="track_shipment_nonce" name="track_shipment_nonce" value="9ebc295d30">
        <input type="hidden" name="_wp_http_referer" value="/tracking/">

        <h4 class="p-5 text-center">Enter the Consignment No.</h4>
        
        <div class="row">
          <div class="col-md-8 form-group">
            <input type="text" class="form-control" name="wpcargo_tracking_number" value="" autocomplete="off" placeholder="Enter Tracking Number" required>
          </div>

          <div class="col-md-4 form-group mt-3 mt-md-0">
            <button class="btn btn-info" type="submit" name="track-submit-btn">TRACK RESULT</button>
          </div>
        </div>

        <h4 class="p-3 text-center">Ex: 12345</h4>

      </form>





    </div>

  </div>
</section>
<!-- End Page Details Section -->

<?php
include 'layouts/footer.php';
?>