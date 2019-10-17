<?php
session_start();
require_once "../Config/config.php";
require_once "../system/timecontrol.php";
?>

<html>
<link href="../CSS/DefaultCSSsimon.css" rel="stylesheet" type="text/css">

<head>
    <title>Timesheet Timekeeping</title>
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

<main  style="flex-direction: column; justify-content: space-evenly">
    <div class="contentmain" style="height: 200px; width: 800px; text-align: center" >

        <h1 class="font1" style="margin-top: 10px">Timesheet Time-keeping</h1>
        <form action="" method="post"></br></br></br>
            <table class="table2" style="margin-left: 80px">
                <tr>
                    <th>Datum</th>
                    <th>Kalenderwoche</th>
                    <th>Start</th>
                    <th>Stop</th>
                    <th>Pause</th>
                    <th>Projekt</th>
                    <th>Beschreibung</th>
                </tr>
                <tr>
                    <td><input type="date" name="datum" required style="border: unset; background-color: unset; font-family: 'Century Gothic'; color: #404545;"> </td>
                    <td><input type="number" name="kalenderwoche" required style="border: unset; background-color: unset; font-family: 'Century Gothic'; color: #404545;"> </td>
                    <td><input type="time" name="start" required style="border: unset; background-color: unset; font-family: 'Century Gothic'; color: #404545;"> </td>
                    <td><input type="time" name="stop" required style="border: unset; background-color: unset; font-family: 'Century Gothic'; color: #404545;"> </td>
                    <td><input type="time" name="pause" style="border: unset; background-color: unset; font-family: 'Century Gothic'; color: #404545;"></td>
                    <td><select name="projekt"  required style="border: unset; background-color: unset; font-family: 'Century Gothic'; color: #404545;-webkit-appearance: none;">
                            <?php
                            $commsel = "SELECT * FROM `projekt`WHERE projekt.archiviert = 'FALSE'";
                            $query = $mysqli->query($commsel);
                            while ($res = $query->fetch_array()){
                                echo('<option>'. $res['projektname'] .'</option>');
                            }
                            ?>
                        </select>
                    </td>
                    <td><input type="text" name="beschreibung" placeholder="Beschreibung" required style="border: unset; background-color: unset; font-family: 'Century Gothic' font-size: 13px; color: #404545;"></td>
                </tr>
            </table>
            </br>
            <button class="button" type="submit" name="save" value="save">Speichern</button>
        </form>
    </div>

<div style="text-align: center">
        <form method="post" action="page_timecontrol.php">
            <button class="button" type="submit" name="main">Mainpage</button>
            <button class="button" type="submit" name="time" value="time">Timecontrol</button>
        </form>
</div>

</main>

<footer>
    <p class="copy">Copyright reamis ag</p>
    <p class="copy">User: <?php echo($_SESSION['vorname'] . ' ' . $_SESSION['nachname']); ?></p>
</footer>
</body>
</html>


















