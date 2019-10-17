<?php
session_start();
require_once "../Config/config.php";
require_once "../system/usercontrol.php";
?>

<html>
<link href="../CSS/DefaultCSSsimon.css" rel="stylesheet" type="text/css">

<head>
    <title>Timesheet Usercontrol</title>
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
        <?php
        if($_SESSION['user'] == 'user') {
        ?>
        <div class="contentmain" style="height: 300px">

            <div><h1 class="font1" style="margin-top: 10px">User-controls</h1></div>

            <form method="POST">
                </br></br>
                    <div class='bls'>

                        <input class="logini" type="email" name="email" id='email' placeholder="New E-Mail">
                        </br></br></br>
                        <input class="logini" type="password" name="passwort" id="passwort" placeholder="New Password">
                    </div>
                     </br></br>
                    <button class="button" type="submit" name="aendern" value="aendern">Change</button>
                    <button class="button" type="reset" name="Reset" value="Zurücksetzen">Reset</button>
                    <p class="copy" id="Perro"><?php if($errorMessage){echo ("$errorMessage");}?></p>
            </form>
            <?php
            }
            if($_SESSION['user'] == 'admin') {
                ?>
            <div class="contentmain" style="height: 550px" >
                <h1 class="font1" style="margin-top: 10px">User-controls</h1>

                <form method="post" style="text-align: center">
                        <div>
                            <input class="logini"  type="number" name="userId" id='userId' placeholder="ID">
                            </br></br>
                            <input class="logini"  type="text" name="nachname" id='nachname' placeholder=" Last name">
                            </br></br>
                            <input class="logini"  type="text" name="vorname" id='vorname' placeholder=" First name">
                            </br></br>
                            <input class="logini"  type="email" name="email" id='email' placeholder="E-Mail">
                            </br></br>
                            <input class="logini"  type="password" name="passwort" id="passwort" placeholder="Password">
                            </br></br>
                            <input class="logini"  type="text" name="typ" id='typ' placeholder="Type">
                            </br></br>
                            <input class="logini"  type="text" name="soll" id='soll' placeholder="Soll time">
                            </br></br>
                        </div>
                        <button class="button" type="submit" name="hinzu" value="hinzu">Apply</button>
                        <button class="button" type="submit" name="loeschen" value="loeschen">Delete</button>
                        <button class="button" type="submit" name="pasz" value="pasz">Password reset</button>
                        <button class="button" type="reset" name="Reset" value="Zurücksetzen">Reset</button>

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
        </div>
            <div style="text-align: center">
                <form method="post"><button class="button" type="submit" name="main">Mainpage</button></br></form>
            </div>
    </main>

    <footer>
        <p class="copy">Copyright reamis ag</p> <p class="copy">User: <?php echo($_SESSION['vorname'] . ' ' . $_SESSION['nachname']); ?></p>
    </footer>
</body>
</html>


















