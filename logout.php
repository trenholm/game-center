<!DOCTYPE html>
<html>
  <head>
  </head>
  <body>
  <?php
  // destroy the session cache
  session_start();
  session_destroy();

  // send the user back to the index page
  header("Cache-Control: no-cache");
  header("Location: index.php", true, 302);
  ?>
  </body>
</html>