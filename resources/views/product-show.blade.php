@extends('layout_final4')

@section('title', $product->name . ' - Toko Maju Jaya')

@section('content')
    <!-- Navigation Breadcrumbs -->
    <section class="section-header" style="margin-top: 2rem; margin-bottom: 0;">
        <div class="section-header-left">
            <p style="font-size: 0.9rem;">
                <a href="{{ route('home') }}" style="color: var(--text-muted); text-decoration: none;">Beranda</a> &nbsp;/&nbsp; 
                <a href="{{ route('shop') }}" style="color: var(--text-muted); text-decoration: none;">Katalog</a> &nbsp;/&nbsp; 
                <span id="breadcrumb-active" style="color: var(--text-primary); font-weight: 600;">{{ $product->name }}</span>
            </p>
        </div>
    </section>

    <!-- Product Detail Container -->
    <section id="product-detail-view">
        <div class="detail-layout">
            <!-- Left Side: Product Gallery -->
            <div class="detail-gallery">
                <div class="main-image-container">
                    @if($product->image)
                        <img id="detail-product-img" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                    @else
                        <img id="detail-product-img" src="https://via.placeholder.com/600?text=No+Image" alt="{{ $product->name }}">
                    @endif
                </div>
            </div>

            <!-- Right Side: Product Details info -->
            <div class="detail-info">
                <span id="detail-product-cat" class="product-category">{{ $product->category->name }}</span>
                <h1 id="detail-product-title" class="detail-title">{{ $product->name }}</h1>
                
                <!-- Rating -->
                <div class="product-rating">
                    <div id="detail-stars">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                    </div>
                    <span id="detail-rating-count">(15 ulasan)</span>
                </div>

                <div id="detail-product-price" class="detail-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>

                <!-- Description Block -->
                <div class="detail-desc-block">
                    <h3>Deskripsi Produk</h3>
                    <p id="detail-product-desc">{{ $product->description }}</p>
                </div>

                <!-- Product metadata list -->
                <div class="detail-meta-list">
                    <div class="meta-item">Ketersediaan: 
                        @if($product->stock > 0)
                            <strong id="detail-stock-status" style="color: var(--success);">Tersedia</strong>
                        @else
                            <strong id="detail-stock-status" style="color: var(--error);">Habis</strong>
                        @endif
                    </div>
                    <div class="meta-item">Stok: <strong id="detail-stock-count">{{ $product->stock }} item</strong></div>
                    <div class="meta-item">Garansi: <strong>1 Tahun Resmi</strong></div>
                    <div class="meta-item">Kondisi: <strong>Baru (Sealed)</strong></div>
                </div>

                <!-- Quantity and CTA Purchase Actions -->
                <div class="purchase-row">
                    <div class="quantity-picker">
                        <button type="button" class="qty-btn" id="btn-qty-minus"><i class="fas fa-minus"></i></button>
                        <input type="text" id="detail-qty-input" value="1" readonly>
                        <button type="button" class="qty-btn" id="btn-qty-plus"><i class="fas fa-plus"></i></button>
                    </div>
                    
                    <button type="button" class="btn btn-primary" style="flex-grow: 1;" onclick="addToCart({{ $product->id }}, '{{ $product->name }}', {{ $product->price }}, '{{ asset('storage/' . $product->image) }}')">
                        <i class="fas fa-cart-plus"></i> Tambah Ke Keranjang
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Related Products Section (Placeholder for now) -->
    <section class="section-header">
        <div class="section-header-left">
            <h2>Produk Terkait</h2>
            <p>Produk sejenis yang mungkin Anda sukai</p>
        </div>
    </section>
    <section class="products-section" style="margin-bottom: 8rem;">
        <div class="products-grid">
            <div style="grid-column: 1 / -1; text-align: center; color: var(--text-secondary);">
                Silakan lihat katalog untuk produk lainnya.
            </div>
        </div>
    </section>
@endsection
