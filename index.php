<!DOCTYPE html>
<html>
  <head>
    <title>Game Center</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Game Center web application for IGS520M">
    <meta name="author" content="Cody Clerke, Jamie McKee-Scott, Ryan Trenholm">
    <!-- Styles -->
    <link rel="shortcut icon apple-touch-icon" href="img/pig.png" />
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="css/font-awesome.min.css" rel="stylesheet">
  </head>
  <body>
    <?php 
      unset($page);
      include('nav.php');
      // Connect to the database
      include('db/db_mysql.php');
      
      // Retrieve the list of games (including thumbnail image?) (order by highest scores earned)
      $games = array();
      $query = "SELECT id, name, SUM(score) score, picture FROM game, scores" . 
        " WHERE id = gameId GROUP BY id ORDER BY score DESC, name ASC LIMIT 3;";
      $result = mysql_query($query);
      while ($row = mysql_fetch_assoc($result)) {
        $gid = $row['id'];
        $name = $row['name'];
        $pic = $row['picture'];
        
        $games[$gid] = array('id' => $gid, 'name' => $name, 'picture' => $pic);
      }
      
      // Retrieve the list of players (order by highest score first?)
      $players = array();
      $query = "SELECT id, firstName, lastName, picture, SUM(score) totalScore FROM player, scores" . 
        " WHERE id = playerId GROUP BY id ORDER BY totalScore DESC, firstName ASC LIMIT 3;";
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
      <!-- FEATURED GAME ROW / HERO UNIT -->
      <div class="row-fluid">
        <div class="span12">
          <img class="pull-right" height="250" width="250" style="border-radius:5px;margin-right:20px;margin-top:20px;" src="img/pig.png">
          <!-- <div class="hero-unit hero" style="border-radius:20px;"> -->
          <div class="hero-unit hero" style="border-radius:20px;background-image:url(img/vortex-light.jpg);background-position:center;"> 
            <h1 style="text-shadow:2px 2px #5BC0DE;">PACIFIST PIGS!</h1>
            <p>This little piggy just wanted world peace...</p>
            <p><a class="btn btn-primary btn-large" href="gameDetail.php?gid=1">Learn more &raquo;</a></p>
          </div>
        </div>
      </div>
      <!-- Sub-Articles? -->
      <div class="row-fluid">
        <div class="span6">
          <table class="table table-bordered table-striped">
            <thead>
              <tr class="error"><td>
                <h2>Top Games</h2>
                <a class="btn btn-info" href="gameList.php">View more games &raquo;</a>
              </td></tr>
            </thead>
            <tbody>
              <?php 
              foreach ($games as $key => $value) {
                echo '<tr><td>' . 
                  '<a href="gameDetail.php?gid=' . $value['id'] . '">';
                if($value['picture']) {
                  echo '<img class="pull-left" height="50px" width="50px" style="border-radius:5px;margin-right:10px;" src="img/games/' . $value['picture'] . '">';
                }
                else {
                  echo '<i class="icon-picture icon-3x pull-left" style="margin:0px 10px 0px 0px;"></i>';
                }
                echo 
                  '<h4>' . $value['name'] . '</h4></a></td>' . 
                  '</tr>' . "\n";
              }
            ?>
            </tbody>
          </table>
        </div><!--/span-->
        <div class="span6">
          <table class="table table-bordered table-striped">
            <thead>
              <tr><td>
                <h2>Top Players</h2>
                <a class="btn btn-info" href="playerList.php">See more players &raquo;</a>
              </td></tr>
            </thead>
            <tbody>
              <?php 
                foreach ($players as $key => $value) {
                  echo '<tr><td>' . 
                    '<a href="playerDetail.php?pid=' . $value['id'] . '">';
                  if($value['picture']) {
                    echo '<img class="pull-left" height="50px" width="50px" style="border-radius:5px;margin-right:10px;" src="img/players/' . $value['picture'] . '">';
                  }
                  else {
                    echo '<i class="icon-user icon-3x icon-border pull-left" style="padding:2px 7px 2px 7px;margin:0px 10px 0px 0px;"></i>';
                  }
                  echo  '<h4>' . $value['firstName'] . ' ' . $value['lastName'] . '</h4></a></td>' .  
                    '</tr>' . "\n";
                }
              ?>
            </tbody>
          </table>
        </div><!--/span-->
      </div><!--/row-->
      <?php include('footer.php'); ?>
    </div>
    <?php require_once('requiredJS.php'); ?>
  </body>
</html>