<?php

const TIMESHEET_DB_HOST = 'localhost';
const TIMESHEET_DB_USER = 'root';
const TIMESHEET_DB_PW = 'root';
const TIMESHEET_DB_DATABASE = 'Timesheet';

$mysqli = new mysqli(TIMESHEET_DB_HOST, TIMESHEET_DB_USER, TIMESHEET_DB_PW, TIMESHEET_DB_DATABASE);

if ($mysqli === false) {
    die("Fehler: " . $mysqli->connect_error);
}

if ($mysqli->connect_error) {
    die("Fehler: " . $mysqli->connect_error);

}
