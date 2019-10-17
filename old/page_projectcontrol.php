<?php
session_start();
require_once "../Config/config.php";


    require_once "../system/projectcontrol.php";

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
    <main style="flex-direction: row; justify-content: space-evenly">
        <div class="contentmain" style="height: 200px">
            <h1 class="font1" style="margin-top: 10px">Project-control Add</h1>
            <form action="" method="post"></br></br>
                <input class="logini" type="text" name="projektName" placeholder="Project name"></br></br>
                <input class="logini" type="text" name="projektBeschreibung" placeholder="Description"></br>
                <input class="button" type="submit" name="projekt" value="Add">
            </form>
        </div>

        <div class="contentmain" style="height: 400px">
            <h1 class="font1" style="margin-top: 10px">Project-control projects</h1>
            <table class="table1" id="tablehover" style="margin-top: 10px; width: 400px; margin-left: 70px">
                <th>
                    Projektname
                </th>
                <th>
                    Beschreibung
                </th>
                </tr>
                <?php
                $res = $mysqli->query("SELECT projektname, beschreibung FROM projekt WHERE archiviert LIKE 'false' ORDER BY projektId");
                while ($row = $res->fetch_assoc()) {
                    echo('<tr>
          <td>' . $row['projektname'] . '</td>
          <td>' . $row['beschreibung'] . '</td>
          </tr>');
                }
                ?>
            </table>

            <form method="post" action="page_main.php" style=" margin-top: 150px" ><button class="button" type="submit" name="main" > mainpage </button></form>
        </div>


        <div class="contentmain" style="height: 200px">
            <form method="post" action="">
                <h1 class="font1" style="margin-top: 10px">Project-control Archive</h1>
                <select class="logini" name="projektName"  required style="-webkit-appearance: none;">
                    <?php
                    $commsel = "SELECT * FROM projekt";
                    $query = $mysqli->query($commsel);
                    while ($res = $query->fetch_array()){
                        echo('<option>'. $res['projektname'].'</option>');
                    }
                    ?>
                </select>
            </br>
                <input class="button" type="submit" name="archiv" value="Archive">
            </form>
        </div>
    </main>
    <footer>
        <p class="copy">Copyright reamis ag</p> <p class="copy">User: <?php echo($_SESSION['vorname'] . ' ' . $_SESSION['nachname']); ?></p>
    </footer>
</body>
</html>


















