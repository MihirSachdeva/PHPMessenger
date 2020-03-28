<?php

  display();

  function display () {
   $con = mysqli_connect("localhost", "Mihir", "Mihir123@", "phptest");
   $sql = "SELECT image FROM mihir_users WHERE username = 'pqr'";
   $query = mysqli_query($con, $sql);
   $num_rows = mysqli_num_rows($query);
   for($i = 0; $i < $num_rows; $i++) {
     $result = mysqli_fetch_array($query);
     $img = $result['image'];
     echo '<img src="data:image;base64,'.$img.'">';
   }
  }

?>
