<?php
  if(isset($_POST['signup-submit'])) {
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
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $phone = $_POST['phone'];
    $sex = $_POST['sex'];
    $password = $_POST['password'];
    $rePassword = $_POST['rePassword'];

    if(empty($username) || empty($email) || empty($phone) || empty($sex) || empty($password) || empty($rePassword)) {
      header("Location:./signup.php?error=emptyfields&username=".$username."&email=".$email."&phone=".$phone);
      exit();
    }
    else if(!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^\w+$/", $username)) {
      header("Location:./signup.php?error=invalidemailandusername&phone=".$phone."&sex=".$sex);
      exit();
    }
    else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      header("Location:./signup.php?error=invalidemail&username=".$username."&phone=".$phone."&sex=".$sex);
      exit();
    }
    else if(!preg_match("/^\w+$/", $username)) {
      header("Location:./signup.php?error=invalidusername&email=".$email."&phone=".$phone."&sex=".$sex);
      exit();
    }
    else if(!preg_match("/^[6-9]\d{9}$/", $phone)) {
      header("Location:./signup.php?error=invalidphone&username=".$username."&email=".$email."&sex=".$sex);
      exit();
    }
    else if(!preg_match("/^\w+$/", $password)) {
      header("Location:./signup.php?error=invalidpassword&username=".$username."&email=".$email."&phone=".$phone."&sex=".$sex);
      exit();
    }
    else if($password != $rePassword) {
      header("Location:./signup.php?error=passwordsdonotmatch&username=".$username."&email=".$email."&phone=".$phone."&sex=".$sex);
      exit();
    }
    else {
      $sql = "SELECT username FROM $table WHERE username = ?";
      $stmt = mysqli_stmt_init($con);
      if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location:./signup.php?error=sqlerror");
        exit();
      }
      else {
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $resultCheck = mysqli_stmt_num_rows($stmt);
        if($resultCheck > 0) {
          header("Location:./signup.php?error=usernametaken&email=".$email."&phone=".$phone);
          exit();
        }
        else {
          $sql = "INSERT INTO $table (username, email, phone, sex, password) VALUES (?, ?, ?, ?, ?)";
          $stmt = mysqli_stmt_init($con);
          if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location:./signup.php?error=sqlerror");
            exit();
          }
          else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            mysqli_stmt_bind_param($stmt, "sssss", $username, $email, $phone, $sex, $hashedPassword);
            mysqli_stmt_execute($stmt);

            session_start();
            //get user id
            $sql = "SELECT id FROM $table WHERE username = '$username'";
            $result = $con->query($sql);
            if($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                $_SESSION['userId'] = $row['id'];
              }
            }

            $_SESSION['username'] = $username;
            header("Location: ./profile.php");
            exit();
          }
        }
      }
    }

  mysqli_stmt_close($stmt);
  mysqli_close($con);

  }
  else {
    header("Location:./signup.php");
    exit();
  }
?>
