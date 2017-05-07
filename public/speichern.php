<?php
session_start();
if(isset($_SESSION['userid'])) {
	if(isset($_POST['save'])){
  		include '../speichern.php';
  		if($ausgabe){
  			$_SESSION['message'] = "Spiel gespeichert";
  			header("Location: game.php");
  		}
  		else {
  			$_SESSION['message'] = "Beim Speichern ist ein Fehler aufgetreten.";
  			header("Location: game.php");
  		}
  }  
}
?>
