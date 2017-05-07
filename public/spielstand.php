<?php
session_start();
if(!isset($_SESSION['userid'])) {
	header("Location: index.php");
}
include '../spielstand.php';
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
	echo htmlentities($spielstand[$i]."\n");
}

  ?>

 </body>
 </html>
