<?php
$filename = $_FILES['file']['name'];
$size = $_FILES['file']['size'];
$type = $_FILES['file']['type'];
$error = $_FILES['file']['error'];
$tempfile = $_FILES['file']['tmp_name'];

$allowedExts = array("jpg", "jpeg", "gif", "png");
$allowedMimes = array("image/jpg", "image/pjpeg", "image/gif", "image/png");
//$ext = end(explode(".", $filename));
$ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
$maxSize = 20000;

// retrieve player id from the push request
$pid = intval($_REQUEST['pid']);
// set the location to store the picture
$target_path = "img/players/";
// Use the Player's ID to name the file (extra-step for ensure the right picture goes to the correct player)
$filename = $pid . "." . $ext;
$target_path = $target_path.basename($filename);

// Set up the session parameters
session_set_cookie_params(0);
session_start();

// Checks if file type is allowed and file size is allowed
// if (in_array($ext, $allowedExts) && in_array($type, $allowedMimes) && $size <= $maxSize) {
if (in_array($ext, $allowedExts) && $size <= $maxSize) {
	if ($error === UPLOAD_ERR_OK) {
		
		if (move_uploaded_file($tempfile, $target_path)) {
			echo "The file ".basename($filename)." has been uploaded.";

			// Update the database to include the new profile picture for this player
      		include('db_mysql.php');
			$query = 'UPDATE player SET picture = "' . $filename . '" WHERE id = ' . $pid;
      		mysql_query($query);
      		mysql_close($con);

      		// pass message that upload was successful
			$_SESSION['success'] = true;
			$_SESSION['message'] = "Uploaded image successfully.";
			// REPLACE = 'TRUE', CODE 302 = 'FOUND'
			header('Location: playerProfile.php', true, 302);
		}
		else {
			// echo "There was an error uploading the file. Please try again.";
			$_SESSION['success'] = false;
			$_SESSION['error'] = "There was an error uploading the file. Please try again.";
			// REPLACE = 'TRUE', CODE 304 = 'NOT MODIFIED'
			header('Location: playerProfile.php', true, 304);
		}
	}
	else { //Error occurred
		echo getError($error);
		$_SESSION['success'] = false;
		$_SESSION['error'] = getError($error);
		// CODE 304 = 'NOT MODIFIED'
		header('Location: playerProfile.php', true, 304);
	}
}
else { //Error: invalid file type or file size too large
	echo "File was wrong file type or too large.";
	$_SESSION['success'] = false;
	$_SESSION['error'] = "File was wrong file type or too large.";
	// CODE 304 = 'NOT MODIFIED'
	header('Location: playerProfile.php', true, 304);
}

// Returns error message
function getError($e) {
	$upload_errors = array( 
	UPLOAD_ERR_OK => "No errors.", 
	UPLOAD_ERR_INI_SIZE => "Larger than upload_max_filesize.", 
	UPLOAD_ERR_FORM_SIZE => "Larger than form MAX_FILE_SIZE.", 
	UPLOAD_ERR_PARTIAL => "Partial upload.", 
	UPLOAD_ERR_NO_FILE => "No file.", 
	UPLOAD_ERR_NO_TMP_DIR => "No temporary directory.", 
	UPLOAD_ERR_CANT_WRITE => "Can't write to disk.", 
	UPLOAD_ERR_EXTENSION => "File upload stopped by extension.", 
	UPLOAD_ERR_EMPTY => "File is empty." // add this to avoid an offset 
	);
	return $upload_erros[$e];
}
