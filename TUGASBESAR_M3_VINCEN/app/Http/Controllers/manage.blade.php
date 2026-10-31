
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Produk - ShopKu</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 24px;
            background: #f5f5f5;
            color: #222;
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 1400px;
            margin: auto;
        }

        h1, h2 {
            margin-top: 0;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 24px;
        }

        .panel {
            background: white;
            border-radius: 10px;
            padding: 22px;
            margin-bottom: 24px;
            box-shadow: 0 2px 10px #0000000d;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 14px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-size: 14px;
            font-weight: bold;
        }

        input {
            width: 100%;
            min-width: 80px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font: inherit;
        }

        button, .button {
            display: inline-block;
            padding: 10px 14px;
            border: 0;
            border-radius: 6px;
            background: #dfa51c;
            color: white;
            font: inherit;
            text-decoration: none;
            cursor: pointer;
        }

        .secondary {
            background: #555;
        }

        .danger {
            background: #c62828;
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            align-items: center;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: left;
            vertical-align: top;
        }

        th {
            background: #f1f1f1;
            white-space: nowrap;
        }

        .edit-form {
            display: grid;
            grid-template-columns: repeat(2, minmax(130px, 1fr));
            gap: 8px;
            min-width: 300px;
        }

        .edit-form label {
            margin-top: 4px;
        }

        .message {
            padding: 12px;
            margin-bottom: 18px;
            border-radius: 6px;
            background: #e1f4e5;
            color: #205b2b;
        }

        .errors {
            padding: 12px 12px 12px 32px;
            background: #fde7e7;
            color: #8c1d1d;
            border-radius: 6px;
            margin-bottom: 18px;
        }

        .product-id {
            font-weight: bold;
        }

        @media (max-width: 800px) {
            body {
                padding: 12px;
            }

            .form-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 480px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
<div class="container">

    <div class="topbar">
        <h1>Kelola Produk ShopKu</h1>
        <a class="button secondary" href="{{ route('products.index') }}">
            Kembali ke Katalog
        </a>
    </div>

    @if (session('success'))
        <div class="message">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="errors">
            <strong>Periksa kembali data yang dimasukkan:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section class="panel">
        <h2>Tambah Produk</h2>

        <form action="{{ route('products.store') }}" method="POST">
            @csrf

            <div class="form-grid">
                <div>
                    <label for="name">Nama produk</label>
                    <input id="name" name="name" type="text"
                           value="{{ old('name') }}" required>
                </div>

                <div>
                    <label for="product_condition">Kondisi</label>
                    <input id="product_condition" name="product_condition"
                           type="text" value="{{ old('product_condition') }}"
                           required>
                </div>

                <div>
                    <label for="price">Harga (Rp)</label>
                    <input id="price" name="price" type="number"
                           min="0" step="any" value="{{ old('price') }}"
                           required>
                </div>

                <div>
                    <label for="size">Ukuran</label>
                    <input id="size" name="size" type="text"
                           value="{{ old('size', '-') }}">
                </div>

                <div>
                    <label for="image">Nama file gambar</label>
                    <input id="image" name="image" type="text"
                           value="{{ old('image') }}"
                           placeholder="contoh: sneakers.jpg">
                </div>

                <div>
                    <label for="likes">Jumlah like</label>
                    <input id="likes" name="likes" type="number"
                           min="0" value="{{ old('likes', 0) }}">
                </div>

                <div>
                    <label for="stock">Stok</label>
                    <input id="stock" name="stock" type="number"
                           min="0" value="{{ old('stock', 0) }}" required>
                </div>
            </div>

            <p>
                <button type="submit">Tambah Produk</button>
            </p>
        </form>
    </section>

    <section class="panel">
        <h2>Daftar Produk dan Stok</h2>

        <p>
            Total produk:
            <strong>{{ $products->count() }}</strong>
        </p>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Edit produk dan stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td class="product-id">
                                {{ $product->id }}
                            </td>

                            <td>
                                <form class="edit-form"
                                      id="update-product-{{ $product->id }}"
                                      action="{{ route('products.update', $product->id) }}"
                                      method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div>
                                        <label>Nama produk</label>
                                        <input name="name" type="text"
                                               value="{{ $product->name }}"
                                               required>
                                    </div>

                                    <div>
                                        <label>Kondisi</label>
                                        <input name="product_condition"
                                               type="text"
                                               value="{{ $product->product_condition }}"
                                               required>
                                    </div>

                                    <div>
                                        <label>Harga (Rp)</label>
                                        <input name="price" type="number"
                                               min="0" step="any"
                                               value="{{ $product->price }}"
                                               required>
                                    </div>

                                    <div>
                                        <label>Ukuran</label>
                                        <input name="size" type="text"
                                               value="{{ $product->size }}">
                                    </div>

                                    <div>
                                        <label>Nama file gambar</label>
                                        <input name="image" type="text"
                                               value="{{ $product->image }}">
                                    </div>

                                    <div>
                                        <label>Jumlah like</label>
                                        <input name="likes" type="number"
                                               min="0"
                                               value="{{ $product->likes }}"
                                               required>
                                    </div>

                                    <div>
                                        <label>Stok</label>
                                        <input name="stock" type="number"
                                               min="0"
                                               value="{{ $product->stock }}"
                                               required>
                                    </div>
                                </form>
                            </td>

                            <td>
                                <div class="actions">
                                    <button type="submit"
                                            form="update-product-{{ $product->id }}">
                                        Simpan perubahan
                                    </button>

                                    <form action="{{ route('products.destroy', $product->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                        @csrf
                                        @method('DELETE')

                                        <button class="danger" type="submit">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">
                                Belum ada produk di database.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

</div>
</body>
</html>
