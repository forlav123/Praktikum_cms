<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'GlowTech Store - Solusi Belanja Gadget & Fashion Premium')</title>
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Main Style CSS -->
    <link rel="stylesheet" href="{{ asset('public_html/assets/css/style.css') }}">
    @stack('styles')
</head>
<body>

    <!-- Header Navigation -->
    <header>
        <div class="nav-container">
            <a href="{{ route('home') }}" class="logo-link">
                <div class="logo">
                    <i class="fas fa-shopping-bag"></i> GlowTech
                </div>
            </a>
            <nav>
                <ul>
                    <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a></li>
                    <li><a href="{{ url('public_html/shop.html') }}">Katalog</a></li>
                    <li><a href="{{ url('public_html/about.html') }}">Tentang</a></li>
                    <li><a href="{{ url('public_html/contact.html') }}">Kontak</a></li>
                </ul>
            </nav>
            <div class="nav-actions">
                <div style="margin-right: 15px; display: inline-block;">
                    @auth
                        <a href="{{ url('/dashboard') }}" style="text-decoration: none; color: var(--text-primary); font-weight: 600; font-size: 0.9rem;">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" style="text-decoration: none; color: var(--text-primary); font-weight: 600; font-size: 0.9rem;">Login</a>
                    @endauth
                </div>
                <a href="{{ url('public_html/cart.html') }}" class="cart-icon-btn">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="cart-badge" style="display: none;">0</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer>
        <div class="footer-container">
            <div class="footer-brand">
                <div class="logo">
                    <i class="fas fa-shopping-bag"></i> GlowTech
                </div>
                <p>Toko ritel online terpercaya yang menyediakan berbagai macam kebutuhan gadget high-end dan fashion tren terkini.</p>
            </div>
            <div class="footer-column">
                <h3>Tautan Cepat</h3>
                <ul>
                    <li><a href="{{ route('home') }}">Beranda</a></li>
                    <li><a href="{{ url('public_html/shop.html') }}">Katalog</a></li>
                    <li><a href="{{ url('public_html/about.html') }}">Tentang Kami</a></li>
                    <li><a href="{{ url('public_html/contact.html') }}">Hubungi Kami</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h3>Kategori</h3>
                <ul>
                    <li><a href="{{ url('public_html/shop.html?category=Laptop') }}">Laptop</a></li>
                    <li><a href="{{ url('public_html/shop.html?category=Smartphone') }}">Smartphone</a></li>
                    <li><a href="{{ url('public_html/shop.html?category=Pakaian') }}">Pakaian</a></li>
                    <li><a href="{{ url('public_html/shop.html?category=Aksesoris') }}">Aksesoris</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h3>Kontak Kami</h3>
                <ul style="color: var(--text-secondary); font-size: 0.9rem; gap: 0.5rem; list-style: none; padding-left: 0;">
                    <li style="margin-bottom: 0.5rem;"><i class="fas fa-map-marker-alt" style="margin-right: 0.5rem; color: var(--accent-primary);"></i> Jl. Malioboro No. 45, Yogyakarta</li>
                    <li style="margin-bottom: 0.5rem;"><i class="fas fa-phone" style="margin-right: 0.5rem; color: var(--accent-primary);"></i> +62 812-3456-7890</li>
                    <li style="margin-bottom: 0.5rem;"><i class="fas fa-envelope" style="margin-right: 0.5rem; color: var(--accent-primary);"></i> support@glowtech.com</li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} GlowTech Store - Praktikum CMS. Seluruh Hak Cipta Dilindungi.</p>
            <div class="social-links">
                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-youtube"></i></a>
            </div>
        </div>
    </footer>

    <!-- Products Mock DB (Dihapus jika full dinamis) -->
    <!-- <script src="{{ asset('public_html/assets/js/products-db.js') }}"></script> -->
    <!-- Cart Logic -->
    <script src="{{ asset('public_html/assets/js/cart.js') }}"></script>
    <!-- Main JS -->
    <script src="{{ asset('public_html/assets/js/main.js') }}"></script>
    
    @stack('scripts')
</body>
</html>
