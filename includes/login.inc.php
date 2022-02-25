<?php
require 'auth_functions.php';
require 'security_functions.php';

check_logged_out();
$error = array();

if (!isset($_POST['login-submit-btn'])) {
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

  $username = $_POST['username'];
  $password = $_POST['password'];

  if (empty($username)) {
    $error[] = 'The username field is empty.';
  }

  if (empty($password)) {
    $error[] = 'The password field is empty.';
  }

  if (count($error) > 0) {
    $_SESSION['ERRORS'] = $error;
    header("Location: ../login");
    exit();
  } else {
    /*
    * -------------------------------------------------------------------------------
    *   Creating SESSION Variables
    * -------------------------------------------------------------------------------
    */

    $sql = "SELECT * FROM users WHERE email=? OR username=?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
      $error[] = 'SQL ERROR';
      $_SESSION['ERRORS'] = $error;
      header("Location: ../login");
      exit();
    } else {
      mysqli_stmt_bind_param($stmt, "ss", $username, $username);
      mysqli_stmt_execute($stmt);

      $result = mysqli_stmt_get_result($stmt);

      if ($row = mysqli_fetch_assoc($result)) {
        $pwdCheck = password_verify($password, $row['password']);

        if ($pwdCheck == false) {
          $error[] = 'Wrong password';
          $_SESSION['ERRORS'] = $error;
          header("Location: ../login");
          exit();
        } elseif ($pwdCheck == true) {
          session_start();
          $_SESSION['auth'] = 'loggedin';

          $_SESSION['username'] = $row['username'];
          $_SESSION['email'] = $row['email'];
          $_SESSION['created_at'] = $row['created_at'];
          $_SESSION['updated_at'] = $row['updated_at'];

          /*
          * -------------------------------------------------------------------------------
          *   Setting rememberme cookie
          * -------------------------------------------------------------------------------
          */

          if (isset($_POST['rememberme'])) {

            $selector = bin2hex(random_bytes(8));
            $token = random_bytes(32);

            $sql = "DELETE FROM auth_tokens WHERE user_email=? AND auth_type='remember_me';";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
              $error[] = 'SQL ERROR';
              $_SESSION['ERRORS'] = $error;
              header("Location: ../login");
              exit();
            } else {
              mysqli_stmt_bind_param($stmt, "s", $_SESSION['email']);
              mysqli_stmt_execute($stmt);
            }

            setcookie(
              'rememberme',
              $selector . ':' . bin2hex($token),
              time() + 864000,
              '/',
              NULL,
              false, // TLS-only
              true  // http-only
            );

            $sql = "INSERT INTO auth_tokens (user_email, auth_type, selector, token, expires_at) 
                              VALUES (?, 'remember_me', ?, ?, ?);";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
              $error[] = 'SQL ERROR';
              $_SESSION['ERRORS'] = $error;
              header("Location: ../login");
              exit();
            } else {
              $hashedToken = password_hash($token, PASSWORD_DEFAULT);
              mysqli_stmt_bind_param($stmt, "ssss", $_SESSION['email'], $selector, $hashedToken, date('Y-m-d\TH:i:s', time() + 864000));
              mysqli_stmt_execute($stmt);
            }
          }

          if (isset($_SESSION['ERRORS'])) {
            $_SESSION['ERRORS'] = null;
            unset($_SESSION["ERRORS"]);
          }
          header("Location: ../user/dashboard");
          exit();
        }
      } else {
        $error[] = 'User does not exist';
        $_SESSION['ERRORS'] = $error;
        header("Location: ../login");
        exit();
      }
    }
  }
}
