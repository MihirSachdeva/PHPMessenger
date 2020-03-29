<?php
  session_start();
  if(isset($_SESSION[userId])) {
    $currentUserId = $_SESSION['userId'];
    $currentUserName = $_SESSION['username'];
  }
  else {
    header("Location: ./signin.php");
    exit();
  }

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

  $sql = "SELECT * FROM $user_table WHERE username = '$currentUserName'";
  $query = mysqli_query($con, $sql);
  $result = mysqli_fetch_array($query);
  if(empty($result['email']) || empty($result['phone']) || empty($result['sex']) || empty($result['image']) || empty($result['fname']) || empty($result['lname'])) {
    header("Location: ./profile.php?error=emptyfields");
    exit();
  }

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>PHPMessenger</title>
    <link rel="stylesheet" href="./css/mainapp.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700,800,900&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript">

      var currentDisplayingContactId = "";

      $(document).ready(function() {

        $('.user-icon').click(function() {
          $('.user-dropdown').toggleClass("hidden");
        });

        $('.send-button').click(function() {
          var typed_message = $('#type-message').val();
          if(typed_message == "") {
            alert("Empty message.");
          }
          else {
            $('#type-message').val("");
            if(currentDisplayingContactId == "") {
              alert("No contact selected.");
            }
            else {
              $.ajax({
                url: "sendMessage.php",
                type: "POST",
                data: {sent_by: <?php echo $currentUserId; ?>, sent_to: currentDisplayingContactId, message: typed_message}, //sent_by should be the user id and sent_to should be the contact id
                success: function(data) {
                  $('.just-for-alert').html(data);
                }
              });
            }
          }
        });

        $('.contact').click(function() {
          var contactid = $(this).val();
          currentDisplayingContactId = contactid;
          $('.messages').html("");
          $.ajax({
            url: "getMessages.php",
            type: "POST",
            data: {userId: <?php echo $currentUserId; ?>, contactId: contactid},
            success: function(messages) {
              $('.messages').html(messages);
            }
          });
          $.ajax({
            url: "navContact.php",
            type: "POST",
            data: {contactId: contactid},
            success: function(info) {
              $('.selectedContact').html(info);
            }
          });

        });

        setInterval(function(){
         if(currentDisplayingContactId != "") {
           $.ajax({
             url: "getMessages.php",
             type: "POST",
             data: {userId: <?php echo $currentUserId; ?>, contactId: currentDisplayingContactId},
             success: function(messages) {
               $('.messages').html(messages);
             }
           });
         }
       }, 500);

      });
    </script>
    </body>

  </head>
  <body>

  <div class="page-container">

    <div class="navbar">

      <a href="#" class="logo">

        <div class="logo-container">

          <div class="logo-image">
            <img class="navContactImage" src="./photos/logo.png" alt="PHPMessenger Logo">
          </div>

          <div class="logo-name">
            PHPMessenger
          </div>

        </div>

      </a>

      <div class="selectedContact">

      </div>

      <div class="user-icon">

        <?php

        $sql = "SELECT image FROM mihir_users WHERE username = '$currentUserName'";
        $query = mysqli_query($con, $sql);
        $num_rows = mysqli_num_rows($query);
        for($i = 0; $i < $num_rows; $i++) {
          $result = mysqli_fetch_array($query);
          $img = $result['image'];
          echo '<img class="navContactImage" src="data:image;base64,'.$img.'">';
        }


        ?>

      </div>

      <div class="user-dropdown hidden">
        <div class="profile dropdown-button">
          <p><a href="./profile.php">Profile</a></p>
        </div>
        <div class="logout dropdown-button">
          <p><a href="./logout.php">Logout</a></p>
        </div>
      </div>



    </div>

    <div class="main">

      <div class="contacts">

        <?php

        $sql = "SELECT username, id, image from $user_table WHERE id != $currentUserId";

        $result = $con->query($sql);

        if($result->num_rows > 0) {

          while ($row = $result->fetch_assoc()) {

            ?>

            <button class="contact" value="<?php echo $row['id']; ?>">

              <div class="contact-image">

                <?php echo '<img class="navContactImage" src="data:image;base64,'.$row['image'].'">'; ?>

              </div>

              <div class="contact-name">

                <?php echo $row['username']; ?>

              </div>

              <div class="contact-status">

              </div>

            </button>

            <?php

          }
        }

        ?>


      </div>

      <div class="main-separator-line">

      </div>

      <div class="message-container">

        <div class="messages">


        </div>

        <div class="message-type-send">

          <form class="send-form" action="" method="post">

            <input class="type-message" id="type-message" type="text" name="message" placeholder="Type a message" autocomplete="off">
            <button class="send-button" type="button" name="send-message-button">Send</button>

          </form>


        </div>

      </div>

    </div>

    <div class="just-for-alert">

    </div>

  </div>

</html>
