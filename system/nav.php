<?php

if (isset($_POST['main'])) {
    header('Location: ../pages/page_main.php');
}
if (isset($_POST['logout'])) {
    header('Location: ../pages/page_login.php');
    session_destroy();
}
if (isset($_POST['timeview'])) {
    header('Location: ../pages/page_timeview.php');
}
if (isset($_POST['timekeeping'])) {
    header('Location: ../pages/page_timekeeping.php');
}
if (isset($_POST['charts'])) {
    header('Location: ../pages/page_projectview.php');
}
if (isset($_POST['usercontrol'])) {
    header('Location: ../pages/page_usercontrol.php');
}
if (isset($_POST['projectcontrol'])) {
    header('Location: ../pages/page_projectcontrol.php');
}
if (isset($_POST['system'])) {
    header('Location: ../pages/page_system.php');
}
if (isset($_POST['time'])) {
    header('Location: ../pages/page_timecontrol.php');
}
if (isset($_POST['export'])) {
    header('Location: ../pages/page_export.php');
}
if (isset($_POST['quote'])) {
    header('Location: ../pages/page_dayquote.php');
}
