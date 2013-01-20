<?php
//////////////////////////////////////////////////////////////////////////////
// Script to randomly generate a score for playing the game, record that 	//
// information in the database if the player is signed in, and displaying 	//
// everything nicely to the player 											//
//////////////////////////////////////////////////////////////////////////////

// retrieve the game id
$gid = $_REQUEST['gid'];

// check if the player is signed in
session_set_cookie_params(0);
session_start();
if (session_is_registered('pid')) {
	$pid = $_SESSION['pid'];
}

// formula to randomly generate a score for the current game
$score = rand(100, 1000);

// display the score (and other information?)
echo "You scored " . $score . " points!<br>";

// display any achievements that were earned during this game
echo "<hr><h4>Achievements earned this game</h4>";

// if the player is NOT signed in, then just display message telling them to register & sign in
if (!$pid) {
	echo "Register or sign in to receive achievements and to record your scores!";
}
// the player IS logged in
else {
	// Retrieve the list of achievements for this game
	include('db/db_mysql.php');
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
	// echo "This game has " . $numAchieve . " achievements. <br>";

	// Retrieve the total number of achievements earned by this player
	$prevEarned = 0;
	$query = "SELECT COUNT(*) AS total FROM achievement A, earns E WHERE " . 
		"A.id = E.achievementId AND gameId = {$gid} AND playerId = {$pid};";
	$result = mysql_query($query);
	while ($row = mysql_fetch_assoc($result)) {
		$prevEarned = $row['total'];
	}
	// echo "You have earned " . $prevEarned . " in total.<br>";

	// Remove achievements already earned from the list of possible ones the player can still earn
	$query = "SELECT id FROM achievement A, earns E WHERE " . 
	"A.id = E.achievementId AND gameId = {$gid} AND playerId = {$pid};";
	$result = mysql_query($query);
	while ($row = mysql_fetch_assoc($result)) {
		$aid = $row['id'];
		unset($achievements[$aid]);
	}

	// variables to assist in keeping track of achievements earned
	$available = count($achievements);
	$dateEarned = date("Y-m-d");
	$newlyEarned = array();
	$earnedPoints = 0;

	// Randomly determine if the player has earned any new achievements
	$percent = rand(0,100);

	// If first time playing this game
	if ($prevEarned == 0 && $available > 0) {
		foreach ($achievements as $key => $value) {
			// the player earns the "first" achievement if available
			if ($value['name'] === "FIRST!") {
				// record that this achievement has been earned
				$aid = $key;
				$newlyEarned[$aid] = $value;
				$earnedPoints += $value['points'];
				$query = 'INSERT INTO earns (playerId, achievementId, dateEarned, remark)'.
					' VALUES (' . $pid . ', ' . $aid . ', "' . $dateEarned . '", "Woot! First!")';
            	$result = mysql_query($query);

				// remove achievement from list of remaining
				unset($achievements[$aid]);
				$available--;
				break;
			}
		}
		echo "You earned the FIRST achievement! :)" . "<br>";
	}

	// the player has a 5 percent chance of completing the entire game (and earning the remaining achievements)
	if ($percent <= 5 && $available > 0) { 
		foreach ($achievements as $key => $value) {
			// record that this achievement has been earned
			$aid = $key;
			$newlyEarned[$aid] = $value;
			$earnedPoints += $value['points'];
			$query = 'INSERT INTO earns (playerId, achievementId, dateEarned, remark)'.
				' VALUES (' . $pid . ', ' . $aid . ', "' . $dateEarned . '", "Booyah! Alright, I totally rock!")';
        	$result = mysql_query($query);

			// remove achievement from list of remaining
			unset($achievements[$aid]);
			$available--;
		}
		echo "Earned all remaining achievements!";
	}
	// the player has a 30 percent chance of earning up to (2) remaining achievements
	else if ($percent <= 30 && $available > 0) {
		// loop twice (if possible)
		$i = 0;
		for ($i=0; $i < 2; $i++) { 
			// if no more achievements remain, then stop
			if ($available === 0) {
				break;
			}

			// randomly select one of the remaining achievements
			$index = rand(0,$available-1);
			$keys = array_keys($achievements);
			$aid = $keys[$index];
			$value = $achievements[$aid];
		
			// record that this achievement has been earned
			$newlyEarned[] = $value;
			$earnedPoints += $value['points'];
			$query = 'INSERT INTO earns (playerId, achievementId, dateEarned, remark)'.
				' VALUES (' . $pid . ', ' . $aid . ', "' . $dateEarned . '", "Yes! Another achievement for my wall!")';
			$result = mysql_query($query);

			// remove achievement from list of remaining
			unset($achievements[$aid]);
			$available--;
		}
		echo "Earned (" . $i . ") achievements!";
	}
	// the player has a 70 percent chance of earning (1) of the remaining achievements
	else if ($percent <= 70 && $available > 0) {
		// randomly select one of the achievements
		$index = rand(0,$available-1);
		$keys = array_keys($achievements);
		$aid = $keys[$index];
		$value = $achievements[$aid];
	
		// record that this achievement has been earned
		$newlyEarned[] = $value;
		$earnedPoints += $value['points'];
		$query = 'INSERT INTO earns (playerId, achievementId, dateEarned, remark)'.
			' VALUES (' . $pid . ', ' . $aid . ', "' . $dateEarned . '", "Yay I got an achievement!")';
		$result = mysql_query($query);

		// remove achievement from list of remaining
		unset($achievements[$aid]);
		$available--;
		echo "Earned (1) achievement!";
	}
	// the player failed to earn any achievements (or there are no more achievements left to earn)
	else if (count($newlyEarned) === 0) {
		echo "Sorry no achievements earned this time. Play again!";
	}

	// if any achievements were earned
	if (count($newlyEarned) > 0) {
		// display the list of achievements the player earned this game
		foreach ($newlyEarned as $key => $value) {
			echo '<li><strong>' . 
		        $value['name'] . '</strong> on ' . 
		        $dateEarned . ' for '  .
		        $value['points'] . ' points.</li>'
		        ;
		}
	}

	// modify the score the player sees based on earned achievements!
	$score += $earnedPoints;
	echo "<br><strong>Total points earned: </strong>" . $score;

	// Retrieve the player's previous score
	$gameScore = 0;
	$query = 'SELECT score FROM scores WHERE playerId = ' . $pid . ' AND gameId = ' . $gid . ';';
	$result = mysql_query($query);
	while ($row = mysql_fetch_assoc($result)) {
		$gameScore = $row['score'];
	}

	$gameScore += $score;
	$query = 'REPLACE scores (playerId, gameId, score) VALUES (' . $pid . ', ' . $gid . ', ' . $gameScore . ');';
	$result = mysql_query($query);

	mysql_close($con);

	// optional: provide option for the user to record their remark?
}
?>