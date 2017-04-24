<?php
include 'config.php';

/**
 * Das login-Script
 */
session_start();

/**
 * Der Uebergebene Username und das Passwort werden gespeichert.
 * Anschliessend wird der Username in ein Prepared Statement uebergeben und die Userdaten abgefragt.
 * Das Passwort wird ueber die password_verify-Funktion verifiziert. Bei korrektem Passwort wird auf die loggedin-Seite weitergeleitet.
 * Bei falschem Passwort oder nicht vorhandenem Username wird eine Fehlermeldung ausgegeben.
 */
if(isset($_GET['login'])) {
	$username = $_POST['username'];
	$passwort = $_POST['passwort'];

	$statement = $pdo->prepare("SELECT * FROM users WHERE username = :username");
	$result = $statement->execute(array('username' => $username));
	$user = $statement->fetch();

	//Ueberpruefung des Passworts
	if ($user !== false && password_verify($passwort, $user['passwort'])) {
		$_SESSION['userid'] = $user['ID'];
		header("Location: game.php");
		exit;
	} else {
		$errorMessage = "Benutzername oder Passwort war ungültig<br>";
	}

}
?>
