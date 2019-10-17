<?php
session_start();
require_once "../Config/config.php";
require_once "../system/export.php";
?>

<html>
<link href="../CSS/DefaultCSSsimon_1.css" rel="stylesheet" type="text/css">
<head>
    <title>Timesheet exports</title>
</head>
<body>
    <ul>
        <p class="titlemain">Timesheet</p>
    </ul>
    <nav>
        <form class="nav" method="post">
            <button class="buttonnavigation" name="system">System</button>
            <button class="buttonnavigation" name="logout">Logout</button>
        </form>
    </nav>
    <main>
        <div class="divcontent" id="login">
            <h1 class="titelcontetn" style="margin-top: 10px">CSV Export</h1>
            <form method="post"style="text-align: center">
                <br>
                <p class="copyright">From <input type="date" name="von" style="width: 130px; background-color: unset; font-family: 'Century Gothic';color: #404545;border: unset; font-size: 20px"></p>
                <p class="copyright">To     <input type="date" name="bis" style="width: 130px; background-color: unset; font-family: 'Century Gothic';color: #404545; border: unset; font-size: 20px; text-decoration: none"></p>
                <button class="buttoncontetn" type="submit" name="go" style="width: 130px">Export</button>
                <button class="buttoncontetn" style="width: 130px"><a href="../CSV/Stundenexport.csv" class="buttoncontetn">Save</a></button>
            </form>
        </div>
    </main>
    <footer>
        <p class="copyright">Copyright reamis ag</p> <p class="copyright">User: <?php echo($_SESSION['vorname'] . ' ' . $_SESSION['nachname']); ?></p>
    </footer>
</body>
</html>


















