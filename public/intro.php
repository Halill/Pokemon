<?php
session_start();
include '../spielstand_Handler.php';
$handler = NEW Spielstand_Handler();
if(isset($_GET['Bisasam'])){
  echo $handler->spielstand_anlegen(key($_GET));
  header("Location: PlayerMovement.html");
}
if(isset($_GET['Schiggy'])){
  echo $handler->spielstand_anlegen(key($_GET));
  header("Location: PlayerMovement.html");
}
if(isset($_GET['Glumanda'])){
  echo $handler->spielstand_anlegen(key($_GET));
  header("Location: PlayerMovement.html");
}
?>

<!DOCTYPE html>
<html>
<head>
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
