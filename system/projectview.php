<?php
session_start();
require_once "../system/Class_Zeit.php";
require_once "nav.php";

/// ----- Test Charts ----- ///
$z = new Zeit();

$query = $mysqli->query('SELECT * FROM zeit 
LEFT JOIN user ON zeit.userId = user.userId
LEFT JOIN projekt ON zeit.projektId = projekt.projektId 
WHERE projekt.archiviert = \'FALSE\'

ORDER BY zeit.projektId ASC, zeit.userId ASC;
');

// Holt alle Daten in ein Array namens Rows.
$rows = array();
while ($res = $query->fetch_assoc()) {
    $rows[] = $res;
}
// Daten verarbeiten
$data = array();
foreach ($rows as $entry) {
    $data[$entry['projektname']][$entry['vorname'].' '.$entry['nachname']] += $z->arbeitszeitcharts($entry['start'], $entry['stop'], $entry['pause']);
}
?>



