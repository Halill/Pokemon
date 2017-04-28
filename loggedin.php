<?php
include 'config.php';

/**
 * �berpr�fung, ob der User eingeloggt ist, indem die Userid aus der Session abgefragt wird.
 * Bei nicht gesetzter Userid wird der User auf die Login-Seite verwiesen.
 */

if(!isset($_SESSION['userid'])) {
	$ausgabe = 'Bitte zuerst <a href="index.php">einloggen</a>';
}

//Abfrage der Nutzer ID vom Login
$userid = $_SESSION['userid'];
$statement = $pdo->prepare("SELECT * FROM spielstand WHERE spielerid = :id");
$result = $statement->execute(array('id' => $userid));
$spielstand = $statement->fetch();
if(empty($spielstand)){
	$ausgabe = true;
	$_SESSION['ausgabe'] = $ausgabe;
}
else {
	$ausgabe =  false;
	$_SESSION['ausgabe'] = $ausgabe;
}
?>
