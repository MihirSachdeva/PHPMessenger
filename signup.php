<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>PHPMessenger - Sign Up PHP</title>
  </head>
  <body>
    <?php
    if(isset($_POST['submit'])) {
      $host = "localhost";
      $user = "Mihir";
      $database = "phptest";
      $passwd = "Mihir123@";

        $con =  new mysqli($host, $user, $passwd, $database);
        if($con->connect_errno) {
          die("Can not connect: ".$con->connect_error);
        }

        // $stmt = $con->prepare("INSERT INTO $table (username, email, phone, sex, password) VALUES (?, ?, ?, ?)");
        // $stmt->bind_param("ssss", $username, $email, $phone, $sex, $password);

        $table = "mihir_users";

        $username = $_POST['username'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $sex = $_POST['sex'];
        $password = $_POST['password'];

        // $stmt->execute();

        $sql = "INSERT INTO $table (username, email, phone, sex, password)
        VALUES
          ('$username', '$email', '$phone', '$sex', '$password')
        ";

        if($con->query($sql) === TRUE) {
          echo("Data inserted successfully!</p>");

        // $stmt->close();
        } else {
          echo("Error: ".$con->error);
        }

      $con->close();

    } else {
      echo 'No data entered. Redirect to <a href="./signup.html">Sign-Up Page.</a>';
    }
    ?>
  </body>
</html>
