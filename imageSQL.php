<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>MySQL PHP Image Test</title>
  </head>
  <body>
    <form method="post", enctype="multipart/form-data">
      <input type="file" name="image">
      <br>
      <input type="submit" name="submit" value="Submit">
    </form>

    <?php

      //UPLOAD
      if(isset($_POST['submit'])) {
        if(getimagesize($_FILES['image']['tmp_name']) == FALSE) {
          echo "failed";
        } else {
          $name = addslashes($_FILES['image']['name']);
          $image = base64_encode(file_get_contents(addslashes($_FILES['image']['tmp_name'])));
          saveImage($name, $image);
        }
      }

      function saveImage($name, $image) {
        $con = mysqli_connect("localhost", "Mihir", "Mihir123@", "phptest");
        $sql = "INSERT INTO image_test (name, image) VALUES ('$name', '$image')";
        $query=mysqli_query($con, $sql);
        if ($query) {
          echo "success";
        } else {
          echo "not uploaded";
        }
      }

      //DISPLAY
      display();

      function display () {
        $con = mysqli_connect("localhost", "Mihir", "Mihir123@", "phptest");
        $sql = "SELECT * FROM image_test";
        $query = mysqli_query($con, $sql);
        $num_rows = mysqli_num_rows($query);
        for($i = 0; $i < $num_rows; $i++) {
          $result = mysqli_fetch_array($query);
          $img = $result['image'];
          echo '<img src="data:image;base64,'.$img.'">';
        }
      }
    ?>
  </body>
</html>
