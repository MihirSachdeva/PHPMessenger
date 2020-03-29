<?php
  if(isset($_POST['login-submit'])) {
    $host = "localhost";
    $user = "Mihir";
    $database = "phptest";
    $passwd = "Mihir123@";

    $con =  mysqli_connect($host, $user, $passwd, $database);
    if(!$con) {
      die("Can not connect: ".mysqli_connect_error());
    }

    $table = "mihir_users";

    $username = $_POST['username'];
    $password = $_POST['password'];

    if(empty($username) || empty($password)) {
      header("Location: ./signin.php?error=emptyfields");
      exit();
    }
    else {
      $sql = "SELECT id, username, password from $table where username = ?;";
      $stmt = mysqli_stmt_init($con);
      if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ./signin.php?error=sqlerror");
        exit();
      }
      else {
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if($row = mysqli_fetch_assoc($result)) {
          $passwordCheck = password_verify($password, $row['password']);
          if($passwordCheck == FALSE) {
            header("Location: ./signin.php?error=wrongpassword&username=".$username);
            exit();
          }
          else if($passwordCheck == TRUE) {
            session_start();
            $_SESSION['userId'] = $row['id'];
            $_SESSION['username'] = $row['username'];

            $usrId = $_SESSION['userId'];
            $usrName = $_SESSION['username'];

            if(isset($_POST['rememberMe'])) {
              $selectorName = "PHPMessengerSelector";
              $validatorName = "PHPMessengerValidator";

              $randomSelector = bin2hex(random_bytes(6));
              $randomValidator = bin2hex(random_bytes(20));
              $hashedValidator = password_hash($randomValidator, PASSWORD_DEFAULT);

              setcookie($selectorName, $randomSelector, time() + 86400*15, "/");
              setcookie($validatorName, $randomValidator, time() + 86400*15, "/");

              $sql = "INSERT INTO mihir_auth (user_id, user_name, selector, hashedValidator) VALUES (
                '$usrId',
                '$usrName',
                '$randomSelector',
                '$hashedValidator'
              )";

              if($con->query($sql)) {
                header("Location: ./mainapp.php?login=success");
                exit();
              }
              else {
                header("Location: ./mainapp.php?error=sqlerror");
                exit();
              }
            }
            header("Location: ./signin.php?login=success");
            exit();
          }
          else {
            header("Location: ./signin.php?error=wrongpassword");
            exit();
          }
        }
        else {
          header("Location: ./signin.php?error=nouser");
          exit();
        }
      }
    }

    mysqli_close($con);

  }
  else {
    header("Location: ./signin.php");
    exit();
  }
?>
