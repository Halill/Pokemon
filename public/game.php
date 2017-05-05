<?php
session_start();

include '../loggedin.php';
//if($_POST['save']) include 'speichern.php';
//if(!$_SESSION["ausgabe"]) exit("kein Spielstand vorhanden")
// $link = "spielstand.php";
// if(isset($_POST["game"])) $link = "PlayerMovement.html";
$link = "PlayerMovement.html";
if(isset($_POST["change"])) $link = "pwchange.php";
if(isset($_POST["spielstand"])) $link = "spielstand.php";
//wird gesetzt, beim Speichern -> speichern.php
if(isset($_SESSION["message"])) echo $_SESSION["message"];

?>

<!DOCTYPE html>
<html>
<head>

    <link href="/css/style.css" rel="stylesheet">
  	<link rel="shortcut icon" type="image/x-icon" href="bilder/pokeball.ico" />
    <title>Poke-Game</title>
</head>
<body>
<div id="wrapper">
<div id="game">
<iframe style="margin: 0 auto;display: block;" src=<?php echo htmlentities($link); ?>  scrolling="no" width="560" height="428"></iframe>
</div>
<div id="menue">
<fieldset style="align:right">
  <legend style="padding:20px;text-align:center">Menü</legend>
<form method="post" action="speichern.php">
   <input value="Speichern" type="submit" name="save">
</form>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
   <input value="Spielstandübersicht" type="submit" name="spielstand">
</form>
<form method="post" action="logout.php">
  <input value="Logout" type="submit" name="sent" align="right">
</form>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
  <input value="Passwort ändern" type="submit" name="change">
</form>
</div>
</div>
</fieldset>


</body>
</html>
