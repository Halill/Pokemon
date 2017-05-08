<?php
session_start();
include '../config.php';
include '../spielstand_Handler.php';
$spielstand_check = Spielstand_Handler::check_spielstand();

$json = '{
	"spielstand_check": '.$spielstand_check.',
}';
echo json_encode($json);


?>
