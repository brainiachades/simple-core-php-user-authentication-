<?php
require 'auth_functions.php';
require 'security_functions.php';

check_logged_out();
$error = array();

if (!isset($_POST['register-submit-btn'])) {
  header("Location: ../register");
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

  //filter POST data
  function input_filter($data)
  {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  $username = input_filter($_POST['username']);
  $email = input_filter($_POST['email']);
  $password = input_filter($_POST['password']);
  $passwordRepeat = input_filter($_POST['confirmpassword']);

  /*
  * -------------------------------------------------------------------------------
  *   Data Validation
  * -------------------------------------------------------------------------------
  */

  if (empty($username)) {
    $error[] = 'The username field is empty.';
  }

  if (empty($email)) {
    $error[] = 'The email field is empty.';
  }

  if (empty($password)) {
    $error[] = 'The password field is empty.';
  }

  if (empty($passwordRepeat)) {
    $error[] = 'Confirm password.';
  }

  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error[] = 'Invalid email';
  }

  if ($password !== $passwordRepeat) {
    $error[] = 'Passwords does not match';
  }

  if (!availableUsername($conn, $username)) {
    $error[] = 'Username already taken.';
  }

  if (!availableEmail($conn, $username)) {
    $error[] = 'Email already taken.';
  }

  if (count($error) > 0) {
    $_SESSION['ERRORS'] = $error;
    header("Location: ../register");
    exit();
  } else {
    /*
  * -------------------------------------------------------------------------------
  *   User Creation
  * -------------------------------------------------------------------------------
  */

    $sql = "INSERT INTO users(username, email, password, created_at) values (?,?,?, NOW())";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
      $error[] = 'SQL ERROR';
      $_SESSION['ERRORS'] = $error;
      header("Location: ../register");
      exit();
    } else {
      $hashedPwd = password_hash($password, PASSWORD_DEFAULT);

      mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashedPwd);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_store_result($stmt);


      // Account created then login
      $sql = "SELECT * FROM users WHERE email=?;";
      $stmt = mysqli_stmt_init($conn);

      if (!mysqli_stmt_prepare($stmt, $sql)) {
        $error[] = 'SQL ERROR';
        $_SESSION['ERRORS'] = $error;
        header("Location: ../login");
        exit();
      } else {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);

        // Logged in
        session_start();
        $_SESSION['auth'] = 'loggedin';

        $_SESSION['username'] = $row['username'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['created_at'] = $row['created_at'];
        $_SESSION['updated_at'] = $row['updated_at'];

        if (isset($_SESSION['ERRORS'])) {
          $_SESSION['ERRORS'] = null;
          unset($_SESSION["ERRORS"]);
        }
        header("Location: ../user/dashboard");
        exit();
      }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
  }
}
