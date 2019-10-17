<?php
session_start();
require_once "../Config/config.php";
require_once "../system/system.php";
?>

<html>
<link href="../CSS/DefaultCSSsimon.css" rel="stylesheet" type="text/css">

<head>
    <title>Timesheet Dayli quotes</title>
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

<main style="flex-direction: row; justify-content: space-evenly" >
    <div class="contentmain" style="height: 300px; width: 300px; text-align: center" >
        <h1 class="font1" style="margin-top: 10px"> Dayli-quotes </h1>
        <form action="" method="POST" style="text-align: center">
            </br></br>
            <input  class="logini " type="text" name="nachname" placeholder="Last name" style="width: 200px">
            </br></br>
            <input class="logini" type="text" name="vorname" placeholder="First name" style="width: 200px">
            </br></br>
            <input class="logini" type="time" name="tagessoll" placeholder="Day should" style="width: 200px">
            </br></br>
            <input class="button" type="submit" name="soll" value="Set" style="width: 200px">
        </form>
    </div>

    <div class="contentmain" style="height: 300px; width: 350px;">
                <h1 class="font1">Public-holidays</h1>
                        <form action="" method="post">
                            </br></br></br>
                            <input class="logini" type="text" name="feiertagName" placeholder="Name" style="width: 200px">
                            </br></br>
                            <input class="logini" type="date" name="feiertagDatum" placeholder="Date" style="width: 200px">
                            </br></br>
                            <input class="button" type="submit" name="addFeiertag" value="Add" style="width: 200px">
                        </form>
    </div>
        <div class="contentmain" style="height: 300px; width: 350px;">
            <form action="" method="post">
                <h1 class="font1">Public-holidays</h1>

                <input class="logini" type="number" name="feiertagId" placeholder="Public-holiday ID" style="width: 200px">
                </br></br>
                <input class="button" type="submit" name="delFeiertag" value="Delete" style="width: 200px">
                </br></br>
            </form>
        </div>

        <div class="contentmain">
            <h1 class="font1" >Public-holidays</h1>
            <table class="table1" id="tablehover" style="margin-top: 60px; width: 400px; margin-left: 75px">
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
                </div>
            </fieldset>
        </form>
    </div>




</main>

<footer>
    <form method="post" style="text-align: center;">
        <button class="button" type="submit" name="main" value="main" style="margin-top: -150px">Mainpage</button>
    </form>

    <p class="copy">Copyright reamis ag</p>
    <p class="copy">User: <?php echo($_SESSION['vorname'] . ' ' . $_SESSION['nachname']); ?></p>
</footer>
</body>
</html>


















