<?php
session_start();
include '../spielstand_Handler.php';
$handler = NEW Spielstand_Handler();
if(isset($_SESSION['userid'])) {
	if(isset($_POST['save'])){
  		if($handler->spielstand_speichern()){
  			$_SESSION['message'] = "Spiel gespeichert";
  			header("Location: game.php");
  		}
  		else {
  			$_SESSION['message'] = "Beim Speichern ist ein Fehler aufgetreten.";
  			header("Location: PlayerMovement.html");
  		}
  }
}
?>
