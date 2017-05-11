<?php
/**
* die wonFight.php wird von der app.js (das Spiel) benutzt.
* Wird ein Pokemon Kampf im Spiel gewonnen wird der Score über die Funktion setScore() um eins erhöht.
*/
session_start();
if(!isset($_SESSION['userid'])){
	header("Location: index.php");
	die();
}
else {
	include '../pokemon_handler.php';
	Pokemon::setScore();
	echo "Add Score";
}
?>
