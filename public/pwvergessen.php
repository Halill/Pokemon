<?php
/**
* Die pwvergessen.php wird aufgerufen, wenn in der index.php der Button "Passwort vergessen?" geklickt wurde.
* Hier muss der registrierte User seine E-Mailadresse eingeben.
* Ist diese in der Datenbank vorhanden, wird eine E-Mail an diese geschickt.
* Bei Fehleingaben werden per Popup Fehlermeldungen angezeigt.
*/
session_start();
if(isset($_POST['email'])){
	include '../passwort_handler.php';
    $h = NEW Passwort_Handler();
    $ausgabe = $h->send_pwforgotmail();
}
if(isset($ausgabe))
	echo'<script type="text/javascript" language="Javascript"> alert("'.htmlentities($ausgabe).'") </script>';
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="shortcut icon" type="image/x-icon" href="assets/pokeball.ico" />
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
				<br>
				<br>

				<form action="?email=1" method="post">
					<div class="field-wrap">
						<label>E-Mail<span class="req">*</span></label>
						<input type="email" name="email" value="<?php echo isset($_POST['email']) ? htmlentities($_POST['email']) : ''; ?>">
					</div>
					<input type="image" src="assets/pokeball.png" alt="Passwort anfordern"/>
				</form>

			</div>
			<div id="login">
				<form action="?login=1" method="post">
					<div class="field-wrap">
						<label>Benutzername<span class="req">*</span></label>
						<input type="text" name="username"/>
					</div>

					<div class="field-wrap">
						<label>Passwort<span class="req">*</span></label>
						<input type="password" name="passwort"/>
					</div>

					<p class="forgot"><a href="/pwvergessen.php">Passwort vergessen?</a></p>

					<input type="image" src="assets/pokeball.png" alt="Anmelden"/>

				</form>
			</div>
		</div>
	</div> <!-- /form -->
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src="js/pw.js"></script>
</body>
</html>
