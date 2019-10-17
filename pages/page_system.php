<?php
session_start();
require_once "../Config/config.php";
require_once "../system/system.php";
?>

<html>
<link href="../CSS/DefaultCSSsimon_1.css" rel="stylesheet" type="text/css">
<head>
    <title>Timesheet System</title>
</head>
<body>
    <ul>
        <p class="titlemain">Timesheet</p>
    </ul>
    <nav>
        <form class="nav" method="post">
            <button class="buttonnavigation" name="main">Mainpage</button>
            <button class="buttonnavigation" name="export">Export</button>
            <button class="buttonnavigation" name="logout">Logout</button>
        </form>
    </nav>
    <main>

        <div class="divcontent" id="login" >
            <h1 class="titelcontetn"> Dayli-quotes </h1>
            <form action="" method="POST" style="text-align: center">
                </br></br>
                <input  class="inputcontetn " type="text" name="nachname" placeholder="Last name" style="width: 200px">
                </br></br>
                <input class="inputcontetn" type="text" name="vorname" placeholder="First name" style="width: 200px">
                </br></br>
                <input class="inputcontetn" type="time" name="tagessoll" placeholder="Day should" style="width: 200px">
                </br></br>
                <input class="buttoncontetn" type="submit" name="soll" value="Set" style="width: 200px">
            </form>
        </div>

        <div class="divcontent" id="projectcontrol">
            <h1 class="titelcontetn" >Public-holidays</h1>
            <table class="table1" id="tablehover" style="margin-left: 2.5vw">
                <th>Id</th>
                <th>Feiertag</th>
                <th>Datum</td>
                <?php
                $res = $mysqli->query("SELECT feiertagId,feiertagName, datum FROM feiertag ORDER BY feiertagId");
                while ($row = $res->fetch_assoc()) {
                    echo('<tr>
                              <td>' . $row['feiertagId'] . '</td>
                              <td>' . $row['feiertagName'] . '</td>
                              <td>' . $row['datum'] . '</td>
                              </tr>');
                }
                ?>
            </table>
        </div>

        <div class="divcontent" id="login">
            <h1 class="titelcontetn">Public-holidays</h1>
            <form action="" method="post">
                </br></br>
                <input class="inputcontetn" type="text" name="feiertagName" placeholder="Name" style="width: 200px">
                </br></br>
                <input class="inputcontetn" type="date" name="feiertagDatum" placeholder="Date" style="width: 200px">
                </br></br>
                <input class="buttoncontetn" type="submit" name="addFeiertag" value="Add" style="width: 200px">
            </form>
        </div>

        <div class="divcontent" id="login">
            <form action="" method="post">
                <h1 class="titelcontetn">Delete holidays</h1>
                </br></br>
                <select class="inputcontetn" name="feiertagName" style="width: 200px">
                <?php
                $query = $mysqli->query("SELECT feiertagName FROM feiertag");
                while ($row = $query->fetch_assoc()) {
                    echo ('<option>'.$row['feiertagName'].'</option>');
                }
                ?>
                </select>
                </br></br>
                <input class="buttoncontetn" type="submit" name="delFeiertag" value="Delete" style="width: 200px">
                </br></br>
            </form>
        </div>
    </main>
    <footer>
        <p class="copyright">Copyright reamis ag</p> <p class="copyright">User: <?php echo($_SESSION['vorname'] . ' ' . $_SESSION['nachname']); ?></p>
    </footer>
</body>
</html>


















