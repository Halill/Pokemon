<?php
session_start();
session_regenerate_id();
include '../loggedin.php';

?>

<!DOCTYPE html>
<html>
<head>
    <link href="/css/style.css" rel="stylesheet">
  	<link rel="shortcut icon" type="image/x-icon" href="bilder/pokeball.ico" />
    <title>Poke-Game</title>
</head>
<body>
<?php echo $ausgabe ?>
 <iframe src="PlayerMovement.html" scrolling="no" height="500" width="1000" frameboder=0></iframe>
<form method="post" action="logout.php">
  <input value="Logout" type="submit" name="sent">
</form>
</body>
</html>
