<?php
class Pokemon{
  function get_pokemon_in_json(){
    include 'config.php';
    include 'spielstand_Handler.php';
    $spielstand_check = Spielstand_Handler::check_spielstand();

    $stmt = $pdo->prepare("SELECT pokemon FROM spielstand WHERE spielerid = :userid");
    $stmt->bindParam(':userid', $_SESSION['userid']);
    $result = $stmt->execute();
    $pokemonid = $stmt->fetch();

    $stmt = $pdo->prepare("SELECT pokename, kp, staerke, att1, att2, att3,att4, pfad FROM pokemon WHERE id = :pokemonid");
    $stmt->bindParam(':pokemonid', $pokemonid[0]);
    $result = $stmt->execute();
    $pokemon = $stmt->fetch();

    $stmt = $pdo->prepare("SELECT name, schaden FROM attacken WHERE id = :att1");
    $stmt->bindParam(':att1', $pokemon[3]);
    $result = $stmt->execute();
    $att1 = $stmt->fetch();


    $stmt = $pdo->prepare("SELECT name, schaden FROM attacken WHERE id = :att2");
    $stmt->bindParam(':att2', $pokemon[4]);
    $result = $stmt->execute();
    $att2 = $stmt->fetch();

    $stmt = $pdo->prepare("SELECT name, schaden FROM attacken WHERE id = :att3");
    $stmt->bindParam(':att3', $pokemon[5]);
    $result = $stmt->execute();
    $att3 = $stmt->fetch();

    $stmt = $pdo->prepare("SELECT name, schaden FROM attacken WHERE id = :att4");
    $stmt->bindParam(':att4', $pokemon[6]);
    $result = $stmt->execute();
    $att4 = $stmt->fetch();

    $pokename = $pokemon[0];
    $kp = $pokemon[1];
    $staerke = $pokemon[2];
    $attname1 = $att1[0];
    $attschaden1 = $att1[1];
    $attname2 = $att2[0];
    $attschaden2 = $att2[1];
    $attname3 = $att3[0];
    $attschaden3 = $att3[1];
    $attname4 = $att4[0];
    $attschaden4 = $att4[1];
    $pfad = $pokemon[7];

    $json = '{
    	"spielstand_check": '.$spielstand_check.',
    	"pokename": "'.$pokename.'",
    	"kp": '.$kp.',
    	"staerke": '.$staerke.',
    	"attname1": "'.$attname1.'",
    	"attschaden1": '.$attschaden1.',
    	"attname2": "'.$attname2.'",
    	"attschaden2": '.$attschaden2.',
    	"attname3": "'.$attname3.'",
    	"attschaden3": '.$attschaden3.',
    	"attname4": "'.$attname4.'",
    	"attschaden4": '.$attschaden4.',
    	"pfad": "'.$pfad.'"
    }';
    return $json;
  }

  function get_random_pokemon(){
    include 'config.php';

    $stmt = $pdo->prepare("SELECT pokename, kp, staerke, att1, att2, att3,att4, pfad FROM pokemon WHERE id = :pokemonid");
    $stmt->bindParam(':pokemonid', rand(1,3));
    $result = $stmt->execute();
    $pokemon = $stmt->fetch();

    $stmt = $pdo->prepare("SELECT name, schaden FROM attacken WHERE id = :att1");
    $stmt->bindParam(':att1', $pokemon[3]);
    $result = $stmt->execute();
    $att1 = $stmt->fetch();


    $stmt = $pdo->prepare("SELECT name, schaden FROM attacken WHERE id = :att2");
    $stmt->bindParam(':att2', $pokemon[4]);
    $result = $stmt->execute();
    $att2 = $stmt->fetch();

    $stmt = $pdo->prepare("SELECT name, schaden FROM attacken WHERE id = :att3");
    $stmt->bindParam(':att3', $pokemon[5]);
    $result = $stmt->execute();
    $att3 = $stmt->fetch();

    $stmt = $pdo->prepare("SELECT name, schaden FROM attacken WHERE id = :att4");
    $stmt->bindParam(':att4', $pokemon[6]);
    $result = $stmt->execute();
    $att4 = $stmt->fetch();

    $pokename = $pokemon[0];
    $kp = $pokemon[1];
    $staerke = $pokemon[2];
    $attname1 = $att1[0];
    $attschaden1 = $att1[1];
    $attname2 = $att2[0];
    $attschaden2 = $att2[1];
    $attname3 = $att3[0];
    $attschaden3 = $att3[1];
    $attname4 = $att4[0];
    $attschaden4 = $att4[1];
    $pfad = $pokemon[7];

    $json = '{
      "spielstand_check": '.$spielstand_check.',
      "pokename": "'.$pokename.'",
      "kp": '.$kp.',
      "staerke": '.$staerke.',
      "attname1": "'.$attname1.'",
      "attschaden1": '.$attschaden1.',
      "attname2": "'.$attname2.'",
      "attschaden2": '.$attschaden2.',
      "attname3": "'.$attname3.'",
      "attschaden3": '.$attschaden3.',
      "attname4": "'.$attname4.'",
      "attschaden4": '.$attschaden4.',
      "pfad": "'.$pfad.'"
    }';
    return $json;



  }



}



 ?>
