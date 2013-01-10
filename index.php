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
      unset($page);
      include('nav.php');
      // Connect to the database
      include('db_mysql.php');
      
      // Retrieve the list of games (including thumbnail image?) (order by highest scores earned)
      $games = array();
      $query = "SELECT id, name FROM game ORDER BY name ASC LIMIT 3;";
      $result = mysql_query($query);
      while ($row = mysql_fetch_assoc($result)) {
        $gid = $row['id'];
        $name = $row['name'];
        
        $games[$gid] = array('id' => $gid, 'name' => $name);
      }
      
      // Retrieve the list of players (order by highest score first?)
      $players = array();
      $query = "SELECT * FROM player P, scores S WHERE P.id = S.playerId ORDER BY S.score, P.firstName ASC LIMIT 3;";
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
          <div class="hero-unit" style="border-radius:20px;">
            <h1>FEATURED GAME!</h1>
            <p>This is a template for a simple marketing or informational website. It includes a large callout called the hero unit and three supporting pieces of content. Use it as a starting point to create something more unique.</p>
            <p><a class="btn btn-primary btn-large" href="./gameDetail.php?gid=1">Learn more &raquo;</a></p>
          </div>
        </div>
      </div>
      <!-- CAROUSEL TO SHOW TOP GAMES? -->
      <!-- <div class="row-fluid">
        <div class="span12">
          <div id="myCarousel" class="carousel slide">
              <div class="carousel-inner">
                <div class="active item">
                  <div style="height:200px;">
                    <h1>This little piggy just wanted world peace...</h1>
                  </div>
                  <div class="carousel-caption">
                    <h4>Pacifist Pigs</h4>
                    <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                    <p><a class="btn btn-primary btn-large" href="./gameDetail.php?gid=1">Learn more &raquo;</a></p>
                  </div>
                </div>
                <div class="item">
                  <div style="height:200px;">
                    <h1>Second game</h1>
                  </div>
                  <div class="carousel-caption">
                    <h4>Name</h4>
                    <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                    <p><a class="btn btn-primary btn-large" href="./gameDetail.php?gid=1">Learn more &raquo;</a></p>
                  </div>
                </div>
                <div class="item">
                  <div style="height:200px;">
                    <h1>Third game</h1>
                  </div>
                  <div class="carousel-caption"><h4>Name</h4></div>
                </div>
              </div>
              <a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
              <a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
            </div>
        </div>
      </div> -->
      <!-- Sub-Articles? -->
      <div class="row-fluid">
        <div class="span6">
          <table class="table table-bordered table-striped">
            <thead>
              <tr><td>
              <span class="pull-left">
                <h2>TOP GAMES</h2>
                <a class="btn" href="./gameList.php">View more games &raquo;</a>
              </span>
              </td></tr>
            </thead>
            <tbody>
              <?php 
              foreach ($games as $key => $value) {
                echo '<tr><td>' . 
                  '<a href="./gameDetail.php?gid=' . $value['id'] . '">' . 
                  // <img style="border-radius:5px; src="">
                  '<div class="pull-left well well-small" style="width:20px;margin:0px 10px 0px 0px;"></div>' .
                  '<h4>' . $value['name'] . '</h4></a></td>' . 
                  // '<td>' . $value['rating'] . '</td>' . 
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
                <h2>TOP PLAYERS</h2>
                <a class="btn" href="./playerList.php">See more players &raquo;</a>
              </td></tr>
            </thead>
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
                      '</tr>' . "\n";
                  }
                ?>

              <?php 
                // foreach ($players as $key => $value) {
                //   echo '<tr><td>' . 
                //     '<a href="./playerDetail.php?pid=' . $value['id'] .'">' . 
                //     // <img style="border-radius:5px; src="">
                //     '<div class="pull-left well well-small" style="width:20px;margin:0px 10px 0px 0px;"></div>' .
                //     '<h4>' . $value['firstName'] . ' ' . $value['lastName'] . '</h4></a></td></tr>' . "\n";
                // }
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