<?php
include 'config.php';


date_default_timezone_set("Europe/Berlin");
$timestamp = time();

$datum = date("d.m.Y",$timestamp);
$uhrzeit = date("H:i",$timestamp);
$saved_at = $datum.' - '.$uhrzeit." Uhr";

$stmt = $pdo->prepare("UPDATE spielstand SET saved_at = :saved_at WHERE spielerid = :userid");
$stmt->bindParam(':saved_at', $saved_at);
$stmt->bindParam(':userid', $_SESSION['userid']);
$result = $stmt->execute();
//cstmt=check statement, Variablen mit c -> check Variablen, also um zu prüfen, ob der Datenbankeintrag funktioniert hat
$cstmt = $pdo->prepare("SELECT saved_at FROM spielstand WHERE spielerid = :userid");
$cstmt->bindParam(':userid', $_SESSION['userid']);
$result = $cstmt->execute();
$csaved_at = $cstmt->fetch();
if($csaved_at['saved_at']==$saved_at){
  $ausgabe = true;
}
else {
  $ausgabe = false;
}
 ?>
