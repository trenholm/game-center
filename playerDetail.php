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
    <link href="css/font-awesome.min.css" rel="stylesheet">
  </head>
  <body>
    <?php
      $page = "player";
      include('nav.php');
      // Connect to the database
      include('db/db_mysql.php');
      $player = $_GET['pid'];
      
      // default values
      $totalScore = 0;
      $numGamesPlayed = 0;

      // list player information
      $playerInfo = array();
      $query = "SELECT * FROM player WHERE id = {$player};";
      $result = mysql_query($query);
      while ($row = mysql_fetch_assoc($result)) {
        $pid = $row['id'];
        $fname = $row['firstName'];
        $lname = $row['lastName'];
        $pic = $row['picture'];
        $sex = $row['sex'];

        $playerInfo = array('id' => $pid, 
                                  'firstName' => $fname, 
                                  'lastName' => $lname, 
                                  'picture' => $pic, 
                                  'sex' => $sex);
      }
     
      // list the games this player has played
      $games = array();
      $query = "SELECT game.id id, game.name name, score FROM game, scores" . 
        " WHERE game.id = scores.gameId AND scores.playerId = {$player} ORDER BY name ASC;";
      $result = mysql_query($query);
      $numGamesPlayed = mysql_num_rows($result);
      if ($numGamesPlayed > 0) {
        while ($row = mysql_fetch_assoc($result)) {
          $gid = $row['id'];
          $gname = $row['name'];
          $gscore = $row['score'];

          // for each game, grab the achievements the player earned (for that game)
          $achieves = array();
          $subquery = "SELECT A.id id, A.name name, A.points points, E.remark remark, E.dateEarned earned" . 
            " FROM earns E, achievement A" . 
            " WHERE A.id = E.achievementId AND E.playerId = {$player} AND A.gameId = {$gid};";
          $subresult = mysql_query($subquery);
          $numAchieve = mysql_num_rows($subresult);
          while ($row = mysql_fetch_assoc($subresult)) {
            $aid = $row['id'];
            $aname = $row['name'];
            $apoint = $row['points'];
            $aremark = $row['remark'];
            $aearned = $row['earned'];

            $achieves[$aid] = array('name' => $aname, 
                                    'points' => $apoint, 
                                    'remark' => $aremark, 
                                    'dateEarned' => $aearned);
          }

          // sum up the total points earned for this game
          $earnedPoints = 0;
          foreach ($achieves as $key => $value) {
            $earnedPoints += $value['points'];
          }
          // add each game's score to the player's total score
          $totalScore += $earnedPoints;

          // Store all the game information
          $games[$gid] = array('id' => $gid, 
                              'name' => $gname, 
                              'numAchieve' => $numAchieve, 
                              'earnedPoints' => $earnedPoints, 
                              'achievements' => $achieves);
        }
      }
      mysql_close($con);

    ?>
    <div class="container-fluid">
      <!-- Player name -->
      <div class="row-fluid">
        <div class="span12">
          <?php 
            echo "<h1>" . $playerInfo['firstName'] . " " . $playerInfo['lastName'] . "</h1>";
          ?>
        </div>
      </div>
      <!-- Player Photo -->
      <div class="row-fluid">
        <div class="span3">
          <div class="media">
          <?php 
            if($playerInfo['picture']) {
              echo '<img class="media-object" style="border-radius:5px;margin-top:20px;" src="img/players/' . $playerInfo['picture'] . '">';
            }
            else {
              echo '<div style="font-size:50px;margin-top:65px;margin-bottom:45px;">' . 
                '<i class="icon-user icon-4x icon-border media-object"></i></div>';
            }
          ?>
          </div>
        </div>
        <!-- Player Information -->
        <div class="span9">
          <div class="row-fluid">
            <h3 class="span12 pull-left">Player Information</h3>
          </div>
          <div class="row-fluid">
            <table class="span12 table-condensed">
              <thead></thead>
              <tbody>
                <tr>
                  <td class="span4"><strong><span class="pull-right">Name</span></strong></td>
                  <td class="span8"><?php echo $playerInfo['firstName'] . ' ' . $playerInfo['lastName']; ?></td>
                </tr>
                <tr>
                  <th><span class="pull-right">Sex</span></th>
                  <td><?php echo $playerInfo['sex']; ?></td>
                </tr>
                <tr>
                  <th><span class="pull-right">Games Played</span></th>
                  <td><?php echo $numGamesPlayed; ?></td>
                </tr>
                <tr>
                  <th><span class="pull-right">Gamer Score</span></th>
                  <td><?php echo $totalScore; ?></td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="row-fluid">
            <h3 class="span12 pull-left">Achievements Earned</h3>
            <table class="table table-bordered table-striped">
              <caption></caption>
              <thead>
                <!-- <tr><th>Game</th><th>Achievements</th><th>Points</th></tr> -->
              </thead>
              <tbody>
                <?php 
                  if($numGamesPlayed > 0) {

                    foreach ($games as $key => $value) {
                      $pid = $player;
                      $gid = $value['id'];
                      echo '<tr><td class="span4">' . 
                        '<a href="gameDetail.php?gid=' . $value['id'] . '">';
                      if($value['picture']) {
                        echo '<img class="pull-left" height="50px" width="50px" style="border-radius:5px;margin-right:10px;" src="img/games/' . $value['picture'] . '">';
                      }
                      else {
                        echo '<i class="icon-picture icon-3x pull-left" style="margin:0px 10px 0px 0px;"></i>';
                      }

                      echo '<h4>' . $value['name'] . '</h4>' . 
                        '</a>' . 
                        '</td>' . 
                        '<td class="span8" colspan="2">' . 
 
                        // '<div class="accordion-group">' . 
                        // '<div class="accordion-heading">' . 
                        '<div >' . 
                        '<div >' . 
                        '<a class="accordion-toggle" data-toggle="collapse" data-parent="#game' . $pid . '" href="#collapse' . $gid . '">' . 
                        '<h4>' . 
                        $value['numAchieve'] . 
                        ' achievements for ' . $value['earnedPoints'] . ' points' . 
                        ' <i class="icon-chevron-down"></i>' . 
                        '</h4>' . 
                        '</a>' . 
                        '</div>' .
                        '<div id="collapse' . $gid . '" class="accordion-body collapse">' . 
                        '<div class="accordion-inner">';

                        $ach = $value['achievements'];
                        foreach ($ach as $key => $value) {
                          echo '<li><strong>' . 
                            // '<tr id="#"><td></td><td>' . 
                            $value['name'] . '</strong> on ' . 
                            $value['dateEarned'] . ' for '  .
                            // '</td><td>' . 
                            $value['points'] . ' points: <em>"' . 
                              // '</td><td>' . 
                            $value['remark'] . '"</em> <br></li>'
                              // '</td></tr>'
                            ;
                        }

                        echo '</div>' . 
                        '</div>' . 
                        '</div></td></tr>';

                      
                    }
                  }
                  else {
                    echo $playerInfo['firstName'] . " has not played any games yet!<br>";
                  }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <?php include('footer.php'); ?>
    </div>
    <?php require_once('requiredJS.php'); ?>
  </body>
</html>