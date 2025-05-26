<?php

$host = "localhost";
$db = "bloodflower";
$user = "root";
$pass = "";

mysqli_report(MYSQLI_REPORT_OFF);


$conn = @mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Erro ao conectar com o banco: " . mysqli_connect_error());
} else {
    // echo "Connected successfully";
}
