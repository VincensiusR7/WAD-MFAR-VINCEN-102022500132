<?php

include "koneksi.php";

// Cek apakah kolom stock sudah ada
$cek = mysqli_query($koneksi, "SHOW COLUMNS FROM products LIKE 'stock'");

if (mysqli_num_rows($cek) == 0) {

    $sql = "ALTER TABLE products
            ADD COLUMN stock INT NOT NULL DEFAULT 0
            AFTER likes";

    if (mysqli_query($koneksi, $sql)) {
        echo "Kolom stock berhasil ditambahkan ke tabel products!";
    } else {
        echo "Gagal menambahkan kolom stock: " . mysqli_error($koneksi);
    }

} else {

    echo "Kolom stock sudah ada. Tidak perlu dibuat lagi.";

}

mysqli_close($koneksi);

?>