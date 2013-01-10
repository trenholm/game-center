<!DOCTYPE html>
<html>
  <head>
    <title>Game Center</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Game Center web application for IGS520M">
    <meta name="author" content="Cody Clerke, Jamie McKee-Scott, Ryan Trenholm">
    <!-- Styles -->
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="./css/font-awesome.min.css" rel="stylesheet">
  </head>
  <body>
    <?php 
      $page = "game";
      include('nav.php');
      // Connect to the database
      include('db_mysql.php');
      $gid = $_GET['gid'];
      
      // Retrieve information about currently selected game
      $gameInfo = array();
      $query = "SELECT * FROM game WHERE id = {$gid};";
      $result = mysql_query($query);
      while ($row = mysql_fetch_assoc($result)) {
        $gameInfo['id'] = $row['id'];
        $gameInfo['name'] = $row['name'];
        $gameInfo['rating'] = $row['rating'];
        $gameInfo['publisher'] = $row['publisher'];
        $gameInfo['releaseDate'] = $row['releaseDate'];
        // photo & other "extras"
      }
      
      // Retrieve the total number of players who play this game
      // CURRENTLY INCORRECT! Need to return the number of PLAYERS who have played this game!!
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
      $totalAchieveEarned = 0;
      $query = "SELECT COUNT(*) AS total FROM achievement, earns WHERE " . 
        "achievement.id = earns.achievementId AND gameId = {$gid};";
      $result = mysql_query($query);
      while ($row = mysql_fetch_assoc($result)) {
        $totalAchieveEarned = $row['total'];
      }

      // Retrieve list of top-scoring players
      $players = array();
      $query = "SELECT playerId, firstName, lastName, score FROM scores, player " . 
        "WHERE scores.playerId = player.id AND scores.gameId = " . $gid . " LIMIT 10";
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
          <!-- Photo(s) of the game/gameplay
          Number of players who have played this game
          Number/List of achievements
          Total number of achievements earned by players?
          Top 10 list of highest scoring players! (click on player name to go to PlayerDetail)

          BONUS: "Play Now" button that "allows" the user to "play" the game and recieve a score, 
          along with "earning" some achievements?
          -->
        <div class="span9">
          <div class="row-fluid">
            <!-- Game Photo -->
            <div class="span5">
              <p><div class="well well-large" style="height:400px;">PHOTO HERE</div></p>
              <p><a class="btn btn-primary btn-block btn-large disabled" href="#">Play Now!</a></p>
            </div>
            <div class="span7">
              <!-- Game Info -->
              <h3 class="span12 pull-left">Game Information</h3>
              <table class="table-condensed span12">
                <tbody>
                  <tr>
                    <th class="span5"><span class="pull-right">Publisher</span></th>
                    <td class="span7"><span class="pull-left"><?php echo $gameInfo["publisher"]; ?></span></td>
                  </tr>
                  <tr>
                    <th class="span5"><span class="pull-right">ESRB Rating</span></th>
                    <td class="span7"><?php echo $gameInfo["rating"]; ?></td>
                  </tr>
                  <tr>
                    <th class="span5"><span class="pull-right">Release Date</span></th>
                    <td class="span7"><?php echo $gameInfo["releaseDate"]; ?></td>
                  </tr>
                  <tr>
                    <th class="span5"><span class="pull-right">Achievements</span></th>
                    <td class="span7"><?php echo $numAchieve; ?></td>
                  </tr>
                  <tr>
                    <th class="span5"><span class="pull-right" align="right">Achievements Earned</span></th>
                    <td class="span7"><?php echo $totalAchieveEarned; ?></td>
                  </tr>
                  <tr>
                    <th class="span5"><span class="pull-right">Total Players</span></th>
                    <td class="span7"><?php echo $numPlayers; ?></td>
                  </tr>
                  <tr>
                    <th class="span5"></th>
                    <td class="span7"></td>
                  </tr>
                </tbody>
              </table>
              <!-- Achievements -->
              <h3 class="span12 pull-left">Achievements</h3>
              <table class="table table-bordered table-striped span12">
                <caption></caption>
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
            </div><!--/row-->
          </div><!--/span-->
        </div><!--/game information-->
        <!--Top 10 Scoring Players-->
        <div class="span3">
          <h3 class="pull-left span12">Top 10 Players</h3>
          <table class="table">
            <thead>
              <!-- Include a "RANK" as well? -->
              <tr><th>Score</th><th>Player name</th></tr>
            </thead>
            <tbody>
              <?php 
                foreach ($players as $key => $value) {
                  echo '<tr><td>' . $value['score'] . '</td><td>
                    <a href="./playerDetail.php?pid=' . $key . '">' . 
                    $value['name'] . '</a></td></tr>';
                }
              ?>
            </tbody>
          </table>
        </div><!--/top 10 players-->
      </div><!--/row-->
      <?php include('footer.php'); ?>
    </div><!--/container-->

    <?php require_once('requiredJS.php'); ?>
  </body>
</html>