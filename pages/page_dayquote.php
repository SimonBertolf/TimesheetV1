<?php
session_start();
require_once "../system/dayquote.php";
?>

<html>
<link href="../CSS/DefaultCSSsimon_1.css" rel="stylesheet" type="text/css">
<head>
    <title>Timesheet dayquote</title>
</head>
<body>
    <ul>
        <p class="titlemain">Timesheet</p>
    </ul>
    <nav>
        <form class="nav" method="post">
            <button class="buttonnavigation" name="usercontrol">Usercontrol</button>
            <button class="buttonnavigation" name="logout">Logout</button>
        </form>
    </nav>
    <main>
        <div class="divcontent" id="login">
            <h1 class="copyright">User</h1>
            <br><br>
            <form method="post">
                <?php
                if($_SESSION['user'] == 'admin') {
                    ?>
                    <select class="inputcontetn" name="name" id="name">
                        <?php
                        $query = $mysqli->query("SELECT vorname FROM user");
                        while ($res = $query->fetch_assoc())
                            echo('<option>' . $res['vorname'] . '</option>');
                        ?>
                    </select>
                    <?php
                }
                ?>
                <br><br><br>
                <input class="inputcontetn" type="number" name="kw" id="kw" placeholder="Kalenderwoche">
                <br><br><br>
                <button class="buttoncontetn" type="submit" name="show">Show</button>
            </form>
        </div>
        <div class="divcontent">
            <div id="curve_chart_1" ></div>
        </div>

        <div class="divcontent" style="height: 400px; width: 300px;" >
        <div id="columnchart_material" style="width: 800px; height: 500px; margin-left: 10px;margin-top: 10"></div>
        </div>
    </main>
    <footer>
        <p class="copyright">Copyright reamis ag</p> <p class="copyright">User: <?php echo($_SESSION['vorname'] . ' ' . $_SESSION['nachname']); ?></p>
    </footer>
</body>
</html>



    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Datum', 'soll', 'ist'],
            <?php

                foreach ($rows as $data){
                    $z->arbeitszeit($data['start'],$data['stop'], $data['pause']);
                    echo ("['".$data['datum']."',".$d.",".$tot_time."],");
                }
                    ?>
                ]);

            var options = {
                title: 'Dayli Quote',
                colors: ['#777777','#202525'],
                'backgroundColor': 'transparent',
                'borderColor': '#86B900',
                'width': 800, 'height': 400,
                legend: {position: 'right', textStyle: {color: '#404545', fontSize: 12, fontFamily: 'Century Gothic'}},
                titleTextStyle:{
                    color: '#404545',
                    bold: true,
                    fontSize: 25,
                }
            };
            var chart = new google.visualization.LineChart(document.getElementById('curve_chart_1'));
            chart.draw(data, options);
        }
    </script>





    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['bar']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Soll/Ist','Soll', 'ist',],
                <?php
                echo ("['Quote',".$soll.",".$ist."],");
                ?>
            ]);

            var options = {
                title: 'Dayli Quote',
                colors: ['#777777','#202525'],
                'backgroundColor': 'transparent',
                'borderColor': '#86B900',
                'width': 280, 'height': 380,
                legend: {position: 'right',
                    textStyle: {color: '#404545', fontSize: 12, fontFamily: 'Century Gothic'}},
                titleTextStyle:{
                    color: '#404545',
                    bold: true,
                    fontSize: 25,
                }
            };
            var chart = new google.charts.Bar(document.getElementById('columnchart_material'));
            chart.draw(data, google.charts.Bar.convertOptions(options));
        }
    </script>











