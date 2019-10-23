<?php
session_start();
require_once "../system/main.php";
require_once "../system/excel_exportV2.php";

if (file_exists('Export '.$monat.'-'.$jahr.'.Xlsx') && isset($_POST['exportexport'])) {

    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.basename('Export '.$monat.'-'.$jahr.'.Xlsx'));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Content-Length: ' . filesize('Export '.$monat.'-'.$jahr.'.Xlsx'));

    ob_clean();
    flush();
    readfile('Export '.$monat.'-'.$jahr.'.Xlsx');
    exit;
}

?>

<html>
<link href="../CSS/DefaultCSSsimon_1.css" rel="stylesheet" type="text/css">
<head>
    <title>Timesheet mainpage</title>
</head>
<body>
    <ul>
        <p class="titlemain">Timesheet</p>
    </ul>
    <nav>
        <form class="nav" method="post">
            <?php
            if ($_SESSION['user'] == "admin"){
                ?>
                <button class="buttonnavigation" type="submit" name="usercontrol"> Usercontrol </button>
                <button class="buttonnavigation" type="submit" name="projectcontrol"> Projectcontrol </button>
                <button class="buttonnavigation" type="submit" name="system"> System </button>
                <button class="buttonnavigation" type="submit" name="logout"> logout </button>

                <?php
            }
            elseif ($_SESSION['user'] == "user"){
                ?>
                <button class="buttonnavigation" type="submit" name="usercontrol"> Usercontrol </button>
                <button class="buttonnavigation" type="submit" name="time"> Timecontrol </button>
                <button class="buttonnavigation" type="submit" name="logout"> Logout </button>
                <?php
            }
            else{
                //header('Location: ../pages/page_login.php');
            }
            ?>
        </form>
    </nav>
    <main>
        <div class="divcontent" id="main" >

            <h1 class="titelcontetn" style="margin-top: 10px">Main-page</h1>
            <p class="copyright">Select the Month you want to export</p>

            <form method="post">
            <input class="inputcontetn" type="text" name="monat" placeholder=" Month as XX "><br><br>
                <button class="buttoncontetn" type="submit" name="exportexport">Exportieren</button>
            </form>
        </div>
    </main>
    <footer>
        <p class="copyright">Copyright reamis ag</p> <p class="copyright">User: <?php echo($_SESSION['vorname'] . ' ' . $_SESSION['nachname']); ?></p>
    </footer>
</body>
</html>













