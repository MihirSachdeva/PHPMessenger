<?php

  $host = "localhost";
  $user = "first_year";
  $database = "first_year";
  $passwd = "first_year";
  $con =  new mysqli($host, $user, $passwd, $database);
  if($con->connect_errno) {
    die("Can not connect: ".$con->connect_error);
  }
  $user_table = "mihir_users";

  $contactId = $_POST['contactId'];

  $sql = "SELECT username, image FROM $user_table WHERE id = $contactId";

  $result = $con->query($sql);

  if($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {

      echo(
        "<div class='contact-image'>".

          '<img class="navContactImage" src="data:image;base64,'.$row['image'].'">'.

        "</div>".

        "<div class='contact-name'>".

          $row['username'].

        "</div>".

        "<div class='contact-status'>".

        "</div>"
      );
    }
  }

  mysqli_close($con);

  ?>
