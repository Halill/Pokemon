<?php
session_start();
include '../loggedin.php';
//if(!$_SESSION["ausgabe"]) exit("kein Spielstand vorhanden")
$link = "PlayerMovement.html";
if($_POST["change"]) $link = "pwchange.php";
?>

<!DOCTYPE html>
<html>
<head>

    <link href="/css/style.css" rel="stylesheet">
  	<link rel="shortcut icon" type="image/x-icon" href="bilder/pokeball.ico" />
    <title>Poke-Game</title>
</head>
<body>

 <iframe src=<?php echo htmlentities($link); ?> align="middle" scrolling="no" width="560" height="428"></iframe>


<form method="post" action="logout.php">
  <input value="Logout" type="submit" name="sent">
</form>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
  <input value="Passwort ändern" type="submit" name="change">
</form>
</body>
</html>
