<?php
define('TITLE', "Contact Us");
require 'env.php';
include 'layouts/header.php';
?>

<!-- ======= Breadcrumbs Section ======= -->
<section class="breadcrumbs">
  <div class="container">

    <div class="d-flex justify-content-between align-items-center">
      <h2>Contact Us</h2>
      <ol>
        <li><a href="home">Home</a></li>
        <li>Contact Us</li>
      </ol>
    </div>

  </div>
</section>
<!-- Breadcrumbs Section -->

<!-- ======= Contact Section ======= -->
<section id="contact" class="contact section-bg">
  <div class="container" data-aos="fade-up">

    <div class="section-title">
      <h2>Contact Us</h2>
    </div>

    <div class="row">

      <div class="col-lg-6">

        <div class="row">
          <div class="col-md-12">
            <div class="info-box" data-aos="fade-up">
              <i class="bx bx-map"></i>
              <h3>Address</h3>
              <p>5 Mill Road, London W06 5MV, UK</p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="info-box mt-4" data-aos="fade-up" data-aos-delay="100">
              <i class="bx bx-envelope"></i>
              <h3>Email Us</h3>
              <p>info@copiousglobal.com</p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="info-box mt-4" data-aos="fade-up" data-aos-delay="100">
              <i class="bx bx-phone-call"></i>
              <h3>Call Us</h3>
              <p>+44 7467 908960</p>
            </div>
          </div>
        </div>

      </div>

      <div class="col-lg-6 mt-4 mt-lg-0">
        <form action="includes/contact.inc.php" method="post" role="form" class="php-email-form w-100" data-aos="fade-up">
          <div class="row">
            <div class="col-md-6 form-group">
              <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" required>
            </div>
            <div class="col-md-6 form-group mt-3 mt-md-0">
              <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required>
            </div>
          </div>
          <div class="form-group mt-3">
            <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" required>
          </div>
          <div class="form-group mt-3">
            <textarea class="form-control" name="message" rows="5" placeholder="Message" required></textarea>
          </div>
          <div class="my-3">
            <!-- <div class="loading">Loading</div>
            <div class="error-message"></div>
            <div class="sent-message">Your message has been sent. Thank you!</div> -->
          </div>
          <div class="text-center"><button type="submit" name="contact-submit-btn">Send Message</button></div>
        </form>
      </div>

    </div>

  </div>
</section><!-- End Contact Section -->

<?php
include 'layouts/footer.php';
?>