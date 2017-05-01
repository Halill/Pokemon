<?php
session_start();
include '../loggedin.php';
//if(!$_SESSION["ausgabe"]) exit("kein Spielstand vorhanden")
?>

<!DOCTYPE html>
<html>
<head>

    <link href="/css/style.css" rel="stylesheet">
  	<link rel="shortcut icon" type="image/x-icon" href="bilder/pokeball.ico" />
    <title>Poke-Game</title>
</head>
<body>
 <iframe src="PlayerMovement.html" align="middle" scrolling="no" width="80%" height="80%"></iframe>

<form method="post" action="logout.php">
  <input value="Logout" type="submit" name="sent">
</form>
</body>
</html>
