<?php
//	ini_set('display_errors', 0);

try {
	$pdo = new PDO('mysql:host=instanz1.cf6ecdewusof.eu-central-1.rds.amazonaws.com:3306;dbname=php','benutzer', 'passwort');
} catch (Exception $e) {
	print "Error!:" . $e->getMessage() . "<br/>";
	die();
}

/**
 * Funktion um einen zuf�lligen String zur Passwortwiederherstellung zu generieren.
 */
function random_string() {
	if(function_exists('random_bytes')) {
		$bytes = random_bytes(16);
		$str = bin2hex($bytes);
	} else if(function_exists('openssl_random_pseudo_bytes')) {
		$bytes = openssl_random_pseudo_bytes(16);
		$str = bin2hex($bytes);
	} else if(function_exists('mcrypt_create_iv')) {
		$bytes = mcrypt_create_iv(16, MCRYPT_DEV_URANDOM);
		$str = bin2hex($bytes);
	} else {
		$str = md5(uniqid('KUI&RIt23Q41', true));
	}
	return $str;
}

$showForm = true;

/**
 * �berpr�fung, ob eine E-Mailadresse �bergeben wurde und entsprechende Anforderung, falls nein.
 * Wenn eine E-Mailadresse �bergeben wurde, wird diese per Prepared Statement in der DB gesucht und die Userdaten abgefragt.
 * Anschlie�end wird gepr�ft, ob der User gefunden wurde (Daten in Variable gespeichert wurden) und ob es bereits einen g�ltigen Passwortcode gibt.
 * Es wird ein Passwortcode per random-Funktion (s.o.) erstellt und gehasht in der DB gespeichert. Auch wird ein Timestamp gesetzt, sodass das Alter des Codes gespeichert ist.
 * Der Passwortcode wird in die Password-Zur�cksetzen-URL integriert und per mail-Funktion an die E-Mailadresse des Users geschickt.
 */

if(isset($_GET['send']) ) {
	if(!isset($_POST['email']) || empty($_POST['email'])) {
		$error = "<b>Bitte eine E-Mail-Adresse eintragen</b>";
	} else {
		$statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
		$result = $statement->execute(array('email' => $_POST['email']));
		$user = $statement->fetch();

		if($user === false) {
			$error = "<b>Kein Benutzer gefunden</b>";
		} else {
			if(strtotime($user['passwortcode_time']) > (time()-24*3600)) {
				$error = "<b>Es wurde bereits ein Passwortcode verschickt.</b>";
			}
			else{
				require_once 'Mail.php';
				$passwortcode = random_string();
				$statement = $pdo->prepare("UPDATE users SET passwortcode = :passwortcode, passwortcode_time = NOW() WHERE id = :userid");
				$result = $statement->execute(array('passwortcode' => sha1($passwortcode), 'userid' => $user['ID']));

				// $empfaenger = $user['email'];
				// $betreff = "Neues Passwort f�r deinen Pokemon-Account";
				// $from = "From: WI 47/15 <maltepeters@gmx.de>";
				$url_passwortcode = 'http://localhost/pwreset.php?userid='.$user['ID'].'&code='.$passwortcode;
// 				$text = 'Hallo '.$user['username'].',
// f�r deinen Pokemon-Account wurde nach einem neuen Passwort gefragt. Um ein neues Passwort zu vergeben, rufe innerhalb der n�chsten 24 Stunden die folgende Website auf:
// '.$url_passwortcode.'
//
// Sollte dir dein Passwort wieder eingefallen sein oder hast du dies nicht angefordert, kannst du diese E-Mail einfach ignorieren.
//
// Liebe Gr��e,
// dein Pokemon-Team';
				define('BODY','Hallo '.$user['username'].',
für deinen Pokemon-Account wurde nach einem neuen Passwort gefragt. Um ein neues Passwort zu vergeben, rufe innerhalb der n�chsten 24 Stunden die folgende Website auf:
'.$url_passwortcode.'

Sollte dir dein Passwort wieder eingefallen sein oder hast du dies nicht angefordert, kannst du diese E-Mail einfach ignorieren.

Liebe Grüße,
dein Pokemon-Team');
				$headers = array (
				'From' => 'poke.game@web.de',
				'To' =>  $user['email'],
				'Subject' => 'Neues Passwort für deinen Pokemon-Account');
				$smtpParams = array (
						'host' => 'smtp.web.de',
						'port' => '587',
						'auth' => true,
						'username' => 'poke.game@web.de',
						'password' => 'pokemon01'
					);
				$mail = Mail::factory('smtp', $smtpParams);

				// Send the email.
				$result = $mail->send($user['email'], $headers, BODY);

				if (PEAR::isError($result)) {
						echo("Email not sent. " .$result->getMessage() ."\n");
					} else {
						echo("Email sent!"."\n");
					}
				$showForm = false;
			}
		}
	}
}

if($showForm):
?>

<h1>Passwort vergessen</h1>
Gib hier deine E-Mail-Adresse ein, um ein neues Passwort anzufordern.<br><br>

<?php
if(isset($error) && !empty($error)) {
 echo $error;
}
?>

<head>
<link href="background.css" rel="stylesheet">
<link rel="shortcut icon" type="image/x-icon" href="bilder/pokeball.ico" />
</head>
<form action="?send=1" method="post">
E-Mail:<br>
<input type="email" name="email" value="<?php echo isset($_POST['email']) ? htmlentities($_POST['email']) : ''; ?>"><br>
<input type="submit" value="Neues Passwort">

<br><br>
<a href="login.php"><button name=login type="button">Einloggen</button></a>
<a href="register.php"><button name=register type="button">Registrieren</button></a>

</form>



<?php
endif; //Endif von if($showForm)
?>
