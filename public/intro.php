<?php
session_start();
//Falls in der Session die userid nicht gesetzt ist, wird derjenige auf die index.php umgeleitet.
if(!isset($_SESSION['userid'])){
	header("Location: index.php");
	die();
}
include '../spielstand_Handler.php';
$handler = NEW Spielstand_Handler();

if((isset($_GET['Bisasam']) || isset($_GET['Glumanda']) || isset($_GET['Schiggy'])) && $handler->check_spielstand()==true){
  echo $handler->spielstand_ueberschreiben(key($_GET));
  header("Location: PlayerMovement.html");
}
if((isset($_GET['Bisasam']) || isset($_GET['Glumanda']) || isset($_GET['Schiggy'])) && $handler->check_spielstand()==false){
	echo $handler->spielstand_anlegen(key($_GET));
  header("Location: PlayerMovement.html");
}




?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link href="/css/intro.css" rel="stylesheet">
</head>
<body>


<div id="oben">
<form action="?Bisasam=1" method="post">
<input type="image" src="/assets/misc/Pokemon/Bisasam_Front.png" alt="bisasam" width="100" height="100"/>
</form>
<form action="?Schiggy=1" method="post">
<input type="image" src="/assets/misc/Pokemon/Schiggy_Front.gif" alt="bisasam" width="100" height="100"/>
</form>
<form action="?Glumanda=1" method="post">
<input type="image" src="/assets/misc/Pokemon/Glumanda_Front.gif" alt="bisasam" width="100" height="100"/>
</form>
</div>

<div id="unten"><img src="/assets/intro.png" alt="intro" width="760" height="628"></div>


</body>
</html>
