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
      $searchParam = mysql_real_escape_string($_GET['search']);

      $games = array();
      $query = "SELECT * FROM game";
      if($searchParam) {
        $query .= ' WHERE name LIKE "%' . $searchParam . '%"';
      }
      $query .= " ORDER BY name ASC;";
      $result = mysql_query($query);
      while ($row = mysql_fetch_assoc($result)) {
        $gid = $row['id'];
        $gname = $row['name'];
        $grate = $row['rating'];
        $pic = $row['picture'];

        $games[$gid] = array('id' => $gid, 'name' => $gname, 'rating' => $grate, 'picture' => $pic);
      }
      
      mysql_close($con);
    ?>
    <div class="container-fluid">
      <div class="row-fluid">
        <!-- Search bar -->
        <div class="span12">
          <form class="form-search" name="search-form" action="gameList.php" method="get">
            <div class="input-append span12"> 
              <?php 
                include('db/db_mysql.php');
                $gameNames = array();
                $query = "SELECT name FROM game ORDER BY name ASC;";
                $result = mysql_query($query);
                while ($row = mysql_fetch_assoc($result)) {
                  $gameNames[] = $row['name'];
                }
                mysql_close($con);
                echo '<input type="text" class="span11 search-query" name="search" placeholder="" autocomplete="off" ' . 
                  ' data-provide="typeahead" data-source="' . '[&quot;' . implode('&quot;,&quot;', $gameNames) . '&quot;]' . '" >';  
                ?>
              <!-- <input type="text" class="span11 search-query" name="search" placeholder="" autocomplete="off" autofocus> -->
              <button type="submit" class="btn"><i class="icon-search"></i> Search</button>
            </div>
          </form>
        </div>
      </div>
      <div class="row-fluid">
        <div class="span12">
          <br>
          <table class="table table-striped table-hover">
            <tbody>
              <?php 
                foreach ($games as $key => $value) {
                  echo '<tr><td>' . 
                    '<a href="gameDetail.php?gid=' . $value['id'] . '">';
                  if($value['picture']) {
                    echo '<img class="pull-left" height="50px" width="50px" style="border-radius:10px;margin:0px 10px 0px 0px;" src="img/games/' . $value['picture'] . '">';
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
        </div>
      </div>
      <?php include('footer.php'); ?>
    </div>
    
    <?php require_once('requiredJS.php'); ?>
  </body>
</html>