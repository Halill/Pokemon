<?php
include 'config.php';
/**
 * Das register-Script
 */
$showFormular = true;


if(isset($_GET['register'])) {
	$error = false;
	$username = $_POST['username'];
	$email = $_POST['email'];
	$passwort = $_POST['passwort'];
	$passwort2 = $_POST['passwort2'];
	
	if(strlen($username) == 0) {
		echo 'Bitte einen Username eingeben<br>';
		$error = true;
	}
	if(strlen($email) == 0) {
		echo 'Bitte eine E-Mailadresse eingeben<br>';
		$error = true;
	}
	if(strlen($passwort) == 0) {
		echo 'Bitte ein Passwort angeben<br>';
		$error = true;
	}
	if($passwort != $passwort2) {
		echo 'Die Passwoerter muessen uebereinstimmen<br>';
		$error = true;
	}
	
	/**
	 * Ueberpruefe, ob die E-Mailadresse schon vergeben ist
	 */
	if(!$error) {
		$statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
		$result = $statement->execute(array('email' => $email));
		$user = $statement->fetch();
		
		if($user !== false) {
			echo 'Diese E-Mailadresse ist bereits vergeben<br>';
			$error = true;
		}
	}
	
	/**
	 * Ueberpruefe, ob der Username schon vergeben ist
	 */
	if(!$error) {
		$statement = $pdo->prepare("SELECT * FROM users WHERE username = :username");
		$result = $statement->execute(array('username' => $username));
		$user = $statement->fetch();
		
		if($user !== false) {
			echo 'Dieser Username ist bereits vergeben<br>';
			$error = true;
		}
	}
	
	/**
	 * Wenn keine Fehler, kann der Nutzer registriert werden.
	 * Password wird gehasht, anschliessend ein Prepared Statement fuer die Restrierung erstellt und die eingegeben Daten in die DB gespeichert.  *
	 */
	if(!$error) {
		$passwort_hash = password_hash($passwort, PASSWORD_DEFAULT);
		
		$statement = $pdo->prepare("INSERT INTO users (username, email, passwort) VALUES (:username, :email, :passwort)");
		$result = $statement->execute(array('username' => $username, 'email' => $email, 'passwort' => $passwort_hash));
		
		if($result) {
			echo 'Du wurdest erfolgreich registriert. <a href="login.php">Zum Login</a>';
			$showFormular = false;
		} else {
			echo 'Beim Abspeichern ist leider ein Fehler aufgetreten<br>';
		}
	}
}

/**
 * Ueberpruefung, ob das Script erfolgreich durchlaufen wurde.
 */
if($showFormular) {}
?>