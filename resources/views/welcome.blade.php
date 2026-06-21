@extends('layout_final4')

@section('title', 'Beranda - GlowTech Store')

@section('content')
    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-text">
            <h1>Gaya Hidup Modern dengan <span>Produk Premium</span></h1>
            <p>Temukan koleksi pilihan laptop berkinerja tinggi, smartphone andalan generasi terbaru, dan tren fashion modern dengan kualitas terbaik serta garansi resmi terpercaya.</p>
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

    <!-- Categories Section -->
    <section class="section-header">
        <div class="section-header-left">
            <h2>Kategori Pilihan</h2>
            <p>Jelajahi berbagai koleksi produk berkualitas tinggi berdasarkan kebutuhan Anda</p>
        </div>
        <a href="{{ url('public_html/shop.html') }}" style="color: var(--accent-primary); font-weight: 600; text-decoration: none;">Lihat Semua <i class="fas fa-chevron-right" style="font-size: 0.8rem;"></i></a>
    </section>

    <section class="categories-grid">
        <a href="{{ url('public_html/shop.html?category=Laptop') }}" class="category-card">
            <img src="https://images.unsplash.com/photo-1593642702821-c8da6771f0c6?w=400&auto=format&fit=crop&q=80" alt="Laptop Kategori">
            <div class="category-name">Laptop</div>
        </a>
        <a href="{{ url('public_html/shop.html?category=Smartphone') }}" class="category-card">
            <img src="https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=400&auto=format&fit=crop&q=80" alt="Smartphone Kategori">
            <div class="category-name">Smartphone</div>
        </a>
        <a href="{{ url('public_html/shop.html?category=Pakaian') }}" class="category-card">
            <img src="https://images.unsplash.com/photo-1483985988355-763728e1935b?w=400&auto=format&fit=crop&q=80" alt="Pakaian Kategori">
            <div class="category-name">Pakaian</div>
        </a>
        <a href="{{ url('public_html/shop.html?category=Aksesoris') }}" class="category-card">
            <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=400&auto=format&fit=crop&q=80" alt="Aksesoris Kategori">
            <div class="category-name">Aksesoris</div>
        </a>
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
                    <div class="product-image">
                        <span class="product-badge">{{ $product->category->name }}</span>
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                        @else
                            <img src="https://via.placeholder.com/300?text=No+Image" alt="{{ $product->name }}">
                        @endif
                        <div class="product-actions">
                            <button class="action-btn" title="Tambahkan ke Wishlist"><i class="far fa-heart"></i></button>
                            <a href="{{ route('product.show', $product->slug) }}" class="action-btn" title="Lihat Detail"><i class="far fa-eye"></i></a>
                        </div>
                    </div>
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

    <!-- Testimonial Section -->
    <section class="section-header">
        <div class="section-header-left">
            <h2>Apa Kata Mereka?</h2>
            <p>Ulasan jujur dari pelanggan setia mengenai pengalaman berbelanja di GlowTech</p>
        </div>
    </section>

    <section class="products-section" style="margin-bottom: 8rem;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
            <div class="feature-card" style="text-align: left; padding: 2rem;">
                <div class="product-rating" style="margin-bottom: 0.5rem;">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                </div>
                <p style="color: var(--text-primary); font-weight: 700; margin-bottom: 0.5rem;">"Pelayanan Cepat & Produk 100% Asli!"</p>
                <p style="color: var(--text-secondary); font-size: 0.85rem; margin-bottom: 1.5rem;">ROG Zephyrus G14 yang saya beli sampai hanya dalam waktu 2 hari dalam kondisi tersegel rapi dan bergaransi resmi. Kinerja gaming sangat memuaskan!</p>
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <div style="width: 40px; height: 40px; border-radius: 50%; background: #6366f1; display: flex; align-items: center; justify-content: center; font-weight: 700; color: white;">A</div>
                    <div>
                        <h4 style="font-size: 0.9rem;">Agus Setiawan</h4>
                        <span style="font-size: 0.75rem; color: var(--text-muted);">Verified Buyer (Laptop)</span>
                    </div>
                </div>
            </div>
            <div class="feature-card" style="text-align: left; padding: 2rem;">
                <div class="product-rating" style="margin-bottom: 0.5rem;">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                </div>
                <p style="color: var(--text-primary); font-weight: 700; margin-bottom: 0.5rem;">"Bahan Hoodie Sangat Premium"</p>
                <p style="color: var(--text-secondary); font-size: 0.85rem; margin-bottom: 1.5rem;">Hoodie Oversized-nya tebal dan bagian dalamnya sangat lembut. Cocok dipakai saat cuaca dingin maupun nongkrong. Pasti beli lagi warna lainnya!</p>
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <div style="width: 40px; height: 40px; border-radius: 50%; background: #a855f7; display: flex; align-items: center; justify-content: center; font-weight: 700; color: white;">S</div>
                    <div>
                        <h4 style="font-size: 0.9rem;">Siti Rahma</h4>
                        <span style="font-size: 0.75rem; color: var(--text-muted);">Verified Buyer (Pakaian)</span>
                    </div>
                </div>
            </div>
            <div class="feature-card" style="text-align: left; padding: 2rem;">
                <div class="product-rating" style="margin-bottom: 0.5rem;">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                </div>
                <p style="color: var(--text-primary); font-weight: 700; margin-bottom: 0.5rem;">"Transaksi Mudah & Aman"</p>
                <p style="color: var(--text-secondary); font-size: 0.85rem; margin-bottom: 1.5rem;">Saya sangat terbantu dengan fungsionalitas webnya. Mulai dari cart hingga checkout dan konfirmasi pembayaran berjalan mulus sekali tanpa kendala.</p>
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <div style="width: 40px; height: 40px; border-radius: 50%; background: #06b6d4; display: flex; align-items: center; justify-content: center; font-weight: 700; color: white;">R</div>
                    <div>
                        <h4 style="font-size: 0.9rem;">Rian Hadiman</h4>
                        <span style="font-size: 0.75rem; color: var(--text-muted);">Verified Buyer (Smartphone)</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
