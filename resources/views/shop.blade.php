@extends('layout_final4')

@section('title', 'Katalog Produk Premium - Toko Maju Jaya')

@section('content')
    <!-- Page Header Banner -->
    <section class="section-header" style="margin-top: 3rem;">
        <div class="section-header-left">
            <h2>Katalog Produk</h2>
            <p>Jelajahi produk teknologi dan gaya hidup premium dengan penawaran harga terbaik</p>
        </div>
    </section>

    <!-- Shop Layout Section -->
    <section class="shop-layout">
        
        <!-- Sidebar Filters -->
        <aside class="filter-sidebar">
            <!-- Filter Group: Search -->
            <div class="filter-group">
                <h3 class="filter-title">Cari Produk</h3>
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="search-input" placeholder="Ketik nama produk...">
                </div>
            </div>

            <!-- Filter Group: Category Checkboxes -->
            <div class="filter-group">
                <h3 class="filter-title">Kategori</h3>
                <div class="category-list" id="category-filter-list">
                    @php
                        $categories = $productsJson->pluck('category')->unique()->sort()->values();
                    @endphp
                    @foreach($categories as $cat)
                    <label class="category-item">
                        <input type="checkbox" value="{{ $cat }}" class="category-checkbox"> {{ $cat }}
                    </label>
                    @endforeach
                </div>
            </div>

            <!-- Filter Group: Price Slider -->
            <div class="filter-group">
                <h3 class="filter-title">Filter Harga</h3>
                <div class="price-range-container">
                    <input type="range" id="price-slider" class="price-slider" min="100000" max="35000000" step="100000" value="35000000">
                    <div class="price-display">
                        <span>Rp 100.000</span>
                        <span id="price-slider-val" style="font-weight: 700; color: var(--accent-primary);">Rp 35.000.000</span>
                    </div>
                </div>
            </div>

            <!-- Reset Button -->
            <button id="btn-reset-filters" class="btn-filter-reset">
                <i class="fas fa-undo-alt" style="margin-right: 0.5rem;"></i> Bersihkan Filter
            </button>
        </aside>

        <!-- Right Content Area -->
        <main>
            <!-- Shop Toolbar controls -->
            <div class="shop-header">
                <div class="results-count">
                    Menampilkan <span id="results-count-num" style="font-weight: 700; color: var(--text-primary);">0</span> produk
                </div>
                <div class="sort-select-wrapper">
                    <select id="sort-select">
                        <option value="default">Urutkan: Rekomendasi</option>
                        <option value="price-asc">Harga: Terendah ke Tertinggi</option>
                        <option value="price-desc">Harga: Tertinggi ke Terendah</option>
                        <option value="rating-desc">Ulasan: Rating Tertinggi</option>
                    </select>
                </div>
            </div>

            <!-- Product Cards Grid -->
            <div id="shop-products-grid" class="products-grid" style="min-height: 400px;">
                <!-- Dynamically loaded cards via JS -->
            </div>

            <!-- Pagination (Visual) -->
            <div style="display: flex; justify-content: center; gap: 0.5rem; margin-top: 4rem; margin-bottom: 4rem;">
                <a href="#" class="qty-btn" style="border: 1px solid var(--border-color);"><i class="fas fa-chevron-left"></i></a>
                <a href="#" class="qty-btn" style="border: 1px solid var(--border-color); background: var(--accent-primary); color: white;">1</a>
                <a href="#" class="qty-btn" style="border: 1px solid var(--border-color);"><i class="fas fa-chevron-right"></i></a>
            </div>
        </main>
        
    </section>
@endsection

@push('scripts')
<script>
    // Override products variable dengan data dari database Laravel
    // Ini menggantikan products-db.js yang statis
    const products = {!! json_encode($productsJson->values()) !!};

    // Patch fungsi createProductCard agar link detail mengarah ke Laravel route
    function createProductCard(product) {
        const detailUrl = '/product/' + product.slug;
        return `
            <div class="product-card">
                ${product.stock < 10 ? `<div class="product-badge" style="background: var(--warning);">Sisa ${product.stock}</div>` : ''}
                <a href="${detailUrl}" class="product-img-wrapper">
                    <img src="${product.image}" alt="${product.name}">
                </a>
                <div class="product-info">
                    <div class="product-category">${product.category}</div>
                    <a href="${detailUrl}" class="product-title-link">
                        <h3 class="product-title">${product.name}</h3>
                    </a>
                    <div class="product-rating">
                        ${generateStars(product.rating)}
                        <span>(${product.reviewsCount})</span>
                    </div>
                    <div class="product-price-row">
                        <div class="product-price">${formatRupiah(product.price)}</div>
                        <button type="button" class="add-cart-btn" onclick="addToCart(${product.id}, '${product.name}', ${product.price}, '${product.image}')" title="Tambah ke Keranjang">
                            <i class="fas fa-cart-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
    }

    document.addEventListener('DOMContentLoaded', () => {
        renderShopPage();
        initShopFilters();
    });
</script>
@endpush
