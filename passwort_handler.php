<?php
/**
 *
 * Anschließend:
 *
 * Überpruefung, ob eine E-Mailadresse übergeben wurde und entsprechende Anforderung falls nicht.
 * Wenn eine E-Mailadresse übergeben wurde, wird diese per Prepared Statement in der DB gesucht und die Userdaten abgefragt.
 * Anschließend wird geprüft, ob der User gefunden wurde (Daten in Variable gespeichert wurden) und ob es bereits einen gültigen Passwortcode gibt.
 * Es wird ein Passwortcode per random-Funktion (s.o.) erstellt und gehasht in der DB gespeichert. Auch wird ein Timestamp gesetzt, sodass das Alter des Codes gespeichert ist.
 * Der Passwortcode wird in die Password-Zuruecksetzen-URL integriert und der E-Mail-Text mit dem Username sowie dem Link um das Passwort zurueckzusetzen erstellt.
 * Daraufhin wird die Mail Variable mit den notwendigen Mailadressen etc. gefuellt.
 * Zuletzt wird die Mail versendet und eine Nachricht ueber den Erfolg oder Misserfolg ausgegeben.
 */
/**
 *
 */
class Passwort_Handler
{
	/**
	 * Funktion um einen zufälligen String zur Passwortwiederherstellung zu generieren.
	 * @return String
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
	/**
	 * Gibt einen Error- bzw. Erfolgsstring zurück.
	 * @return string
	 */
	function send_pwforgotmail(){
		include 'config.php';
			try {
				if(!isset($_POST['email']) || empty($_POST['email'])) {
					$error = "Bitte eine E-Mail-Adresse eintragen";
				} else {
					//Holt den passenden Datensatz aus der users Tabelle zur eingebenen E-Mail-Adresse
					$statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
					$result = $statement->execute(array('email' => $_POST['email']));
					$user = $statement->fetch();
					//Es wird hier anhand der eingebenen E-Mail geprüft, ob diese E-Mail überhaupt in der Datenbank vorhanden ist.
					if($user === false) {
						$error = "Kein Benutzer gefunden";
					} else {
						//Time auf 24h gesetzt.
						if(strtotime($user['passwortcode_time']) > (time()-24*3600)) {
							$error = "Es wurde bereits ein Passwortcode verschickt.";
						}
						else{
							// aus dem Pear-Package Mail:
							require_once 'Mail.php';
							// Generierung eines zufälligen Strings. Dieser wird in das Feld passwortcode der users Tabelle gesetzt und zusätzlich
							// per sha1 verschlüsselt.
							$passwortcode = $this->random_string();
							$_GET['code'] = $passwortcode;
							$_GET['userid'] = $user['ID'];
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
								$error = "Die E-Mail konnte nicht versendet werden. " .$result->getMessage();
							} else {
								$error = "Die E-Mail wurde versendet!";
							}
							$showForm = false;
						}
					}
				}
				
				return $error;
			} catch (Exception $e) {
				return "Ein Fehler ist aufgetreten.";
			}
	}
	
	/**
	 * Versucht das Passwort mithilfe des in der URL eingegeben Codes zurückzusetzen.
	 * Es wird eine Fehler- oder Erfolgsmeldung als String zurückgegeben.
	 * @return string
	 */
  function pwreset(){
  	include 'config.php';
  	try {
  		if(!isset($_GET['userid']) || !isset($_GET['code'])) {
  			return "Leider wurde kein Code zum Zurücksetzen deines Passworts übermittelt";
  		}
  		
  		$userid = $_GET['userid'];
  		$code = $_GET['code'];
  		
  		//Abfrage des Nutzers
  		$statement = $pdo->prepare("SELECT * FROM users WHERE id = :userid");
  		$result = $statement->execute(array('userid' => $userid));
  		$user = $statement->fetch();
  		
  		//Überprüfe dass ein Nutzer gefunden wurde und dieser auch ein Passwortcode hat
  		if($user === null || $user['passwortcode'] === null) {
  			return "Es wurde kein passender Benutzer gefunden";
  		}
  		
  		//Überprüfe, ob ein gültiger Code in der Datenbank hinterlegt ist.
  		if($user['passwortcode_time'] === null || strtotime($user['passwortcode_time']) < (time()-24*3600) ) {
  			return "Dein Code ist leider abgelaufen";
  		}
  		
  		
  		//Überprüfe den Passwortcode
  		if(sha1($code) != $user['passwortcode']) {
  			return "Der übergebene Code war ungültig. Stell sicher, dass du den genauen Link in der URL aufgerufen hast.";
  		}
  		
  		//Der Code war korrekt, der Nutzer darf ein neues Passwort eingeben
  		
  		if(isset($_GET['send'])) {
  			$passwort = $_POST['passwort'];
  			$passwort2 = $_POST['passwort2'];
  			
  			if($passwort != $passwort2){
  				return $error = "Bitte identische Passwörter eingeben";
  			} else { //Speichere neues Passwort und lösche den Code
  				$passworthash = password_hash($passwort, PASSWORD_DEFAULT);
  				$statement = $pdo->prepare("UPDATE users SET passwort = :passworthash, passwortcode = NULL, passwortcode_time = NULL WHERE id = :userid");
  				$result = $statement->execute(array('passworthash' => $passworthash, 'userid'=> $userid ));
  				
  				if($result) {
  					return "Dein Passwort wurde erfolgreich geändert";
  				}
  			}
  		}
  	} catch (Exception $e) {
  		return "Ein Fehler ist aufgetreten.";
  	}
		
  }
  
	/**
	 * Passwortändern-Funktion
	 * Nimmt die ID aus der Session-Variablen und überprüft das eingebene currentPassword mit dem in der DB hinterlegten.
	 * Bei richtigem Passwort wird die Übereinstimmung des neuen Passworts überprüft und anschließend geändert. 
	 * @return Messagestring
	 */
	function pwchange() {
		include 'config.php';
		if(isset($_SESSION['userid'])){
			try {
				if(count($_POST)>0) {
					$statement = $pdo->prepare("SELECT * FROM users WHERE userId= :userid");
					$result = $statement->execute(array('userid' => $_SESSION['userid']));
					$user = $statement->fetch();
					
					if(password_verify($_POST['currentPassword'], $user['passwort'])){
						if($_POST['newpassword'] == $_POST['confirmpassword']){
							$statement = $pdo->prepare("UPDATE users set password=':newpassword' WHERE userId='" . $_SESSION['userid'] . "'");
							$statement->execute(array('newpassword' => $_POST['newPassword'], 'userid' => $_SESSION['userid']));
							return "Das Passwort wurde erfolgreich geändert.";
						}
						else return "Die Passwörter stimmten nicht überein.";
					}
					else return "Das aktuelle Passwort war fehlerhaft.";
				}
			} catch (Exception $e) {
				return "Ein Fehler ist aufgetreten.";
			}
		}
		else "Es ist ein Fehler aufgetreten.";
		
		
	}
	

}
?>
