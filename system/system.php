<?php
session_start();
require_once('../Config/config.php');
require_once('nav.php');

if(isset($_SESSION['user'])) {

#region verarbeitung soll
    if (isset($_POST['soll'])) {
        $nachname = $_POST['nachname'];
        $vorname = $_POST['vorname'];
        $tagessoll = $_POST['tagessoll'];
        $mysqli->query("UPDATE user SET soll = '$tagessoll' WHERE nachname = '$nachname' AND vorname = '$vorname'");
    }
}


if(isset($_SESSION['user'])) {

#region verarbeitung Feiertag Hinzufügen
    if (isset($_POST['addFeiertag'])) {
        $feiertagName = $_POST['feiertagName'];
        $feiertagDatum = $_POST['feiertagDatum'];
        $mysqli->query("INSERT INTO feiertag (datum,feiertagName) VALUES ('$feiertagDatum','$feiertagName')");
    }
#endregion
#region verarbeitung Feiertag Entfernen
    elseif (isset($_POST['delFeiertag'])) {
        $feiertagName = $_POST['feiertagName'];
        $mysqli->query("DELETE FROM feiertag WHERE feiertagName = '$feiertagName'");
    }
}
