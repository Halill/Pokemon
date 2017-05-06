<?php
if(isset($_GET['login'])) {
	include '../login.php';
}

if(isset($_GET['register'])) {
	include '../register.php';
}
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
<!-- Hier wird eine Gruppe gebildet. Standardmaessig ist login aktiv, sodass die login-Seite angezeigt.
Bei Klick auf Registrieren wird ueber die index.js der signup-Tab geoeffnet und login auf hide gesetzt.
 -->
      <ul class="tab-group">
        <li class="tab active"><a href="#login">Login</a></li>
        <li class="tab"><a href="#signup">Registrieren</a></li>
      </ul>

      <div class="tab-content">

<!-- Hier beginnt die Login-Seite -->
       <div id="login">
          <h1>Willkommen!</h1>

          <form action="?login=1" method="post">

            <div class="field-wrap">
            <label>
              Benutzername<span class="req">*</span>
            </label>
            <input type="text" name="username"/>
          </div>

          <div class="field-wrap">
            <label>
              Passwort<span class="req">*</span>
            </label>
            <input type="password" name="passwort"/>
          </div>

          <p class="forgot"><a href="../pwvergessen.php">Passwort vergessen?</a></p>

       	  <input type="image" src="assets/pokeball.png" alt="Anmelden"/>

          </form>

        </div>

 <!-- Hier beginnt die Registrieren-Seite -->
        <div id="signup">
          <h1>Registrieren</h1>

          <form action="/?register=1" method="post">

            <div class="field-wrap">
              <label>
                Benutzername<span class="req">*</span>
              </label>
              <input type="text" required autocomplete="off" name="username"/>
            </div>

          <div class="field-wrap">
            <label>
              E-Mail<span class="req">*</span>
            </label>
            <input type="email"required autocomplete="off" name="email"/>
          </div>

          <div class="field-wrap">
            <label>
              Passwort<span class="req">*</span>
            </label>
            <input type="password"required autocomplete="off" name="passwort"/>
          </div>

          <div class="field-wrap">
            <label>
              Passwort erneut eingeben<span class="req">*</span>
            </label>
            <input type="password" required autocomplete="off" name="passwort2"/>
          </div>

          <input type="image" src="assets/pokeball.png" style="width:150px" alt="Registrieren" />

          </form>

        </div>

  </div><!-- tab-content -->

</div> <!-- /form -->
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

    <script src="js/index.js"></script>

</body>
</html>
