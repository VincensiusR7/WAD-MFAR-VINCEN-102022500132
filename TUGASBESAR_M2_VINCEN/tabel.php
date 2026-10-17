<?php

$host = "localhost";
$user = "root";
$password = "";
$db = "db_shopku";
$port = 3306;

$koneksi = mysqli_connect($host, $user, $password, $db, $port);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Melihat semua tabel dalam database db_shopku
$sql = "SHOW TABLES";
$result = mysqli_query($koneksi, $sql);

echo "<h2>Daftar Tabel dalam db_shopku</h2>";

if (mysqli_num_rows($result) > 0) {

    while ($row = mysqli_fetch_array($result)) {
        echo $row[0] . "<br>";
    }

} else {
    echo "Belum ada tabel.";
}

mysqli_close($koneksi);

?>