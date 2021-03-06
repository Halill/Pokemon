<?php
/**
* In der benutzerverwaltung.php wird im Iframe der game.php dem User eine Möglichkeit gegeben,
* sein Passwort oder seine E-Mailadresse zu ändern. Wichtig ist, dass der User sein Passwort weiß.
* Ansonsten muss er in der index.php sein Passwort über seine E-Mailadresse neu setzen-
*
*/
session_start();
//Falls in der Session die userid nicht gesetzt ist, wird derjenige auf die index.php umgeleitet.
if(!isset($_SESSION['userid'])) {
	header("Location: public");
	die();
}
// Wird der Button "zumspiel" geklickt, wird auf das Spiel umgeleitet
if(isset($_GET['zumspiel'])){
	header("Location: PlayerMovement.html");
}
//bindet Funktion change_pw_or_mail() ein.
include '../passwort_handler.php';
$ausgabe = Passwort_Handler::change_pw_or_mail();
// Gibt Fehlermeldung der Funktion change_pw_or_mail() als Popup aus
// Ausnahme: Wenn der Button "zumspiel" geklickt wird.
if(isset($ausgabe) && !isset($_GET['zumspiel'])){
	echo '<script type="text/javascript" language="Javascript"> alert("'.htmlentities($ausgabe).'") </script>';
}

?>
<html>
<head>
	<meta charset="UTF-8">
  <title>Pokemon-Game</title>
  <link rel="shortcut icon" type="image/x-icon" href="assets/pokeball.ico" />
  <link rel="stylesheet" href="css/benutzerverwaltung.css">
</head>
<body bgcolor="white">
<div id="ranking">
	<form name="frmChange" method="post" action="" onSubmit="return validatePassword()">
		<table border="0" cellpadding="10" cellspacing="0" width="500" align="center" class="tblSaveForm">
			<tr>
				<!-- Hallo User -->
			</tr>
			<tr>
				<!-- aktuelle E-Mailadresse -->
			</tr>
			<tr>
				<td>
					<label>Neues Passwort</label>
				</td>
				<td>
					<input type="password" name="newPassword" class="txtField"/><span id="newPassword" class="required"></span>
				</td>
				<td>
					<label>Neue E-Mail</label>
				</td>
				<td>
					<input type="email" name="newEmail" class="txtField"/><span id="newEmail" class="required"></span>
				</td>
			</tr>
			<tr>
				<td>
					<label>Passwort bestätigen</label>
				</td>
				<td>
					<input type="password" name="confirmPassword" class="txtField"/><span id="confirmPassword" class="required"></span>
				</td>
				<td>
					<label>E-Mail bestätigen</label>
				</td>
				<td>
					<input type="email" name="confirmEmail" class="txtField"/><span id="confirmEmail" class="required"></span>
				</td>
			</tr>
		</table>
	</div>
<div id="button">
	<table>
    <tr>
      <td><label>Aktuelles Passwort</label><input type="password" name="currentPassword" class="txtField"/><span id="currentPassword"  class="required"></span></td>
    </tr>
		<tr>
			<td>
				<!-- Button, der die Funktion change_pw_or_mail() aufruft-->
				<input type="image" src="assets/pokeball.png" alt="Abschicken" name='submit'/>
			  </form>
			</td>
			<td>
				<!-- Button, der wieder zum Spiel führt-->
				<form action="?zumspiel=1" method="post">
					<input value="zumspiel" type="image" src="assets/pokeball.png" name="zumspiel">
				</form>
			</td>
		</tr>
		<tr>
			<td>
				<label>Abschicken</label>
			</td>
			<td>
				<label>Zum Spiel</label>
			</td>
		</tr>
	</table>
</div>

</body>
</html>
