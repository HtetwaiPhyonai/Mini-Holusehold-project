<?php
$dbhost = '127.0.0.1';
$dbuser = 'root';
$dbpass = '';
$dbname = 'money_management';
$connection = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
mysqli_report(MYSQLI_REPORT_OFF);
if(!$connection){
    die();
}