<!DOCTYPE html>
<html>
  <head>
  </head>
  <body>
  <?php
    // retrieve login information from user ($_POST)
    $username = $_REQUEST['username'];
    $password = $_REQUEST['password'];

    // // To protect MySQL injection
    $username = stripslashes($username);
    $password = stripslashes($password);
    $username = mysql_real_escape_string($username);
    $password = mysql_real_escape_string($password);

    // connect to the database and see if user exists
    include('db/db_mysql.php');
    $query = 'SELECT id FROM player WHERE username = "' . $username . '" AND password = "' . $password . '";';
    $result = mysql_query($query);

    $pid = 0;
    while ($row = mysql_fetch_assoc($result)) {
      $pid = $row['id'];
    }

    // count the number of results
    $count = mysql_num_rows($result);

    // close the connection to the database
    mysql_close($con);

    // if there is only one result return (they logged in correctly)
    if ($count == 1) {

      session_set_cookie_params(0);
      session_start();
      $_SESSION["username"] = $username;
      $_SESSION["pid"] = $pid;

      // successfully logged in, so go to the player's profile page
      // refresh the profile page and send message that successfully transerred (the 302?)
      header("Cache-Control: no-cache");
      header("Location: playerProfile.php", true, 302);
    }
    else {
      // pass message that error in sign in
      // pop up a message saying invalid log in information?
      header("Cache-Control: no-cache");
      header("Location: index.php");
    }
  ?>
  </body>
</html>