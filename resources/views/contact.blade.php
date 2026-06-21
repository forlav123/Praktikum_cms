@extends('layout_final4')

@section('title', 'Hubungi Kami - GlowTech Store')

@section('content')
    <!-- Page Title -->
    <section class="section-header" style="margin-top: 3rem; margin-bottom: 0;">
        <div class="section-header-left">
            <h2>Hubungi Kami</h2>
            <p>Punya pertanyaan atau keluhan? Jangan ragu untuk menghubungi tim bantuan kami.</p>
        </div>
    </section>

    <!-- Contact Container -->
    <section class="contact-layout">
        
        <!-- Left Column: Contact Info & Map -->
        <div class="contact-info-card">
            <div>
                <h3 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 0.5rem;">Informasi Kontak</h3>
                <p style="color: var(--text-secondary); font-size: 0.95rem;">Tim dukungan pelanggan kami siap melayani Anda 24/7. Hubungi kami melalui salah satu saluran berikut.</p>
                
                <div class="contact-methods">
                    <div class="contact-method-item">
                        <div class="contact-method-icon"><i class="fas fa-map-marker-alt"></i></div>
                        <div class="contact-method-text">
                            <h4>Lokasi Toko Fisik</h4>
                            <p>Jl. Maguwoharjo Demangan, Yogyakarta</p>
                        </div>
                    </div>
                    <div class="contact-method-item">
                        <div class="contact-method-icon"><i class="fas fa-envelope"></i></div>
                        <div class="contact-method-text">
                            <h4>Email Dukungan</h4>
                            <p>forlavhadiman@gmail.com<br>sales@glowtech.com</p>
                        </div>
                    </div>
                    <div class="contact-method-item">
                        <div class="contact-method-icon"><i class="fas fa-phone-alt"></i></div>
                        <div class="contact-method-text">
                            <h4>Layanan Telepon</h4>
                            <p>+62 85237146917<br>(021) 9876-5432</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="contact-map-placeholder">
                <i class="fas fa-map-marked-alt"></i>
                <span style="font-weight: 600;">Peta Lokasi Google Maps Terintegrasi</span>
                <span style="font-size: 0.8rem; color: var(--text-secondary);">Fitur Interaktif Peta Aktif</span>
            </div>
        </div>

        <!-- Right Column: Contact Form -->
        <div class="checkout-card" style="display: flex; flex-direction: column;">
            <h3 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 0.5rem;">Kirim Pesan Langsung</h3>
            <p style="color: var(--text-secondary); font-size: 0.95rem; margin-bottom: 2rem;">Silakan isi formulir di bawah ini dan kami akan merespons pesan Anda maksimal dalam 2x24 jam kerja.</p>
            
            <form id="contact-form" novalidate style="display: flex; flex-direction: column; gap: 1.5rem; flex-grow: 1;">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="contact-name">Nama Lengkap *</label>
                        <input type="text" id="contact-name" required placeholder="Contoh: Budi Santoso">
                        <span class="form-error-msg">Silakan masukkan nama Anda.</span>
                    </div>
                    <div class="form-group">
                        <label for="contact-email">Alamat Email *</label>
                        <input type="email" id="contact-email" required placeholder="Contoh: budi@gmail.com">
                        <span class="form-error-msg">Silakan masukkan email yang valid.</span>
                    </div>
                    <div class="form-group full-width">
                        <label for="contact-subject">Subjek / Topik *</label>
                        <input type="text" id="contact-subject" required placeholder="Contoh: Kendala Pengiriman Pesanan">
                        <span class="form-error-msg">Subjek wajib diisi.</span>
                    </div>
                    <div class="form-group full-width" style="flex-grow: 1; display: flex; flex-direction: column;">
                        <label for="contact-message">Detail Pesan *</label>
                        <textarea id="contact-message" required placeholder="Jelaskan pertanyaan atau kendala Anda secara rinci di sini..." style="flex-grow: 1; min-height: 150px; resize: vertical;"></textarea>
                        <span class="form-error-msg">Pesan tidak boleh kosong.</span>
                    </div>
                </div>
                
                <button type="submit" id="btn-submit-contact" class="btn btn-primary" style="margin-top: auto;">
                    Kirim Pesan Sekarang <i class="fas fa-paper-plane btn-icon" style="margin-left: 0.5rem;"></i>
                </button>
            </form>
        </div>
        
    </section>
@endsection
