@extends('layout_final4')

@section('title', 'Tentang Kami - Toko Maju Jaya')

@section('content')
    <!-- About Hero Section -->
    <section class="about-hero">
        <span style="font-size: 0.85rem; font-weight: 700; color: var(--accent-primary); text-transform: uppercase; letter-spacing: 1px;">Kisah & Misi Kami</span>
        <h1>Mendefinisikan Ulang <span>Belanja Online</span></h1>
        <p>Toko Maju Jaya berdiri sejak tahun 2026 sebagai wadah e-commerce ritel premium yang berfokus menyajikan produk-produk teknologi orisinal berkualitas tinggi dan pakaian modern kelas atas. Kami percaya bahwa teknologi dan gaya hidup harus saling melengkapi untuk menunjang produktivitas Anda.</p>
    </section>

    <!-- Core Values / Philosophy -->
    <section class="about-values-section">
        <div class="section-header" style="margin-top: 0; padding: 0;">
            <div class="section-header-left">
                <h2>Nilai & Filosofi Kami</h2>
                <p>Prinsip dasar yang menuntun kami dalam memberikan pelayanan terbaik kepada pelanggan</p>
            </div>
        </div>
        
        <div class="features-container" style="margin-top: 3rem;">
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-check-double"></i></div>
                <h3>Keaslian 100%</h3>
                <p>Kami menjamin semua produk gadget dan elektronik yang kami jual merupakan produk baru dan original.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-gem"></i></div>
                <h3>Kualitas Terpilih</h3>
                <p>Melalui proses kurasi ketat untuk memastikan barang tiba di tangan Anda dalam kondisi sempurna.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-magic"></i></div>
                <h3>Inovasi Layanan</h3>
                <p>Terus berinovasi mengembangkan platform website yang user-friendly demi kemudahan belanja Anda.</p>
            </div>
        </div>
    </section>

    <!-- Bottom CTA Banner -->
    <section class="about-hero" style="background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: 4rem 2rem; margin-bottom: 8rem; max-width: 1200px; margin-left: auto; margin-right: auto;">
        <h2 style="font-size: 2.25rem; font-weight: 800; margin-bottom: 1rem;">Siap Menjelajahi Produk Kami?</h2>
        <p style="margin-bottom: 2rem; max-width: 600px; margin-left: auto; margin-right: auto;">Dapatkan penawaran harga terbaik dan pengalaman belanja paling menyenangkan hanya di toko kami.</p>
        <a href="{{ route('shop') }}" class="btn btn-primary">Mulai Belanja <i class="fas fa-shopping-cart btn-icon"></i></a>
    </section>
@endsection
