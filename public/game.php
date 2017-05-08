<?php
session_start();
if(!isset($_SESSION['userid'])){
	header("Location: index.php");
	die();
}
include '../Spielstand_Handler.php';
$h = NEW Spielstand_Handler();
if($h->check_spielstand() && !isset($_GET['Fortsetzen'])){
	 $link = "spielstand.php";
}
elseif (!$h->check_spielstand()) {
	 $link = "intro.php";
}
else {
	$link = "PlayerMovement.html";
}
if(isset($_POST["change"])) $link = "pwchange.php";
if(isset($_POST["spielstand"])) $link = "spielstand.php";
//wird gesetzt, beim Speichern -> speichern.php
?>

<!DOCTYPE html>
<html>
<head>

    <link href="/css/style.css" rel="stylesheet">
  	<link rel="shortcut icon" type="image/x-icon" href="assets/pokeball.ico" />
    <title>Poke-Game</title>
</head>
<body>
<div id="wrapper">
<div id="game">
<iframe style="margin: 0 auto;display: block;" src=<?php echo htmlentities($link); ?>  scrolling="no" width="760" height="628" frameBorder="0"></iframe>
</div>

<div id="message">
<?php if(isset($_SESSION["message"])) echo htmlentities($_SESSION["message"]);?>
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
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
  <input value="Benutzerverwaltung" type="submit" name="change">
</form>
<form method="post" action="logout.php">
  <input value="Logout" type="submit" name="logout" align="right">
</form>
</div>
</div>
</fieldset>


</body>
</html>
