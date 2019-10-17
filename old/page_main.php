<?php
session_start();
require_once "../Config/config.php";
require_once "../system/main.php";
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

    <main  style="flex-direction: column">
        <div class="contentmain" style="height: 300px">
            <h1 class="font1" style="margin-top: 10px">Main-page</h1>
            <p class="copy">Welcome to Timesheets. Please chose you wishes or die.</p>
        </div>
        <div>
            <form method="post" action="" style="text-align: center">
                <?php
                if ($_SESSION['user'] == "admin"){
                    ?> </br></br>
                    <button class="button" type="submit" name="usercontrol"> Usercontrol </button>
                    <button class="button" type="submit" name="projekte"> Projectcontrol </button>
                    <button class="button" type="submit" name="Charts"> Projectview </button>
                    <button class="button" type="submit" name="system"> System </button>
                    <button class="button" type="submit" name="export"> Exports </button>
                    <?php
                }
                elseif ($_SESSION['user'] == "user"){
                    ?></br></br>
                    <button class="button" type="submit" name="usercontrol"> Usercontrol </button>
                    <button class="button" type="submit" name="time"> Timecontrol </button>
                    <?php
                }
                else{
                    header('Location: ../pages/page_login.php');
                }
                ?>
            </form>
        </div>
    </main>

    <footer>
        <p class="copy">Copyright reamis ag</p> <p class="copy">User: <?php echo($_SESSION['vorname'] . ' ' . $_SESSION['nachname']); ?></p>
    </footer>
</body>
</html>


















