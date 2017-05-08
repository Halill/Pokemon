<?php
session_start();
if(!isset($_SESSION['userid'])){
	header("Location: index.php");
	die();
}
include '../spielstand_Handler.php';
$handler = NEW Spielstand_Handler();
$spielstand = $handler->spielstand_laden();

if(!isset($_SESSION['userid'])) {
	header("Location: index.php");
}
if(isset($_GET['Fortsetzen'])){
	header("Location: PlayerMovement.html");
}
if(isset($_GET['neu_spielstand'])){
	header("Location: intro.php");
}
 ?>
 <!DOCTYPE html>
 <html>
 <head>
     <link href="/css/spielstand.css" rel="stylesheet">

   	<link rel="shortcut icon" type="image/x-icon" href="assets/pokeball.ico" />
     <title>Poke-Game</title>
 </head>

 <body>
<div id="spielstand">
<table>
<tr>
	<td><?php echo htmlentities(key($spielstand));?></td>
	<td><?php echo htmlentities($spielstand["Spielername: "]);?></td>
	<?php next($spielstand); ?>
</tr>
<tr>
	<td><?php echo htmlentities(key($spielstand));?></td>
	<td><?php echo htmlentities($spielstand["Zuletzt gespeichert: "]);?></td>
	<?php next($spielstand); ?>
</tr>
<tr>
	<td><?php echo htmlentities(key($spielstand));?></td>
	<td><?php echo htmlentities($spielstand["Score: "]);?></td>
	<?php next($spielstand); ?>
</tr>
<tr>
	<td><?php echo htmlentities(key($spielstand));?></td>
	<td><?php echo htmlentities($spielstand["Pokemon: "]);?></td>
	<?php next($spielstand); ?>
</tr>

</table>
</div>
<div id="button">
<table id="button">
<tr>
<td>
<form action="?Fortsetzen=1" method="post">
	<input value="Fortsetzen" type="image" src="assets/pokeball.png" name="Fortsetzen">
</form>
</td>
<td>
<form action="?neu_spielstand=1" method="post">
	<input value="Neuen Spielstand anlegen" type="image" src="assets/pokeball.png" name="Neuen Spielstand anlegen">
</form>
</td>
</tr>
<tr>
	<td>
		Fortsetzen
	</td>
	<td>
		Spielstand anlegen
	</td>
</tr>
</table>
</div>
 </body>
 </html>
