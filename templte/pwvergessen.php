<?php
ini_set('display_errors', 1);

include 'config.php';

/**
 * Funktion um einen zufaelligen String zur Passwortwiederherstellung zu generieren.
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
 * Ueberpruefung, ob eine E-Mailadresse uebergeben wurde und entsprechende Anforderung falls nicht.
 * Wenn eine E-Mailadresse uebergeben wurde, wird diese per Prepared Statement in der DB gesucht und die Userdaten abgefragt.
 * Anschliessend wird geprueft, ob der User gefunden wurde (Daten in Variable gespeichert wurden) und ob es bereits einen gueltigen Passwortcode gibt.
 * Es wird ein Passwortcode per random-Funktion (s.o.) erstellt und gehasht in der DB gespeichert. Auch wird ein Timestamp gesetzt, sodass das Alter des Codes gespeichert ist.
 * Der Passwortcode wird in die Password-Zuruecksetzen-URL integriert und der E-Mail-Text mit dem Username sowie dem Link um das Passwort zurueckzusetzen erstellt.
 * Daraufhin wird die Mail Variable mit den notwendigen Mailadressen etc. gefuellt.
 * Zuletzt wird die Mail versendet und eine Nachricht ueber den Erfolg oder Misserfolg ausgegeben.
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
		
				$url_passwortcode = 'http://localhost/pwreset.php?userid='.$user['ID'].'&code='.$passwortcode;
						
				// Hier wird der Mailtext erstellt
				define('BODY','Hallo '.$user['username'].',
fuer deinen Pokemon-Account wurde nach einem neuen Passwort gefragt. Um ein neues Passwort zu vergeben, rufe innerhalb der naechsten 24 Stunden die folgende Website auf:
'.$url_passwortcode.'
						
Sollte dir dein Passwort wieder eingefallen sein oder hast du dies nicht angefordert, kannst du diese E-Mail einfach ignorieren.
						
Liebe Gruesse,
dein Pokemon-Team');
				
				// Hier werden die Daten zum Versenden der Mail definiert und vorbereitet
				$headers = array (
						'From' => 'poke.game@web.de',
						'To' =>  $user['email'],
						'Subject' => 'Neues Passwort fuer deinen Pokemon-Account');
				$smtpParams = array (
						'host' => 'smtp.web.de',
						'port' => '587',
						'auth' => true,
						'username' => 'poke.game@web.de',
						'password' => 'pokemon01'
				);
				$mail = Mail::factory('smtp', $smtpParams);
				
				// Hier wird die Mail versendet 
				$result = $mail->send($user['email'], $headers, BODY);
				
				if (PEAR::isError($result)) {
					echo("Die E-Mail konnte nicht versendet werden. " .$result->getMessage() ."\n");
				} else {
					echo("Die E-Mail wurde versendet!"."\n");
				}
				$showForm = false;
			}
		}
	}
}

if($showForm){}
?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Pokemon-Game</title>
  <link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,300,600' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">

      <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <div class="form">
      
      <ul class="tab-group">
        <li class="tab"><a href="#login">Login</a></li>
        <li class="tab active"><a href="#pw">Passwort vergessen</a></li>
      </ul>
      
      <div class="tab-content">

<!-- Hier beginnt die Passwort-vergessen-Seite -->      
       <div id="pw">
              
          <h1>Passwort vergessen!</h1>
          <br><br>
          <form action="?email=1" method="post">

          <div class="field-wrap">
            <label>
              E-Mail<span class="req">*</span>
            </label>
            <input type="email" name="email" value="<?php echo isset($_POST['email']) ? htmlentities($_POST['email']) : ''; ?>">
          </div>
                    
       		<input type="image" src="bilder/pokeball.png" alt="Passwort anfordern"/>
    
          </form>
		</div>     
      
</div>
</div> <!-- /form -->
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

    <script src="js/pw.js"></script>

</body>
</html>