<?php
session_start();
require BASE_PATH . 'config/db.inc.php';
require BASE_PATH . 'includes/auth_functions.php';
require BASE_PATH . 'includes/security_functions.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title><?php echo TITLE . ' - ' . APP_NAME; ?></title>
  <meta content="<?php echo APP_DESCRIPTION; ?>" name="description">
  <meta content="<?php echo APP_KEYWORDS; ?>" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header">
    <div class="container d-flex align-items-center justify-content-between">

      <div class="logo">
        <a href="home">
          <img src="assets/img/logo.png" alt="logo" class="img-fluid">
        </a>
      </div>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto active" href="home">Home</a></li>
          <li><a class="nav-link scrollto" href="about-us">About Us</a></li>
          <li><a class="nav-link scrollto" href="our-services">Our Services</a></li>
          <li><a class="nav-link scrollto" href="contact-us">Contact Us</a></li>
          <li><a class="nav-link scrollto" href="tracking">Track Shipment</a></li>
          <li><a class="getstarted scrollto" href="user/dashboard">Security Vault</a></li>
        </ul>
        <i class="fa fa-bars mobile-nav-toggle"></i>
      </nav>
      <!-- .navbar -->

    </div>
  </header>
  <!-- End Header -->