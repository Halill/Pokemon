<?php
session_start();
//Falls in der Session die userid nicht gesetzt ist, wird derjenige auf die index.php umgeleitet.
if(!isset($_SESSION['userid'])){
	header("Location: index.php");
	die();
}
include '../Spielstand_Handler.php';
if(Spielstand_Handler::check_spielstand() && !isset($_GET['Fortsetzen'])){
	 $link = "spielstand.php";
}
elseif (!$h->check_spielstand()) {
	 $link = "intro.php";
}
else {
	$link = "PlayerMovement.html";
}
if(isset($_POST["change"])) $link = "benutzerverwaltung.php";
if(isset($_POST["spielstand"])) $link = "spielstand.php";
if(isset($_POST["ranking"])) $link = "ranking.php";

if(isset($_SESSION["message"]) && $_SESSION['counter']<1){
	echo '<script type="text/javascript" language="Javascript"> alert("'.htmlentities($_SESSION["message"]).'") </script>';
	$_SESSION['counter'] = 1;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link href="/css/style.css" rel="stylesheet">
  	<link rel="shortcut icon" type="image/x-icon" href="assets/pokeball.ico" />
    <title>Poke-Game</title>
</head>
<body>
<div id="wrapper">
<div id="game">
<iframe style="margin: 0 auto;display: block;" src=<?php echo htmlentities($link); ?>  scrolling="no" width="760" height="628" frameBorder="0"></iframe>
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
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
  <input value="Ranking" type="submit" name="ranking">
</form>
<form method="post" action="logout.php">
  <input value="Logout" type="submit" name="logout" align="right">
</form>
</div>
</div>
</fieldset>
</body>
</html>
