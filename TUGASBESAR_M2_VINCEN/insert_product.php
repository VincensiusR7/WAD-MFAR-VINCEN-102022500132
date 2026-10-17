<?php

include "koneksi.php";


$cek = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM products");
$data = mysqli_fetch_assoc($cek);
$total = $data['total'];

if ($total > 0) {
    die("Data produk sudah ada sebanyak " . $total . " produk. Data tidak dimasukkan lagi untuk mencegah duplikat.");
}


$products = [
    [
        "Vintage Denim Jacket",
        "Sangat baik",
        250000,
        "L",
        "Vintagedenimjacket.jpg",
        10
    ],
    [
        "Oversized Hoodie",
        "Baik",
        180000,
        "M",
        "Oversizedhoodie.jpg",
        7
    ],
    [
        "White Sneakers",
        "Sangat baik",
        350000,
        "42",
        "sneakers.jpg",
        17
    ],
    [
        "Black Cargo Pants",
        "Baik",
        150000,
        "L",
        "blackcargo.jpg",
        21
    ],
    [
        "Vintage Knit Sweater",
        "Sangat baik",
        220000,
        "M",
        "sweaters.jpg",
        7
    ],
    [
        "BD PS 5 God Of War Ragnarok",
        "Baik",
        520000,
        "M",
        "bdps5.jpg",
        45
    ],
    [
        "Leather Bag",
        "Sangat baik",
        300000,
        "-",
        "leatherbag.jpg",
        7
    ],
    [
        "RTX 3080 Founder Edition",
        "Sangat Baik",
        10951000,
        "L",
        "rtx3080.jpg",
        47
    ],
    [
        "Running Shoes",
        "Baik",
        275000,
        "41",
        "runningshoes.jpg",
        50
    ],
    [
        "Denim Skirt",
        "Sangat baik",
        175000,
        "M",
        "denimskirt.jpg",
        0
    ],
    [
        "Casual Blazer",
        "Baik",
        280000,
        "L",
        "casualblazer.jpg",
        0
    ],
    [
        "Slavia Praha Jersey 2008-2009",
        "Sangat baik",
        1200000,
        "-",
        "slaviaprahaumbro.jpg",
        69
    ],
    [
        "Real Madrid Jersey",
        "Baik",
        240000,
        "M",
        "realmadrid.jpg",
        200
    ],
    [
        "Classic Sneakers",
        "Sangat baik",
        320000,
        "40",
        "clasicsneakers.jpg",
        10
    ],
    [
        "Casual Jacket",
        "Baik",
        225000,
        "M",
        "casualjacket.jpg",
        19
    ]
];


// Query INSERT
$sql = "INSERT INTO products 
        (name, product_condition, price, size, image, likes)
        VALUES (?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($koneksi, $sql);

if (!$stmt) {
    die("Gagal menyiapkan query: " . mysqli_error($koneksi));
}


foreach ($products as $product) {

    mysqli_stmt_bind_param(
        $stmt,
        "ssissi",
        $product[0],
        $product[1],
        $product[2],
        $product[3],
        $product[4],
        $product[5]
    );

    if (!mysqli_stmt_execute($stmt)) {
        die("Gagal memasukkan produk: " . mysqli_stmt_error($stmt));
    }
}

mysqli_stmt_close($stmt);

echo "<h2>Berhasil!</h2>";
echo "<p>15 produk berhasil dimasukkan ke database ShopKu.</p>";
echo "<p><a href='ecommerce.php'>Lihat halaman ShopKu</a></p>";

mysqli_close($koneksi);

?>