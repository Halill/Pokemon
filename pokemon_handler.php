<?php

/**
* Die Klasse Pokemon beinhaltet Schnittstellenfunktionen zwischen dem Spiel (der app.js) und der Datenbank.
*
*/
class Pokemon{

  /**
  * Diese Funktion sammelt Informationen über das Pokemon des Users aus der Datenbank
  * Diese Informationen werden gesammelt und dann in eine Variable json gespeichert.
  * Diese hat das Format einer JSON Datei.
  * @return json Informationen über das Pokemon des Users in JSON-Format
  */
  function get_pokemon_in_json(){
    include 'config.php';
    include 'spielstand_Handler.php';
    $spielstand_check = Spielstand_Handler::check_spielstand();

    $stmt = $pdo->prepare("SELECT pokemon, score FROM spielstand WHERE spielerid = :userid");
    $stmt->bindParam(':userid', $_SESSION['userid']);
    $result = $stmt->execute();
    $pokemonid = $stmt->fetch();
    $score = $pokemonid[1];
    $stmt = $pdo->prepare("SELECT pokename, kp, staerke, att1, att2, att3,att4,id FROM pokemon WHERE id = :pokemonid");
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

    // Der Score hat Einfluss auf das Pokemon:
    // Je öfters gewonnen wird (siehe @method setScore()), desto stärker wird das Pokemon.
    if($score>0){
        $kp = $pokemon[1]+$score;
        $staerke = $pokemon[2]+($score/10);
    }
    // Die Basiskampfwerte stehen in der Datenbank
    else {
      $kp = $pokemon[1];
      $staerke = $pokemon[2];
    }
    // Die Informationen werden zur Übersicht nochmal in eine Zwischenvariable gespeichert
	  $pokename = $pokemon[0];
    $attname1 = $att1[0];
    $attschaden1 = $att1[1];
    $attname2 = $att2[0];
    $attschaden2 = $att2[1];
    $attname3 = $att3[0];
    $attschaden3 = $att3[1];
    $attname4 = $att4[0];
    $attschaden4 = $att4[1];

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
    	"id": '.$pokemon[7].'
    }';
    return $json;
  }
  /**
  * Diese Funktion sammelt Informationen über das gegnerische Pokemon aus der Datenbank.
  * Das Pokemon wird zufällig ausgewählt.
  * Diese Informationen werden gesammelt und dann in eine Variable json gespeichert.
  * Diese hat das Format einer JSON Datei.
  *
  * @return json Informationen über das Pokemon in JSON-Format
  */
  function get_random_pokemon(){
    include 'config.php';
    $random = rand(1,3);
    $stmt = $pdo->prepare("SELECT pokename, kp, staerke, att1, att2, att3,att4, id FROM pokemon WHERE id = :pokemonid");
    $stmt->bindParam(':pokemonid', $random);
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

    // Die Informationen werden zur Übersicht nochmal in eine Zwischenvariable gespeichert
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
    $id = $pokemon[7];

    $json = '{
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
    	"id": '.$id.'
    }';
    return $json;
  }

  /**
  * Der Score eines users wird in den Session-Variablen gespeichert.
  * Wird ein Kampf gewonnen, erhöht sich der Score um 1.
  */
  function setScore(){
      $_SESSION['score'] = $_SESSION['score']+1;
  }
}
?>
