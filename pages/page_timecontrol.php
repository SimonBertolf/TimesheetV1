<?php
session_start();
require_once "../Config/config.php";
require_once "../system/timecontrol.php";
?>

<html>
<link href="../CSS/DefaultCSSsimon_1.css" rel="stylesheet" type="text/css">
<head>
    <title>Timesheet Test Layout</title>
</head>
<body>
    <ul>
        <p class="titlemain">Timesheet</p>
    </ul>
    <nav>
        <form class="nav" method="post">
            <button class="buttonnavigation" name="main">Mainpage</button>
            <button class="buttonnavigation" name="logout">Logout</button>
        </form>
    </nav>
    <main>
        <div class="divcontent" id="timecontrol">
            <h1 class="titelcontetn" style="margin-top: 10px">Time-control</h1>
            <form method="post" style="display: flex; justify-content: space-evenly; flex-flow: wrap; overflow: hidden" >
                <div>
                    <?php
                    echo('<button class="buttontime"  type="submit" name="was" value="all"> All </button><br><br>');
                    while ($res = $query1->fetch_array()) {
                        $name = $res['projektname'];
                        $id = $res['projektId'];
                        echo('<button class="buttontime" type="submit" name="was" value=' . $res['projektId'] . '> ' . $name . ' </button><br><br>');
                    }
                    ?>
                </div>
                <div style="display: flex; height: 300px; overflow-y: scroll; padding: 10px">
                    <table class="table1"  id="tablehover" style="width: 550px;">
                        </br></br>
                        <?php
                        if (!$_POST || $_POST['was'] == 'all' || $_POST['num']) {
                            $query1 = $mysqli->query($commalle);
                            while ($res1 = $query1->fetch_array()) {
                                echo('<tr>');
                                echo('<td>' . $res1['zeitId'] . '</td>');
                                echo('<td>' . $res1['datum'] . '</td>');
                                $startzeit = $res1['start'];         ///Rechnen zeit
                                $endzeit = $res1['stop'];            ///Rechnen zeit
                                $pause = $res1['pause'];            ///Rechnen zeit
                                $s->arbeitszeit($startzeit, $endzeit, $pause);
                                echo('<td>' . $tot_time . ' Stunden</td>');
                                echo('<td>' . $res1['projektname'] . '</td>');
                                echo('<td>' . $res1['beschreibung'] . '</td>');
                            }
                        } elseif ($_POST['was'] = $_POST['was']) {
                            $query = $mysqli->query($comm);
                            while ($res = $query->fetch_array()) {
                                echo('<tr>');
                                echo('<td>' . $res['zeitId'] . '</td>');
                                echo('<td>' . $res['datum'] . '</td>');
                                $startzeit = $res['start'];         ///Rechnen zeit
                                $endzeit = $res['stop'];            ///Rechnen zeit
                                $pause = $res['pause'];            ///Rechnen zeit
                                $s->arbeitszeit($startzeit, $endzeit, $pause);
                                echo('<td>' . $tot_time . ' Stunden</td>');
                                echo('<td>' . $res['beschreibung'] . '</td>');
                            }
                        }
                        ?>
                    </table>
                </div>
            </form>

            <form action="" method="post">
                <table class="table" style="margin-left: 6vw">
                    <tr>
                        <th>Datum</th>
<!--                        <th>Kalenderwoche</th>-->
                        <th>Start</th>
                        <th>Stop</th>
<!--                        <th>Pause</th>-->
                        <th>Projekt</th>
                        <th>Beschreibung</th>
                    </tr>
                    <tr>
                        <td><input type="date" name="datum" required style="border: unset; background-color: unset; font-family: 'Century Gothic'; color: #404545;"> </td>
<!--                        <td><input type="number" name="kalenderwoche" style="border: unset; background-color: unset; font-family: 'Century Gothic'; color: #404545;"> </td>-->
                        <td><input type="time" name="start"  style="border: unset; background-color: unset; font-family: 'Century Gothic'; color: #404545;"> </td>
                        <td><input type="time" name="stop"  style="border: unset; background-color: unset; font-family: 'Century Gothic'; color: #404545;"> </td>
<!--                        <td><input type="time" name="pause" style="border: unset; background-color: unset; font-family: 'Century Gothic'; color: #404545;"></td>-->
                        <td><select name="projekt"   style="border: unset; background-color: unset; font-family: 'Century Gothic'; color: #404545;-webkit-appearance: none;">
                                <?php
                                $commsel = "SELECT * FROM `projekt`WHERE projekt.archiviert = 'FALSE'";
                                $query = $mysqli->query($commsel);
                                while ($res = $query->fetch_array()){
                                    echo('<option>'. $res['projektname'] .'</option>');
                                }
                                ?>
                            </select>
                        </td>
                        <td><input type="text" name="beschreibung" placeholder="Beschreibung"  style="border: unset; background-color: unset; font-family: 'Century Gothic' font-size: 13px; color: #404545;"></td>
                    </tr>
                </table>
                </br>
                <button class="buttoncontetn" type="submit" name="save" value="save">Save</button>
                <button class="buttoncontetn" type="submit" name="schule" value="schule">Schule</button>
            </form>
            <div>
                <form method="post"> </br> </br>
                    <input class="inputcontetn" type="number" name="num" required placeholder="Stunden ID">
                    <button class="buttoncontetn" type="submit" name="del" value= >Delete</button>
                    <?php
                    $id = $_POST['num'];

                    if ($_POST['num']) {
                        $id = $_POST['num'];
                        $comdel = "DELETE FROM zeit WHERE zeitId = $id ";
                        $mysqli->query($comdel);
                        header('Location: page_timecontrole');
                    }
                    ?>
                </form>
            </div>
        </div>

<!--        <div class="divcontent" id="long">-->
<!--            <h1 class="titelcontetn">Time-view</h1>-->
<!--            <form method="post" style="margin-left: 2vw">-->
<!--                <table class="table">-->
<!--                    <tr>-->
<!--                        <td>-->
<!--                            <select name="projekt"  required style="border: unset; background-color: unset; font-family: 'Century Gothic'; color: #404545;-webkit-appearance: none;">-->
<!--                                --><?php
//                                $commsel = "SELECT * FROM `projekt`WHERE archiviert = 'FALSE'";
//                                $query = $mysqli->query($commsel);
//                                while ($res = $query->fetch_array()){
//                                    echo('<option>'. $res['projektname'] .'</option>');
//                                }
//                                ?>
<!--                            </select>-->
<!---->
<!--                            <select name="user"  required style="border: unset; background-color: unset; font-family: 'Century Gothic'; color: #404545;-webkit-appearance: none;">-->
<!--                                --><?php
//                                $commsel = "SELECT * FROM user";
//                                $query = $mysqli->query($commsel);
//                                while ($res = $query->fetch_array()){
//                                    echo('<option>'. $res['vorname'].'</option>');
//                                }
//                                ?>
<!--                            </select>-->
<!--                            <input type="date" name="start" required style="border: unset; background-color: unset; font-family: 'Century Gothic'; color: #404545;">-->
<!--                            <input type="date" name="stop" required style="border: unset; background-color: unset; font-family: 'Century Gothic'; color: #404545;">-->
<!--                    </tr></table>-->
<!--                <br/>-->
<!--                <input class="buttoncontetn" type="submit" name="go" value="Anzeigen">-->
<!--                <h2 class="titelcontetn">--><?php //echo ($stunden. ' Stunden');?><!--</h2>-->
<!--            </form>-->
<!--        </div>-->
    </main>
    <footer>
        <p class="copyright">Copyright reamis ag</p> <p class="copyright">User: <?php echo($_SESSION['vorname'] . ' ' . $_SESSION['nachname']); ?></p>
    </footer>
</body>
</html>


















