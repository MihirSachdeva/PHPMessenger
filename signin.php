<?php
  session_start();
  if(isset($_SESSION['userId'])) {
    header("Location: ./mainapp.php");
    exit();
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
