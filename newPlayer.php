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
    <script type="text/javascript">
      function checkSubmit(e) {
        if (e && e.keyCode == 13) {
          document.register.submit();
        }
      }
    </script>
    <?php
      $page = "profile";
      include('nav.php');
      
      // check for username update error
      if (session_is_registered('username_error')) {
        // display the warning / error message ALERT!
        echo '<div class="alert alert-error fade in">' . 
          '<button type="button" class="close" data-dismiss="alert">&times</button>' . 
          '<strong>Warning: </strong>' . $_SESSION['username_msg'] . '</div>';

        unset($_SESSION['username_error']);
        unset($_SESSION['username_msg']);
      }
      // check for password update error
      if (session_is_registered('confirm_error')) {
        // display the warning / error message ALERT!
        echo '<div class="alert alert-error fade in">' . 
          '<button type="button" class="close" data-dismiss="alert">&times</button>' . 
          '<strong>Warning: </strong>' . $_SESSION['confirm_msg'] . '</div>';

        unset($_SESSION['confirm_error']);
        unset($_SESSION['confirm_msg']);
      }
    ?>

    <div class="container-fluid">
      <!-- Player name -->
      <div class="row-fluid">
        <div class="span11 offset1">
            <h3>Create your new profile</h3>
            <form name="register" class="form-horizontal" action="register.php" method="post">
              <div class="control-group">
                <label class="control-label" for="username">Create a Username</label>
                <div class="controls">
                  <input autofocus type="text" id="username" name="username" placeholder="Username">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="password">Enter Password</label>
                <div class="controls">
                  <input type="password" name="password" placeholder="Password">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="password">Confirm Password</label>
                <div class="controls">
                  <input type="password" name="confirmpassword" placeholder="Confirm Password" onKeyPress="return checkSubmit(event)">
                </div>
              </div>
              <div class="control-group">
                <div class="controls">
                  <button type="submit" class="btn btn-primary">Register</button>
                </div>
              </div>
            </form>
        </div>
    </div>
      <?php include('footer.php'); ?>
    </div>
    <?php require_once('requiredJS.php'); ?>
  </body>
</html>