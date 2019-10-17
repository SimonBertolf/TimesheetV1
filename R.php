<?php
echo 'hallo';
$kw = 44;

require_once "vendor/autoload.php";
use PhpOffice\PhpSpreadsheet\Chart\Chart;
use PhpOffice\PhpSpreadsheet\Chart\DataSeries;
use PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues;
use PhpOffice\PhpSpreadsheet\Chart\Layout;
use PhpOffice\PhpSpreadsheet\Chart\Legend;
use PhpOffice\PhpSpreadsheet\Chart\PlotArea;
use PhpOffice\PhpSpreadsheet\Chart\Title;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;


    $spreadsheet = new Spreadsheet();
    $worksheet = $spreadsheet->getActiveSheet();
///////// Style
    $spreadsheet->getDefaultStyle()->getFont()->setName('Arial')->setSize(12);
    $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setSize(22);
    $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB('a3182e');

    $spreadsheet->getActiveSheet()->getStyle('A1:J1')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);

    $spreadsheet->getActiveSheet()->getStyle('C5:D5')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('6279b5');
    $spreadsheet->getActiveSheet()->getStyle('C6:D6')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('6279b5');

///////// Text
    $spreadsheet->setActiveSheetIndex(0)  /// Kopfzeile
        ->setCellValue('A1', 'REAM AG / reamis ag')
        ->setCellValue('A2', 'Zugerstrasse 50, 6340 Baar')
        ->setCellValue('A5', 'Mitarbeiter/In:')
        ->setCellValue('A6', 'E-Mail des Mitarbeiters: ');

    $spreadsheet->setActiveSheetIndex(0)    /// Kopfzeile tabelle
    ///
        ->setCellValue('A8','Tag')
        ->setCellValue('B8','Woche');

    $spreadsheet->setActiveSheetIndex(0) /// Wochentage
        ->setCellValue('A9', 'Montag')
        ->setCellValue('A10', 'Dienstag');

$spreadsheet->setActiveSheetIndex(0) /// Woche
        ->setCellValue('B9', $kw);  //


// Save Excel 2007 file
    $filename = 'TestV1.Xlsx';
    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $writer->setIncludeCharts(true);
    $callStartTime = microtime(true);
    $writer->save($filename);
