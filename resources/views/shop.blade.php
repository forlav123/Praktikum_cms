@extends('layout_final4')

@section('title', 'Katalog Produk Premium - Toko Barang')

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
                    <span id="results-count-summary">Memuat produk...</span>
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

            <div id="load-more-status" style="display: none; text-align: center; color: var(--text-secondary); margin-top: 1rem; font-size: 0.95rem;"></div>

            <div id="load-more-wrapper" style="display: flex; justify-content: center; margin-top: 1rem; margin-bottom: 4rem;">
                <button id="load-more-btn" type="button" class="btn btn-primary" style="display: none; min-width: 180px; border-radius: 999px; box-shadow: 0 10px 24px rgba(0,0,0,0.12); transition: all 0.25s ease;">
                    <span class="load-more-label">Muat Lebih</span>
                    <span class="load-more-spinner" style="display: none; margin-left: 0.5rem;">
                        <i class="fas fa-spinner fa-spin"></i>
                    </span>
                </button>
            </div>
        </main>
        
    </section>
@endsection

@push('scripts')
<style>
    .shop-layout {
        display: grid;
        grid-template-columns: 280px minmax(0, 1fr);
        gap: 2rem;
        align-items: start;
    }

    .filter-sidebar {
        background: rgba(255,255,255,0.92);
        border: 1px solid rgba(15,23,42,0.08);
        border-radius: 20px;
        padding: 1.25rem;
        box-shadow: 0 12px 32px rgba(15,23,42,0.06);
        position: sticky;
        top: 1rem;
    }

    .filter-group {
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid rgba(15,23,42,0.08);
    }

    .filter-title {
        font-size: 0.95rem;
        font-weight: 700;
        margin-bottom: 0.75rem;
        color: var(--text-primary);
    }

    .search-box {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        padding: 0.75rem 0.9rem;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 999px;
    }

    .search-box input {
        border: none;
        background: transparent;
        width: 100%;
        outline: none;
        color: var(--text-primary);
    }

    .category-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.35rem 0;
        color: var(--text-secondary);
        font-size: 0.95rem;
    }

    .btn-filter-reset {
        width: 100%;
        border: none;
        padding: 0.8rem 1rem;
        border-radius: 999px;
        font-weight: 700;
        background: linear-gradient(135deg, var(--accent-primary), #1d4ed8);
        color: #fff;
    }

    #shop-products-grid {
        transition: opacity 0.25s ease, transform 0.25s ease;
    }

    #shop-products-grid .product-card {
        animation: fadeUpIn 0.4s ease both;
    }

    .product-card-skeleton {
        border-radius: 20px;
        overflow: hidden;
        background: #f8fafc;
        min-height: 320px;
    }

    .product-card-skeleton .skeleton-line {
        background: linear-gradient(90deg, #e2e8f0 25%, #f8fafc 50%, #e2e8f0 75%);
        background-size: 200% 100%;
        animation: shimmer 1.2s infinite linear;
        border-radius: 999px;
    }

    #load-more-btn {
        min-width: 180px;
        border-radius: 999px;
        box-shadow: 0 10px 24px rgba(0,0,0,0.12);
        transition: transform 0.2s ease, box-shadow 0.2s ease, opacity 0.2s ease;
    }

    #load-more-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 14px 30px rgba(0,0,0,0.16);
    }

    #load-more-btn:disabled {
        opacity: 0.8;
        cursor: wait;
    }

    @keyframes fadeUpIn {
        from {
            opacity: 0;
            transform: translateY(12px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes shimmer {
        from { background-position: 200% 0; }
        to { background-position: -200% 0; }
    }
</style>
<script>
    // Override products variable dengan data dari database Laravel
    // Ini menggantikan products-db.js yang statis
    let products = {!! json_encode($productsJson->values()) !!};

    function renderShopSkeleton() {
        const shopGrid = document.getElementById('shop-products-grid');
        if (!shopGrid) return;

        shopGrid.innerHTML = Array.from({ length: 6 }, (_, i) => `
            <div class="product-card product-card-skeleton" style="animation-delay: ${i * 0.05}s;">
                <div class="skeleton-line" style="height: 180px; margin: 1rem; border-radius: 16px;"></div>
                <div class="skeleton-line" style="height: 14px; width: 50%; margin: 1rem;"></div>
                <div class="skeleton-line" style="height: 20px; width: 80%; margin: 1rem;"></div>
                <div class="skeleton-line" style="height: 14px; width: 70%; margin: 1rem;"></div>
            </div>
        `).join('');
    }

    function escapeHtml(value) {
        return String(value ?? '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#39;');
    }

    function createProductCard(product) {
        const detailUrl = '/product/' + product.slug;
        const safeName = JSON.stringify(product.name);
        const safeImage = JSON.stringify(product.image);
        const displayName = escapeHtml(product.name);
        const displayCategory = escapeHtml(product.category);
        const displayImage = escapeHtml(product.image);
        return `
            <div class="product-card">
                ${product.stock < 10 ? `<div class="product-badge" style="background: var(--warning);">Sisa ${product.stock}</div>` : ''}
                <a href="${detailUrl}" class="product-img-wrapper">
                    <img src="${displayImage}" alt="${displayName}" loading="lazy">
                </a>
                <div class="product-info">
                    <div class="product-category">${displayCategory}</div>
                    <a href="${detailUrl}" class="product-title-link">
                        <h3 class="product-title">${displayName}</h3>
                    </a>
                    <div class="product-rating">
                        ${generateStars(product.rating)}
                        <span>(${product.reviewsCount})</span>
                    </div>
                    <div class="product-price-row">
                        <div class="product-price">${formatRupiah(product.price)}</div>
                        <button type="button" class="add-cart-btn" onclick="addToCart(${product.id}, ${safeName}, ${product.price}, ${safeImage})" title="Tambah ke Keranjang">
                            <i class="fas fa-cart-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
    }

    document.addEventListener('DOMContentLoaded', () => {
        renderShopSkeleton();
        initShopFilters();
        window.setTimeout(() => renderShopPage(), 220);
    });
</script>
@endpush
