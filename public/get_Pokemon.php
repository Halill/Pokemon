<?php
/**
* Die get_Pokemon.php wird von der app.js (das Spiel) aufgerufen.
* Hier holt sich das Spiel die Informationen über das Pokemon  des Users über die Funktion
* get_pokemon_in_json(). Die Variable wird vom Spiel als json gespeichert (json_encode()).
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
	$json_user_pokemon = Pokemon::get_pokemon_in_json();
	echo json_encode($json_user_pokemon);
}
?>
