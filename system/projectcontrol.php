<?php
session_start();
require_once('../Config/config.php');
require_once('nav.php');



$projektName = $_POST['projektName'];
$projektBeschreibung = $_POST['projektBeschreibung'];



if (isset($_POST['projekt'])) {
    $mysqli->query("INSERT INTO projekt (projektname,beschreibung,archiviert) VALUES ('$projektName','$projektBeschreibung','false')");
}
if (isset($_POST['archiv'])) {
    $mysqli->query("UPDATE projekt SET archiviert = 'true' WHERE projektname LIKE '$projektName'");
}

