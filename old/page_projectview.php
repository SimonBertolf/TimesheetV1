<?php
session_start();
require_once "../Config/config.php";
require_once "../system/projectview.php";
?>

<html>
<link href="../CSS/DefaultCSSsimon.css" rel="stylesheet" type="text/css">

<head>
    <title>Timesheet projectview</title>
</head>


<body>
    <ul>
        <div class="divtitel"><p class="tsTitle"> --- T i m e s h e e t --- </p></div>
        <div class="divtitelLog">
            <form method="post" action="page_login.php">
                <button type="submit" name="logout" class="logout"><img src="../images/Logout.png" height="40px" width="40px"></button>
            </form>
        </div>
    </ul>
       <main style="justify-content: space-evenly; flex-direction: row">

           <?php
           foreach ($data as $name => $chart) {
           ?>

<!--            <h1 class="font1" style="margin-top: 10px">Project-view</h1>-->
                 <div class="divchart">
                     <form method="post" action="" style="text-align: center">
                        <div class="chart" id="piechart<?php echo $name; ?>">
                            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                            <div class="chart">
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
                                            'width': 400, 'height': 400,
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
        <form action="page_main.php" style="text-align: center"><button class="button" style="margin-top: -250px">Mainpage</button></form>

        <p class="copy">Copyright reamis ag</p> <p class="copy">User: <?php echo($_SESSION['vorname'] . ' ' . $_SESSION['nachname']); ?></p>
    </footer>
</body>
</html>


















