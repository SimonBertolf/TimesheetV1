<?php
session_start();
require_once('nav.php');

if (isset($_SESSION['user'])) {

}
else {
   //header('Location: ../pages/page_login.php');
}
