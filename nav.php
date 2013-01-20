<script type="text/javascript">
  function checkSubmit(e) {
    if (e && e.keyCode == 13) {
      document.signin.submit();
    }
  }
</script>
<div class="navbar">
  <div class="navbar-inner">
    <div class="container-fluid" style="font-size:16px;">
      <!-- Logo goes here? -->
      <a class="brand" href="index.php">Game Center</a>
      <ul class="nav" role="navigation">
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
        <ul class="nav pull-right">
        <!-- User options -->
        
        <?php 
      
          // Set up the session parameters
          session_set_cookie_params(0);
          session_start();
    
          // If logged IN, display FirstName with dropdown menu for more options
          if(session_is_registered('pid')) {
            $player = $_SESSION['pid'];
            $username = $_SESSION['username'];

            // if viewing your profile, highlight that tab as active
            if ( $page == "profile") {
              echo '<li class="active dropdown">'; 
            }
            else {
              echo '<li class="dropdown">';
            }

            // echo '<li class="dropdown">';

            // Display dropdown menu to update your profile or log out
            echo '<a href="#" class="navbar-link dropdown-toggle" data-toggle="dropdown">' . 
              '<i class="icon-user"></i> ' . 
              $username . '</a>';
            // include down icon
            echo '<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">' . 
              '<li><a href="playerProfile.php" tabindex="-1">Your profile</a></li>' . 
              '<li><a href="logout.php" tabindex="-1">Sign out</a></li>';
            echo '</ul></li>';
          }
          // If logged OUT, only display button to sign in?
          else {

            // Display button to sign in
            echo '<li><a href="#signInModal" role="button" class="navbar-link" data-toggle="modal">' . 
              '<i class="icon-user"></i> ' . 
              'Sign In</a></li>';
            // drop-down sign in box
            echo '
              <div id="signInModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="signInModalLabel" aria-hidden="true">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times</button>
                  <h3 id="myModalLabel">Sign In or Register</h3>
                </div>
                <div class="modal-body">
                  <form name="signin" class="form-horizontal" action="login.php" method="post">
                    <div class="control-group">
                      <label class="control-label" for="username">Username</label>
                      <div class="controls">
                        <input type="text" id="username" name="username" autofocus placeholder="Username">
                      </div>
                    </div>
                    <div class="control-group">
                      <label class="control-label" for="password">Password</label>
                      <div class="controls">
                        <input type="password" name="password" placeholder="Password" onKeyPress="return checkSubmit(event)">
                      </div>
                    </div>
                    <div class="control-group">
                      <div class="controls">
                        <button type="submit" class="btn btn-primary btn-success">Sign In</button>
                        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                      </div>
                    </div>
                  </form>
                  <hr>
                  <h4>Need an account?</h4>
                  <a class="btn btn-primary offset1" href="newPlayer.php">Register now!</a>
                </div>
              </div>';
          }
        
        ?>
      </ul>
    </div>
  </div>
</div>