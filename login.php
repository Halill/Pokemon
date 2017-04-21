<?php
session_start();

try {
	$pdo = new PDO('mysql:host=instanz1.cf6ecdewusof.eu-central-1.rds.amazonaws.com:3306;dbname=php','benutzer', 'passwort');
} catch (Exception $e) {
	print "Error!:" . $e->getMessage() . "<br/>";
	die();
}

/**
 * Der �bergebene Username und das Passwort werden gespeichert.
 * Anschlie�end wird der Username in ein Prepared Statement �bergeben und die Userdaten abgefragt.
 * Das Passwort wird �ber die password_verify-Funktion verifiziert. Bei korrektem Passwort wird auf die loggedin-Seite weitergeleitet.
 * Bei falschem Passwort oder nicht vorhandenem Username wird eine Fehlermeldung ausgegeben.
 */
if(isset($_GET['login'])) {
	$username = $_POST['username'];
	$passwort = $_POST['passwort'];

	$statement = $pdo->prepare("SELECT * FROM users WHERE username = :username");
	$result = $statement->execute(array('username' => $username));
	$user = $statement->fetch();

	//�berpr�fung des Passworts
	if ($user !== false && password_verify($passwort, $user['passwort'])) {
		$_SESSION['userid'] = $user['ID'];
		header("Location: loggedin.php");
		exit;
	} else {
		$errorMessage = "Benutzername oder Passwort war ung�ltig<br>";
	}

}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<link href="background.css" rel="stylesheet">
<style>
body{
  display: flex;
  align-items: center;
  justify-content: center;
  flex-flow: row wrap;
}

header, nav, footer {
  flex: 1 100%;
}

article {
  flex: 3 1 0%;
}

aside {
  flex: 1 1 0%;
}
</style>
  <title>Pokemon-Game Login</title>
	<link rel="shortcut icon" type="image/x-icon" href="bilder/pokeball.ico" />
</head>
<body>

<?php
if(isset($errorMessage)) {
 echo $errorMessage;
}
?>

<form action="?login=1" method="post">
Benutzername:<br>
<input type="text" size="40" maxlength="250" name="username"><br><br>

Dein Passwort:<br>
<input type="password" size="40"  maxlength="250" name="passwort"><br>

<input type="submit" value="Abschicken">
<br><br>

<a href="pwvergessen.php"><button name=pwvergessen type="button">Passwort vergessen</button></a>
<a href="register.php"><button name=register type="button">Registrieren</button></a>

</form>


</body>
</html>
