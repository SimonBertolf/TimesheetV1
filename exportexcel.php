<?php
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// Daten
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
require_once 'vendor/autoload.php';
require_once 'Config/config.php';
function arbeitszeit($startzeit, $endzeit, $pause)
{
    global $tot_time;

    $start_time = explode(":", $startzeit);
    $end_time = explode(":", $endzeit);
    $break = explode(":", $pause);

    $start_time_stamp = mktime($start_time[0], $start_time[1]);
    $end_time_stamp = mktime($end_time[0], $end_time[1]);
    $break_stamp = $break[0] + ($break[1] / 60);

    $time_difference = ($end_time_stamp - $start_time_stamp) / 3600;
    $tot_time = $time_difference - ($break_stamp);
    //echo($tot_time);
}
function soll($soll)
{
    global $d;
    $start_time = explode(":", $soll);
    $d = ($start_time[1]+$start_time[0]) / 5;

}
use PhpOffice\PhpSpreadsheet\Chart\Chart;
use PhpOffice\PhpSpreadsheet\Chart\DataSeries;
use PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues;
use PhpOffice\PhpSpreadsheet\Chart\Layout;
use PhpOffice\PhpSpreadsheet\Chart\Legend;
use PhpOffice\PhpSpreadsheet\Chart\PlotArea;
use PhpOffice\PhpSpreadsheet\Chart\Title;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

/// ----- Info ----- ///
echo('Test des Exports für die Monatskarte');
/// ----- Variablen ----- ///
$username = $_POST['name'];
$monat = $_POST['monat'];
$jahr = 2019;
$soll = 0;
$ist = 0;
$rows = array();
$data = array();

$monate = array(
    '01' => "Januar",
    '02' => "Februar",
    '03' => "M&auml;rz",
    '04' => "April",
    '05' => "Mai",
    '06' => "Juni",
    '07' => "Juli",
    '08' => "August",
    '09' => "September",
    '10' => "Oktober",
    '11' => "November",
    '12' => "Dezember");


$comm1= ('SELECT user.vorname,user.nachname, zeit.datum, zeit.start, zeit.stop, zeit.pause, user.soll FROM zeit 
            LEFT JOIN user ON zeit.userId = user.userId WHERE user.vorname LIKE "'.$username.'"AND datum LIKE "%-' . $monat . '-%" ORDER BY zeit.datum');

$comm = ('SELECT * FROM zeit
             LEFT JOIN user ON zeit.userId = user.userId
             LEFT JOIN projekt ON zeit.projektId = projekt.projektId
             WHERE user.vorname = "'.$username.'" AND datum LIKE "%-' . $monat . '-%" ORDER BY datum');

$comm2 = ('SELECT vorname FROM user');
$user = $mysqli->query($comm2);

$query = $mysqli->query($comm);
$res = $query->fetch_assoc();
$name = ($res['vorname'].' '.$res['nachname']);
$mail = $res['email'];

/// ----- Abfrage ----- ///
$query1 = $mysqli->query($comm1);
while ($res = $query1->fetch_assoc()){
    $rows[] = $res;
}

foreach ($rows as $data) {
    arbeitszeit($data['start'], $data['stop'], $data['pause']);
    soll($data['soll']);
    $soll += $d;
    $ist += $tot_time;

}
$stund = ($ist - $soll);
if ($stund >= 0){
    $zeit = 'Überstunden';
}
else{
    $zeit = 'Minusstunden';
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// Page
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
<html>
<body>
    <form method="post">
        <select name="name" required>
            <option></option>
            <?php
            while ($res = $user->fetch_assoc()){
                foreach ($res as $d){
                    echo ('<option>'.$d.'</option>');
                }
            }
            ?>
        </select>
        <select name="monat" required>
            <option></option>
            <?php
            foreach ($monate as $key => $d){
                echo ('<option>'.$key.'</option>');
            }
            ?>
        </select>
        <button type="submit" name="export">Export</button>
    </form>
</body>
</html>
<?php
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// Export
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['export'])) {

    $spreadsheet = new Spreadsheet();
    $worksheet = $spreadsheet->getActiveSheet();

    $spreadsheet->getDefaultStyle()->getFont()->setName('YU Gothic')->setSize(11);
    $spreadsheet->getActiveSheet()->getStyle('B2')->getFont()->setSize(40);
    $spreadsheet->getActiveSheet()->mergeCells('B16:C16');
    $spreadsheet->getActiveSheet()->getStyle('B12:C12')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FBF2EF');
    $spreadsheet->getActiveSheet()->getStyle('B14:C14')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('EFF8FB');
    $spreadsheet->getActiveSheet()->getStyle('A1:I34')->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);

    $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('B2', 'Stundenübersicht');

    $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('B5', $monate[$monat] . ' ' . $jahr)
        ->setCellvalue('B7', $name)
        ->setCellValue('B9', $mail);

    $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('B14', 'Soll')
        ->setCellValue('C14', $soll)
        ->setCellvalue('B12', 'Ist')
        ->setCellValue('C12', $ist)
        ->setCellValue('B16', $zeit . ' ' . round($stund, 2))
        ->setCellValue('G8', 'Soll')
        ->setCellValue('G9', 'Ist');

// Name der legende
    $dataSeriesLabels = [
        new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, 'Worksheet!$B$14', null, 1),         // Soll
        new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, 'Worksheet!$B$12', null, 1),         // ist
    ];
    $xAxisTickValues = [
        new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, 'Worksheet!$G$8:$G$9', null, 4),   // Unten soll - ist
    ];
    $dataSeriesValues = [
        new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_NUMBER, 'Worksheet!$C$14:$C$15', null, 4),   // soll
        new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_NUMBER, 'Worksheet!$C$11:$C$12', null, 4),   // ist
    ];

    $series = new DataSeries(
        DataSeries::TYPE_BARCHART, // plotType
        DataSeries::GROUPING_STACKED, // plotGrouping
        range(0, count($dataSeriesValues) - 1), // plotOrder
        $dataSeriesLabels, // plotLabel
        $xAxisTickValues, // plotCategory
        $dataSeriesValues        // plotValues
    );
// Richtung der Balken
    $series->setPlotDirection(DataSeries::DIRECTION_COL);
    $plotArea = new PlotArea(null, [$series]);
// position legende
    $legend = new Legend(Legend::POSITION_TOPRIGHT, null, false);
    $title = new Title('Stunden');
    $chart = new Chart(
        'SollIstVergleich', // name
        $title, // title
        $legend, // legend
        $plotArea, // plotArea
        true, // plotVisibleOnly
        0, // displayBlanksAs
        null, // xAxisLabel
        $yAxisLabel  // yAxisLabel
    );
// position des charts
    $chart->setTopLeftPosition('E4');
    $chart->setBottomRightPosition('I17');
// Add the chart to the worksheet
    $worksheet->addChart($chart);
// Save Excel 2007 file
    $filename = 'TestV1.Xlsx';
    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $writer->setIncludeCharts(true);
    $callStartTime = microtime(true);
    $writer->save($filename);
}
