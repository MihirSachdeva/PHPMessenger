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
    <title>PHPMessenger</title>
    <link rel="stylesheet" href="./css/landing.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700,800,900&display=swap" rel="stylesheet">
  </head>
  <body>
    <div class="main">
      <div class="logo">
        <div class="logo-image">
          <img class="navContactImage" src="./photos/logo.png" alt="PHPMessenger Logo">
        </div>
        <div class="logo-name">
          PHPMessenger
        </div>

      </div>
      <div class="middle-line">

      </div>
      <div class="action">
        <a class="sign-link" href="./signup.php">
          <div class="sign">
            Sign Up
          </div>
        </a>
        <div class="or">
          <div class="or-line">

          </div>
          <div class="or-or">
            or
          </div>
          <div class="or-line">

          </div>
        </div>
        <a class="sign-link" href="./signin.php">
          <div class="sign">
            Sign In
          </div>
        </a>


      </div>

    </div>
  </body>
</html>
