<!DOCTYPE html>
<html>
  <head>
    <title>Game Center</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Game Center web application for IGS520M">
    <meta name="author" content="Cody Clerke, Jamie McKee-Scott, Ryan Trenholm">
    <!-- Styles -->
    <link href="./css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="./css/font-awesome.min.css" rel="stylesheet">
  </head>
  <body>
    <?php
      $page = "player";
      include('nav.php');
      // Connect to the database
      include('db_mysql.php');
      $searchParam = mysql_real_escape_string($_GET['name']);
         
      // list player information
      $players = array();
      $query = "SELECT * FROM player"; 
      if($searchParam) {
        $query .= " WHERE firstName LIKE '%" . $searchParam . "%' OR lastName LIKE '%" . $searchParam . "%'";
      }
      $query .= " ORDER BY firstName ASC;";
      $result = mysql_query($query);
      while ($row = mysql_fetch_assoc($result)) {
        $pid = $row['id'];
        $fname = $row['firstName'];
        $lname = $row['lastName'];
        $pic = $row['picture'];

        $players[$pid] = array('id' => $pid, 'firstName' => $fname, 'lastName' => $lname, 'picture' => $pic);
      }
      mysql_close($con);
    ?>

    <div class="container-fluid">
      <div class="row-fluid">
        <!-- Search bar -->
        <div class="span12">
          <form class="form-search" action="playerList.php" method="get">
            <div class="input-append span12">
              <input type="text" class="span11 search-query" name="name" placeholder="">
              <button type="submit" class="btn"><i class="icon-search"></i> Search</button>
            </div>
          </form>
        </div>
      </div>
      <div class="row-fluid">
        <div class="span12">
          <br>
          <table class="table table-striped table-hover">
              <!-- <caption>List of available games and their ESRB rating</caption> -->
              <!-- <thead>
                <tr><th>Name</th></tr>
              </thead> -->
              <tbody>
                <?php 
                  foreach ($players as $key => $value) {
                    echo '<tr><td>' . 
                      '<a href="./playerDetail.php?pid=' . $value['id'] . '">';
                    if($value['picture']) {
                      echo '<img class="pull-left" height="50px" width="50px" style="border-radius:5px;margin:0px 10px 0px 0px;" src="./img/players/' . $value['picture'] . '">';
                    }
                    else {
                      echo '<i class="icon-user icon-3x icon-border pull-left" style="padding:2px 7px 2px 7px;margin:0px 10px 0px 0px;"></i>';
                    }
                    echo  '<h4>' . $value['firstName'] . ' ' . $value['lastName'] . '</h4></a></td>' . 
                      // '<td>' . $value['rating'] . '</td>' . 
                      '</tr>' . "\n";
                  }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      <?php include('footer.php'); ?>
    </div>
    <?php require_once('requiredJS.php'); ?>
  </body>
</html>