<?php


/**
 * Die Klasse Session beinhaltet Funktionen rund um die Session. Es gibt eine login(), register() und eine logout() Funktion.
 */
class Session
{
  /**
  * Diese Funktion wird aufgerufen, wenn der Login Button in der index.php geklickt wurde.
  * Hier wird geprüft, ob der eingegebene User existiert und, ob das Passwort korrekt ist.
  * Es wird auch die Session-Variable 'score' initialisiert und auf den Wert der Datenbank gesetzt.
  * @return String gibt eine Fehlermeldung im Fehlerfall aus
  */
  function login(){
    include 'config.php';
    $username = $_POST['username'];
    $passwort = $_POST['passwort'];

    $statement = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $result = $statement->execute(array('username' => $username));
    $user = $statement->fetch();

    //Ueberpruefung des Passworts
    if ($user !== false && password_verify($passwort, $user['passwort'])) {
    	$_SESSION['userid'] = $user['id'];
      $stmt = $pdo->prepare("SELECT score FROM spielstand WHERE spielerid = :userid");
      $stmt->bindParam(':userid', $_SESSION['userid']);
      $result = $stmt->execute();
      $score = $stmt->fetch();
      $_SESSION['score'] = $score[0];
    	if(session_regenerate_id()) header("Location: game.php");
    	exit;
    }
    //Wenn kein User in der Datenbank gefunden wurde.
    if(!$user) {
      return "Dieser Benutzername wurde nicht gefunden.";
    }
    // Wenn das falsche Passwort eingegebene wurde:
    if(password_verify($passwort, $user['passwort'])==false) {
    		return "Bitte geben Sie das richtige Passwort ein.";
    }
  }
  /**
  * Diese Funktion wird aufgerufen, wenn der Register Button in der index.php geklickt wurde.
  * Dabei werden die Eingaben auf Plausibilität geprüft. Es kann auch kein User oder keine E-Mailadresse dopppelt vergeben werden.
  * @return String gibt eine Fehlermeldung im Fehlerfall aus. Ansonsten wird eine Erfolgsmeldung ausgegeben.
  */
  function register(){
    include 'config.php';
    $error = false;
    $username = $_POST['username'];
    $email = $_POST['email'];
    $passwort = $_POST['passwort'];
    $passwort2 = $_POST['passwort2'];

    if(strlen($username) == 0) {
    	return 'Bitte einen Username eingeben.';
    	$error = true;
    }
    if(strlen($email) == 0) {
    	return 'Bitte eine E-Mailadresse eingeben.';
    	$error = true;
    }
    if(strlen($passwort) == 0) {
    	return 'Bitte ein Passwort angeben.';
    	$error = true;
    }
    if($passwort != $passwort2) {
    	return 'Die Passwoerter muessen übereinstimmen.';
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
    		return 'Diese E-Mailadresse ist bereits vergeben.';
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
    		return 'Dieser Username ist bereits vergeben.';
    		$error = true;
    	}
    }
    /**
     * Wenn keine Fehler, kann der Nutzer registriert werden.
     * Password wird gehasht, anschliessend ein Prepared Statement fuer die Restrierung erstellt und die eingegeben Daten in die DB gespeichert.
     */
    if(!$error) {
    	$passwort_hash = password_hash($passwort, PASSWORD_DEFAULT);

    	$statement = $pdo->prepare("INSERT INTO users (username, email, passwort) VALUES (:username, :email, :passwort)");
    	$result = $statement->execute(array('username' => $username, 'email' => $email, 'passwort' => $passwort_hash));
    	if($result) {
    		return 'Du wurdest erfolgreich registriert.';
    	} else {
    		return 'Beim Abspeichern ist leider ein Fehler aufgetreten<br>';
    	}
    }
  }
  /**
  * Die Logout Funktion loggt einen User aus dem Spiel per Klick auf den Button Logout aus.
  * Der Spielstand wird hier nicht gespeichert.
  * @return Boolean Falls der Logout-Prozess erfolgreich ist, wird true ausgegeben.
  */
  function logout(){
    session_start();
    $_SESSION = array();
    session_destroy();
    session_regenerate_id();
    return true;
  }
}
?>
