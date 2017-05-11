<?php
/**
* Die ranking.php zeigt alle Spielstände an, sortiert nach Score.
* Angezeigt wird die Platzierung, der Username, das benutzte Pokemon und der Score.
* Sie wird aufgerufen, über den Button "Ranking" in der game.php.
*/
session_start();
//Falls in der Session die userid nicht gesetzt ist, wird derjenige auf die index.php umgeleitet.
if(!isset($_SESSION['userid'])){
	header("Location: index.php");
	die();
}
if(isset($_GET['zumspiel'])){
	header("Location: PlayerMovement.html");
}
include '../spielstand_Handler.php';
$handler = NEW Spielstand_Handler();
$spielstand = $handler->ranking();
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
	<table id="ranking">
		<tr>
			<th>Platzierung</th>
			<th>Spieler</th>
      <th>Pokemon</th>
      <th>Score</th>
		</tr>
		<?php for ($i=0; $i < sizeof($spielstand) ; $i++) { ?>
			<tr>
				<td><?php echo htmlentities($i+1) ?></td>
				<?php for ($j=0; $j < 3; $j++) { ?>
					<?php if(isset($spielstand[$i][$j])) ?> <td> <?php  echo htmlentities($spielstand[$i][$j]); ?></td>
					<?php next($spielstand[$i]); ?>
				<?php } ?>
			</tr>
		<?php } ?>
	</table>
	<div id="button">
		<table id="button">
			<tr>
				<td>

					<form action="?zumspiel=1" method="post">
						<input value="zumspiel" type="image" src="assets/pokeball.png" name="zumspiel">
					</form>

				</td>
			</tr>
			<tr>
				<td>

					<div id="button">Zum Spiel zurück</div>

				</td>
			</tr>
		</table>
	</div>
</body>
</html>
