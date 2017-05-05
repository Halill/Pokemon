<?php
if(isset($_POST['save'])){
  session_start();
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
?>
