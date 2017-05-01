<?php
include 'config.php';

$_SESSION["id"] = "1";

if(count($_POST)>0) {
	$statement = $pdo->prepare("SELECT * FROM users WHERE userId= :userid");
	$result = $statement->execute(array('userid' => $_SESSION["id"]));
	$user = $statement->fetch();

	if(password_verify($_POST["currentPassword"], $user['passwort'])){
		$statement = $pdo->prepare("UPDATE users set password=':newpassword' WHERE userId='" . $_SESSION["id"] . "'");
		$statement->execute(array('newpassword' => $_POST["newPassword"], 'userid' => $_SESSION["id"]));
		$message = "Das Passwort wurde erfolgreich geändert.";
	} else $message = "Das aktuelle Passwort war fehlerhaft.";
}
?>
