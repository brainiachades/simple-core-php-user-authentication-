<?php
require 'auth_functions.php';
require 'security_functions.php';

check_logged_out();
$error = array();
$success = array();

if (!isset($_POST['resetsend-submit-btn'])) {
  header("Location: ../login");
  exit();
} else {
  /*
  * -------------------------------------------------------------------------------
  *   Securing against Header Injection
  * -------------------------------------------------------------------------------
  */

  foreach ($_POST as $key => $value) {
    $_POST[$key] = _cleaninjections(trim($value));
  }

  /*
  * -------------------------------------------------------------------------------
  *   Verifying CSRF token
  * -------------------------------------------------------------------------------
  */

  if (!verify_csrf_token()) {
    $error[] = 'Request could not be validated';
    $_SESSION['ERRORS'] = $error;
    header("Location: ../login");
    exit();
  }

  require '../config/db.inc.php';

  $selector = bin2hex(random_bytes(8));
  $token = random_bytes(32);
  $url = APP_URL . "forget-password/?selector=" . $selector . "&validator=" . bin2hex($token);
  $expires = 'DATE_ADD(NOW(), INTERVAL 1 HOUR)';

  $email = $_POST['email'];

  $sql = "SELECT email, username FROM users WHERE email=?;";
  $stmt = mysqli_stmt_init($conn);

  if (!mysqli_stmt_prepare($stmt, $sql)) {
    $error[] = 'SQL ERROR';
    $_SESSION['ERRORS'] = $error;
    header("Location: ../login");
    exit();
  } else {
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) == 0) {
      $error[] = 'Given email does not exist in our records';
      $_SESSION['ERRORS'] = $error;
      header("Location: ../login");
      exit();
    }
  }

  $sql = "DELETE FROM auth_tokens WHERE user_email=? AND auth_type='password_reset';";
  $stmt = mysqli_stmt_init($conn);

  if (!mysqli_stmt_prepare($stmt, $sql)) {
    $error[] = 'SQL ERROR';
    $_SESSION['ERRORS'] = $error;
    header("Location: ../login");
    exit();
  } else {
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
  }

  $sql = "INSERT INTO auth_tokens (user_email, auth_type, selector, token, expires_at) 
            VALUES (?, 'password_reset', ?, ?, " . $expires . ");";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    $error[] = 'SQL ERROR';
    $_SESSION['ERRORS'] = $error;
    header("Location: ../login");
    exit();
  } else {
    $hashedToken = password_hash($token, PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt, "sss", $email, $selector, $hashedToken);
    mysqli_stmt_execute($stmt);
  }
  mysqli_stmt_close($stmt);
  mysqli_close($conn);

  // Send mail
  $to = $email;
  $subject = 'Reset Your Password';
  $message = "";

  if (mail($to, $subject, $message)) {
    $success[] = 'Reset email sent';
    $_SESSION['STATUS'] = $success;
    header("Location: ../forget-password");
    exit();
  } else {
    $error[] = 'Message could not be sent, try again later';
    $_SESSION['ERRORS'] = $error;
    header("Location: ../forget-password");
    exit();
  }
}
