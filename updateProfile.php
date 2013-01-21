<!DOCTYPE html>
<html>
  <head>
  </head>
  <body>
  <?php

    session_set_cookie_params(0);
    session_start();

    // player id
    $pid = $_SESSION['pid'];

    // retrieve the player information and remove it from the session
    $pinfo = $_SESSION['playerInfo'];

    // retrieve (potentially) updated information from user ($_POST)
    $fname = $_REQUEST['firstname'];
    $lname = $_REQUEST['lastname'];
    $sex = $_REQUEST['sex'];
    $bday = $_REQUEST['birthday'];
    $username = $_REQUEST['username'];
    $password = $_REQUEST['password'];
    $cnfmpwd = $_REQUEST['confirmpassword'];

    // To protect MySQL injection
    $fname = mysql_real_escape_string(stripslashes($fname));
    $lname = mysql_real_escape_string(stripslashes($lname));
    $sex = mysql_real_escape_string(stripslashes($sex));
    $bday = mysql_real_escape_string(stripslashes($bday));
    $username = mysql_real_escape_string(stripslashes($username));
    $password = mysql_real_escape_string(stripslashes($password));
    $cnfmpwd = mysql_real_escape_string(stripslashes($cnfmpwd));

    // if any section of the FORM is the same as before or blank, do not change!
    // collect the required update statements
    $updateStmts = array();

    // Check for any changes to the player's first name
    if ($fname !== $pinfo['firstName'] && $fname !== "") {
      $updateStmts['name'] = 'UPDATE player SET firstName = "' . $fname . '" WHERE id = ' . $pid . ';';
    }
    // check for any changes to the player's last name
    if ($lname !== $pinfo['lastName'] && $lname !== "") {
      $updateStmts['surname'] = 'UPDATE player SET lastName = "' . $lname . '" WHERE id = ' . $pid . ';';
    }
    // check for any changes to the player's sex
    if ($sex !== $pinfo['sex'] && $sex !== "") {
      $updateStmts['sex'] = 'UPDATE player SET sex = "' . $sex . '" WHERE id = ' . $pid . ';';
    }
    // check for any changes to the player's birthdate
    if ($bday !== $pinfo['birthday'] && $bday !== "") {
      $updateStmts['birthday'] = 'UPDATE player SET birthDate = "' . $bday . '" WHERE id = ' . $pid . ';';
    }
    // check for any changes to the player's username
    if ($username !== $pinfo['username'] && $username !== "") {
        // before updating username, make sure the new one does not exist already in the DB
        include('db/db_mysql.php');
        $query = 'SELECT id FROM player WHERE username = "' . $username . '";';
        $result = mysql_query($query);
        while ($row = mysql_fetch_assoc($result)) {
          $pid = $row['id'];
        }
        $count = mysql_num_rows($result);
        mysql_close($con);

        echo $count . " results for the username: " . $username . "<br>";

        // if there are any results, then there is a conflict!
        if ($count >= 1) {
            echo "warning: conflicting username: " . $username;
            $_SESSION['username_error'] = true;
            $_SESSION['username_msg'] = "That <em>username</em> already exists, please try a changing it to a different one."; 
        }
        else {
            echo "no conflicting usernames exist";
            $updateStmts['username'] = 'UPDATE player SET username = "' . $username . '" WHERE id = ' . $pid . ';';
        }

    }
    // check for any changes to the player's password
    if ($password !== $pinfo['password'] && $password !== "") {
      // if they are changing their password, make sure that they have confirmed the new password correctly
      if ($password === $cnfmpwd) {
        // echo "<br> new password confirmed (and will be changed)";
        $updateStmts['password'] = 'UPDATE player SET password = "' . $password . '" WHERE id = ' . $pid . ';';
      }
      else {
        echo "please confirm your new password";
        // password not changed, please try again and confirm your new password
        $_SESSION['confirm_error'] = true;
        $_SESSION['confirm_msg'] = "Your <em>password</em> was not changed, please try again and confirm your new password.";
      }
    }

    // if no changes are going to be made to the player's profile
    if (empty($updateStmts)) {
        echo "No changes were made to your profile.";
        // return to playerProfile with message "no changes made"
        $_SESSION['success'] = false;
        $_SESSION['error'] = "No changes were made to your profile.";
        // REPLACE => 'TRUE', CODE: 304 => 'NOT MODIFIED'
        header("Cache-Control: no-cache");
        header('Location: playerProfile.php', true, 302);
    }
    // make the changes to the player's profile
    else {
        // create a list of the attributes that are being updated
        $attributes = "";

        foreach ($updateStmts as $key => $value) {
            $attributes .= $key . ", ";
            // execute the update statements in the DB
            echo $value . "<br>";
            include('db/db_mysql.php');
            $query = $value;
            $result = mysql_query($query);
            mysql_close($con);

            // update session variable for username if it has been changed
            if ($key === "username") {
                $_SESSION['username'] = $username;
            }
        }

        echo "Your attributes have been successfully updated.";

        // pass the message that update was successful
        $_SESSION['success'] = true;
        $_SESSION['message'] = "Your <em>" . substr($attributes, 0, -2) . "</em> have been successfully updated.";
        header("Cache-Control: no-cache");
        header('Location: playerProfile.php', true, 302);
    }
  ?>
  </body>
</html>