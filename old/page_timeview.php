<?php
session_start();
require_once "../Config/config.php";
require_once "../system/timeview.php";
?>

<html>
<link href="../CSS/DefaultCSSsimon.css" rel="stylesheet" type="text/css">

<head>
    <title>Timesheet Timeview</title>
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
    <div class="contentmain" style="height: 500px">
        <h1 class="font1" style="margin-top: 10px">Time-view</h1>
        <form method="post" action="" style="text-align: center"><br/>
            <table class="table2" style="margin-left: 90px">
                <tr>
                    <td>
                <select name="projekt"  required style="border: unset; background-color: unset; font-family: 'Century Gothic'; color: #404545;-webkit-appearance: none;">
                    <?php
                    $commsel = "SELECT * FROM `projekt`WHERE archiviert = 'FALSE'";
                    $query = $mysqli->query($commsel);
                    while ($res = $query->fetch_array()){
                        echo('<option>'. $res['projektname'] .'</option>');
                    }
                    ?>
                </select>
                <select name="user"  required style="border: unset; background-color: unset; font-family: 'Century Gothic'; color: #404545;-webkit-appearance: none;">
                    <?php
                    $commsel = "SELECT * FROM user";
                    $query = $mysqli->query($commsel);
                    while ($res = $query->fetch_array()){
                        echo('<option>'. $res['vorname'].'</option>');
                    }
                    ?>
                </select>

                <input type="date" name="start" required style="border: unset; background-color: unset; font-family: 'Century Gothic'; color: #404545;">
                <input type="date" name="stop" required style="border: unset; background-color: unset; font-family: 'Century Gothic'; color: #404545;">
                </tr></table>
            <br/><br/><br/>
                <input class="button" type="submit" name="go" value="Anzeigen">
            <br/><br/><br/>
                <h2 class="copy"><?php echo ($stunden. ' Stunden');?></h2>
        </form>

    </div>
    <div style="text-align: center">
        <form method="post">
            <button class="button" type="submit" name="main">Mainpage</button>
            <button class="button" type="submit" name="timekeeping">Timekeeping</button>
        </form>
    </div>
</main>
<footer>
    <p class="copy">Copyright reamis ag</p>
    <p class="copy">User: <?php echo($_SESSION['vorname'] . ' ' . $_SESSION['nachname']); ?></p>
</footer>
</body>
</html>


















