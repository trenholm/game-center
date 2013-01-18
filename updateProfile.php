<!DOCTYPE html>
<html>
  <head>
  </head>
  <body>
  <?php

    session_set_cookie_params(0);
    session_start();

    // retrieve the player information and remove it from the session
    $pinfo = $_SESSION['playerInfo'];
    unset($_SESSION['playerInfo']);

    // retrieve (potentially) updated information from user ($_POST)
    $fname = $_REQUEST['firstname'];
    $lname = $_REQUEST['lastname'];
    $sex = $_REQUEST['sex'];
    $bday = $_REQUEST['birthday'];
    $usr = $_REQUEST['username'];
    $pwd = $_REQUEST['password'];
    $cnfmpwd = $_REQUEST['confirmpassword'];

    // To protect MySQL injection
    $fname = mysql_real_escape_string(stripslashes($fname));
    $lname = mysql_real_escape_string(stripslashes($lname));
    $sex = mysql_real_escape_string(stripslashes($sex));
    $bday = mysql_real_escape_string(stripslashes($bday));
    $usr = mysql_real_escape_string(stripslashes($usr));
    $pwd = mysql_real_escape_string(stripslashes($pwd));
    $cnfmpwd = mysql_real_escape_string(stripslashes($cnfmpwd));

    // debug
    print_r($pinfo);
    echo "<br>";
    echo "<br>" . $fname . "<br>" . $lname . "<br>" . $sex . "<br>" . $bday . "<br>" . $usr . "<br>" . $pwd . "<br> [" . $cnfmpwd . "]";
    echo "<br>";

    // if a section of the FORM is the same as before or blank, do not change!
    if ($fname === $pinfo['firstName'] || $fname == "") {
      echo "<br> fname same";
    }
    else {
      echo "<br> fname different: " . $fname;
    }
    if ($lname === $pinfo['lastName'] || $lname == "") {
      echo "<br> lname same";
    }
    else {
      echo "<br> lname different: " . $lname;
    }
    if ($sex === $pinfo['sex'] || $sex == "") {
      echo "<br> sex same";
    }
    else {
      echo "<br> sex different: " . $sex;
    }
    if ($bday === $pinfo['birthday'] || $bday == "") {
      echo "<br> bday same";
    }
    else {
      echo "<br> bday different: " . $bday;
    }
    if ($usr === $pinfo['username'] || $usr == "") {
      echo "<br> usr same";
    }
    else {
      echo "<br> usr different: " . $usr;
    }
    if ($pwd === $pinfo['password'] || $pwd == "") {
      echo "<br> pwd same";
    }
    else {
      echo "<br> pwd different: " . $pwd;
    }
    // if ($cnfmpwd === $pinfo['confirmpassword'] || $cnfmpwd == "") {
    //   echo "<br>";
    //   echo "cnfmpwd same";
    // }


    // // connect to the database and see if user exists
    // include('db/db_mysql.php');
    // $query = 'SELECT id FROM player WHERE username = "' . $username . '" AND password = "' . $password . '";';
    // $result = mysql_query($query);

    // $pid = 0;
    // while ($row = mysql_fetch_assoc($result)) {
    //   $pid = $row['id'];
    // }

    // // if there is only one result return (they logged in correctly)
    // $count = mysql_num_rows($result);

    // mysql_close($con);


    // if ($count == 1) {

    //   session_set_cookie_params(0);
    //   session_start();
    //   $_SESSION["username"] = $username;
    //   $_SESSION["password"] = $password;
    //   $_SESSION["pid"] = $pid;

    //   // successfully logged in, so go to the player's profile page
    //   // refresh the profile page and send message that successfully transerred (the 302?)
    //   header("Location: playerProfile.php", true, 302);
    // }
    // else {
    //   // pop up a message saying invalid log in information?
    //   header("Location: index.php");
    // }

  ?>
  </body>
</html>