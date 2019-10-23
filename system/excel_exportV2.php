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
$monat = '10';
$jahr = 2019;
$datum = '2019-'.$monat.'-01';
$row = 9;
$z = 0;
$savedata = 'g';
$savetime = 0;
$name = 'Simon';
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
    $startdate->modify('first day of this month');
    $startdate->modify('last monday');

    $enddate = new DateTime($rows[0]['datum']);
    $enddate->modify('last day of this month');
    $enddate->modify('next monday');

    $interval = new DateInterval('P1D');
    $daterange = new DatePeriod($startdate, $interval, $enddate);
    return $daterange;
}
function arbeitszeit($startzeit, $endzeit)
{
    $start_time = explode(":", $startzeit);
    $end_time = explode(":", $endzeit);

    $start_time_stamp = mktime($start_time[0], $start_time[1]);
    $end_time_stamp = mktime($end_time[0], $end_time[1]);

    $time_difference = ($end_time_stamp - $start_time_stamp) / 3600;

    return ($time_difference);
}
function soll($soll)
{
    $start_time = explode(":", $soll);
    $d = ($start_time[0] + ($start_time[1]));
    return $d;
}
function UserData($name, $mysqli){
         $Userdaten = $mysqli->query('SELECT * FROM user WHERE vorname = "'.$name.'"')->fetch_assoc();
         return $Userdaten;
}

$rows = AbfrageAll($monat,$mysqli);
$userdaten = UserData($name, $mysqli);
$soll = soll($userdaten['soll']);
$daterange = StartDatum($rows);
#endregion

#region/// ----- Code ----- ///
$spreadsheet = new Spreadsheet();
$worksheet = $spreadsheet->getActiveSheet();

$startdate = new DateTime($rows[0]['datum']);
$startdate->modify('first day of this month');
$startdate->modify('last sunday');

foreach($daterange  as $date) {

    echo $date->format('Y-m-d-D');

    $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $row . '', $woche[$date->format('N')]);
    $spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . $row . '', $date->format('Y-m-d'));
    $spreadsheet->setActiveSheetIndex(0)->setCellValue('H' . $row . '', '=SUM(D' . $row . ':G' . $row . ')');

    while ($date->format('Y-m-d') == $rows[$z]['datum']) {
        echo $date->format('Y-m-d').'normal<br/>';
        $total = arbeitszeit($rows[$z]['start'], $rows[$z]['stop']);
        $savetime += $total;
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $row . '', $savetime);
        $z++;
    }
    if ($date->format('N') == 7) {
        $row++;
        $summrow = $row;
        $spreadsheet->getActiveSheet()->getStyle('A' . $row . ':J' . $row . '')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $spreadsheet->getActiveSheet()->getStyle('A' . $row . ':I' . $row . '')->getFont()->setSize(13);
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('I' . $row . '', '=sum(H' . ($summrow -= 1) . ':H' . ($summrow -= 6) . ')');
    }
    echo $date->format('Y-m-d').'nichts<br/>';
    $savedata = 'h';
    $savetime = 'h';
        $row++;
}
#endregion

#region/// ----- Styles Default----- ///
/// ----- Styles Default----- ///
$spreadsheet->getDefaultStyle()->getFont()->setName('Arial')->setSize(12);
$spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(11);
$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(11);
$spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(11);

$spreadsheet->getActiveSheet()->getStyle('A6')->getFont()->setSize(11);
$spreadsheet->getActiveSheet()->getStyle('C6')->getFont()->setSize(11);
$spreadsheet->getActiveSheet()->getStyle('J6')->getFont()->setSize(10);
$spreadsheet->getActiveSheet()->getStyle('H6')->getFont()->setSize(9);

/// ----- Style Titel ----- ///
$spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setSize(22);
$spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB('a3182e');

/// ----- Style Border ----- ///
$spreadsheet->getActiveSheet()->getStyle('A1:J1')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
$spreadsheet->getActiveSheet()->getStyle('A4:J4')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
$spreadsheet->getActiveSheet()->getStyle('A5:J5')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
$spreadsheet->getActiveSheet()->getStyle('A6:J6')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
$spreadsheet->getActiveSheet()->getStyle('A8:J'.$row.'')->getBorders()->getVertical()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

$spreadsheet->getActiveSheet()->getStyle('A8:J'.$row.'')->getBorders()->getVertical()->getColor()->setARGB('FFFFFF');  // Weiss
$spreadsheet->getActiveSheet()->getStyle('A8:J8')->getFont()->getColor()->setARGB('FFFFFF');    // Weiss

/// ----- Style BG Color----- ///
$spreadsheet->getActiveSheet()->getStyle('A8:J8')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('615351'); // Braun hell
$a = 9;
for ($a = 9; $a < $row; $a ++){
    if($a % 2 !== 0){
    $spreadsheet->getActiveSheet()->getStyle('A'.$a.':J'.$a.'')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('E5F0FC'); // Hell
    }
    else{
    $spreadsheet->getActiveSheet()->getStyle('A'.$a.':J'.$a.'')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('AED2FB'); // Dunkel
    }
}
$spreadsheet->getActiveSheet()->getStyle('A'.$row.':J'.$row.'')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('615351'); // Braun hell

$spreadsheet->getActiveSheet()->getStyle('A'.$row.':J'.$row.'')->getFont()->getColor()->setARGB('FFFFFF');    // Weiss
/// ----- Text ----- ///
$spreadsheet->setActiveSheetIndex(0)  /// Kopfzeile
    ->setCellValue('A1', 'REAM AG / reamis ag')
    ->setCellValue('A2', 'Zugerstrasse 50, 6340 Baar')
    ->setCellValue('A5', 'Mitarbeiter/In:')
    ->setCellValue('C5', $userdaten['vorname'].' '.$userdaten['nachname'])
    ->setCellValue('A6', 'E-Mail des Mitarbeiters:')
    ->setCellValue('C6',  $userdaten['email'])
    ->setCellValue('E6', 'Dokumentationsperiode')
    ->setCellValue('H6', $monate[$monat].' '.$jahr)
    ->setCellValue('E5', 'Arbeitspensum pro Woche')
    ->setCellValue('H5', $soll)

    ->setCellValue('A'.$row.'', 'Soll')
    ->setCellValue('B'.$row.'', '184.6')
    ->setCellValue('E'.$row.'', 'Stunden')
    ->setCellValue('F'.$row.'', '=(J'.$row.'-B'.$row.')')           //überstunden
    ->setCellValue('J'.$row.'', '=sum(I8:I'.$row.')')
    ->setCellValue('I'.$row.'', 'Total Monat');

$spreadsheet->setActiveSheetIndex(0)  /// Tabellonkopf
    ->setCellValue('A8', 'Tag')
    ->setCellValue('B8', 'Woche')
    ->setCellValue('C8', 'Datum')
    ->setCellValue('D8', 'Arbeitszeit')
    ->setCellValue('E8', 'Feiertag')
    ->setCellValue('F8', 'Krank')
    ->setCellValue('G8', 'Ferien')
    ->setCellValue('H8', 'Total Tag')
    ->setCellValue('I8', 'Total Woche')
    ->setCellValue('J8', 'Total Monat');
#endregion

#region/// ----- Save ----- ///
$filename = 'Export '.$monat.'-'.$jahr.'.Xlsx';
$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->setIncludeCharts(true);
$callStartTime = microtime(true);
$writer->save($filename);
#endregion
