@extends('layout_final4')

@section('title', 'Proses Pembayaran - Toko Barang')

@section('content')
    <!-- Page Title -->
    <section class="section-header" style="margin-top: 3rem; margin-bottom: 0;">
        <div class="section-header-left">
            <h2>Proses Checkout</h2>
            <p>Lengkapi informasi pengiriman dan pilih metode pembayaran untuk menyelesaikan pesanan Anda</p>
        </div>
    </section>

    <!-- Checkout Main Container -->
    <section id="checkout-main-container" class="checkout-layout">
        <!-- Left Column: Checkout Forms -->
        <div style="display: flex; flex-direction: column; gap: 2rem;">
            
            <!-- Shipping Information Form -->
            <form id="checkout-form" class="checkout-card" novalidate>
                <div class="checkout-step-title">
                    <span>1</span> Informasi Pengiriman
                </div>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label for="checkout-name">Nama Lengkap *</label>
                        <input type="text" id="checkout-name" required placeholder="Contoh: Budi Santoso">
                        <span class="form-error-msg" id="name-error">Nama lengkap wajib diisi.</span>
                    </div>
                    <div class="form-group">
                        <label for="checkout-email">Alamat Email *</label>
                        <input type="email" id="checkout-email" required placeholder="Contoh: budi@gmail.com">
                        <span class="form-error-msg" id="email-error">Masukkan alamat email yang valid.</span>
                    </div>
                    <div class="form-group full-width">
                        <label for="checkout-phone">Nomor Telepon / WhatsApp *</label>
                        <input type="tel" id="checkout-phone" required placeholder="Contoh: 081234567890">
                        <span class="form-error-msg" id="phone-error">Nomor telepon wajib diisi.</span>
                    </div>
                    <div class="form-group full-width">
                        <label for="checkout-address">Alamat Pengiriman Lengkap *</label>
                        <textarea id="checkout-address" rows="3" required placeholder="Nama jalan, nomor rumah, RT/RW, kecamatan, kabupaten..."></textarea>
                        <span class="form-error-msg" id="address-error">Alamat pengiriman wajib diisi.</span>
                    </div>
                    <div class="form-group">
                        <label for="checkout-city">Kota / Provinsi *</label>
                        <input type="text" id="checkout-city" required placeholder="Contoh: Yogyakarta, DIY">
                        <span class="form-error-msg" id="city-error">Kota wajib diisi.</span>
                    </div>
                    <div class="form-group">
                        <label for="checkout-zip">Kode Pos *</label>
                        <input type="text" id="checkout-zip" required placeholder="Contoh: 55281">
                        <span class="form-error-msg" id="zip-error">Kode pos wajib diisi.</span>
                    </div>
                </div>
            </form>

            <!-- Payment Method Card -->
            <div class="checkout-card">
                <div class="checkout-step-title">
                    <span>2</span> Metode Pembayaran
                </div>
                
                <div class="payment-methods">
                    <div class="payment-method-card active" data-method="bank">
                        <i class="fas fa-university"></i>
                        <span>Transfer Bank</span>
                        <input type="radio" name="payment-option" value="bank" checked>
                    </div>
                    <div class="payment-method-card" data-method="ewallet">
                        <i class="fas fa-wallet"></i>
                        <span>E-Wallet (OVO/Gopay)</span>
                        <input type="radio" name="payment-option" value="ewallet">
                    </div>
                    <div class="payment-method-card" data-method="cod">
                        <i class="fas fa-hand-holding-usd"></i>
                        <span>Bayar di Tempat (COD)</span>
                        <input type="radio" name="payment-option" value="cod">
                    </div>
                </div>
                
                <!-- Payment Instructions -->
                <div id="payment-details-box" style="margin-top: 1.5rem; background: var(--bg-tertiary); padding: 1.25rem; border-radius: var(--radius-sm); border: 1px solid var(--border-color); font-size: 0.85rem; color: var(--text-secondary);">
                    <p id="payment-instructions-text">Silakan pilih metode yang paling nyaman untuk Anda. Setelah itu, klik tombol di samping untuk mengonfirmasi pesanan.</p>
                    <div id="bank-transfer-list" style="margin-top: 0.75rem; display: block; line-height: 1.7;">
                        <strong style="color: var(--text-primary);">Transfer Bank:</strong>
                        <ul style="margin: 0.35rem 0 0 1rem; padding: 0;">
                            <li>BNI: 1234567890 a/n Toko Barang</li>
                            <li>BRI: 9876543210 a/n Toko Barang</li>
                            <li>BCA: 1122334455 a/n Toko Barang</li>
                        </ul>
                        <span style="display: block; margin-top: 0.35rem; color: var(--text-secondary);">Nomor rekening dapat disesuaikan sesuai kebutuhan transaksi.</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Order Summary Review -->
        <aside class="order-summary">
            <h3 class="summary-title" style="margin-bottom: 1rem;">Tinjau Pesanan</h3>
            
            <!-- Items list inside scrollable card -->
            <div id="checkout-items-list" class="checkout-review-items">
                <!-- Dynamically loaded review items -->
            </div>
            
            <div style="border-top: 1px solid var(--border-color); margin-top: 1.5rem; padding-top: 1.5rem;">
                <div class="summary-row">
                    <span>Subtotal Produk</span>
                    <span id="checkout-summary-subtotal">Rp 0</span>
                </div>
                <div class="summary-row">
                    <span>Estimasi Ongkos Kirim</span>
                    <span id="checkout-summary-shipping" style="color: var(--success); font-weight: 600;">GRATIS</span>
                </div>
                <div class="summary-row">
                    <span>Pajak PPN (11%)</span>
                    <span id="checkout-summary-tax">Rp 0</span>
                </div>
                <div class="summary-row total">
                    <span>Total Pembayaran</span>
                    <span id="checkout-summary-total">Rp 0</span>
                </div>
            </div>
            
            <button type="button" id="btn-submit-order" class="btn btn-primary" style="width: 100%; margin-top: 1.5rem;">
                Buat Pesanan Sekarang <i class="fas fa-check-circle btn-icon" style="margin-left: 0.5rem;"></i>
            </button>
        </aside>
    </section>

    <!-- Empty Checkout Warning -->
    <section id="checkout-empty-container" class="empty-cart-view" style="display: none; margin-bottom: 8rem;">
        <div class="empty-cart-icon"><i class="fas fa-credit-card"></i></div>
        <h2>Tidak Ada Transaksi Aktif!</h2>
        <p>Keranjang belanja Anda kosong, sehingga Anda tidak dapat melakukan pembayaran.</p>
        <a href="{{ route('shop') }}" class="btn btn-primary">Mulai Belanja</a>
    </section>

    <!-- Transaction Success Modal Overlay -->
    <div id="success-modal-overlay" class="modal-overlay">
        <div class="success-modal">
            <div class="success-modal-icon">
                <i class="fas fa-check"></i>
            </div>
            <h2>Transaksi Berhasil!</h2>
            <p>Terima kasih atas pesanan Anda. Kode pesanan Anda adalah <strong id="success-order-id" style="color: var(--accent-primary);">#GTX-10398</strong>. Tim logistik kami akan segera mengemas dan mengirimkan produk Anda.</p>
            <button type="button" id="btn-modal-close" class="btn btn-primary" style="width: 100%;">
                Selesai & Kembali Belanja
            </button>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    renderCheckoutPage();

    const paymentCards = document.querySelectorAll('.payment-method-card');
    const textEl = document.getElementById('payment-instructions-text');
    const bankListEl = document.getElementById('bank-transfer-list');

    function updatePaymentUI(selectedValue) {
        paymentCards.forEach(card => {
            const radio = card.querySelector('input[type="radio"]');
            const isActive = radio && radio.value === selectedValue;
            card.classList.toggle('active', isActive);
            if (radio) radio.checked = isActive;
        });

        if (!textEl) return;

        if (selectedValue === 'bank') {
            textEl.innerHTML = 'Silakan transfer pembayaran Anda ke salah satu rekening berikut. Setelah transfer, pesanan akan segera diproses.';
            if (bankListEl) bankListEl.style.display = 'block';
        } else if (selectedValue === 'ewallet') {
            textEl.innerHTML = 'Silakan lakukan pembayaran ke nomor OVO/Gopay: <strong style="color: var(--text-primary);">0812-3456-7890</strong>. Sistem akan mendeteksi pembayaran Anda secara otomatis.';
            if (bankListEl) bankListEl.style.display = 'none';
        } else if (selectedValue === 'cod') {
            textEl.innerHTML = 'Anda akan membayar langsung kepada kurir saat pesanan tiba di alamat Anda. Siapkan uang pas untuk mempermudah transaksi.';
            if (bankListEl) bankListEl.style.display = 'none';
        }
    }

    paymentCards.forEach(card => {
        card.addEventListener('click', () => {
            const radio = card.querySelector('input[type="radio"]');
            if (!radio) return;
            updatePaymentUI(radio.value);
        });
    });

    const initialValue = document.querySelector('input[name="payment-option"]:checked')?.value || 'bank';
    updatePaymentUI(initialValue);

    // Override modal close redirect
    const btnClose = document.getElementById('btn-modal-close');
    if (btnClose) {
        btnClose.replaceWith(btnClose.cloneNode(true));
        document.getElementById('btn-modal-close').addEventListener('click', () => {
            localStorage.removeItem('cms_ecommerce_cart');
            window.location.href = '{{ route("home") }}';
        });
    }

    // Override tombol "Buat Pesanan" agar menyimpan ke database
    const btnSubmit = document.getElementById('btn-submit-order');
    if (btnSubmit) {
        btnSubmit.replaceWith(btnSubmit.cloneNode(true));
        document.getElementById('btn-submit-order').addEventListener('click', submitOrderToServer);
    }
});

function resetBtn() {
    const btn = document.getElementById('btn-submit-order');
    if (btn) {
        btn.disabled = false;
        btn.innerHTML = 'Buat Pesanan Sekarang <i class="fas fa-check-circle btn-icon" style="margin-left:0.5rem;"></i>';
    }
}

async function submitOrderToServer() {
    // --- Validasi form ---
    const name    = document.getElementById('checkout-name')?.value.trim();
    const email   = document.getElementById('checkout-email')?.value.trim();
    const phone   = document.getElementById('checkout-phone')?.value.trim();
    const address = document.getElementById('checkout-address')?.value.trim();
    const city    = document.getElementById('checkout-city')?.value.trim();
    const zip     = document.getElementById('checkout-zip')?.value.trim();

    let valid = true;
    const setError = (id, show) => {
        const el = document.getElementById(id);
        if (el) el.style.display = show ? 'block' : 'none';
    };

    setError('name-error',    !name);    if (!name)    valid = false;
    setError('email-error',   !email || !email.includes('@')); if (!email || !email.includes('@')) valid = false;
    setError('phone-error',   !phone);   if (!phone)   valid = false;
    setError('address-error', !address); if (!address) valid = false;
    setError('city-error',    !city);    if (!city)    valid = false;
    setError('zip-error',     !zip);     if (!zip)     valid = false;

    if (!valid) return;

    // --- Ambil item dari localStorage ---
    const cart = JSON.parse(localStorage.getItem('cms_ecommerce_cart') || '[]');
    if (!cart.length) {
        alert('Keranjang belanja kosong!');
        return;
    }

    const paymentMethod = document.querySelector('input[name="payment-option"]:checked')?.value || 'bank';

    const items = cart.map(item => ({
        product_id:   item.id   || null,
        product_name: item.name || item.title || 'Produk',
        quantity:     item.quantity || 1,
        price:        item.price,
    }));

    const payload = {
        customer_name:    name,
        customer_email:   email,
        customer_phone:   phone,
        shipping_address: address,
        city:             city,
        zip_code:         zip,
        payment_method:   paymentMethod,
        items:            items,
    };

    // --- Kirim ke server dengan timeout 15 detik ---
    const btn = document.getElementById('btn-submit-order');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';

    // AbortController untuk timeout otomatis
    const controller = new AbortController();
    const timeoutId  = setTimeout(() => controller.abort(), 15000); // 15 detik

    try {
        const response = await fetch('{{ route("orders.store") }}', {
            method:  'POST',
            signal:  controller.signal,
            headers: {
                'Content-Type':  'application/json',
                'Accept':        'application/json',
                'X-CSRF-TOKEN':  '{{ csrf_token() }}',
            },
            body: JSON.stringify(payload),
        });

        clearTimeout(timeoutId);

        // Cek apakah response adalah JSON
        const contentType = response.headers.get('content-type') || '';
        if (!contentType.includes('application/json')) {
            // Server balik HTML (biasanya halaman error Laravel)
            const text = await response.text();
            console.error('Server returned non-JSON:', text.substring(0, 500));
            alert('Terjadi kesalahan di server (HTTP ' + response.status + '). Lihat konsol untuk detail.');
            resetBtn();
            return;
        }

        const data = await response.json();

        if (response.ok && data.success) {
            // Tampilkan modal sukses
            const codeEl = document.getElementById('success-order-id');
            if (codeEl) codeEl.textContent = '#' + data.order_code;

            const overlay = document.getElementById('success-modal-overlay');
            if (overlay) {
                overlay.style.display = 'flex';
                overlay.classList.add('show');
            }

            localStorage.removeItem('cms_ecommerce_cart');
            if (typeof updateCartBadge === 'function') updateCartBadge();
            resetBtn();
        } else {
            // Tampilkan pesan error dari server
            const msg = data.message || (data.errors ? Object.values(data.errors).flat().join('\n') : 'Terjadi kesalahan.');
            alert('Gagal menyimpan pesanan:\n' + msg);
            resetBtn();
        }

    } catch (err) {
        clearTimeout(timeoutId);
        if (err.name === 'AbortError') {
            alert('Waktu tunggu habis (15 detik).\nServer terlalu lama merespons. Coba lagi.');
        } else {
            console.error('Fetch error:', err);
            alert('Gagal terhubung ke server.\nError: ' + err.message);
        }
        resetBtn();
    }
}
</script>
@endpush
