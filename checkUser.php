<?php
  $host = "localhost";
  $user = "Mihir";
  $database = "phptest";
  $passwd = "Mihir123@";

  $con =  mysqli_connect($host, $user, $passwd, $database);
  if(!$con) {
    die("Can not connect: ".mysqli_connect_error());
  }

  $table = "mihir_users";

  $username = $_POST['search'];

  $sql = "SELECT username from $table WHERE username = '$username'";

  $result = mysqli_query($con, $sql);

  if(mysqli_num_rows($result) > 0) {
    echo '<p class="error-message">Username taken</p>';
  }
  else {
    echo '<p class="success-message">Username available</p>';
  }

  mysqli_close($con);
?>
