<!DOCTYPE html>
<html>
  <head>
  </head>
  <body>
  <?php
    session_start();
    
    // connect to the database
    include('db_mysql_connect.php');

    // retrieve login information from user ($_POST)
    $username = $_REQUEST['username'];
    $password = $_REQUEST['password'];

    // // To protect MySQL injection
    $username = stripslashes($username);
    $password = stripslashes($password);
    $username = mysql_real_escape_string($username);
    $password = mysql_real_escape_string($password);

    // connect to the database and see if user exists
    $query = "SELECT id FROM player WHERE username = {$username} AND password = {$password};";
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

      echo "sucess!";
      // header("location:profile.php");
    }
    else {
      // pop up a message saying invalid log in information
      echo "didn't work :(";
    }

    mysql_close($con);
    
  ?>
  <br>TEST<br>
  </body>
</html>