<?php
session_start();
if(!isset($_SESSION['userid'])){
	header("Location: index.php");
	die();
}
include '../session_handler.php';
$handler = NEW Session();

$erfolgreich = $handler->logout();
?>
<html>
<head>
  <title>Poke-Game</title>
  <link rel="shortcut icon" type="image/x-icon" href="/assets/pokeball.ico" />
  <link href="/css/style.css" rel="stylesheet">
</head>
<body>
  <?php
  if($erfolgreich) header("Location: index.php");?>
</body>
</html>
