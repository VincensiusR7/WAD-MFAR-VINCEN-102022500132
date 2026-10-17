<?php

include "koneksi.php";

/* =====================================================
   UPDATE DATA PRODUK
   ===================================================== */

if (isset($_POST['update_product'])) {

    $id = $_POST['id'];
    $name = $_POST['name'];
    $condition = $_POST['product_condition'];
    $price = $_POST['price'];
    $size = $_POST['size'];
    $likes = $_POST['likes'];
    $stock = $_POST['stock'];

    // Pastikan angka tidak negatif
    if ($price < 0) {
        $price = 0;
    }

    if ($likes < 0) {
        $likes = 0;
    }

    if ($stock < 0) {
        $stock = 0;
    }

    $sql = "UPDATE products 
            SET name = ?,
                product_condition = ?,
                price = ?,
                size = ?,
                likes = ?,
                stock = ?
            WHERE id = ?";

    $stmt = mysqli_prepare($koneksi, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "ssisiii",
        $name,
        $condition,
        $price,
        $size,
        $likes,
        $stock,
        $id
    );

    if (mysqli_stmt_execute($stmt)) {

        header("Location: data_produk.php?updated=1");
        exit;

    } else {

        die("Gagal mengubah produk: " . mysqli_stmt_error($stmt));

    }

    mysqli_stmt_close($stmt);
}


/* =====================================================
   DELETE DATA PRODUK
   ===================================================== */

if (isset($_POST['delete_product'])) {

    $id = $_POST['id'];

    $sql = "DELETE FROM products WHERE id = ?";

    $stmt = mysqli_prepare($koneksi, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "i",
        $id
    );

    if (mysqli_stmt_execute($stmt)) {

        header("Location: data_produk.php?deleted=1");
        exit;

    } else {

        die("Gagal menghapus produk: " . mysqli_stmt_error($stmt));

    }

    mysqli_stmt_close($stmt);
}


/* =====================================================
   PRODUK YANG SEDANG DIEDIT
   ===================================================== */

$edit_id = null;

if (isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];
}


/* =====================================================
   AMBIL SEMUA PRODUK
   ===================================================== */

$sql = "SELECT * FROM products ORDER BY id ASC";

$result = mysqli_query($koneksi, $sql);

if (!$result) {
    die("Query gagal: " . mysqli_error($koneksi));
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Data Produk - ShopKu</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 40px;
        }

        .container {
            width: 95%;
            margin: auto;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 25px;
        }

        .back-button {
            display: inline-block;
            margin-bottom: 20px;
            padding: 10px 18px;
            background-color: #edc001;
            color: black;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
        }

        .back-button:hover {
            background-color: #d4aa00;
        }

        .message {
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 6px;
            text-align: center;
            font-weight: bold;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background-color: #edc001;
            color: black;
            padding: 12px;
            text-align: center;
        }

        td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #fff8d6;
        }

        .product-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 6px;
        }

        .edit-button {
            display: inline-block;
            padding: 8px 14px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
            border: none;
            cursor: pointer;
        }

        .edit-button:hover {
            background-color: #2980b9;
        }

        .delete-button {
            padding: 8px 14px;
            background-color: #e74c3c;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
        }

        .delete-button:hover {
            background-color: #c0392b;
        }

        .save-button {
            padding: 8px 14px;
            background-color: #27ae60;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            margin-bottom: 5px;
        }

        .save-button:hover {
            background-color: #219150;
        }

        .cancel-button {
            display: inline-block;
            padding: 8px 14px;
            background-color: #777;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
        }

        .cancel-button:hover {
            background-color: #555;
        }

        .edit-input {
            width: 90%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .edit-input-number {
            width: 100px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            text-align: center;
        }

        .action-form {
            display: inline;
        }

    </style>

</head>


<body>

<div class="container">

    <h1>Data Produk ShopKu</h1>


    <a href="ecommerce.php" class="back-button">
        ← Kembali ke ShopKu
    </a>


    <?php if (isset($_GET['updated'])) { ?>

        <div class="message success">
            Data produk berhasil diperbarui!
        </div>

    <?php } ?>


    <?php if (isset($_GET['deleted'])) { ?>

        <div class="message success">
            Produk berhasil dihapus dari database!
        </div>

    <?php } ?>


    <table>

        <thead>

            <tr>

                <th>ID</th>

                <th>Gambar</th>

                <th>Nama Produk</th>

                <th>Kondisi</th>

                <th>Harga</th>

                <th>Size</th>

                <th>Likes</th>

                <th>Stock</th>

                <th>Aksi</th>

            </tr>

        </thead>


        <tbody>


            <?php while ($product = mysqli_fetch_assoc($result)) { ?>


                <?php if ($edit_id == $product['id']) { ?>

                    <!-- =================================================
                         BARIS EDIT
                         ================================================= -->

                    <tr>

                        <form method="POST" action="data_produk.php">

                            <td>

                                <?php echo $product['id']; ?>

                                <input
                                    type="hidden"
                                    name="id"
                                    value="<?php echo $product['id']; ?>"
                                >

                            </td>


                            <td>

                                <img
                                    src="img/<?php echo htmlspecialchars($product['image']); ?>"
                                    alt="<?php echo htmlspecialchars($product['name']); ?>"
                                    class="product-image"
                                >

                            </td>


                            <td>

                                <input
                                    type="text"
                                    name="name"
                                    value="<?php echo htmlspecialchars($product['name']); ?>"
                                    class="edit-input"
                                    required
                                >

                            </td>


                            <td>

                                <input
                                    type="text"
                                    name="product_condition"
                                    value="<?php echo htmlspecialchars($product['product_condition']); ?>"
                                    class="edit-input"
                                    required
                                >

                            </td>


                            <td>

                                <input
                                    type="number"
                                    name="price"
                                    value="<?php echo $product['price']; ?>"
                                    class="edit-input-number"
                                    min="0"
                                    required
                                >

                            </td>


                            <td>

                                <input
                                    type="text"
                                    name="size"
                                    value="<?php echo htmlspecialchars($product['size']); ?>"
                                    class="edit-input-number"
                                    required
                                >

                            </td>


                            <td>

                                <input
                                    type="number"
                                    name="likes"
                                    value="<?php echo $product['likes']; ?>"
                                    class="edit-input-number"
                                    min="0"
                                    required
                                >

                            </td>


                            <td>

                                <input
                                    type="number"
                                    name="stock"
                                    value="<?php echo $product['stock']; ?>"
                                    class="edit-input-number"
                                    min="0"
                                    required
                                >

                            </td>


                            <td>

                                <button
                                    type="submit"
                                    name="update_product"
                                    class="save-button"
                                >
                                    Simpan
                                </button>

                                <br>

                                <a
                                    href="data_produk.php"
                                    class="cancel-button"
                                >
                                    Batal
                                </a>

                            </td>

                        </form>

                    </tr>


                <?php } else { ?>


                    <!-- =================================================
                         BARIS NORMAL
                         ================================================= -->

                    <tr>

                        <td>
                            <?php echo $product['id']; ?>
                        </td>


                        <td>

                            <img
                                src="img/<?php echo htmlspecialchars($product['image']); ?>"
                                alt="<?php echo htmlspecialchars($product['name']); ?>"
                                class="product-image"
                            >

                        </td>


                        <td>
                            <?php echo htmlspecialchars($product['name']); ?>
                        </td>


                        <td>
                            <?php echo htmlspecialchars($product['product_condition']); ?>
                        </td>


                        <td>
                            Rp<?php echo number_format(
                                $product['price'],
                                0,
                                ',',
                                '.'
                            ); ?>
                        </td>


                        <td>
                            <?php echo htmlspecialchars($product['size']); ?>
                        </td>


                        <td>
                            <?php echo $product['likes']; ?>
                        </td>


                        <td>
                            <?php echo $product['stock']; ?>
                        </td>


                        <td>

                            <!-- EDIT -->

                            <a
                                href="data_produk.php?edit=<?php echo $product['id']; ?>"
                                class="edit-button"
                            >
                                Edit
                            </a>


                            <!-- HAPUS -->

                            <form
                                method="POST"
                                action="data_produk.php"
                                class="action-form"
                                onsubmit="return confirm('Yakin ingin menghapus produk ini?');"
                            >

                                <input
                                    type="hidden"
                                    name="id"
                                    value="<?php echo $product['id']; ?>"
                                >

                                <button
                                    type="submit"
                                    name="delete_product"
                                    class="delete-button"
                                >
                                    Hapus
                                </button>

                            </form>

                        </td>

                    </tr>


                <?php } ?>


            <?php } ?>


        </tbody>

    </table>

</div>

</body>

</html>