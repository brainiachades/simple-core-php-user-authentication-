<!-- ======= Footer ======= -->
<footer id="footer">
  <div class="footer-top">
    <div class="container text-start">
      <img src="assets/img/logo.png" class="img-fluid" alt="logo">
    </div>
  </div>

  <div class="container footer-bottom clearfix">
    <div class="copyright">
      &copy; <strong><span>Copious Security Vault</span></strong>. All Rights Reserved
    </div>
  </div>
</footer>
<!-- End Footer -->

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="fa fa-arrow-up"></i></a>

<!-- Vendor JS Files -->
<script src="assets/vendor/jquery/jquery.min.js"></script>
<script src="assets/vendor/aos/aos.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
<script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

<!-- Template Main JS File -->
<script src="assets/js/main.js"></script>
<script>
  $(".alert").alert();
</script>

</body>

</html>

<?php
if (isset($_SESSION['ERRORS'])) {
  $_SESSION['ERRORS'] = null;
  unset($_SESSION["ERRORS"]);
}
if (isset($_SESSION['STATUS'])) {
  $_SESSION['STATUS'] = NULL;
  unset($_SESSION["STATUS"]);
}
?>