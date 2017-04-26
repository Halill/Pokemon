<<?php include '../pwvergessen.php' ?>

<!DOCTYPE html>
<html>
<head>
  <link rel="shortcut icon" type="image/x-icon" href="bilder/pokeball.ico" />
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
