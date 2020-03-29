<?php

  session_start();
  session_unset();
  session_destroy();

  setcookie("PHPMessengerSelector", "", time() - 3600, "/");
  setcookie("PHPMessengerValidator", "", time() - 3600, "/");

  header("Location: ./signin.php");
  exit();

?>
