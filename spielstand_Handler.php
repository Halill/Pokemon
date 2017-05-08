<?php

class Spielstand_Handler
{
  function spielstand_speichern(){
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
      return true;
    }
    else {
      return false;
    }
  }
  function spielstand_anlegen($pokemon){
    include 'config.php';
    //Uhrzeit wird generiert, um den Erst-Speicherpunkt zu ermitteln. Ergebnis $saved_at
    date_default_timezone_set("Europe/Berlin");
    $timestamp = time();
    $datum = date("d.m.Y",$timestamp);
    $uhrzeit = date("H:i",$timestamp);
    $saved_at = $datum.' - '.$uhrzeit." Uhr";

    //Hier wird anhand des Namens des Pokemons die ID des Pokemons übermittelt.
    $stmt = $pdo->prepare("SELECT id FROM pokemon WHERE pokename = :pokename");
    $stmt->bindParam(':pokename', $pokemon);
    $result = $stmt->execute();
    $pokemonid = $stmt->fetch();

    $stmt = $pdo->prepare("INSERT INTO spielstand(spielerid,saved_at,score,pokemon) VALUES (:userid, :saved_at, 0, :pokemonid)");
    $stmt->bindParam(':userid', $_SESSION['userid']);
    $stmt->bindParam(':saved_at', $saved_at);
    $stmt->bindParam(':pokemonid', $pokemonid['id']);
    $result = $stmt->execute();
    if($result) return "Spielstand angelegt";
    else {
      return "Spielstand anlegen fehlgeschlagen";
    }

  }

  function spielstand_ueberschreiben($pokemon){
    include 'config.php';
    //Uhrzeit wird generiert, um den Erst-Speicherpunkt zu ermitteln. Ergebnis $saved_at
    date_default_timezone_set("Europe/Berlin");
    $timestamp = time();
    $datum = date("d.m.Y",$timestamp);
    $uhrzeit = date("H:i",$timestamp);
    $saved_at = $datum.' - '.$uhrzeit." Uhr";

    //Hier wird anhand des Namens des Pokemons die ID des Pokemons übermittelt.
    $stmt = $pdo->prepare("SELECT id FROM pokemon WHERE pokename = :pokename");
    $stmt->bindParam(':pokename', $pokemon);
    $result = $stmt->execute();
    $pokemonid = $stmt->fetch();

    $stmt = $pdo->prepare("UPDATE spielstand SET saved_at = :saved_at, score = 0, pokemon = :pokemonid WHERE spielerid = :userid");
    $stmt->bindParam(':userid', $_SESSION['userid']);
    $stmt->bindParam(':saved_at', $saved_at);
    $stmt->bindParam(':pokemonid', $pokemonid['id']);
    $result = $stmt->execute();
    if($result) return "Spielstand angelegt";
    else {
      return "Spielstand anlegen fehlgeschlagen";
    }

  }

  function spielstand_laden(){
    include 'config.php';

    $stmt = $pdo->prepare("SELECT username FROM users WHERE ID = :userid");
    $stmt->bindParam(':userid', $_SESSION['userid']);
    $result = $stmt->execute();
    $result = $stmt->fetch();
    $spielername = $result[0];

    $stmt = $pdo->prepare("SELECT saved_at, score, pokemon FROM spielstand WHERE spielerid = :userid");
    $stmt->bindParam(':userid', $_SESSION['userid']);
    $result = $stmt->execute();
    $result = $stmt->fetch();

    $saved_at = $result[0];
    $score = $result[1];
    $pokemonid = $result[2];

    $stmt = $pdo->prepare("SELECT pokename FROM pokemon WHERE id = :pokemonid");
    $stmt->bindParam(':pokemonid', $pokemonid);
    $result = $stmt->execute();
    $result = $stmt->fetch();

    $pokemon = $result[0];


    $spielstand = array(
    "Spielername: " => $spielername,
    "Zuletzt gespeichert: " => $saved_at,
    "Score: " => $score,
    "Pokemon: " => $pokemon,
    );
    return $spielstand;

  }
  function check_spielstand(){
    include 'config.php';
    $statement = $pdo->prepare("SELECT * FROM spielstand WHERE spielerid = :id");
    $result = $statement->execute(array('id' => $_SESSION['userid']));
    $result = $statement->fetch();
    if($result) return true;
    else {
      return false;
    }



  }
}



 ?>
