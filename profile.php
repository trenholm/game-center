<!DOCTYPE html>
<html>
  <head>
    <title>Game Center</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Game Center web application for IGS520M">
    <meta name="author" content="Cody Clerke, Jamie McKee-Scott, Ryan Trenholm">
    <!-- Styles -->
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="./css/font-awesome.min.css" rel="stylesheet">
  </head>
  <body>
    <?php
      $page = "player";
      include('nav.php');
      // Connect to the database
      include('db_mysql.php');
      $player = $_GET['pid'];
      $success = $_GET['success'];

      // This page is only viewable if logged in!

      // Need ability to upload new photo to the server (c.f. PARKS UPLOAD)

      // include('uploadForm.html');

      mysql_close($con);
    ?>

    <div class="container-fluid">
      <?php 

        echo "Player ID: " . $player;
        if($success) {
          echo "<br>Success = " . $success;
          // Need ability to update name, other information, etc.
        }
        echo '<br><img src="./img/players/'. $player . '.jpg">';

        echo "<h4>Want to change your profile picture?</h4>";
        include('uploadForm.php');
      ?>
    </div>
  </body>
</html>  