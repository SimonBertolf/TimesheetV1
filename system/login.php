<?php
session_start();
require_once('../Config/config.php');

if (isset($_POST['log'])) {
    $email = $_POST['email'];
    $passwort = md5($_POST['passwort']);
    $user = $mysqli->query("SELECT * FROM user WHERE email = '$email'");
    $res = $user->fetch_assoc();
    if ($res !== false && $res !== null && $res['passwort'] == $passwort) {
        $_SESSION['user'] = $res['typ'];
        $_SESSION['userId'] = $res['userId'];
        $_SESSION['nachname'] = $res['nachname'];
        $_SESSION['vorname'] = $res['vorname'];
        header('Location: ../pages/page_main.php');
    } else {
        $errorMessage = " E-Mail oder Passwort Ungültig !!";
    }
}

