<?php
#region/// ----- include ----- ///
session_start();
require_once '../Config/config.php';
require_once '../vendor/autoload.php';
setlocale(LC_TIME, "de_DE.utf8");
use PhpOffice\PhpSpreadsheet\Chart\Chart;
use PhpOffice\PhpSpreadsheet\Chart\DataSeries;
use PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues;
use PhpOffice\PhpSpreadsheet\Chart\Layout;
use PhpOffice\PhpSpreadsheet\Chart\Legend;
use PhpOffice\PhpSpreadsheet\Chart\PlotArea;
use PhpOffice\PhpSpreadsheet\Chart\Title;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
#endregion

#region/// ----- Variablen ----- ///
$monate = array('01' => 'Januar', '02' => 'Februar', '03' => 'März', '04' => 'April', '05' => 'Mai', '06' => 'Juni', '07' => 'Juli', '08' => 'August', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Dezember');
$woche = array('', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag', 'Sonntag');
$monat = '08';
$datum = '2019-'.$monat.'-01';
$row = 1;
#endregion

#region/// ----- Functionen ----- ///
function AbfrageAll($monat, $mysqli)
{
    $comm = ('SELECT * FROM zeit LEFT JOIN user ON zeit.userId = user.userId LEFT JOIN projekt ON zeit.projektId = projekt.projektId  WHERE user.vorname = "Simon" and datum LIKE "%-' . $monat . '-%"  AND NOT projekt.projektname = "Feiertage" AND NOT projekt.projektname = "Ferien" AND NOT projekt.projektname = "Krankheit" ORDER BY datum ');
    $rows = array();

    $query = $mysqli->query($comm);

    while ($res = $query->fetch_assoc()) {
        $rows[] = $res;
    }
    return $rows;
}

function StartDatum($rows)
{
    $startdate = new DateTime($rows[0]['datum']);
    $d = $startdate->format('N');
    $a = $d - 1;
    $startdate->modify('-' . $a . ' day');
    return $startdate;
}



$rows = AbfrageAll($monat,$mysqli);
$startdate = StartDatum($rows);
$count  = strtotime($datum);
#endregion




$spreadsheet = new Spreadsheet();
$worksheet = $spreadsheet->getActiveSheet();

while (date('n', $count ) == $monat) {
    $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $row . '', $woche[$startdate->format('N')]);
    $spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . $row . '', $startdate->format('Y-m-d'));
    $row++;
    $startdate->modify('+1 day');

    if($startdate->format('N') == 7){
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $row . '', $woche[$startdate->format('N')]);
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . $row . '', $startdate->format('Y-m-d'));

        $row ++;
        $row ++;
        $startdate->modify('+1 day');

    }

}

#region/// ----- Save ----- ///
$filename = 'Export.Xlsx';
$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->setIncludeCharts(true);
$callStartTime = microtime(true);
$writer->save($filename);
#endregion
