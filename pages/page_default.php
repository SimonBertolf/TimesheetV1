<?php
session_start();
require_once "../Config/config.php";
require_once "../system/projectview.php";
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
        <div class="divcontent" >

        </div>
    </main>
    <footer>
        <p class="copyright">Copyright reamis ag</p> <p class="copyright">User: <?php echo($_SESSION['vorname'] . ' ' . $_SESSION['nachname']); ?></p>
    </footer>
</body>
</html>


















