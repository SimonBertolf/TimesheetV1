<?php
#region/// ----- include ----- ///
session_start();
require_once '../Config/config.php';
require_once '../vendor/autoload.php';
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
#region/// ----- Code ----- ///
if ( isset($_POST['exportexport'])){
#region/// ----- Funktionen ----- ///
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
        $d = ($start_time[1]+$start_time[0]);
        return $d;
    }
    function writeText($sp, $col, $row , $val){
        $sp->setActiveSheetIndex(0)->setCellValue(".$col.$row.",".$val.");
    }
    function out() {

        $args = func_get_args();
        foreach($args as $arg) {
            echo($arg."<br />");
        }
    }
#endregion
#region/// ----- Variablen ----- ///
$monate = array('01'=>'Januar','02'=>'Februar','03'=>'März','04'=>'April','05'=>'Mai','06'=>'Juni','07'=>'Juli','08'=>'August','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Dezember');
$woche = array('','Montag','Dienstag','Mittwoch','Donnerstag','Freitag','Samstag','Sonntag');
$jahr = 2019;

$name = $_SESSION['vorname'];
$monat = $_POST['monat'];
$_SESSION['monat'] = $monat;
$datum = '2019-'.$_POST['monat'].-'01';
setlocale(LC_TIME, "de_DE.utf8");

/// ----- Code ----- ///
$spreadsheet = new Spreadsheet();
$worksheet = $spreadsheet->getActiveSheet();

$Userdaten = $mysqli->query('SELECT * FROM user WHERE vorname = "'.$name.'"')->fetch_assoc();
$sollq = soll($Userdaten['soll']);
#endregion

#region/// ----- Abfrage alle ----- ///
$comm = ('SELECT * FROM zeit LEFT JOIN user ON zeit.userId = user.userId 
            LEFT JOIN projekt ON zeit.projektId = projekt.projektId 
            WHERE user.vorname = "'.$name.'" and datum LIKE "%-' . $monat . '-%"  
            AND NOT projekt.projektname = "Feiertage" AND NOT projekt.projektname = "Ferien" AND NOT projekt.projektname = "Krankheit" ORDER BY datum ');
$query = $mysqli->query($comm);
    $rows = array();
    while ($res = $query->fetch_assoc()) {
    $rows[] = $res;
    }
#endregion
#region/// ----- Abfrage Feiertage ----- ///
    $commFeiertage = ('SELECT * FROM zeit LEFT JOIN user ON zeit.userId = user.userId 
            LEFT JOIN projekt ON zeit.projektId = projekt.projektId 
            WHERE user.vorname = "'.$name.'" and datum LIKE "%-' . $monat . '-%"  
            AND projekt.projektname = "Feiertage" ORDER BY datum ');
    $queryFeiertage = $mysqli->query($commFeiertage);
    $rowsFeiertage = array();
    while ($res = $queryFeiertage->fetch_assoc()) {
        $rowsFeiertage[] = $res;
    }
#endregion
#region/// ----- Abfrage Krank ----- ///
    $commKrankheit = ('SELECT * FROM zeit LEFT JOIN user ON zeit.userId = user.userId 
            LEFT JOIN projekt ON zeit.projektId = projekt.projektId 
            WHERE user.vorname = "'.$name.'" and datum LIKE "%-' . $monat . '-%"  
            AND projekt.projektname = "Krankheit" ORDER BY datum ');
    $queryKrankheit = $mysqli->query($commKrankheit);
    $rowsKrankheit = array();
    while ($res = $queryKrankheit->fetch_assoc()) {
        $rowsKrankheit[] = $res;
    }
#endregion
#region/// ----- Abfrage Ferien ----- ///
    $commFerien = ('SELECT * FROM zeit LEFT JOIN user ON zeit.userId = user.userId 
            LEFT JOIN projekt ON zeit.projektId = projekt.projektId 
            WHERE user.vorname = "'.$name.'" and datum LIKE "%-' . $monat . '-%"  
            AND projekt.projektname = "Ferien" ORDER BY datum ');
    $queryFerien = $mysqli->query($commFerien);
    $rowsFerien = array();
    while ($res = $queryFerien->fetch_assoc()) {
        $rowsFerien[] = $res;
    }
#endregion

#region/// ----- Schreiben Alle ----- ///

    $startdate = new DateTime($datum);      /// für datum
    $stamp  = strtotime($datum);            /// für den zähler
    $row = 9;                               /// die reie
    $z = 0;                                 //die nummer des arrasy in ROWS
    $satim = '0';       //gespeicheres zeugs auf 0 setzen
    $sadat = '0';

while (date('n',$stamp ) == $monat) {
    $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $row . '', $woche[$startdate->format('N')]);
    $spreadsheet->setActiveSheetIndex(0)->setCellValue('B' . $row . '', $startdate->format('W'));
    $spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . $row . '', $startdate->format('Y-m-d'));
    $spreadsheet->setActiveSheetIndex(0)->setCellValue('H' . $row . '', '=SUM(D' . $row . ':G' . $row . ')');
    if ($startdate->format('N') == 7){         // Border und so
        $row ++;
        $rownew = $row;
        $spreadsheet->getActiveSheet()->getStyle('A'.$row.':J'.$row.'')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('I' . $row . '', '=SUM(H' .( $rownew ). ':H' . ($rownew -= 7 ). ')');
    }
    if ($rows[$z]['datum'] == $startdate->format('Y-m-d')) {
        $total = arbeitszeit($rows[$z]['start'], $rows[$z]['stop']);
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $row . '', $total);
        $satim = $total;                                                                     //gespeicheres zeugs auf 0 setzen
        $sadat = $rows[$z]['datum'];
        $startdate->modify('+1 day');
        $z++;
        $stamp = strtotime("+1 day", $stamp);
    } elseif ($rows[$z]['datum'] == $sadat) {
        $total = arbeitszeit($rows[$z]['start'], $rows[$z]['stop']);
        $satim += $total;
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $row -= 1 . '', $satim);
        $z++;
        $stamp = strtotime("+1 day", $stamp);
    } else {
        $startdate->modify('+1 day');
        $stamp = strtotime("+1 day", $stamp);
    }
    $row++;
}
#endregion
#region/// ----- Schreiben Feiertage ----- ///
    $startdate = new DateTime($datum);      /// für datum
    $stamp  = strtotime($datum);            /// für den zähler
    $row = 9;                               /// die reie
    $z = 0;                                 //die nummer des arrasy in ROWS
    $satim = '0';       //gespeicheres zeugs auf 0 setzen
    $sadat = '0';

    while (date('n',$stamp ) == $monat) {
        if ($rowsFeiertage[$z]['datum'] == $startdate->format('Y-m-d')) {
            $total = arbeitszeit($rowsFeiertage[$z]['start'], $rowsFeiertage[$z]['stop']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $row . '', $total);
            $satim = $total;                                                                     //gespeicheres zeugs auf 0 setzen
            $sadat = $rowsFeiertage[$z]['datum'];
            $startdate->modify('+1 day');
            $z++;
            $stamp = strtotime("+1 day", $stamp);
        } elseif ($rowsFeiertage[$z]['datum'] == $sadat) {
            $total = arbeitszeit($rowsFeiertage[$z]['start'], $rowsFeiertage[$z]['stop']);
            $satim += $total;
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $row -= 1 . '', $satim);
            $z++;
            $stamp = strtotime("+1 day", $stamp);
        } else {
            $startdate->modify('+1 day');
            $stamp = strtotime("+1 day", $stamp);
        }
        $row++;
    }
#endregion
#region/// ----- Schreiben Krank ----- ///
    $startdate = new DateTime($datum);      /// für datum
    $stamp  = strtotime($datum);            /// für den zähler
    $row = 9;                               /// die reie
    $z = 0;                                 //die nummer des arrasy in ROWS
    $satim = '0';       //gespeicheres zeugs auf 0 setzen
    $sadat = '0';

    while (date('n',$stamp ) == $monat) {
        if ($rowsKrankheit[$z]['datum'] == $startdate->format('Y-m-d')) {
            $total = arbeitszeit($rowsKrankheit[$z]['start'], $rowsKrankheit[$z]['stop']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('F' . $row . '', $total);
            $satim = $total;                                                                     //gespeicheres zeugs auf 0 setzen
            $sadat = $rowsKrankheit[$z]['datum'];
            $startdate->modify('+1 day');
            $z++;
            $stamp = strtotime("+1 day", $stamp);
        } elseif ($rowsKrankheit[$z]['datum'] == $sadat) {
            $total = arbeitszeit($rowsKrankheit[$z]['start'], $rowsKrankheit[$z]['stop']);
            $satim += $total;
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('F' . $row -= 1 . '', $satim);
            $z++;
            $stamp = strtotime("+1 day", $stamp);
        } else {
            $startdate->modify('+1 day');
            $stamp = strtotime("+1 day", $stamp);
        }
        $row++;
    }
#endregion
#region/// ----- Schreiben Ferien ----- ///
    $startdate = new DateTime($datum);      /// für datum
    $stamp  = strtotime($datum);            /// für den zähler
    $row = 9;                               /// die reie
    $z = 0;                                 //die nummer des arrasy in ROWS
    $satim = '0';       //gespeicheres zeugs auf 0 setzen
    $sadat = '0';

    while (date('n',$stamp ) == $monat) {
        if ($rowsFerien[$z]['datum'] == $startdate->format('Y-m-d')) {
            $total = arbeitszeit($rowsFerien[$z]['start'], $rowsFerien[$z]['stop']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $row . '', $total);
            $satim = $total;                                                                     //gespeicheres zeugs auf 0 setzen
            $sadat = $rowsFerien[$z]['datum'];
            $startdate->modify('+1 day');
            $z++;
            $stamp = strtotime("+1 day", $stamp);
        } elseif ($rowsFerien[$z]['datum'] == $sadat) {
            $total = arbeitszeit($rowsFerien[$z]['start'], $rowsFerien[$z]['stop']);
            $satim += $total;
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $row -= 1 . '', $satim);
            $z++;
            $stamp = strtotime("+1 day", $stamp);
        } else {
            $startdate->modify('+1 day');
            $stamp = strtotime("+1 day", $stamp);
        }
        $row++;
    }
#endregion

#region/// ----- Styles Default----- ///
/// ----- Styles Default----- ///
$spreadsheet->getDefaultStyle()->getFont()->setName('Arial')->setSize(12);
$spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(11);
$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(11);
$spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(11);
/// ----- Style Titel ----- ///
$spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setSize(22);
$spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB('a3182e');           // Rot
$spreadsheet->getActiveSheet()->getStyle('A6')->getFont()->setSize(11);
$spreadsheet->getActiveSheet()->getStyle('C6')->getFont()->setSize(11);
$spreadsheet->getActiveSheet()->getStyle('J6')->getFont()->setSize(10);
$spreadsheet->getActiveSheet()->getStyle('H6')->getFont()->setSize(9);

/// ----- Style Border ----- ///
$spreadsheet->getActiveSheet()->getStyle('A1:J1')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
$spreadsheet->getActiveSheet()->getStyle('A4:J4')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
$spreadsheet->getActiveSheet()->getStyle('A5:J5')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
$spreadsheet->getActiveSheet()->getStyle('A6:J6')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

$spreadsheet->getActiveSheet()->getStyle('A8:J44')->getBorders()->getVertical()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN); // weiss
$spreadsheet->getActiveSheet()->getStyle('A8:J44')->getBorders()->getVertical()->getColor()->setARGB('FFFFFF');
$spreadsheet->getActiveSheet()->getStyle('A8:J8')->getFont()->getColor()->setARGB('FFFFFF');    // Weiss
$spreadsheet->getActiveSheet()->getStyle('A45:J45')->getFont()->getColor()->setARGB('FFFFFF');    // Weiss

$spreadsheet->getActiveSheet()->getStyle('I45:J47')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN); // weiss
$spreadsheet->getActiveSheet()->getStyle('I45:J47')->getBorders()->getAllBorders()->getColor()->setARGB('FFFFFF');
$spreadsheet->getActiveSheet()->getStyle('I45:J47')->getFont()->getColor()->setARGB('FFFFFF');    // Weiss

/// ----- Style BG Color----- ///
$spreadsheet->getActiveSheet()->getStyle('A8:J8')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('615351'); // Braun hell
$spreadsheet->getActiveSheet()->getStyle('I45:J47')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('615351'); // Braun hell
for ($a = 9; $a <= 44; $a += 2){
    $spreadsheet->getActiveSheet()->getStyle('A'.$a.':J'.$a.'')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('E5F0FC'); // Hell
}
for ($a = 10; $a <= 44; $a += 2){
    $spreadsheet->getActiveSheet()->getStyle('A'.$a.':J'.$a.'')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('AED2FB'); // Dunkel
}
$spreadsheet->setActiveSheetIndex(0)->setCellValue('J45', '=SUM(H9:H45)');
/// ----- Text ----- ///
$spreadsheet->setActiveSheetIndex(0)  /// Kopfzeile
    ->setCellValue('A1', 'REAM AG / reamis ag')
    ->setCellValue('A2', 'Zugerstrasse 50, 6340 Baar')
    ->setCellValue('A5', 'Mitarbeiter/In:')
    ->setCellValue('C5', $Userdaten['vorname'].' '.$Userdaten['nachname'])      // ??????
    ->setCellValue('A6', 'E-Mail des Mitarbeiters:')
    ->setCellValue('C6',  $Userdaten['email'])            // ??????

    ->setCellValue('E6', 'Dokumentationsperiode')
    ->setCellValue('H6', $monate[$monat].' '.$jahr)        //  durch Variable ersetzen
    ->setCellValue('I6', $sollq)
    ->setCellValue('I46', 'Soll')
    ->setCellValue('J46', '184.6')
    ->setCellValue('I47', 'Stunden')
    ->setCellValue('J47', '=(J45-J46)');


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
    ->setCellValue('I45', 'Total Monat');

#endregion
#region/// ----- Save ----- ///

$filename = 'ExcelExport'.$_SESSION['monat'].'.Xlsx';
$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->setIncludeCharts(true);
$callStartTime = microtime(true);
$writer->save($filename);

#endregion
}
#endregion
