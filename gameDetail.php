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
      $page = "game";
      include('nav.php');
      // Connect to the database
      include('db/db_mysql.php');
      $gid = $_GET['gid'];
      
      // Retrieve information about currently selected game
      $gameInfo = array();
      $query = "SELECT * FROM game WHERE id = {$gid};";
      $result = mysql_query($query);
      while ($row = mysql_fetch_assoc($result)) {
        $gameInfo['id'] = $row['id'];
        $gameInfo['name'] = $row['name'];
        $gameInfo['rating'] = $row['rating'];
        $gameInfo['picture'] = $row['picture'];
        $gameInfo['publisher'] = $row['publisher'];
        $gameInfo['releaseDate'] = $row['releaseDate'];
      }
      
      // Retrieve the total number of players who play this game
      $numPlayers = 0;
      $query = "SELECT COUNT(*) AS total FROM scores WHERE gameId = {$gid};";
      $result = mysql_query($query);
      while ($row = mysql_fetch_assoc($result)) {
        $numPlayers = $row['total'];
      }

      // Retrieve the list of achievements
      $achievements = array();
      $query = "SELECT * FROM achievement WHERE gameId = {$gid};";
      $result = mysql_query($query);
      while ($row = mysql_fetch_assoc($result)) {
        $aid = $row['id'];
        $aname = $row['name'];
        $adesc = $row['description'];
        $apoint = $row['points'];

        $achievements[$aid] = array('name' => $aname, 'description' => $adesc, 'points' => $apoint);
      }
      $numAchieve = mysql_num_rows($result);

      // Retrieve the total number of achievements earned by all players
      $achieveEarned = 0;
      $query = "SELECT COUNT(*) AS total FROM achievement, earns WHERE " . 
        "achievement.id = earns.achievementId AND gameId = {$gid};";
      $result = mysql_query($query);
      while ($row = mysql_fetch_assoc($result)) {
        $achieveEarned = $row['total'];
      }

      // Retrieve list of top-scoring players
      $players = array();
      $query = "SELECT playerId, firstName, lastName, score FROM scores, player " . 
        "WHERE scores.playerId = player.id AND scores.gameId = " . $gid . " ORDER BY score DESC, firstName ASC LIMIT 10";
      $result = mysql_query($query);
      while ($row = mysql_fetch_assoc($result)) {
        $pid = $row['playerId'];
        $name = $row['firstName'];
        $name .= " " . $row['lastName'];
        $score = $row['score'];

        $players[$pid] = array('name' => $name, 'score' => $score);
      }
      mysql_close($con);
    ?>
    <div class="container-fluid">
      <!-- Game Title -->
      <div class="row-fluid">
        <div class="span12">
          <?php 
            echo '<h1>' . $gameInfo["name"] . '</h1>';
          ?>
        </div>
      </div><!--/game title-->
      <!--Game Information-->
      <div class="row-fluid">
        <div class="span9">
          <div class="row-fluid">
            <!-- Game Photo -->
            <div class="span5">
              <?php
                if($gameInfo['picture']) {
                  echo '<img style="border-radius:10px;margin-top:20px;margin-bottom:45px;" src="img/games/' . $gameInfo['picture'] . '">';
                }
                else {
                  echo '<div style="font-size:50px;margin-top:65px;margin-bottom:45px;">' . 
                    '<i class="icon-picture icon-4x icon-border" style="background-color:#EEE;"></i></div>';
                }
              ?>
              <!-- Play the game! -->
              <?php include('playGame.php'); ?>
            </div><!--/game photo-->
            <div class="span7">
              <!-- Game Info -->
              <div class="row-fluid">
                <h3 class="pull-left">Game Information</h3>
              </div>
              <div class="row-fluid">
                <table class="span12 table-condensed">
                  <thead></thead>
                  <tbody>
                    <tr>
                      <th><span class="pull-right">Publisher</span></th>
                      <td><?php echo $gameInfo["publisher"]; ?></td>
                    </tr>
                    <tr>
                      <th><span class="pull-right">ESRB Rating</span></th>
                      <td><?php echo $gameInfo["rating"]; ?></td>
                    </tr>
                    <tr>
                      <th><span class="pull-right">Release Date</span></th>
                      <td><?php echo $gameInfo["releaseDate"]; ?></td>
                    </tr>
                    <tr>
                      <th><span class="pull-right">Achievements</span></th>
                      <td><?php echo $numAchieve; ?></td>
                    </tr>
                    <tr>
                      <th><span class="pull-right">Number of Players</span></th>
                      <td><?php echo $numPlayers; ?></td>
                    </tr>
                    <tr>
                      <th><span class="pull-right">Achievements Earned</span></th>
                      <td><?php echo $achieveEarned; ?></td>
                    </tr>
                  </tbody>
                </table>
              </div><!--/stats-->
              <!-- Achievements -->
              <div class="row-fluid">
                <h3 class="pull-left">Achievements</h3>
              </div>
              <div class="row-fluid">
                <table class="table table-bordered table-striped">
                  <thead>
                    <tr><th>Name</th><th>Description</th><th>Points</th></tr>
                  </thead>
                  <tbody>
                    <?php
                      foreach ($achievements as $key => $value) {
                        echo '<tr><td>' . $value['name'] . '</td><td><em>' . 
                          $value['description'] . '</em></td><td>' . 
                          $value['points'] . '</td></tr>' . "\n";
                      }
                    ?>
                  </tbody>
                </table>
              </div><!--/achievements-->
            </div>
          </div>
        </div><!--/game information-->
        <!--Top 10 Scoring Players-->
        <div class="span3">
          <div class="row-fluid">
            <div class="span12">
              <h3 class="pull-left span12">Top 10 Players</h3>
            </div>
          </div>
          <div class="row-fluid">
            <div class="span12">
              <table class="table">
                <thead>
                  <!-- Include a "RANK" as well? -->
                  <tr><th>Score</th><th>Player name</th></tr>
                </thead>
                <tbody>
                  <?php 
                    foreach ($players as $key => $value) {
                      echo '<tr><td>' . $value['score'] . '</td><td>
                        <a href="playerDetail.php?pid=' . $key . '">' . 
                        $value['name'] . '</a></td></tr>';
                    }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div><!--/top 10 players-->
      </div><!--/row-->
      <?php include('footer.php'); ?>
    </div><!--/container-->

    <?php require_once('requiredJS.php'); ?>
  </body>
</html>