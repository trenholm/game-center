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
    <link href="css/font-awesome.min.css" rel="stylesheet">
  </head>
  <body>
    <?php
      $page = "player";
      include('nav.php');
      // Connect to the database
      include('db/db_mysql.php');
      $player = $_GET['pid'];
      $success = $_GET['success'];

      // This page is only viewable if logged in!

      // list player information
      $playerInfo = array();
      $query = "SELECT * FROM player WHERE id = {$player};";
      $result = mysql_query($query);
      while ($row = mysql_fetch_assoc($result)) {
        $pid = $row['id'];
        $fname = $row['firstName'];
        $lname = $row['lastName'];
        $pic = $row['picture'];
        $sex = $row['sex'];

        $playerInfo = array('id' => $pid, 
                                  'firstName' => $fname, 
                                  'lastName' => $lname, 
                                  'picture' => $pic, 
                                  'sex' => $sex);
      }

      // Need ability to upload new photo to the server (c.f. PARKS UPLOAD)
      // include('uploadForm.html');

      mysql_close($con);
    ?>

    <div class="container-fluid">
      <!-- Player name -->
      <div class="row-fluid">
        <div class="span12">
          <?php 
            echo "<h1>" . $playerInfo['firstName'] . " " . $playerInfo['lastName'] . "</h1>";
          ?>
        </div>
      </div>
      <!-- Player Photo -->
      <div class="row-fluid">
        <div class="span3">
          <div class="media">
            <?php 
              if($success) {
                // Have a "notification system" set up instead of this
                echo "<p>Successfully updated your profile.</p>";
              }
   
              if($playerInfo['picture']) {
                echo '<img class="media-object" style="border-radius:5px;margin-top:20px;" src="img/players/' . $playerInfo['picture'] . '">';
              }
              else {
                echo '<div style="font-size:50px;margin-top:65px;margin-bottom:45px;"><i class="icon-user icon-4x icon-border media-object"></i></div>';
              }

              echo "<h4>Want to change your profile picture?</h4>";
              include('uploadForm.php');
            ?>
          </div>
        </div>
        <div class="span9">
          <div class="row-fluid">
            <h3 class="span12 pull-left">Your Information</h3>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>  