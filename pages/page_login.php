<?php
session_start();
require_once "../system/login.php";
?>

<html>
<link href="../CSS/DefaultCSSsimon_1.css" rel="stylesheet" type="text/css">
<head>
    <title>Timesheet login</title>
</head>
<body>
    <ul>
        <p class="titlemain">Timesheet</p>
    </ul>
    <main>
        <div class="divcontent" id="login">
                <p class="titelcontetn">Welcome to Timesheet</p>
                <form method="post">
                    <input class="inputcontetn" type="email" name="email" placeholder=" E-Mail" required>
                    </br></br>
                    <input class="inputcontetn" type="password" name="passwort" placeholder="Password" required>
                    </br></br></br>
                    <button class="buttoncontetn" type="submit" name="log" >Login</button>
                    <p class="error"><?php if (isset($errorMessage)){ echo$errorMessage;}?></p>
                </form>
        </div>
    </main>
    <footer>
        <p class="copyright">Copyright reamis ag</p>
    </footer>
</body>
</html>


















