<?php

function check_logged_in()
{
    if (isset($_SESSION['auth'])) {
        return true;
    } else {
        header("Location: ../login");
        exit();
    }
}

function check_logged_out()
{
    if (!isset($_SESSION['auth'])) {
        return true;
    } else {
        header("Location: user/dashboard");
        exit();
    }
}

function force_login($email)
{
    require '../config/db.inc.php';

    $sql = "SELECT * FROM users WHERE email=?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        return false;
    } else {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if (!$row = mysqli_fetch_assoc($result)) {
            return false;
        } else {
            $_SESSION['auth'] = 'loggedin';

            $_SESSION['username'] = $row['username'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['created_at'] = $row['created_at'];
            $_SESSION['updated_at'] = $row['updated_at'];

            return true;
        }
    }
}

function check_remember_me()
{
    require '../config/db.inc.php';

    if (empty($_SESSION['auth']) && !empty($_COOKIE['rememberme'])) {

        list($selector, $validator) = explode(':', $_COOKIE['rememberme']);

        $sql = "SELECT * FROM auth_tokens WHERE auth_type='remember_me' AND selector=? AND expires_at >= NOW() LIMIT 1;";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            // SQL ERROR
            return false;
        } else {
            mysqli_stmt_bind_param($stmt, "s", $selector);
            mysqli_stmt_execute($stmt);
            $results = mysqli_stmt_get_result($stmt);

            if (!($row = mysqli_fetch_assoc($results))) {
                // COOKIE VALIDATION FAILURE
                return false;
            } else {
                $tokenBin = hex2bin($validator);
                $tokenCheck = password_verify($tokenBin, $row['token']);

                if ($tokenCheck === false) {
                    // COOKIE VALIDATION FAILURE
                    return false;
                } else if ($tokenCheck === true) {
                    $email = $row['user_email'];
                    force_login($email);

                    return true;
                }
            }
        }
    }
}

function dd($value)
{
    echo '<pre>';
    var_dump($value);
    echo '</pre>';
    exit;
}

function password_generate($chars)
{
    $data = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';
    return substr(str_shuffle($data), 0, $chars);
}

function getStatus($statusname)
{
    if (isset($_SESSION['STATUS'][$statusname])) {
        echo '<small class="form-text text-success">' . $_SESSION['STATUS'][$statusname] . '</small>';
    }
}

function getError($errorname)
{
    if (isset($_SESSION['ERRORS'][$errorname])) {
        echo '<small class="form-text text-danger">' . $_SESSION['ERRORS'][$errorname] . '</small>';
    }
}


function availableUsername($conn, $username)
{
    $sql = "SELECT username FROM users WHERE username=?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        return $_SESSION['ERRORS']['scripterror'] = 'SQL error';
    } else {
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $resultCheck = mysqli_stmt_num_rows($stmt);

        if ($resultCheck > 0) {
            return false;
        } else {
            return true;
        }
    }
}

function availableEmail($conn, $email)
{
    $sql = "SELECT email FROM users WHERE email=?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        return $_SESSION['ERRORS']['scripterror'] = 'SQL error';
    } else {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $resultCheck = mysqli_stmt_num_rows($stmt);

        if ($resultCheck > 0) {
            return false;
        } else {
            return true;
        }
    }
}
