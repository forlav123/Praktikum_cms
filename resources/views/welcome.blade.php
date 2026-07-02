@extends('layout_final4')

@section('title', 'Beranda - Toko Barang')

@section('content')
    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-text">
            <h1>Solusi Kebutuhan Anda dengan <span>Produk Terbaik</span></h1>
            <p>Temukan berbagai pilihan gadget masa kini, elektronik berkualitas, dan tren fashion terbaru dengan harga bersahabat serta pelayanan terpercaya di Toko Barang.</p>
            <div class="cta-group">
                <a href="{{ url('public_html/shop.html') }}" class="btn btn-primary">
                    Belanja Sekarang <i class="fas fa-arrow-right btn-icon"></i>
                </a>
                <a href="{{ url('public_html/about.html') }}" class="btn btn-secondary">Pelajari Selengkapnya</a>
            </div>
        </div>
        <div class="hero-visual">
            <div class="hero-blob"></div>
            <div class="hero-image-card">
                <img src="https://images.unsplash.com/photo-1593642632823-8f785ba67e45?w=600&auto=format&fit=crop&q=80" alt="Premium Tech Hero">
                <div style="padding: 1rem 0.5rem 0.5rem 0.5rem;">
                    <span style="font-size: 0.75rem; font-weight: 700; color: var(--accent-primary); text-transform: uppercase;">Rekomendasi Pekan Ini</span>
                    <h3 style="font-size: 1.1rem; margin-top: 0.25rem;">Eksklusif Gadget & Gaya Hidup</h3>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="features-container">
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-shipping-fast"></i></div>
                <h3>Gratis Ongkir</h3>
                <p>Pengiriman gratis tanpa biaya tambahan ke seluruh wilayah Indonesia.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-shield-alt"></i></div>
                <h3>Transaksi Aman</h3>
                <p>Jaminan keamanan pembayaran penuh di setiap transaksi belanja Anda.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-award"></i></div>
                <h3>Garansi Resmi</h3>
                <p>Semua produk elektronik memiliki garansi resmi pabrik 100%.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-headset"></i></div>
                <h3>Layanan 24/7</h3>
                <p>Tim support pelanggan yang siap sedia membantu Anda setiap saat.</p>
            </div>
        </div>
    </section>


    <!-- Featured Products Section -->
    <section class="section-header">
        <div class="section-header-left">
            <h2>Produk Unggulan</h2>
            <p>Daftar produk terbaik yang paling diminati oleh pelanggan saat ini</p>
        </div>
    </section>

    <section class="products-section">
        <div class="products-grid">
            @forelse($products as $product)
                <div class="product-card">
                    <a href="{{ route('product.show', $product->slug) }}" class="product-img-wrapper">
                        <span class="product-badge">{{ $product->category->name }}</span>
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" loading="lazy">
                        @else
                            <img src="https://via.placeholder.com/300x300?text=No+Image" alt="{{ $product->name }}" loading="lazy">
                        @endif
                    </a>
                    <div class="product-info">
                        <div class="product-category">{{ $product->category->name }}</div>
                        <h3 class="product-title"><a href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a></h3>
                        <div class="product-rating">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                            <span>(4.5)</span>
                        </div>
                        <div class="product-price-row">
                            <div class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                            <button class="add-to-cart-btn" onclick="addToCart({{ $product->id }}, '{{ $product->name }}', {{ $product->price }}, '{{ asset('storage/' . $product->image) }}')">
                                <i class="fas fa-shopping-cart"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 3rem; color: var(--text-secondary);">
                    Belum ada produk yang tersedia.
                </div>
            @endforelse
        </div>
    </section>

@endsection
