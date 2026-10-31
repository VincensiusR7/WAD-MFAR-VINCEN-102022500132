<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>ShopKu</title>

    <link rel="stylesheet" href="{{ asset('css/ecommerce.css') }}">
</head>
<body>

    <h1>Temukan barang favoritmu</h1>

    <div class="product-grid">
        @foreach ($products as $product)
            <div class="product-card">
                <div class="product-image">
                    <img
                        src="{{ asset('img/' . $product->image) }}"
                        alt="{{ $product->name }}"
                    >
                </div>

                <div class="product-info">
                    <h3>{{ $product->name }}</h3>

                    <p class="product-condition">
                        {{ $product->product_condition }}
                    </p>

                    <p class="product-price">
                        Rp{{ number_format($product->price, 0, ',', '.') }}
                    </p>

                    <p class="product-size">
                        {{ $product->size }}
                    </p>
                </div>
            </div>
        @endforeach
    </div>

</body>
</html>