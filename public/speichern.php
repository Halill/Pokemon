<?php
/**
* Die speichern.php wird über den Button "Speichern" in der game.php aufgerufen.
* Die speichern.php speichert über die Funktion spielstand_speichern().
* Ob die das Speichern funktioniert hat oder nicht, wird über ein Popup angezeigt.
*/

session_start();
//Falls in der Session die userid nicht gesetzt ist, wird derjenige auf die index.php umgeleitet.
if(!isset($_SESSION['userid'])){
	header("Location: index.php");
	die();
}
include '../spielstand_Handler.php';
$handler = NEW Spielstand_Handler();
if(isset($_SESSION['userid'])) {
	if(isset($_POST['save'])){
		if($handler->spielstand_speichern()){
			$_SESSION['counter'] = 0;
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
