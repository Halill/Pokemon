<?php

/**
* Die Klasse Spielstand_Handler beinhaltet Funktionen rund um die Spielstandverwaltung.
* Ein Spielstand kann gespeichert, geladen, überschrieben und angelegt werden.
* Zusätzlich gibt es eine Methode check_spielstand() die prüft, ob ein Spielstand vorhanden ist.
* Die ranking() Methode ist für die Anzeige auf der Ranking Seite gedacht.
*/
class Spielstand_Handler
{
  /**
  * Diese Funktion speichert einen Spielstand bei Klick auf den Button Speichern in der game.php
  * Zunächst wird die aktuelle Zeit in die Variable $saved_at gespeichert.
  * Gespeichert wird die Variable saved_at und der score.
  */
  function spielstand_speichern(){
    include 'config.php';
    // Ermittlung der aktuellen Zeit und Datum und Speicherung in Variable $saved_at
    date_default_timezone_set("Europe/Berlin");
    $timestamp = time();
    $datum = date("d.m.Y",$timestamp);
    $uhrzeit = date("H:i",$timestamp);
    $saved_at = $datum.' - '.$uhrzeit." Uhr";

    //Speicherung des scores und der Variable saved_at
    $stmt = $pdo->prepare("UPDATE spielstand SET saved_at = :saved_at, score = :score WHERE spielerid = :userid");
    $stmt->bindParam(':saved_at', $saved_at);
    $stmt->bindParam(':score', $_SESSION['score']);
    $stmt->bindParam(':userid', $_SESSION['userid']);
    $result = $stmt->execute();

    if($result) return true;
    else return false;
  }

  /**
  * Diese Funktion wird einmalig aufgerufen, wenn der User noch keinen Spielstand besitzt.
  * Die Funktion wird in der intro.php aufgerufen.
  * Die Pokemon ID wird aus der Datenbank über den Pokemonnamen ermittelt und in den Spielstand geschrieben.
  * Daneben wird noch die User ID und die Variable saved_at in den Spielstand geschrieben.
  * Der Score wird bei Anlage auf 0 gesetzt.
  * @param $pokemon Hier wird der Pokemonname  des Pokemons übergeben, welchen der User ausgesucht hat
  * @return String Gibt über einen String aus, ob die Anlage funktioniert hat
  */
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
    else return "Spielstand anlegen fehlgeschlagen";
  }

  /**
  * Diese Funktion wird aufgerufen, wenn über den Button "Spielstand anlegen" ein neuer Spielstand angelegt wird.
  * Datenbanktechnisch wird der vorhandene Spielstand mit dem neuen Pokemon und dem neuen Speicherdatum überschrieben.
  * @param $pokemon Hier wird der Pokemonname  des Pokemons übergeben, welchen der User ausgesucht hat
  * @return String Gibt über einen String aus, ob die Neuanlage funktioniert hat
  */
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

  /**
  * Diese Funktionen wird bei jedem Login zunächst aufgerufen, da die Einstiegsseite die spielstand.php aufgerufen wird.
  * Außerdem wird diese Funktion bei jedem Aufruf der Spielstandübersicht angezeigt.
  *
  * @return spielstand Array, in dem alle Spielstand relevanten Informationen stehen: Der Spielername, der Speicherpunkt, der Score und der Pokemonname.
  */
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

  /**
  * Diese Funktion prüft, ob ein User einen Spielstand hat.
  *
  * @return Boolean Wenn Spielstand vorhanden -> true, ansonsten false
  */
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
  /**
  * Diese Funktion bereitet für die ranking.php die Spielstände aus der Datenbank auf.
  * Angezeigt werden der Username, das ausgewählte Pokemon und der Score.
  *
  * @return $result mehrdimensionales Array: $result[i] = Spielstand i, $result[i][j], Parameter j des Spielstands i
  */
  function ranking(){
    include 'config.php';
    $statement = $pdo->prepare("SELECT spielerid, pokemon,score FROM spielstand ORDER BY score DESC");
    $result = $statement->execute();
    $result = $statement->fetchAll();

    for ($i=0; $i < sizeof($result); $i++) {
      $stmt = $pdo->prepare("SELECT username FROM users WHERE ID=:userid");
      $stmt->bindParam(':userid', $result[$i][0]);
      $name = $stmt->execute();
      $name = $stmt->fetch();
      $result[$i][0] = $name[0];

      $stmt = $pdo->prepare("SELECT pokename FROM pokemon WHERE id=:id");
      $stmt->bindParam(':id', $result[$i][1]);
      $pokename = $stmt->execute();
      $pokename = $stmt->fetch();
      $result[$i][1] = $pokename[0];

    }
      return $result;
  }
}
 ?>
