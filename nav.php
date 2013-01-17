<div class="navbar">
  <div class="navbar-inner">
    <div class="container-fluid" style="font-size:16px;">
      <!-- Logo goes here? -->
      <a class="brand" href="index.php">Game Center</a>
      <ul class="nav">
        <!-- Main page of the Game Center -->
        <li <?php if(!$page) { echo 'class="active"'; } ?> >
          <a href="index.php">Home</a></li>
        <!-- List of all games -->
        <li <?php if( $page == "game") { echo 'class="active"'; } ?> >
          <a href="gameList.php">Games</a></li>
        <!-- List of all players -->
        <li <?php if( $page == "player") { echo 'class="active"'; } ?> >
          <a href="playerList.php">Players</a></li>
      </ul>
      <p class="navbar-text pull-right">
        <?php 
      
 

        // start the browser session
        // session_start();

        // If logged IN, display FirstName with dropdown menu for more options
        if(session_is_registered('pid')) {
          $player = $_SESSION['pid'];

          echo "PID: " . $player;
          $username = "JFK";
            // The "more options" include update your information and logout

          // <!-- Have as a dropdown menu? Options to view/edit your account/profile as well as log-out -->
          // <!-- Logged in as <a href="#" class="navbar-link">Username</a> -->

          /*
          // connect to the database
          include('db_mysql_connect.php');
          $myInfo = array();
          $query = "SELECT * FROM player";
          $result = mysql_query($query);
          $count = mysql_num_rows($result);
          print_r($myInfo);


          
          // retrieve login information from user ($_POST)
          // $username = $_POST['username'];
          // $password = $_POST['password'];

          // // To protect MySQL injection
          // $username = stripslashes($username);
          // $password = stripslashes($password);
          // $username = mysql_real_escape_string($username);
          // $password = mysql_real_escape_string($password);

          // connect to the database and see if user exists
          // $query = "SELECT id FROM player WHERE username = {$username} AND password = {$password};";
          $query = "SELECT * FROM player WHERE id = {$player};";
          $result = mysql_query($query);
          $count = mysql_num_rows($result);

          $pid = "";
          $username = "";
          $password = "";
          while ($row = mysql_fetch_assoc($result)) {
            $pid = $row['id'];
            $username = $row['username'];
            $password = $row['password'];
          }

          echo " count= " . $count;
          if ($count == 1) {
            $_SESSION["username"] = $username;
            $_SESSION["password"] = $password;
            $_SESSION["pid"] = $pid;
            header("location:profile.php");
          }
          else {
            // pop up a message saying invalid log in information
          }


          mysql_close($con);

          */

          // Display dropdown menu to update your profile or log out
          echo '<a href="#" class="navbar-link">' . $username . '</a>';
        }
        // If logged OUT, only display button to log in?
        else {

          // Display button to sign in
          echo '<a href="#signInModal" role="button" class="navbar-link" data-toggle="modal">Sign In</a>';

          echo '
          <div id="signInModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="signInModalLabel" aria-hidden="true">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">Register or Sign In</h3>
          </div>
          <div class="modal-body">
            <form class="form-horizontal" action="login.php" method="get">
              <div class="control-group">
                <label class="control-label" for="username">Username</label>
                <div class="controls">
                  <input type="text" id="username" placeholder="Username">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="password">Password</label>
                <div class="controls">
                  <input type="password" id="password" placeholder="Password">
                </div>
              </div>
              <div class="control-group">
                <div class="controls">
                  <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                  <button type="submit" class="btn btn-primary">Sign In</button>
                </div>
              </div>
            </form>

          </div>
        </div>';
        }

        ?>
      </p>
    </div>
  </div>
</div>