<?php
session_start();
require_once "../Config/config.php";
require_once "../system/timecontrol.php";
?>

<html>
<link href="../CSS/DefaultCSSsimon.css" rel="stylesheet" type="text/css">

<head>
    <title>Timesheet Timecontrol</title>
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

<main style=" flex-direction: column; justify-content: space-evenly">
    <div class="contentmain" style="height: 400px" >
        <h1 class="font1" style="margin-top: 10px">Time-control</h1>
        <form method="post" action="" style="text-align: center">
            <div>
            <?php
            echo('<button class="button" type="submit" name="was" value="all"> All </button>    ');
            while ($res = $query1->fetch_array()) {
                $name = $res['projektname'];
                $id = $res['projektId'];
                echo('<button class="button" type="submit" name="was" value=' . $res['projektId'] . '> ' . $name . ' </button>  ');
            }
            ?>
            </div>
            <div style="margin-left: 100px">
                <table class="table1"  id="tablehover"  style="margin-left: -20px">
                    </br></br>
                    <?php
                    if (!$_POST || $_POST['was'] == 'all' || $_POST['num']) {
                        $query1 = $mysqli->query($commall);
                        while ($res1 = $query1->fetch_array()) {
                            echo('<tr class="tablehover">');
                            echo('<td>' . $res1['zeitId'] . '</td>');
                            echo('<td>' . $res1['datum'] . '</td>');
                            $startzeit = $res1['start'];         ///Rechnen zeit
                            $endzeit = $res1['stop'];            ///Rechnen zeit
                            $pause = $res1['pause'];            ///Rechnen zeit
                            $s->arbeitszeit($startzeit, $endzeit, $pause);
                            echo('<td>' . $tot_time . ' Stunden</td>');
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
        <div>
             <form method="post">
                 <input class="logini" type="number" name="num" required placeholder=" Time number"></br>
                 <button class="button" type="submit" name="del" value= >Delete</button>
             </form>

        </div>
    </div>

    <div style="text-align: center">
        <form method="post">
            <button class="button" type="submit" name="main">Mainpage</button>
            <button class="button" type="submit" name="timekeeping">Timekeeping</button>
            <button class="button" type="submit" name="timeview">Timeviwe</button>
        </form>
    </div>
</main>
<footer>
    <p class="copy">Copyright reamis ag</p>
    <p class="copy">User: <?php echo($_SESSION['vorname'] . ' ' . $_SESSION['nachname']); ?></p>
</footer>
</body>
</html>


















