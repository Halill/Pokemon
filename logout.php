<?php

if(isset($_POST['sent'])){
  session_start();
  $_SESSION = array();
  session_destroy();
  session_regenerate_id();
  $erfolgreich = true;
}

?>
