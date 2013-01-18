<form action="imageUploader.php" method="post" enctype="multipart/form-data">
	<!-- <label for="file">Filename:</label> -->
	<input type="file" name="file" id="file"><br>
	<input type="submit" class="btn btn-success" name="submit" value="Upload picture">
	<?php 
		echo '<input type="hidden" name="pid" value="' . $player . '">';
	?>
</form>
