<?php
session_start();
require_once "../Config/config.php";
require_once "../system/export.php";
?>

<html>
<link href="../CSS/DefaultCSSsimon.css" rel="stylesheet" type="text/css">

<head>
    <title>Timesheet Mainpage</title>
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

    <main style="flex-direction: column">
        <div class="contentmain" style="height: 300px">
            <h1 class="font1" style="margin-top: 10px">Timesheet Export</h1>
            <form method="post" action="" style="text-align: center">
<br>
                <p class="copy">From <input type="date" name="von" style="width: 130px; background-color: unset; font-family: 'Century Gothic';color: #404545;border: unset; font-size: 20px"></p>
                <p class="copy">To     <input type="date" name="bis" style="width: 130px; background-color: unset; font-family: 'Century Gothic';color: #404545; border: unset; font-size: 20px; text-decoration: none"></p>
                <button class="button" type="submit" name="go" style="width: 130px">Export</button>
                <button class="button" style="width: 130px"><a href="../Stundenexport.csv" class="button">Save</a></button>
            </form>
        </div>

        <div style="text-align: center">
            <form method="post">
                <br>
                <button class="button" type="submit" name="main">Mainpage</button>
            </form>
        </div>
    </main>

    <footer>
        <p class="copy">Copyright reamis ag</p> <p class="copy">Benutzer: <?php echo($_SESSION['vorname'] . ' ' . $_SESSION['nachname']); ?></p>
    </footer>
</body>
</html>


















