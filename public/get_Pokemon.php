<?php
session_start();
if(!isset($_SESSION['userid'])){
	header("Location: index.php");
	die();
}
else {
	include '../pokemon_handler.php';
	$json_user_pokemon = Pokemon::get_pokemon_in_json();
	echo json_encode($json_user_pokemon);

	$json_gegner_pokemon = Pokemon::get_random_pokemon();
	echo json_encode($json_gegner_pokemon);
}




?>
