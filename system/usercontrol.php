<?php
session_start();
require_once('../Config/config.php');
require_once('nav.php');

if (isset($_SESSION['user'])) {
    #region-Admin
    if ($_SESSION['user'] == 'admin') {
        $id = $_POST['userId'];
        $nachname = $_POST['nachname'];
        $vorname = $_POST['vorname'];
        $email = $_POST['email'];
        $passwort = md5($_POST['passwort']);
        $typ = $_POST['typ'];
        $soll = $_POST['soll'];
//hinzufügen
        if ($_POST['hinzu'] == 'hinzu') {
            if ($nachname != null && $vorname != null && $email != null && $passwort != null && $typ != null && $soll != null) {
                $sql = "INSERT INTO user (nachname,vorname,email,passwort,typ,soll)VALUES('$nachname','$vorname','$email','$passwort','$typ','$soll')";
                if ($mysqli->query($sql) === TRUE) {
                    $meldung = "Neue User wurde erfolgreich hinzugefügt";
                } else {
                    echo "Error: " . $sql . "<br>" . $mysqli->error;
                }
            } else {
                $errorMessage = "Bitte alle eingabe Felder einfüllen!!";
            }

        }
//löschen
        if ($_POST['loeschen'] == 'loeschen') {

            if ($id != null) {

                $sql = "DELETE FROM user WHERE userId ='$id' ";

                if ($mysqli->query($sql) === TRUE) {
                    echo "User wurde erfolgreich Gelöscht";
                } else {
                    echo "Error:" . $sql . "<br>" . $mysqli->error;
                }
            } else {
                $errorMessage = "Geben Sie Nur ID von dem User um zu Löschen!!";
            }
        }
//passwort zurücksetzen
        if ($_POST['pasz'] == 'pasz') {

            if ($email != null) {

                //Generat a random md5 passwort
                $str = rand();
                $passwort = md5($str);
                //E-Mail
                $empfaenger = $email;
                $betreff = 'Passwort zurueck gesetzt';
                $nachricht = 'Guten Tag ' . $_SESSION['nachname'] . "\r\n" . 'Ihre passwort wurde Zurueck ersetzt'
                    . "\r\n" . 'Deine neue Passwort ist: ' . $passwort;
                $header = 'From: bahwar00@hotmail.com' . "\r\n" .
                    "Reply-To: $email" . "\r\n";


                if (mail($empfaenger, $betreff, $nachricht, $header)) {
                    $meldung = "ihre Passwort wurde Zurückersetzt.";
                    $mysqli->query("UPDATE user SET passwort ='$passwort' WHERE email = '$email'");
                }

            } else {
                $errorMessage = "Geben Sie Nur die E-Mail von dem User um zu Zurücksetzen!!";
            }
        }
    }
    elseif ($_SESSION['user'] == 'user') {

        if ($_POST['aendern'] == 'aendern') {

            $email = $_POST['email'];
            $passwort = md5($_POST['passwort']);
            if ($email != null && $passwort != null) {
                $mysqli->query("UPDATE user SET email= '$email', passwort= '$passwort' WHERE userId = '$_SESSION[userId]'");
            } else {
                $errorMessage = "E-Mail Oder Passwort Darf Nicht lerr sein !!";
            }
        }
    } else {
        header('Location: ../pages/page_login.php');
    }
}
#endregion-Admin

#region-User

