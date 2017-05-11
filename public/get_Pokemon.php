<?php
// Die get_Pokemon.php wird von der app.js aufgerufen, um das Pokemon des Users in das Spiel zu integrieren.
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
