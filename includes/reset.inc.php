<?php
require 'auth_functions.php';
require 'security_functions.php';

check_logged_out();
$error = array();
$success = array();

if (!isset($_POST['reset-submit-btn'])) {
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

  $selector = $_POST['selector'];
  $validator = $_POST['validator'];
  $password = $_POST['newpassword'];
  $passwordRepeat = $_POST['confirmpassword'];

  if (empty($selector)) {
    $error[] = 'Invalid token, please use new reset email';
  }

  if (empty($validator)) {
    $error[] = 'Invalid token, please use new reset email';
  }

  if (empty($password)) {
    $error[] = 'The password field is empty.';
  }

  if (empty($passwordRepeat)) {
    $error[] = 'Confirm password.';
  }

  if ($password !== $passwordRepeat) {
    $error[] = 'Passwords does not match';
  }

  if (count($error) > 0) {
    $_SESSION['ERRORS'] = $error;
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
  } else {
    $sql = "SELECT * FROM auth_tokens WHERE auth_type='password_reset' AND selector=? AND expires_at >= NOW() LIMIT 1";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
      $error[] = 'SQL ERROR';
      $_SESSION['ERRORS'] = $error;
      header("Location: " . $_SERVER['HTTP_REFERER']);
      exit();
    } else {
      mysqli_stmt_bind_param($stmt, "s", $selector);
      mysqli_stmt_execute($stmt);
      $results = mysqli_stmt_get_result($stmt);

      if (!($row = mysqli_fetch_assoc($results))) {
        $error[] = 'Non-existent or expired token, please use new reset email';
        $_SESSION['ERRORS'] = $error;
        header("Location: ../forget-password");
        exit();
      } else {
        $tokenBin = hex2bin($validator);
        $tokenCheck = password_verify($tokenBin, $row['token']);

        if ($tokenCheck === false) {
          $error[] = 'Invalid token, please use new reset email';
          $_SESSION['ERRORS'] = $error;
          header("Location: ../forget-password");
          exit();
        } else if ($tokenCheck === true) {
          $tokenEmail = $row['user_email'];

          $sql = 'SELECT * FROM users WHERE email=?;';
          $stmt = mysqli_stmt_init($conn);

          if (!mysqli_stmt_prepare($stmt, $sql)) {
            $error[] = 'SQL ERROR';
            $_SESSION['ERRORS'] = $error;
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
          } else {
            mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
            mysqli_stmt_execute($stmt);
            $results = mysqli_stmt_get_result($stmt);

            if (!($row = mysqli_fetch_assoc($results))) {
              $error[] = 'Invalid token, please use new reset email';
              $_SESSION['ERRORS'] = $error;
              header("Location: ../forget-password");
              exit();
            } else {
              $newPwdHash = password_hash($password, PASSWORD_DEFAULT);
              mysqli_stmt_bind_param($stmt, "ss", $newPwdHash, $tokenEmail);
              mysqli_stmt_execute($stmt);

              $sql = "DELETE FROM auth_tokens WHERE user_email=? AND auth_type='password_reset';";
              $stmt = mysqli_stmt_init($conn);

              if (!mysqli_stmt_prepare($stmt, $sql)) {
                $error[] = 'SQL ERROR';
                $_SESSION['ERRORS'] = $error;
                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit();
              } else {
                mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
                mysqli_stmt_execute($stmt);

                $success[] = 'Password updated, please log in';
                $_SESSION['STATUS'] = $success;
                header("Location: ../login");
                exit();
              }
            }
          }
        }
      }
    }
  }
}
