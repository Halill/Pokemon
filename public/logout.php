<?php
/**
* Die logout.php  wird aufgerufen, wenn der User in der game.php auf den Button "Logout" klickt.
* Führt die Funktion logout() aus und loggt den aktuellen User aus..
*/
session_start();
//Falls in der Session die userid nicht gesetzt ist, wird derjenige auf die index.php umgeleitet.
if(!isset($_SESSION['userid'])){
	header("Location: index.php");
	die();
}
include '../session_handler.php';
$erfolgreich = Session::logout();
?>
<html>
<head>
	<meta charset="UTF-8">
  <title>Poke-Game</title>
  <link rel="shortcut icon" type="image/x-icon" href="/assets/pokeball.ico" />
  <link href="/css/style.css" rel="stylesheet">
</head>
<body>
	<?php if($erfolgreich) header("Location: index.php"); ?>
</body>
</html>
