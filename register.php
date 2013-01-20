<!DOCTYPE html>
<html>
  <head>
  </head>
  <body>
  <?php
    // start session
    session_set_cookie_params(0);
    session_start();

    // retrieve new user information
    $username = $_REQUEST['username'];
    $password = $_REQUEST['password'];
    $cnfmpwd = $_REQUEST['confirmpassword'];

    // To protect MySQL injection
    $username = mysql_real_escape_string(stripslashes($username));
    $password = mysql_real_escape_string(stripslashes($password));
    $cnfmpwd = mysql_real_escape_string(stripslashes($cnfmpwd));

    echo "<br>" . $username;
    echo "<br>" . $password;
    echo "<br>" . $cnfmpwd;

    // check if username already exists in the DB
    include('db/db_mysql.php');
    $query = 'SELECT id FROM player WHERE username = "' . $username . '";';
    $result = mysql_query($query);
    while ($row = mysql_fetch_assoc($result)) {
      $pid = $row['id'];
    }
    $count = mysql_num_rows($result);
    mysql_close($con);

    // if there are any results, then there is a conflict!
    echo $count . " results for the username: " . $username . "<br>";
    if ($count >= 1) {
        // stop and warn the user that username already taken (redirect back to new player page)
        echo "<br> username already taken, please try again";

        echo "<br> warning: conflicting username: " . $username;
        $_SESSION['username_error'] = true;
        $_SESSION['username_msg'] = "That <em>username</em> already exists, please try a changing it to a different one.";
        header("Cache-Control: no-cache");
        header('Location: newPlayer.php', true, 302);
    }
    else {
        // if no conflict, then check for password confirmation

        // check for any changes to the player's password
        if ($password !== "" && $password === $cnfmpwd) {
            // continue with the insert statement
            echo "<br>" . $username;
            echo "<br>" . $password;
            echo "<br>" . $cnfmpwd;

            include('db/db_mysql.php');

            // execute the insert statement
            $query = 'INSERT INTO player (username, password) VALUES ("'. $username . '", "' . $password . '");';
            $result = mysql_query($query);
            echo $query;

            echo "<br> successfully registered user, redirecting to profile page";

            // confirm that the user is now in the database
            $query = 'SELECT id, username FROM player WHERE username = "' . $username . '" AND password = "' . $password . '";';
            $result = mysql_query($query);

            $pid = 0;
            while ($row = mysql_fetch_assoc($result)) {
              $pid = $row['id'];
              $username = $row['username'];
            }

            // close the connection to the database
            mysql_close($con);
            
            // update the session variables
            $_SESSION["username"] = $username;
            $_SESSION["pid"] = $pid;

            echo "You have successfully registered.";

            // if successfully registered user, redirect to the player profile to update their information?
            $_SESSION['success'] = true;
            $_SESSION['message'] = "Congratulations, you have successfully registered. Update your information now!";
            header("Cache-Control: no-cache");
            header('Location: playerProfile.php', true, 302);
            
            
        }
        else {
            echo "please confirm your new password";
            // password not changed, please try again and confirm your new password
            $_SESSION['confirm_error'] = true;
            $_SESSION['confirm_msg'] = "You need to confirm your new <em>password</em> was not changed, please try again.";
            header("Cache-Control: no-cache");
            header('Location: newPlayer.php', true, 302);
        }
    }
  ?>
  </body>
</html>