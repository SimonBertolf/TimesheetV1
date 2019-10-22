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
$savedata = 0;
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
    $d = $startdate->format('N');
    $a = $d - 1;
    $startdate->modify('-' . $a . ' day');
    return $startdate;
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
$startdate = StartDatum($rows);
$userdaten = UserData($name, $mysqli);
$soll = soll($userdaten['soll']);
$count  = strtotime($datum);
#endregion

#region/// ----- Code ----- ///
$spreadsheet = new Spreadsheet();
$worksheet = $spreadsheet->getActiveSheet();

for ($a = 0; $a < 42; $a ++){

    $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $row . '', $woche[$startdate->format('N')]);
    $spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . $row . '', $startdate->format('Y-m-d'));
    $spreadsheet->setActiveSheetIndex(0)->setCellValue('H' . $row . '', '=SUM(D' . $row . ':G' . $row . ')');

   if($startdate->format('Y-m-d') == $rows[$z]['datum']) {
       echo 'Test <br/>';
       echo $startdate->format('Y-m-d').'<br/>';
       echo $rows[$z]['datum'].'<br/>';
       echo $savedata;
       echo '<br/>';
       echo '<br/>';
       $total = arbeitszeit($rows[$z]['start'], $rows[$z]['stop']);
       $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $row . '', $total);

       $savetime = $total;                                                                     //gespeicheres zeugs auf 0 setzen
       $savedata = $rows[$z]['datum'];
       $row++;
       $z ++;
   }
   elseif ($rows[$z]['datum'] == $savedata){
       echo 'Ich bin da <br/>';
       echo $startdate->format('Y-m-d').'<br/>';
       echo $rows[$z]['datum'].'<br/>';
       echo $savedata;
       echo '<br/>';
       echo '<br/>';
       $rowT = $row;
       $total = arbeitszeit($rows[$z]['start'], $rows[$z]['stop']);
       $savetime = $total + $savetime;
       $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $rowT -= 1 . '', $savetime);
       $savedata = $rows[$z]['datum'];
       $z ++;
       $startdate->modify('-1 day');
    }
   else{
       echo 'ich bin tot <br/>';
       echo $startdate->format('Y-m-d').'<br/>';
       echo $rows[$z]['datum'].'<br/>';
       echo $savedata;
       echo '<br/>';
       echo '<br/>';
       $row++;
       $savedata = 0;
       $savetime = 0;

   }
    if($startdate->format('N') == 7)
    {
        $summrow = $row;
        $spreadsheet->getActiveSheet()->getStyle('A'.$row.':J'.$row.'')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $spreadsheet->getActiveSheet()->getStyle('I'.$row)->getFont()->setSize(13);
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('I'.$row.'', '=sum(H'.($summrow -= 1 ) .':H'.($summrow -= 6) .')');
        $row ++;
    }
    $count = strtotime("+1 day", $count);
    $startdate->modify('+1 day');
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
// Rot

/// ----- Style Border ----- ///
$spreadsheet->getActiveSheet()->getStyle('A1:J1')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
$spreadsheet->getActiveSheet()->getStyle('A4:J4')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
$spreadsheet->getActiveSheet()->getStyle('A5:J5')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
$spreadsheet->getActiveSheet()->getStyle('A6:J6')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
$spreadsheet->getActiveSheet()->getStyle('A57:J57')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
$spreadsheet->getActiveSheet()->getStyle('A8:J58')->getBorders()->getVertical()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);


$spreadsheet->getActiveSheet()->getStyle('A8:J56')->getBorders()->getVertical()->getColor()->setARGB('FFFFFF');  // Weiss
$spreadsheet->getActiveSheet()->getStyle('A8:J8')->getFont()->getColor()->setARGB('FFFFFF');    // Weiss
$spreadsheet->getActiveSheet()->getStyle('A57:J68')->getFont()->getColor()->setARGB('FFFFFF');    // Weiss
$spreadsheet->getActiveSheet()->getStyle('A57:J57')->getBorders()->getBottom()->getColor()->setARGB('FFFFFF');    // Weiss

$spreadsheet->getActiveSheet()->getStyle('A57:J58')->getBorders()->getAllBorders()->getColor()->setARGB('FFFFFF'); // Weiss
$spreadsheet->getActiveSheet()->getStyle('A57:J58')->getFont()->getColor()->setARGB('FFFFFF');    // Weiss
/// ----- Style BG Color----- ///
$spreadsheet->getActiveSheet()->getStyle('A8:J8')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('615351'); // Braun hell
$spreadsheet->getActiveSheet()->getStyle('A56:J58')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('615351'); // Braun hell
for ($a = 9; $a <= 56; $a += 2){
    $spreadsheet->getActiveSheet()->getStyle('A'.$a.':J'.$a.'')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('E5F0FC'); // Hell
}
for ($a = 10; $a <= 56; $a += 2){
    $spreadsheet->getActiveSheet()->getStyle('A'.$a.':J'.$a.'')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('AED2FB'); // Dunkel
}

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
    ->setCellValue('G57', 'Soll')
    ->setCellValue('H57', '184.6')
    ->setCellValue('I57', 'Stunden')
    ->setCellValue('J58', '=(J57-H57)')
    ->setCellValue('J57', '=sum(I8:I56)');


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
    ->setCellValue('J8', 'Total Monat')
    ->setCellValue('I58', 'Total Monat');
#endregion

#region/// ----- Save ----- ///
$filename = 'Export.Xlsx';
$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->setIncludeCharts(true);
$callStartTime = microtime(true);
$writer->save($filename);
#endregion
