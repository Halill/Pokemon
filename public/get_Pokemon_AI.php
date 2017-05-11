<?php
/**
* Die get_Pokemon_AI.php wird von der app.js (das Spiel) aufgerufen.
* Hier holt sich das Spiel die Informationen über das gegnerische Pokemon über die Funktion
* get_random_pokemon(). Die Variable wird vom Spiel als json gespeichert (json_encode()).
*
*/

session_start();
//Falls in der Session die userid nicht gesetzt ist, wird derjenige auf die index.php umgeleitet.
if(!isset($_SESSION['userid'])){
	header("Location: index.php");
	die();
}
else {
	include '../pokemon_handler.php';
	$json_gegner_pokemon = Pokemon::get_random_pokemon();
	echo json_encode($json_gegner_pokemon);
}
?>
