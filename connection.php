<?php

mysqli_report(MYSQLI_REPORT_OFF);
$server = "localhost";
$database = "paragraf_zadatak";
$username = "vemicnikola4@gmail.com";
$password = "paragraf";

$conn = new Mysqli( $server, $username, $password, $database);
if ( $conn ->connect_error ){
    die("Neuspela konekcija ".$conn->connect_error);
    // die("Neuspela konekcija".$conn_conect_error);
}
$conn->set_charset("utf16");//utf 32 prosirenje utf8



?>