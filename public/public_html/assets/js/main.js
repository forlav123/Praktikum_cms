// Main JS Controller for GlowTech Store

// Utility format Currency
function formatRupiah(amount) {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    }).format(amount);
}

// Utility to generate Star Ratings
function generateStars(rating) {
    let html = '';
    const fullStars = Math.floor(rating);
    const hasHalfStar = rating % 1 >= 0.5;
    
    for (let i = 0; i < fullStars; i++) {
        html += '<i class="fas fa-star"></i>';
    }
    if (hasHalfStar) {
        html += '<i class="fas fa-star-half-alt"></i>';
    }
    const emptyStars = 5 - fullStars - (hasHalfStar ? 1 : 0);
    for (let i = 0; i < emptyStars; i++) {
        html += '<i class="far fa-star"></i>';
    }
    return html;
}

// Generate a single Product Card HTML
function createProductCard(product) {
    return `
        <div class="product-card">
            ${product.stock < 10 ? `<div class="product-badge" style="background: var(--warning);">Sisa ${product.stock}</div>` : ''}
            <a href="detail.html?id=${product.id}" class="product-img-wrapper">
                <img src="${product.image}" alt="${product.name}">
            </a>
            <div class="product-info">
                <div class="product-category">${product.category}</div>
                <a href="detail.html?id=${product.id}" class="product-title-link">
                    <h3 class="product-title">${product.name}</h3>
                </a>
                <div class="product-rating">
                    ${generateStars(product.rating)}
                    <span>(${product.reviewsCount})</span>
                </div>
                <div class="product-price-row">
                    <div class="product-price">${formatRupiah(product.price)}</div>
                    <button type="button" class="add-cart-btn" onclick="addToCart(${product.id})" title="Tambah ke Keranjang">
                        <i class="fas fa-cart-plus"></i>
                    </button>
                </div>
            </div>
        </div>
    `;
}

// --- Home Page ---
function renderHomePage() {
    const featuredGrid = document.getElementById('featured-products-grid');
    if (!featuredGrid) return;
    
    // Get 4 highest rated products
    const featured = [...products].sort((a, b) => b.rating - a.rating).slice(0, 4);
    
    featuredGrid.innerHTML = featured.map(p => createProductCard(p)).join('');
}

// --- Shop / Catalog Page ---
let activeCategoryFilters = [];
let searchQuery = '';
let minPrice = 0;
let maxPrice = 35000000;
let activeSort = 'default';

function renderShopPage() {
    const shopGrid = document.getElementById('shop-products-grid');
    if (!shopGrid) return;

    // Check URL params for initial category filter
    const urlParams = new URLSearchParams(window.location.search);
    const catParam = urlParams.get('category');
    if (catParam && activeCategoryFilters.length === 0) {
        activeCategoryFilters.push(catParam);
        // Check the corresponding checkbox
        const checkboxes = document.querySelectorAll('.category-checkbox');
        checkboxes.forEach(cb => {
            if (cb.value === catParam) cb.checked = true;
        });
    }

    // Apply Filters
    let filtered = products.filter(p => {
        const matchSearch = p.name.toLowerCase().includes(searchQuery.toLowerCase());
        const matchCat = activeCategoryFilters.length === 0 || activeCategoryFilters.includes(p.category);
        const matchPrice = p.price >= minPrice && p.price <= maxPrice;
        return matchSearch && matchCat && matchPrice;
    });

    // Apply Sorting
    if (activeSort === 'price-asc') {
        filtered.sort((a, b) => a.price - b.price);
    } else if (activeSort === 'price-desc') {
        filtered.sort((a, b) => b.price - a.price);
    } else if (activeSort === 'rating-desc') {
        filtered.sort((a, b) => b.rating - a.rating);
    } // default is keep DB order

    // Update count
    const countEl = document.getElementById('results-count-num');
    if (countEl) countEl.textContent = filtered.length;

    // Render HTML
    if (filtered.length > 0) {
        shopGrid.innerHTML = filtered.map(p => createProductCard(p)).join('');
    } else {
        shopGrid.innerHTML = `
            <div style="grid-column: 1 / -1; text-align: center; padding: 4rem 2rem; background: var(--bg-secondary); border-radius: var(--radius-md);">
                <i class="fas fa-box-open" style="font-size: 3rem; color: var(--text-muted); margin-bottom: 1rem;"></i>
                <h3>Produk Tidak Ditemukan</h3>
                <p style="color: var(--text-secondary);">Coba sesuaikan filter pencarian atau rentang harga Anda.</p>
            </div>
        `;
    }
}

function initShopFilters() {
    const searchInput = document.getElementById('search-input');
    const catCheckboxes = document.querySelectorAll('.category-checkbox');
    const priceSlider = document.getElementById('price-slider');
    const priceDisplay = document.getElementById('price-slider-val');
    const sortSelect = document.getElementById('sort-select');
    const btnReset = document.getElementById('btn-reset-filters');

    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            searchQuery = e.target.value;
            renderShopPage();
        });
    }

    catCheckboxes.forEach(cb => {
        cb.addEventListener('change', () => {
            activeCategoryFilters = Array.from(catCheckboxes)
                .filter(i => i.checked)
                .map(i => i.value);
            renderShopPage();
        });
    });

    if (priceSlider) {
        priceSlider.addEventListener('input', (e) => {
            maxPrice = parseInt(e.target.value);
            priceDisplay.textContent = formatRupiah(maxPrice);
            renderShopPage();
        });
    }

    if (sortSelect) {
        sortSelect.addEventListener('change', (e) => {
            activeSort = e.target.value;
            renderShopPage();
        });
    }

    if (btnReset) {
        btnReset.addEventListener('click', () => {
            searchQuery = '';
            if (searchInput) searchInput.value = '';
            
            activeCategoryFilters = [];
            catCheckboxes.forEach(cb => cb.checked = false);
            
            maxPrice = 35000000;
            if (priceSlider) {
                priceSlider.value = maxPrice;
                priceDisplay.textContent = formatRupiah(maxPrice);
            }
            
            activeSort = 'default';
            if (sortSelect) sortSelect.value = 'default';

            // Clear url params without reloading
            const newUrl = window.location.protocol + "//" + window.location.host + window.location.pathname;
            window.history.pushState({path:newUrl}, '', newUrl);

            renderShopPage();
        });
    }
}

// --- Detail Page ---
function renderDetailPage() {
    const detailView = document.getElementById('product-detail-view');
    const errorView = document.getElementById('product-detail-error');
    if (!detailView || !errorView) return;

    const urlParams = new URLSearchParams(window.location.search);
    const productId = parseInt(urlParams.get('id'));
    const product = products.find(p => p.id === productId);

    if (!product) {
        detailView.style.display = 'none';
        errorView.style.display = 'block';
        return;
    }

    // Set page title
    document.title = `${product.name} - GlowTech Store`;

    // Populate data
    document.getElementById('breadcrumb-active').textContent = product.name;
    document.getElementById('detail-product-img').src = product.image;
    document.getElementById('detail-product-cat').textContent = product.category;
    document.getElementById('detail-product-title').textContent = product.name;
    document.getElementById('detail-stars').innerHTML = generateStars(product.rating);
    document.getElementById('detail-rating-count').textContent = `(${product.reviewsCount} ulasan)`;
    document.getElementById('detail-product-price').textContent = formatRupiah(product.price);
    document.getElementById('detail-product-desc').textContent = product.description;
    
    const stockStatus = document.getElementById('detail-stock-status');
    if (product.stock > 10) {
        stockStatus.textContent = "Tersedia";
        stockStatus.style.color = "var(--success)";
    } else if (product.stock > 0) {
        stockStatus.textContent = `Tersisa Sedikit`;
        stockStatus.style.color = "var(--warning)";
    } else {
        stockStatus.textContent = "Habis";
        stockStatus.style.color = "var(--error)";
    }

    document.getElementById('detail-stock-count').textContent = `${product.stock} item`;

    // Qty picker logic
    const qtyInput = document.getElementById('detail-qty-input');
    const btnMinus = document.getElementById('btn-qty-minus');
    const btnPlus = document.getElementById('btn-qty-plus');
    const btnAddCart = document.getElementById('btn-add-to-cart-detail');

    let currentQty = 1;
    if (product.stock === 0) {
        currentQty = 0;
        qtyInput.value = 0;
        btnAddCart.disabled = true;
        btnAddCart.style.opacity = '0.5';
        btnAddCart.innerHTML = 'Stok Habis';
    }

    btnMinus.addEventListener('click', () => {
        if (currentQty > 1) {
            currentQty--;
            qtyInput.value = currentQty;
        }
    });

    btnPlus.addEventListener('click', () => {
        if (currentQty < product.stock) {
            currentQty++;
            qtyInput.value = currentQty;
        } else {
            showNotification('Stok maksimum tercapai.', 'warning');
        }
    });

    btnAddCart.addEventListener('click', () => {
        addToCart(product.id, currentQty);
    });

    // Render related products (same category, exclude current)
    const relatedGrid = document.getElementById('related-products-grid');
    if (relatedGrid) {
        const related = products
            .filter(p => p.category === product.category && p.id !== product.id)
            .slice(0, 4);
        
        if (related.length > 0) {
            relatedGrid.innerHTML = related.map(p => createProductCard(p)).join('');
        } else {
            relatedGrid.innerHTML = '<p style="color: var(--text-secondary); grid-column: 1/-1; text-align: center;">Tidak ada produk terkait.</p>';
        }
    }
}

// --- Cart Page ---
function renderCartPage() {
    const tbody = document.getElementById('cart-items-tbody');
    if (!tbody) return; // not on cart page

    const mainContainer = document.getElementById('cart-main-container');
    const emptyContainer = document.getElementById('cart-empty-container');
    const cart = getCart();

    if (cart.length === 0) {
        mainContainer.style.display = 'none';
        emptyContainer.style.display = 'block';
        return;
    }

    mainContainer.style.display = 'grid';
    emptyContainer.style.display = 'none';

    let html = '';
    let subtotal = 0;

    cart.forEach(item => {
        const itemSubtotal = item.price * item.quantity;
        subtotal += itemSubtotal;
        
        html += `
            <tr>
                <td>
                    <div class="cart-item-product">
                        <img src="${item.image}" alt="${item.name}" class="cart-item-img">
                        <div>
                            <span class="cart-item-cat">${item.category}</span>
                            <a href="detail.html?id=${item.id}" class="cart-item-name">${item.name}</a>
                        </div>
                    </div>
                </td>
                <td style="font-weight: 600;">${formatRupiah(item.price)}</td>
                <td>
                    <div class="quantity-picker" style="margin: 0 auto; width: fit-content;">
                        <button type="button" class="qty-btn" onclick="updateCartQuantity(${item.id}, ${item.quantity - 1})"><i class="fas fa-minus"></i></button>
                        <input type="text" value="${item.quantity}" readonly>
                        <button type="button" class="qty-btn" onclick="updateCartQuantity(${item.id}, ${item.quantity + 1})"><i class="fas fa-plus"></i></button>
                    </div>
                </td>
                <td style="font-weight: 700; color: var(--text-primary);">${formatRupiah(itemSubtotal)}</td>
                <td style="text-align: center;">
                    <button type="button" class="cart-item-remove" onclick="removeFromCart(${item.id})">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        `;
    });

    tbody.innerHTML = html;

    // Calc totals
    const tax = subtotal * 0.11;
    const total = subtotal + tax;

    document.getElementById('summary-subtotal').textContent = formatRupiah(subtotal);
    document.getElementById('summary-tax').textContent = formatRupiah(tax);
    document.getElementById('summary-total').textContent = formatRupiah(total);

    // Bind Clear Cart
    const btnClear = document.getElementById('btn-clear-cart');
    if (btnClear) {
        // Clone and replace to remove old event listeners safely
        const newBtn = btnClear.cloneNode(true);
        btnClear.parentNode.replaceChild(newBtn, btnClear);
        newBtn.addEventListener('click', clearCart);
    }
}

// --- Checkout Page ---
function renderCheckoutPage() {
    const itemsList = document.getElementById('checkout-items-list');
    if (!itemsList) return; // not on checkout

    const mainContainer = document.getElementById('checkout-main-container');
    const emptyContainer = document.getElementById('checkout-empty-container');
    const cart = getCart();

    if (cart.length === 0) {
        mainContainer.style.display = 'none';
        emptyContainer.style.display = 'block';
        return;
    }

    mainContainer.style.display = 'grid';
    emptyContainer.style.display = 'none';

    let html = '';
    let subtotal = 0;

    cart.forEach(item => {
        const itemSubtotal = item.price * item.quantity;
        subtotal += itemSubtotal;
        
        html += `
            <div class="review-item-card">
                <img src="${item.image}" alt="${item.name}" class="review-item-img">
                <div class="review-item-info">
                    <div class="review-item-name">${item.name}</div>
                    <div class="review-item-qty-price">${item.quantity} x ${formatRupiah(item.price)}</div>
                </div>
                <div class="review-item-subtotal">${formatRupiah(itemSubtotal)}</div>
            </div>
        `;
    });

    itemsList.innerHTML = html;

    // Calc totals
    const tax = subtotal * 0.11;
    const total = subtotal + tax;

    document.getElementById('checkout-summary-subtotal').textContent = formatRupiah(subtotal);
    document.getElementById('checkout-summary-tax').textContent = formatRupiah(tax);
    document.getElementById('checkout-summary-total').textContent = formatRupiah(total);

    initCheckoutForm();
}

function initCheckoutForm() {
    // Payment cards active state
    const paymentCards = document.querySelectorAll('.payment-method-card');
    paymentCards.forEach(card => {
        card.addEventListener('click', () => {
            // remove active class
            paymentCards.forEach(c => c.classList.remove('active'));
            // add active
            card.classList.add('active');
            // check the radio
            const radio = card.querySelector('input[type="radio"]');
            radio.checked = true;
            
            // change instruction text
            const textEl = document.getElementById('payment-instructions-text');
            if (radio.value === 'bank') {
                textEl.innerHTML = 'Silakan transfer pembayaran Anda ke rekening Bank Mandiri kami: <strong style="color: var(--text-primary);">123-456-7890 a/n GlowTech Store</strong>. Pesanan akan segera diproses setelah bukti pembayaran berhasil kami terima.';
            } else if (radio.value === 'ewallet') {
                textEl.innerHTML = 'Silakan lakukan pembayaran ke nomor OVO/Gopay: <strong style="color: var(--text-primary);">0812-3456-7890</strong>. Sistem akan mendeteksi pembayaran Anda secara otomatis.';
            } else if (radio.value === 'cod') {
                textEl.innerHTML = 'Anda akan membayar langsung kepada kurir saat pesanan tiba di alamat Anda. Siapkan uang pas untuk mempermudah transaksi.';
            }
        });
    });

    // Handle Form Submit
    const btnSubmit = document.getElementById('btn-submit-order');
    const checkoutForm = document.getElementById('checkout-form');
    
    btnSubmit.addEventListener('click', (e) => {
        e.preventDefault();
        
        // Simple Validation
        let isValid = true;
        const inputs = checkoutForm.querySelectorAll('input[required], textarea[required]');
        
        inputs.forEach(input => {
            const errorMsg = document.getElementById(`${input.id.split('-')[1]}-error`);
            
            if (!input.value.trim()) {
                isValid = false;
                input.classList.add('invalid');
                if (errorMsg) errorMsg.style.display = 'block';
            } else {
                input.classList.remove('invalid');
                if (errorMsg) errorMsg.style.display = 'none';
            }
        });
        
        if (isValid) {
            // Generate random order ID
            const orderId = '#GTX-' + Math.floor(10000 + Math.random() * 90000);
            
            // Show Modal
            document.getElementById('success-order-id').textContent = orderId;
            document.getElementById('success-modal-overlay').classList.add('show');
            
            // Clear cart
            localStorage.removeItem(CART_STORAGE_KEY);
            updateCartBadge();
        } else {
            showNotification('Mohon lengkapi formulir pengiriman dengan benar.', 'error');
            checkoutForm.scrollIntoView({ behavior: 'smooth' });
        }
    });

    // Close Modal
    document.getElementById('btn-modal-close').addEventListener('click', () => {
        window.location.href = 'index.html';
    });
}

// --- Contact Form Handling ---
function initContactForm() {
    const contactForm = document.getElementById('contact-form');
    if (!contactForm) return;

    contactForm.addEventListener('submit', (e) => {
        e.preventDefault();
        
        // Simple Validation
        let isValid = true;
        const inputs = contactForm.querySelectorAll('input[required], textarea[required]');
        
        inputs.forEach(input => {
            const errorMsg = input.nextElementSibling;
            if (!input.value.trim()) {
                isValid = false;
                input.classList.add('invalid');
                if (errorMsg) errorMsg.style.display = 'block';
            } else {
                input.classList.remove('invalid');
                if (errorMsg) errorMsg.style.display = 'none';
            }
        });
        
        if (isValid) {
            showNotification('Pesan Anda berhasil dikirim! Tim kami akan segera merespons.', 'success');
            contactForm.reset();
        }
    });
}

// Global Initialization
document.addEventListener('DOMContentLoaded', () => {
    // Determine which page we are on and render accordingly
    const path = window.location.pathname;
    
    if (path.includes('index.html') || path === '/' || path.endsWith('public_html/')) {
        renderHomePage();
    } else if (path.includes('shop.html')) {
        renderShopPage();
        initShopFilters();
    } else if (path.includes('detail.html')) {
        renderDetailPage();
    } else if (path.includes('cart.html')) {
        renderCartPage();
    } else if (path.includes('checkout.html')) {
        renderCheckoutPage();
    } else if (path.includes('contact.html')) {
        initContactForm();
    }
});
