<?php
require_once "../Config/config.php";
require_once "Class_Zeit.php";
require_once "nav.php";

session_start();
$s = new Zeit();
$userid = $_SESSION['userId'];

if(isset($_SESSION['user'])) {
    ///----- Variablen -----///

    $commsel = "SELECT * FROM `projekt`";
    $query1 = $mysqli->query($commsel);

    $order = 'datum';
    $comm = ('SELECT * FROM `zeit` WHERE userId = ' . $userid . '  AND projektId =' . $_POST['was'] . ' ORDER BY ' . $order . ' ASC ');
    $commalle = ('SELECT * FROM `zeit` WHERE userId = ' . $userid . ' ORDER BY ' . $order . ' ASC ');

    $id = $_POST['num'];

    if ($_POST['num']) {
        $id = $_POST['num'];
        $comdel = "DELETE FROM zeit WHERE zeitId = $id ";
        $mysqli->query($comdel);
        header('Location:page_timecontrol.php');
    }
}
else{
    header('Location: ../pages/page_login.php');
}

//// stundenanzeigen
//if(isset($_SESSION['user'])) {
//    require_once "../Config/config.php";
//    require_once "../system/Class_Zeit.php";
//
//    $z = new Zeit();
//    $stunden;
//    $datumstrat = $_POST['start'];
//    $datumstop = $_POST['stop'];
//    $username = $_POST['user'];
//    $projektname = $_POST['projekt'];
//
//    $commall = 'SELECT * FROM zeit
//                LEFT JOIN user ON zeit.userId = user.userId
//                LEFT JOIN projekt ON zeit.projektId = projekt.projektId
//                WHERE user.vorname ="'.$username.'" AND projektname = "'.$projektname.'" AND datum >= "'.$datumstrat.'" AND datum <= "'.$datumstop.'"';
//
//    if ($_POST['go'] == 'Anzeigen'){
//        $query = $mysqli->query($commall);
//        while ($res = $query->fetch_assoc()){
//
//            $z->arbeitszeit($res['start'],$res['stop'],$res['pause']);
//            $stunden += $tot_time ;
//        }
//    }
//}else{
//    header('Location: ../pages/page_login.php');
//}




if(isset($_SESSION['user'])) {
    if ($_POST['time'] == 'time'){
    }
    ///----- Welcher Benutzer -----///
    $userId = $_SESSION['userId'];    //abfrage welche user eingelogt ist

    ///----- Variablen -----///
    if($_POST['save'] == 'save')
    {
        $kalenderwoche = $_POST['kalenderwoche'];
        $datum = $_POST['datum'];
        $start = $_POST['start'];
        $stop = $_POST['stop'];
//        $pause = $_POST['pause'];
        $beschreibung = $_POST['beschreibung'];
        $projekt = $_POST['projekt'];

        ///----- SQL Befehle -----///
        $prRes = $mysqli->query("SELECT projektId FROM projekt WHERE projektname LIKE '$projekt' ");
        $prArray = $prRes->fetch_assoc();
        $projektId = $prArray['projektId'];

        $commins = "INSERT INTO zeit (userId, projektId, datum, start, stop,beschreibung) VALUES ( $userId , $projektId ,'$datum','$start','$stop','$beschreibung')";
        $mysqli->query($commins);
        if($mysqli->error){
            echo('Fehler'. $mysqli->error);
        }
    }
}
else
{
    header('Location: ../pages/page_login.php');
}
