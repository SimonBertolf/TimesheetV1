<?php
session_start();
require_once "../Config/config.php";
require_once "Class_Zeit.php";
require_once "nav.php";

$z = new Zeit();
$titel = array('Vorname', 'Nachname', 'Projektname', 'Datum', 'Startzeit', 'Endzeit', 'Pausen', 'Arbeitszeit');
$stunden = array();
$comm = "SELECT user.vorname, user.nachname, projekt.projektname, zeit.datum, zeit.`start`,zeit.`stop`, zeit.pause FROM zeit
LEFT JOIN user ON zeit.userId = user.userId
LEFT JOIN projekt ON zeit.projektId = projekt.projektId
WHERE datum BETWEEN '".$_POST['von']."' AND '".$_POST['bis']."'
ORDER BY datum";

if (isset($_POST['go'])){
    $query = $mysqli->query($comm);
    $rows = array();
    while ($res = $query->fetch_assoc()) {
        $rows[] = $res;
    }
    foreach ($rows as $text) {
        $stunden[] = array(
            $text['vorname'],
            $text['nachname'],
            $text['projektname'],
            $text['datum'],
            $text['start'],
            $text['stop'],
            $text['pause'],
            $z->arbeitszeitcharts($text['start'], $text['stop'], $text['pause'])
        );
    }

    $fp = fopen('../CSV/Stundenexport.csv', 'w');
    fputcsv($fp, $titel);
    foreach ($stunden as  $text) {
        fputcsv($fp, $text);
    }
    fclose($fp);
}
