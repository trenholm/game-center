<form action="imageUploader.php" method="post" enctype="multipart/form-data">
	<!-- <label for="file">Filename:</label> -->
	<input type="file" name="file" id="file"><br>
	<input type="submit" name="submit" value="Upload">
	<?php 
		echo '<input type="hidden" name="pid" value="' . $player . '">';
	?>
</form>