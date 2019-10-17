<?php
session_start();
require_once "../Config/config.php";
require_once "../system/projectview.php";
?>

<html>
<link href="../CSS/DefaultCSSsimon_1.css" rel="stylesheet" type="text/css">
<head>
    <title>Timesheet usercontrols</title>
</head>
<body>
    <ul>
        <p class="titlemain">Timesheet</p>
    </ul>
    <nav>
        <form class="nav" method="post">
            <button class="buttonnavigation" name="main">Mainpage</button>
<!--            <button class="buttonnavigation" name="quote">Dayli Quotes</button>-->
            <button class="buttonnavigation" name="logout">Logout</button>
        </form>
    </nav>
    <main>
            <?php
            if($_SESSION['user'] == 'user') {
            ?>
            <div class="divcontent" id="login">
                <h1 class="titelcontetn">User-controls</h1>
                <form method="POST">
                    </br></br>
                        <input class="inputcontetn" type="email" name="email" id='email' placeholder="New E-Mail">
                        </br></br>
                        <input class="inputcontetn" type="password" name="passwort" id="passwort" placeholder="New Password">
                    </br></br></br></br>
                    <button class="buttoncontetn" type="submit" name="aendern" value="aendern">Change</button>
                    <p class="copy" id="Perro"><?php if($errorMessage){echo ("$errorMessage");}?></p>
                </form>
                <?php
                }
                if($_SESSION['user'] == 'admin') {
                ?>
                <div class="divcontent" id="usercontrol" >
                    <h1 class="titelcontetn" style="margin-top: 10px">User-controls</h1>
                    <form method="post">
                        <div>
                            <input class="inputcontetn"  type="number" name="userId" id='userId' placeholder="ID">
                            </br></br>
                            <input class="inputcontetn"  type="text" name="nachname" id='nachname' placeholder=" Last name">
                            </br></br>
                            <input class="inputcontetn"  type="text" name="vorname" id='vorname' placeholder=" First name">
                            </br></br>
                            <input class="inputcontetn"  type="email" name="email" id='email' placeholder="E-Mail">
                            </br></br>
                            <input class="inputcontetn"  type="password" name="passwort" id="passwort" placeholder="Password">
                            </br></br>
                            <input class="inputcontetn"  type="text" name="typ" id='typ' placeholder="Type">
                            </br></br>
                            <input class="inputcontetn"  type="text" name="soll" id='soll' placeholder="Soll time">
                            </br></br></br></br>
                        </div>
                        <button class="buttoncontetn" type="submit" name="hinzu" value="hinzu">Apply</button>
                        <button class="buttoncontetn" type="submit" name="loeschen" value="loeschen">Delete</button>
                        </br></br>
                        <button class="buttoncontetn" type="submit" name="pasz" value="pasz">Password reset</button>
                        <button class="buttoncontetn" type="reset" name="Reset" value="Zurücksetzen">Reset</button>
                        </br>
                        </br>
                        <label>* Beim Hinzufügen ID Feld am Besten Frei lassen!</label></br>
                        <label>* Beim Löschen Nur ID Feld am Besten eingeben !</label></br>
                        <label>* Beim Psswort Zurücksetzen Nur E-Mail Feld eingeben !</label></br>
                        <p class="copy" id="Perro"><?php if ($errorMessage) {
                                echo("$errorMessage");
                            } ?></p>
                        <p class="copy" id="Pmel"><?php if ($errorMessage) {
                                echo("$errorMessage");
                            } ?></p>
                    </form>
                    <?php
                    }
                    ?>
    </main>
    <footer>
        <p class="copyright">Copyright reamis ag</p> <p class="copyright">User: <?php echo($_SESSION['vorname'] . ' ' . $_SESSION['nachname']); ?></p>
    </footer>
</body>
</html>


















