<?php
require_once "Class_Zeit.php";
require_once "../system/nav.php";
require_once "../Config/config.php";
session_start();
$z = new Zeit();


if($_SESSION['user'] == 'admin') {
    $vorname = $_POST['name'];
}
else{
    $vorname = $_SESSION['vorname'];
}


$datum = $_POST['kw'];
$comm       = ("SELECT user.vorname, zeit.datum, zeit.start, zeit.stop, zeit.pause, zeit.kw, user.vorname, user.soll FROM zeit LEFT JOIN user ON zeit.userId = user.userId WHERE user.vorname LIKE '$vorname' AND zeit.kw = '$datum' ORDER BY zeit.datum");
$commall    = ("SELECT user.vorname, zeit.datum, zeit.start, zeit.stop, zeit.pause, zeit.kw, user.vorname, user.soll FROM zeit LEFT JOIN user ON zeit.userId = user.userId WHERE user.vorname LIKE '$vorname' ORDER BY zeit.datum");
$rows = array();
if (isset($_POST['show'])){
    if  ($_POST['kw']){
        $query = $mysqli->query($comm);
        while ($res = $query->fetch_assoc()){
            $rows[] = $res;
        }
    }
    else if (!$_POST['kw']){

        $query = $mysqli->query($commall);
        while ($res = $query->fetch_assoc()){
            $rows[] = $res;
        }
    }
}

if (isset($_POST['show'])){
    $s =("SELECT soll FROM user WHERE vorname LIKE '$vorname'");
$query = $mysqli->query($s)->fetch_assoc();
 $z->soll($query['soll']);
}


////////////////////////
///
$soll = 0;
$ist = 0;
foreach ($rows as $data) {
    $z->arbeitszeit($data['start'], $data['stop'], $data['pause']);
    $z->soll($data['soll']);
    $soll += $d;
    $ist += $tot_time;
}
