<!DOCTYPE html>
<html>
  <head>
    <title>Game Center</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Game Center web application for COSC416/IGS520M">
    <meta name="author" content="Cody Clerke, Jamie McKee-Scott, Ryan Trenholm">
    <!-- Styles -->
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="css/font-awesome.min.css" rel="stylesheet">
  </head>
  <body>
    <?php
      $page = "profile";
      include('nav.php');

      // Set up the session parameters
      session_set_cookie_params(0);
      session_start();

      // If logged IN, display FirstName with dropdown menu for more options
      if(session_is_registered('pid')) {
        $player = $_SESSION['pid'];
        // Connect to the database
        include('db/db_mysql.php');
        
        // list player information
        $playerInfo = array();
        $query = "SELECT * FROM player WHERE id = {$player};";
        $result = mysql_query($query);
        while ($row = mysql_fetch_assoc($result)) {
          $pid = $row['id'];
          $fname = $row['firstName'];
          $lname = $row['lastName'];
          $pic = $row['picture'];
          $bday = $row['birthDate'];
          $sex = $row['sex'];
          $usr = $row['username'];
          $pwd = $row['password'];

          $playerInfo = array('id' => $pid, 
                              'firstName' => $fname, 
                              'lastName' => $lname, 
                              'picture' => $pic, 
                              'sex' => $sex,
                              'birthday' => $bday,
                              'username' => $usr,
                              'password' => $pwd);
        }
        mysql_close($con);

        // If an update action took place
        if(session_is_registered('success')) {
          $success = $_SESSION['success'];
          // if update was successful
          if ($success) {
            // display the success ALERT!
            echo '<div class="alert alert-success fade in">' . 
              '<button type="button" class="close" data-dismiss="alert">&times</button>' . 
              $_SESSION['message'] . '</div>';

            unset($_SESSION['message']);
          }
          else {
            // display the warning / error message ALERT!
            echo '<div class="alert alert-error fade in">' . 
              '<button type="button" class="close" data-dismiss="alert">&times</button>' . 
              '<strong>Warning: </strong>' . $_SESSION['error'] . '</div>';

            unset($_SESSION['error']);
          }
          // clear the action session variables
          unset($_SESSION['success']);
        }
      }
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
            if($playerInfo['picture']) {
              echo '<img class="media-object" style="border-radius:10px;margin-top:20px;" src="img/players/' . $playerInfo['picture'] . '">';
            }
            else {
              echo '<div style="font-size:50px;margin-top:65px;margin-bottom:45px;">' . 
                '<i class="icon-user icon-4x icon-border media-object"></i></div>';
            }
            echo "<h4>Change your profile picture?</h4>";
            include('uploadForm.php');
          ?>
          </div>
        </div>
        <!-- Player Information -->
        <div class="span9">
          <div class="row-fluid">
            <h3 class="span12 pull-left">Your Information</h3>
          </div>
          <div class="row-fluid">
            <table class="span12 table-condensed">
              <thead></thead>
              <tbody>
                <tr>
                  <td class="span4"><strong><span class="pull-right">First name</span></strong></td>
                  <td class="span8"><?php echo $playerInfo['firstName']; ?></td>
                </tr>
                <tr>
                  <th><span class="pull-right">Last name</span></th>
                  <td><?php echo $playerInfo['lastName']; ?></td>
                </tr>
                <tr>
                  <th><span class="pull-right">Sex</span></th>
                  <td><?php echo $playerInfo['sex']; ?></td>
                </tr>
                <tr>
                  <th><span class="pull-right">Birthday</span></th>
                  <td><?php echo '<input type="date" name="birthday" value="' . $playerInfo['birthday'] . '">'; ?></td>
                </tr>
                <tr>
                  <th><span class="pull-right">Username</span></th>
                  <td><?php echo '<input type="text" name="username" value="' . $playerInfo['username'] . '">'; ?></td>
                </tr>
                <tr>
                  <th><span class="pull-right">Password</span></th>
                  <td><?php echo '<input type="password" name="password" value="' . $playerInfo['password'] . '">'; ?></td>
                </tr>
                <tr>
                  <th><span class="pull-right">Confirm password</span></th>
                  <td><?php echo '<input type="password" name="password-confirm" value="">'; ?></td>
                </tr>
                <tr>
                  <td><a class="btn btn-success" href="#">Update</a></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <?php include('footer.php'); ?>
    </div>
    <?php require_once('requiredJS.php'); ?>
  </body>
</html>