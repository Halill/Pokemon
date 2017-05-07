<?php
/**
* In der config.php wird die Datenbankverbindung gesetzt.
*/
if (!isset($pdo)){
	try {
		$pdo = new PDO('mysql:host=instanz1.cf6ecdewusof.eu-central-1.rds.amazonaws.com:3306;dbname=php','benutzer', 'passwort');
	} catch (Exception $e) {
		print "Error!:" . $e->getMessage() . "<br/>";
		die();
	}
}

?>
