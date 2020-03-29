<?php
  session_start();
  if(isset($_SESSION['userId'])) {
    header("Location: ./mainapp.php");
    exit();
  }
  if(isset($_COOKIE['PHPMessengerSelector'])) {
    $host = "localhost";
    $user = "first_year";
    $database = "first_year";
    $passwd = "first_year";
    $con =  new mysqli($host, $user, $passwd, $database);
    if($con->connect_errno) {
      die("Can not connect: ".$con->connect_error);
    }

    $user_table = "mihir_users";
    $message_table = "mihir_messages";
    $auth_table = "mihir_auth";

    $PHPMessengerSelector = $_COOKIE['PHPMessengerSelector'];
    $PHPMessengerValidator = $_COOKIE['PHPMessengerValidator'];

    $sql = "SELECT * FROM $auth_table WHERE selector = '$PHPMessengerSelector' ORDER BY made_when DESC LIMIT 1";
    $query = mysqli_query($con, $sql);
    $result = mysqli_fetch_array($query);
    if(password_verify($PHPMessengerValidator, $result['hashedValidator'])) {
      session_start();
      $_SESSION['userId'] = $result['user_id'];
      $_SESSION['username'] = $result['user_name'];

      header("Location: ./mainapp.php");
      exit();
    }
  }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="./css/styles.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700,800,900&display=swap" rel="stylesheet">
  </head>
  <body>
    <div class="form">
      <h2>sign in</h2>
      <?php
         if(isset($_GET['error'])) {
           $errorMessage = $_GET['error'];

           if($errorMessage == "emptyfields") {
             echo '<h3 class="error-message">Please fill all the fields.</h3>';
           }
           else if($errorMessage == "wrongpassword") {
             echo '<h3 class="error-message">Incorrect password.</h3>';
           }
           else if($errorMessage == "nouser") {
             echo '<h3 class="error-message">Username does not exist.</h3>';
           }
           else if($errorMessage == "sqlerror") {
             echo '<h3 class="error-message">SQL Error.<br />Do not try to mess <br />with this app. ;).</h3>';
           }
           else {
             echo '<h3 class="error-message">Unknown Error.<br />Contact the developer.</h3>';
           }
         }
         else if($_GET['login'] == "success") {
           echo '<h3 class="success-message">Sign In Successful!</h3>';
         }
      ?>
      <form method="post" action="signinPHP.php" enctype="multipart/form-data">
        <div class="input">
          <div class="inputBox">
            <label for="">Username</label>
            <input type="text" name="username" value="<?php if(isset($_GET['username'])) { echo($_GET['username']);} ?>" placeholder="abc_123@">
          </div>
          <div class="inputBox">
            <label for="">Password</label>
            <input type="password" name="password" value="" placeholder="•••••••">
          </div>
          <div class="inputBox remember-box">
            <label class="remember-label" for="">Remember Me</label>
            <input class="remember-checkbox" type="checkbox" name="rememberMe">
          </div>
          <div class="inputBox">
            <input type="submit" name="login-submit" value="Sign In">
          </div>
        </div>
      </form>
      <p class="instead">Create new account? <a href="./signup.php">Click Here</a></p>
    </div>
    <script src="./sign.js" charset="utf-8"></script>
  </body>
</html>
