<?php
include 'config.php'

$userid = $_SESSION['userid'];
$statement = $pdo->prepare("SELECT * FROM spielstand WHERE spielerid = :id");
$result = $statement->execute(array('id' => $userid));
$spielstand = $statement->fetch();

 ?>
