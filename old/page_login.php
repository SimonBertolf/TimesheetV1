<?php
session_start();
require_once "../Config/config.php";
require_once "../system/login.php";
?>

<html>
<link href="../CSS/DefaultCSSsimon.css" rel="stylesheet" type="text/css">

<head>
    <title>Timesheet login</title>
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

    <main>
        <div class="contentmain">
            <h1 class="font1" style="margin-top: 10px">Welcome to Timesheet</h1>
            <form method="post" action="?index=1">
                </br></br></br>
                <input class="logini" type="email" name="email" id="email" placeholder=" E-Mail">
                </br></br></br>
                <input class="logini" type="password" name="passwort" id="passwort" placeholder="Password">
                </br></br>
                <button class="login" type="submit" name="log" value="log" >Login</button>
            </form>
        </div>
    </main>

    <footer>
        <p class="copy">Copyright reamis ag</p> <p class="copy"></p>
    </footer>
</body>
</html>
