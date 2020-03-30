<?php

  session_set_cookie_params(0);
  session_start();
  $currentUserId = $_SESSION['userId'];

  $host = "localhost";
  $user = "first_year";
  $database = "first_year";
  $passwd = "first_year";
  $con =  new mysqli($host, $user, $passwd, $database);
  if($con->connect_errno) {
    die("Can not connect: ".$con->connect_error);
  }

  $userId = $_POST['userId'];
  $contactId = $_POST['contactId'];

  if($currentUserId != $userId) {
    die("<script>alert('Session error');</script>");
  }

  $sql = "SELECT message, sent_when, sent_by, sent_to FROM mihir_messages WHERE (sent_by = $userId AND sent_to = $contactId) OR (sent_by = $contactId AND sent_to = $userId)";

  $result = $con->query($sql);

  if($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {

      echo(
        "<div class=".($row['sent_by'] == $userId ?"'sent-message'>":"'recieved-message'>").

          "<div class='message-box'>".

            $row['message'].

          "</div>".

          "<div class='timestamp'>".

            $row['sent_when'].

          "</div>".

        "</div>"

      );
    }
  }


?>
