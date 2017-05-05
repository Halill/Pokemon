<?php

include 'config.php';

$userid = $_SESSION['userid'];
$statement = $pdo->prepare("SELECT * FROM spielstand WHERE spielerid = :id");
$result = $statement->execute(array('id' => $userid));
$spielstand = $statement->fetch();
$_SESSION['spielstand'] = $spielstand;



//
// if($spielstand[1]==$userid){
//   $spielstandid = $spielstand[0];
//   $speicherdatum = $spielstand[2];
// }
?>
