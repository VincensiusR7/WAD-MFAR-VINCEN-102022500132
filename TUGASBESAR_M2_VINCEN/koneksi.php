<?php

$host = "localhost";
$user = "root";
$password = "";
$db = "db_shopku";
$port = 3306;

$koneksi = mysqli_connect($host, $user, $password, $db, $port);

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

?>