<?php
  session_start();
  if(!isset($_SESSION['userId'])) {
    header("Location: ./signin.php");
    exit();
  }
  $currentUsername = $_SESSION['username'];
  $currentId = $_SESSION['userId'];

  $host = "localhost";
  $user = "Mihir";
  $database = "phptest";
  $passwd = "Mihir123@";
  $con =  new mysqli($host, $user, $passwd, $database);
  if($con->connect_errno) {
    die("Can not connect: ".$con->connect_error);
  }

  $email = "";
  $phone = "";
  $fname = "";
  $lname = "";

  $sql = "SELECT id, username, email, phone, sex, photo_name, image, fname, lname FROM mihir_users WHERE username = '$currentUsername'";

  $result = $con->query($sql);

  if($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $email = $row['email'];
      $phone = $row['phone'];
      $fname = $row['fname'];
      $lname = $row['lname'];
    }
  }

?>



<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Profile - PHPMessenger</title>
    <link rel="stylesheet" href="./css/styles.css">
  </head>
  <body>
    <div class="form signup-form">
       <h2>profile</h2>
       <?php if(isset($_GET['error'])) {
         echo "<h3 class='error-message'>Please fill all fields to continue.</h3>";
       } ?>
       <form action="profilePHP.php" method="post" enctype="multipart/form-data">
         <div class="input">
           <div class="inputBox">
             <label for="">Username</label>
             <div class="username-display"> <div><?php echo $currentUsername; ?></div> </div>
           </div>
           <div class="inputBox">
             <label for="">First name</label>
             <input type="text" name="fname" value="<?php echo $fname; ?>" placeholder="John">
           </div>
           <div class="inputBox">
             <label for="">Last name</label>
             <input type="text" name="lname" value="<?php echo $lname; ?>" placeholder="Doe">
           </div>
           <div class="inputBox">
             <label for="">Profile picture</label>
             <input type="file" name="image" value="">
           </div>
           <div class="inputBox">
             <label for="">Email-ID</label>
             <input type="text" name="email" value="<?php echo $email; ?>" placeholder="abc@xyz.com">
           </div>
           <div class="inputBox">
             <label for="">Phone number</label>
             <input type="number" name="phone" value="<?php echo $phone; ?>" placeholder="987654321">
           </div>
           <div class="inputBox">
             <label for="">Sex</label>
             <select class="" name="sex">
               <option value="f">Female</option>
               <option value="m">Male</option>
               <option value="o">Other/Prefer not to disclose</option>
             </select>
           </div>
           <div class="inputBox">
             <input type="submit" name="profile-submit" value="Save">
           </div>
         </div>
       </form>
     </div>


  </body>
</html>
