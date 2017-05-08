<?php
session_start();
include '../spielstand_Handler.php';
$handler = NEW Spielstand_Handler();
$spielstand = $handler->spielstand_laden();
if(!isset($_SESSION['userid'])) {
	header("Location: index.php");
}
if(isset($_GET['Fortsetzen'])){
	header("Location: PlayerMovement.html");
}
if(isset($_GET['neu_spielstand'])){
	header("Location: intro.php");
}
 ?>
 <!DOCTYPE html>
 <html>
 <head>
     <link href="/css/style.css" rel="stylesheet">
   	<link rel="shortcut icon" type="image/x-icon" href="assets/pokeball.ico" />
     <title>Poke-Game</title>
 </head>
 <body>
<?php

for ($i=0; $i < sizeof($spielstand); $i++) {
	if(isset($spielstand[$i])){
		for ($j=0; $j < sizeof($spielstand); $j++) {
			echo $spielstand[$i][$j];
		}
		//echo htmlentities($spielstand[$i]."\n");
	}
}
?>
<form action="?Fortsetzen=1" method="post">
	<input value="Fortsetzen" type="submit" name="Fortsetzen">
</form>
<form action="?neu_spielstand=1" method="post">
	<input value="Neuen Spielstand anlegen" type="submit" name="Neuen Spielstand anlegen">
</form>
 </body>
 </html>
