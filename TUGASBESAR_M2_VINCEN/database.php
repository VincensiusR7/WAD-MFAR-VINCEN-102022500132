<?php

$host = "localhost";
$user = "root";
$password = "";
$port = 3306;
$db = "";
// Koneksi ke MySQL Laragon
$koneksi = mysqli_connect($host, $user, $password, $db, $port);

if (!$koneksi) {
    die("Koneksi MySQL gagal: " . mysqli_connect_error());
}

// Membuat database ShopKu
$sql = "CREATE DATABASE IF NOT EXISTS db_shopku";

if (mysqli_query($koneksi, $sql)) {
    echo "Database db_shopku berhasil dibuat!";
} else {
    echo "Gagal membuat database: " . mysqli_error($koneksi);
}

mysqli_close($koneksi);

?>