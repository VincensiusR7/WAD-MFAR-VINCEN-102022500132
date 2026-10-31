<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>ShopKu</title>

    <link rel="stylesheet" href="{{ asset('css/ecommerce.css') }}">
</head>

<body>

    <!-- HEADER -->
    <header>

        <!-- TOP HEADER -->
        <div class="top-header">

            <!-- LOGO -->
            <div class="logo">
                ShopKu
            </div>

            <!-- SEARCH -->
            <div class="search-container">

                <button class="catalog-button">
                    Katalog
                    <span>▼</span>
                </button>

                <div class="search-box">
                    <span class="search-icon">⌕</span>

                    <input
                        type="text"
                        placeholder="Cari Barang"
                    >
                </div>

            </div>

            <!-- RIGHT MENU -->
            <div class="header-actions" style="text-decoration: none;">
                <div class="auth-buttons">
                    <a href="{{ asset('register.html') }}" class="register-button">
                        Daftar
                    </a>

                    <span class="divider">|</span>

                    <a href="{{ url('/login') }}" class="login-button">
                        Masuk
                    </a>
                </div>
            

                <button class="sell-button">
                    Jual Barang-mu sekarang!
                </button>

                <button class="help-button">
                    ?
                </button>

                <button class="language-button">
                    ID
                    <span>▼</span>
                </button>

            </div>

        </div>


        <!-- CATEGORY NAVIGATION -->
        <nav class="category-nav">

            <a href="#">Wanita</a>

            <a href="#">Pria</a>

            <a href="#">Anak-anak</a>

            <a href="#">Home</a>

            <a href="#">Elektronik</a>

            <a href="#">Buku, Musik, Blu-Ray Film</a>

            <a href="#">Hobi & Barang Koleksi</a>

            <a href="#">Olahraga</a>

        </nav>

    </header>

    <!--Hero Section-->
<section class="hero">


    <div class="hero-content">

        <h1>
            Mau jual baju bekas atau barang bekas?
        </h1>

        <button class="hero-button">
            Mulai jualan sekarang
        </button>

        <a href="#" class="hero-link">
            Mau tahu gimana caranya? Cek di sini
        </a>

    </div>

</section>

<!-- PRODUCT SECTION -->
<section class="product-section">

    <div class="product-container">

        <!-- PRODUCT HEADER -->
        <div class="product-header">

            <h2>Temukan barang favoritmu</h2>

            <a href="#" class="see-all">
                Lihat semua
            </a>

        </div>

<!-- PRODUCT GRID -->
<div class="product-grid">

    @forelse ($products as $product)
        <div class="product-card">

            <div class="product-image">
                <a href="{{ url('/products/' . $product->id) }}" class="product-link">
                    <img
                        src="{{ asset('img/' . $product->image) }}"
                        alt="{{ $product->name }}"
                    >
                </a>

                <!-- LIKE BUTTON -->
                <button class="like-button" type="button" aria-label="Sukai produk">
                    <span class="heart-icon">♡</span>
                    <span class="like-count">{{ $product->likes ?? 0 }}</span>
                </button>
            </div>

            <div class="product-info">
                <h3>{{ $product->name }}</h3>

                <p class="product-condition">
                    {{ $product->product_condition }}
                </p>

                <p class="product-price">
                    Rp{{ number_format((float) $product->price, 0, ',', '.') }}
                </p>

                <p class="product-size">
                    {{ $product->size ?: '-' }}
                </p>
            </div>

        </div>
    @empty
        <p>Belum ada produk yang tersedia.</p>
    @endforelse

</div>
<!-- SEE MORE BUTTON -->
<div class="see-more-container">
    <button class="see-more-button">
        Lihat lebih banyak
    </button>
</div>

        <!-- CATEGORIES AND BRANDS -->
        <div class="discovery-section">


            <!-- MOST POPULAR CATEGORIES -->
            <div class="discovery-box">

                <h2>
                    Most popular categories
                </h2>

                <div class="tag-container">

                    <a href="#" class="category-tag">
                        Wanita
                    </a>

                    <a href="#" class="category-tag">
                        Pria
                    </a>

                    <a href="#" class="category-tag">
                        Sepatu
                    </a>

                    <a href="#" class="category-tag">
                        Tas
                    </a>

                    <a href="#" class="category-tag">
                        Tops
                    </a>

                    <a href="#" class="category-tag">
                        Jackets
                    </a>

                    <a href="#" class="category-tag">
                        Dresses
                    </a>

                    <a href="#" class="category-tag">
                        Elektronik
                    </a>

                    <a href="#" class="category-tag">
                        Beranda
                    </a>

                    <a href="#" class="category-tag">
                        Olahraga
                    </a>

                </div>

            </div>


            <!-- BEST SELLING BRANDS -->
            <div class="discovery-box">

                <h2>
                    Best selling brands
                </h2>

                <div class="tag-container">

                    <a href="#" class="brand-tag">
                        Nike
                    </a>

                    <a href="#" class="brand-tag">
                        Adidas
                    </a>

                    <a href="#" class="brand-tag">
                        Uniqlo
                    </a>

                    <a href="#" class="brand-tag">
                        H&M
                    </a>

                    <a href="#" class="brand-tag">
                        Zara
                    </a>

                    <a href="#" class="brand-tag">
                        Levi's
                    </a>

                    <a href="#" class="brand-tag">
                        Converse
                    </a>

                    <a href="#" class="brand-tag">
                        Vans
                    </a>

                    <a href="#" class="brand-tag">
                        Puma
                    </a>

                    <a href="#" class="brand-tag">
                        New Balance
                    </a>

                </div>

            </div>


        </div>

    </div>

</section>
<script>
const likeButtons = document.querySelectorAll(".like-button");

likeButtons.forEach(function(button) {

    button.addEventListener("click", function(event) {

        
        event.preventDefault();
        event.stopPropagation();

        // Ambil jumlah like
        const countElement = button.querySelector(".like-count");

        // Ambil angka
        let currentCount = parseInt(countElement.textContent);

        // Cek apakah produk sudah di like
        if (button.classList.contains("liked")) {

            // UNLIKE
            currentCount--;

            // Tampilkan jumlah baru
            countElement.textContent = currentCount;

            // Hapus status liked
            button.classList.remove("liked");

            // Kembalikan icon menjadi outline
            button.querySelector(".heart-icon").textContent = "♡";

        } else {

            // LIKE
            currentCount++;

            // Tampilkan jumlah baru
            countElement.textContent = currentCount;

            // Tambahkan status liked
            button.classList.add("liked");

            // Ubah icon menjadi hati penuh
            button.querySelector(".heart-icon").textContent = "♥";
        }

    });

});
</script>
</body>

</html>