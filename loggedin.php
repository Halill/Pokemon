<?php
session_start();

/**
 * �berpr�fung, ob der User eingeloggt ist, indem die Userid aus der Session abgefragt wird.
 * Bei nicht gesetzter Userid wird der User auf die Login-Seite verwiesen.
 */
if(!isset($_SESSION['userid'])) {
	die('Bitte zuerst <a href="login.php">einloggen</a>');
}

//Abfrage der Nutzer ID vom Login
$userid = $_SESSION['userid'];

echo "Jetzt h�tte das Spiel starten sollen ...";
?>