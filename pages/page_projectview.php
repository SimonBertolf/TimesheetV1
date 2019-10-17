<?php
session_start();
require_once "../Config/config.php";
require_once "../system/projectview.php";
?>

<html>
<link href="../CSS/DefaultCSSsimon_1.css" rel="stylesheet" type="text/css">
<head>
    <title>Timesheet projectviews</title>
</head>
<body>
    <ul>
        <p class="titlemain">Timesheet</p>
    </ul>
    <nav>
        <form class="nav" method="post">
            <button class="buttonnavigation" name="projectcontrol">Project control</button>
            <button class="buttonnavigation" name="logout">Logout</button>
        </form>
    </nav>

    <main>
        <?php
        foreach ($data as $name => $chart) {
            ?>
            <div class="divchart">
                <form method="post" action="" style="text-align: center">
                    <div class="chart" id="piechart<?php echo $name; ?>">
                        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                        <div>
                            <script type="text/javascript">
                                google.charts.load('current', {'packages': ['corechart']});
                                google.charts.setOnLoadCallback(drawChart);
                                function drawChart() {
                                    var data = google.visualization.arrayToDataTable([
                                        ['Task', '<?php echo($name);?>'],
                                        <?php
                                        foreach ($chart as $innername => $innerdata){
                                            echo("['".$innername."', ".$innerdata."],");
                                        }
                                        ?>
                                    ]);
                                    var options = {
                                        'title': '<?php echo($name);?>',
                                        colors: ['#404545','#202525','#1B1D1F'],
                                        'backgroundColor': 'transparent',
                                        'borderColor': '#86B900',
                                        'width': 300, 'height': 300,
                                        chartArea:{left:50,top:50,width:'75%',height:'75%'},
                                        legend: {position: 'bottom', textStyle: {color: '#404545', fontSize: 12}},
                                        pieHole: 0.6,
                                        pieSliceBorderColor: '#86B900',
                                        titleTextStyle:{
                                            color: '#404545',
                                            bold: true,
                                            fontSize: 25,
                                        }
                                    };
                                    var chart = new google.visualization.PieChart(document.getElementById('piechart<?php echo $name; ?>'));
                                    chart.draw(data, options);
                                }
                            </script>
                        </div>
                    </div>
                </form>
            </div>
            <?php
        }
        ?>
    </main>
    <footer>
        <p class="copyright">Copyright reamis ag</p> <p class="copyright">User: <?php echo($_SESSION['vorname'] . ' ' . $_SESSION['nachname']); ?></p>
    </footer>
</body>
</html>


















