<?php
session_start();
$pdo = new PDO('mysql:host=instanz1.cf6ecdewusof.eu-central-1.rds.amazonaws.com:3306;dbname=php','benutzer', 'passwort');
?>
<!DOCTYPE html> 
<html> 
<head>
  <title>Registrierung</title> 
</head> 
<body>
 
<?php
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
 echo 'Die Passw�rter m�ssen �bereinstimmen<br>';
 $error = true;
 }
 
 //�berpr�fe, ob die E-Mailadresse schon vergeben ist
 if(!$error) {
 	$statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
 	$result = $statement->execute(array('email' => $email));
 	$user = $statement->fetch();
 	
 	if($user !== false) {
 		echo 'Diese E-Mailadresse ist bereits vergeben<br>';
 		$error = true;
 	}
 }
 
 //�berpr�fe, ob der Username schon vergeben ist
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
  * Password wird gehasht, anschlie�end ein Prepared Statement f�r die Restrierung erstellt und die eingegeben Daten in die DB gespeichert.  * 
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
 
if($showFormular) {
?>
 
<form action="?register=1" method="post">

Username:<br>
<input type="text" size="40" maxlength="250" name="username"><br><br>

E-Mailadresse:<br>
<input type="email" size="40" maxlength="250" name="email"><br><br>
 
Dein Passwort:<br>
<input type="password" size="40"  maxlength="250" name="passwort"><br>
 
Passwort wiederholen:<br>
<input type="password" size="40" maxlength="250" name="passwort2"><br><br>
 
<input type="submit" value="Abschicken">
</form>

<a href="login.php">Einloggen</a>  
<a href="pwvergessen.php">Passwort vergessen</a>

<?php
} //Ende von if($showFormular)
?>
 
</body>
</html>