<?php
include '../passwort_handler.php';
$h = NEW Passwort_Handler();
$ausgabe = $h->pwreset();
echo $ausgabe;

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
    <li class="tab active"><a href="#reset">Passwort vergessen</a></li>
  </ul>
  <div class="tab-content">
  <div id="reset">
     <h1>Neues Passwort!</h1>

     <form action="?send=1&amp;userid=<?php echo htmlentities($_GET['userid']); ?>&amp;code=<?php echo htmlentities($_GET['code']); ?>" method="post">

       <div class="field-wrap">
       <label>
         Neues Passwort:<span class="req">*</span>
       </label>
       <input type="password" name="passwort"/>
     </div>

     <div class="field-wrap">
       <label>
         Passwort bestätigen:<span class="req">*</span>
       </label>
       <input type="password" name="passwort2"/>
     </div>

     <input type="image" src="assets/pokeball.png" alt="Passwort speichern"/>

     </form>

   </div>
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

      <p class="forgot"><a href="/pwvergessen.php">Passwort vergessen?</a></p>

      <input type="image" src="assets/pokeball.png" alt="Anmelden"/>

      </form>

    </div>
  </div>
  </div>

<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

  <script src="js/pw.js"></script>
</body>
</html>
