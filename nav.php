<div class="navbar">
  <div class="navbar-inner">
    <div class="container-fluid">
      <!-- Logo goes here? -->
      <a class="brand" href="index.php">Game Center</a>
      <ul class="nav">
        <!-- Main page of the Game Center -->
        <li <?php if(!$page) { echo 'class="active"'; } ?> >
          <a href="./index.php">Home</a></li>
        <!-- List of all games -->
        <li <?php if( $page == "game") { echo 'class="active"'; } ?> >
          <a href="./gameList.php">Games</a></li>
        <!-- List of all players -->
        <li <?php if( $page == "player") { echo 'class="active"'; } ?> >
          <a href="./playerList.php">Players</a></li>
      </ul>
      <p class="navbar-text pull-right">
        <?php 
          // If logged IN, display FirstName with dropdown menu for more options
          // The "more options" include update your information and logout

          // If logged OUT, only display button to log in?
        ?>
        <!-- Have as a dropdown menu? Options to view/edit your account/profile as well as log-out -->
        <!-- Logged in as <a href="#" class="navbar-link">Username</a> -->
        <a href="#" class="navbar-link">Sign in</a>
      </p>
    </div>
  </div>
</div>