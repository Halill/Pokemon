<?php
include '../pwchange.php';

?>


<html>
<head>
  <title>Pokemon-Game</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <form name="frmChange" method="post" action="" onSubmit="return validatePassword()">
    <div style="width:500px;">
      <div class="message"><?php if(isset($message)) { echo $message; } ?></div>
  <table border="0" cellpadding="10" cellspacing="0" width="500" align="center" class="tblSaveForm">
    <tr class="tableheader">
      <td colspan="2">Passwort ändern</td>
    </tr>
    <tr>
      <td width="40%"><label>Aktuelles Passwort</label></td>
      <td width="60%"><input type="password" name="currentPassword" class="txtField"/><span id="currentPassword"  class="required"></span></td>
    </tr>
    <tr>
      <td><label>Neues Passwort</label></td>
      <td><input type="password" name="newPassword" class="txtField"/><span id="newPassword" class="required"></span></td>
  </tr>
  <td><label>Passwort bestätigen</label></td>
  <td><input type="password" name="confirmPassword" class="txtField"/><span id="confirmPassword" class="required"></span></td>
  </tr>
  <tr>
    <td colspan="2"><input type="image" src="assets/pokeball.png" style="width:150px" alt="Registrieren" name='submit'/>
    </td>
  </tr>
  </table>
  </div>
  </form>
</body>
</html>
