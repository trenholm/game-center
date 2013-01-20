<?php
// Note: references the $gid and $gameInfo from the gameDetail.php page
// create a javascript that will get the randomly generated score from the server and display it
echo '
<script type="text/javascript">
  function generateRandomScore() {
    // create the object to allow dynamic retrieval of the game scores from the server
    var xmlhttp;
    if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
      xmlhttp=new XMLHttpRequest();
    }
    else { // code for IE6, IE5
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }

    // when server responds with the results, display them
    xmlhttp.onreadystatechange=function() {
      if (xmlhttp.readyState==4 && xmlhttp.status==200) {
        document.getElementById("gameResults").innerHTML=xmlhttp.responseText;
        }
    }

    // request the results from "playing the game" and send the game id
    xmlhttp.open("POST","generateScore.php",true);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send("gid='.$gid.'");
  }
</script>
';
?>
<p><a class="btn btn-primary btn-block btn-large" data-toggle="modal" href="#playGame" onCLick="generateRandomScore();">Play Now!</a></p>
<div class="modal hide fade" id="playGame" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times</button>
    <h3><?php echo $gameInfo['name']; ?></h3>
  </div>
  <div class="modal-body">
    <div id="gameResults"></div>
  </div>
  <div class="modal-footer">
    <button class="btn btn-success" onClick="generateRandomScore();">Play Again?</button>
    <a href="#" class="btn" data-dismiss="modal">Close</a>
  </div>
</div>