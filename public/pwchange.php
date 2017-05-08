<?php
session_start();
if(!isset($_SESSION['userid'])) {
	header("Location: public");
	die();
}

include '../passwort_handler.php';
$h = NEW Passwort_Handler();
$ausgabe = $h->pwchange();
?>


<html>
<head>

  <title>Pokemon-Game</title>
  <link rel="shortcut icon" type="image/x-icon" href="assets/pokeball.ico" />
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <form name="frmChange" method="post" action="" onSubmit="return validatePassword()">
    <div style="width:500px;">
      <div class="message"><?php echo isset($ausgabe) ? htmlentities($ausgabe) : ''; ?></div>
  <table border="0" cellpadding="10" cellspacing="0" width="500" align="center" class="tblSaveForm">
  <tr>
  <!-- Hallo User -->
  
  </tr>
  
  <tr>
  <!-- aktuelle E-Mailadresse -->
  
  </tr>

  <tr>
      <td><label>Neues Passwort</label></td>
      <td><input type="password" name="newPassword" class="txtField"/><span id="newPassword" class="required"></span></td> 
      <td><label>Neue E-Mail</label></td>
      <td><input type="email" name="newEmail" class="txtField"/><span id="newEmail" class="required"></span></td>
  </tr>
  
  <tr>    
  <td><label>Passwort bestätigen</label></td>
  <td><input type="password" name="confirmPassword" class="txtField"/><span id="confirmPassword" class="required"></span></td>      
  <td><label>E-Mail bestätigen</label></td>
  <td><input type="email" name="confirmEmail" class="txtField"/><span id="confirmEmail" class="required"></span></td>
  </tr>
    <tr>
      <td width="40%"><label>Aktuelles Passwort</label></td>
      <td width="60%"><input type="password" name="currentPassword" class="txtField"/><span id="currentPassword"  class="required"></span></td>
    </tr>
  <tr>
    <td colspan="3"><input type="image" src="assets/pokeball.png" style="width:150px" alt="Registrieren" name='submit'/>
    </td>
  </tr>
  </table>
  </div>
  </form>
</body>
</html>
