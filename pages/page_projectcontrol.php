<?php
session_start();
require_once "../Config/config.php";
require_once "../system/projectcontrol.php";
?>

<html>
<link href="../CSS/DefaultCSSsimon_1.css" rel="stylesheet" type="text/css">
<head>
    <title>Timesheet projectcontrols</title>
</head>
<body>
    <ul>
        <p class="titlemain">Timesheet</p>
    </ul>
    <nav>
        <form class="nav" method="post">
            <button class="buttonnavigation" name="main">Mainpage</button>
            <button class="buttonnavigation" name="charts">Charts</button>
            <button class="buttonnavigation" name="logout">Logout</button>
        </form>
    </nav>
    <main>
        <div class="divcontent" id="projectcontrol">
            <h1 class="titelcontetn" style="margin-top: 10px">Project overview</h1>
            <table class="table1" id="tablehover" style="margin-top: 10px;  margin-left: 2.5vw">
                <th>
                    Name
                </th>
                <th>
                    Description
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
        </div>

        <div class="divcontent" id="projectcontrol">

            <h1 class="titelcontetn">Project set up</h1>
            <div>
                <div>
                    <form action="" method="post">
                        <h1 class="copyright">Set up Project</h1>
                        <input class="inputcontetn" type="text" name="projektName" placeholder="Projectname"><br><br>
                        <input class="inputcontetn" type="text" name="projektBeschreibung" placeholder="Description"><br>
                        <br><br>
                        <input class="buttoncontetn" type="submit" name="projekt" value="Add Project">
                    </form>
                </div>
                <div>
                    <form action="" method="post">
                        <br>
                        <h1 class="copyright"> Project archive</h1>
                        <select class="inputcontetn" name="projekt"  required >
                            <?php
                        $res = $mysqli->query("SELECT projektname, beschreibung FROM projekt WHERE archiviert LIKE 'false' ORDER BY projektId");
                        while ($row = $res->fetch_assoc()) {
                            echo('<option>' . $row['projektname'] . '</option>');
                        }
                        ?>
                        </select>
                        <br><br>
                        <input class="buttoncontetn" type="submit" name="archiv" value="Archive">
                    </form>
                </div>
            </div>
    </main>
    <footer>
        <p class="copyright">Copyright reamis ag</p> <p class="copyright">User: <?php echo($_SESSION['vorname'] . ' ' . $_SESSION['nachname']); ?></p>
    </footer>
</body>
</html>


















