@extends('layout_final4')

@section('title', 'Keranjang Belanja - Toko Maju Jaya')

@section('content')
    <!-- Page Title -->
    <section class="section-header" style="margin-top: 3rem; margin-bottom: 0;">
        <div class="section-header-left">
            <h2>Keranjang Belanja</h2>
            <p>Kelola item pilihan Anda sebelum melakukan pembayaran</p>
        </div>
    </section>

    <!-- Cart Main Grid Layout -->
    <section id="cart-main-container" class="cart-layout">
        <!-- Left Side: Table of items -->
        <div class="cart-table-wrapper">
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th style="text-align: center;">Jumlah</th>
                        <th>Subtotal</th>
                        <th>Hapus</th>
                    </tr>
                </thead>
                <tbody id="cart-items-tbody">
                    <!-- Loaded dynamically via JS -->
                </tbody>
            </table>
            
            <div class="cart-actions">
                <a href="{{ route('shop') }}" style="color: var(--accent-primary); font-weight: 600; text-decoration: none; display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fas fa-arrow-left" style="font-size: 0.85rem;"></i> Kembali Belanja
                </a>
                <button type="button" id="btn-clear-cart" class="clear-cart-btn">
                    <i class="fas fa-trash-alt"></i> Kosongkan Keranjang
                </button>
            </div>
        </div>

        <!-- Right Side: Order Summary -->
        <aside class="order-summary">
            <h3 class="summary-title">Ringkasan Belanja</h3>
            <div class="summary-row">
                <span>Subtotal Produk</span>
                <span id="summary-subtotal">Rp 0</span>
            </div>
            <div class="summary-row">
                <span>Estimasi Ongkos Kirim</span>
                <span id="summary-shipping" style="color: var(--success); font-weight: 600;">GRATIS</span>
            </div>
            <div class="summary-row">
                <span>Pajak PPN (11%)</span>
                <span id="summary-tax">Rp 0</span>
            </div>
            <div class="summary-row total">
                <span>Total Pembayaran</span>
                <span id="summary-total">Rp 0</span>
            </div>
            
            <a href="{{ route('checkout') }}" class="btn btn-primary" style="width: 100%; margin-top: 1.5rem; display: block; text-align: center;">
                Lanjut ke Pembayaran <i class="fas fa-credit-card btn-icon" style="margin-left: 0.5rem;"></i>
            </a>
        </aside>
    </section>

    <!-- Empty Cart View (Hidden by default) -->
    <section id="cart-empty-container" class="empty-cart-view" style="display: none; margin-bottom: 8rem;">
        <div class="empty-cart-icon"><i class="fas fa-shopping-cart"></i></div>
        <h2>Keranjang Belanja Kosong!</h2>
        <p>Anda belum menambahkan produk apapun ke dalam keranjang belanja.</p>
        <a href="{{ route('shop') }}" class="btn btn-primary">Mulai Belanja Sekarang</a>
    </section>
@endsection

@push('scripts')
<script>
    // Override cart page detection for Laravel route
    document.addEventListener('DOMContentLoaded', () => {
        renderCartPage();
    });
</script>
@endpush
