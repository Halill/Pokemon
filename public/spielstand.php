<?php
/**
* Die spielstand.php wird nach dem einloggen angezeigt, wenn der User eine Spielstand besitzt.
* Ansonsten wird sie per Klick auf den Button "Spielstandübersicht" in der game.php gestartet.
*
* Der Button "Fortsetzen" setzt das Spiel fort.
* Über den Button "Spielstand anlegen" kann der User einen neuen Spielstand anlegen.
* Im Endeffekt wird der Score dann auf 0 gesetzt und der User kann sich ein neues Pokemon aussuchen.
*
*/
session_start();
//Falls in der Session die userid nicht gesetzt ist, wird derjenige auf die index.php umgeleitet.
if(!isset($_SESSION['userid'])){
	header("Location: index.php");
	die();
}
include '../spielstand_Handler.php';
$handler = NEW Spielstand_Handler();
$spielstand = $handler->spielstand_laden();
//Falls in der Session die userid nicht gesetzt ist, wird derjenige auf die index.php umgeleitet.
if(!isset($_SESSION['userid'])) {
	header("Location: index.php");
}
//wird der Button "Fortsetzen" geklickt, wird das Spiel fortgeführt.
if(isset($_GET['Fortsetzen'])){
	header("Location: PlayerMovement.html");
}
//wird der Button "Spielstand anlegen" geklickt wird das Intro ausgeführt.
if(isset($_GET['neu_spielstand'])){
	header("Location: intro.php");
}
?>
<!DOCTYPE html>
<html>
<head>
	<link href="/css/spielstand.css" rel="stylesheet">
	<meta charset="UTF-8">
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
					<label>Fortsetzen</label>
				</td>
				<td>
					<label>Spielstand anlegen</label>
				</td>
			</tr>
		</table>
	</div>
</body>
</html>
