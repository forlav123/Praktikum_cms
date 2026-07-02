// Main JS Controller for Toko Barang

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
function escapeHtml(value) {
    return String(value ?? '')
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#39;');
}

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
    const displayName = escapeHtml(product?.name || 'Produk');
    const displayCategory = escapeHtml(product?.category || 'Umum');
    const displayImage = escapeHtml(product?.image || '');
    return `
        <div class="product-card">
            ${product?.stock < 10 ? `<div class="product-badge" style="background: var(--warning);">Sisa ${product?.stock}</div>` : ''}
            <a href="detail.html?id=${product?.id}" class="product-img-wrapper">
                <img src="${displayImage}" alt="${displayName}" loading="lazy">
            </a>
            <div class="product-info">
                <div class="product-category">${displayCategory}</div>
                <a href="detail.html?id=${product?.id}" class="product-title-link">
                    <h3 class="product-title">${displayName}</h3>
                </a>
                <div class="product-rating">
                    ${generateStars(product?.rating || 0)}
                    <span>(${product?.reviewsCount || 0})</span>
                </div>
                <div class="product-price-row">
                    <div class="product-price">${formatRupiah(product?.price || 0)}</div>
                    <button type="button" class="add-cart-btn" onclick="addToCart(${product?.id || 0})" title="Tambah ke Keranjang">
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
let currentPage = 1;
let hasMoreProducts = false;
let isLoadingMore = false;
let allVisibleProducts = [];

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
        const safeName = String(p?.name || '').toLowerCase();
        const safeCategory = String(p?.category || '');
        const matchSearch = safeName.includes(String(searchQuery || '').toLowerCase());
        const matchCat = activeCategoryFilters.length === 0 || activeCategoryFilters.includes(safeCategory);
        const matchPrice = (Number(p?.price) || 0) >= minPrice && (Number(p?.price) || 0) <= maxPrice;
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

    const visibleProducts = filtered.slice(0, currentPage * 6);

    // Update count
    const countEl = document.getElementById('results-count-num');
    const summaryEl = document.getElementById('results-count-summary');
    if (countEl) countEl.textContent = filtered.length;
    if (summaryEl) {
        summaryEl.textContent = filtered.length > 0
            ? `Menampilkan ${Math.min(visibleProducts.length, filtered.length)} dari ${filtered.length} produk`
            : 'Tidak ada produk yang cocok';
    }
    allVisibleProducts = visibleProducts;

    const loadMoreBtn = document.getElementById('load-more-btn');
    const loadMoreStatus = document.getElementById('load-more-status');
    if (loadMoreBtn) {
        hasMoreProducts = filtered.length > visibleProducts.length;
        loadMoreBtn.style.display = hasMoreProducts ? 'inline-block' : 'none';
    }

    if (loadMoreStatus) {
        if (filtered.length > 0 && !hasMoreProducts) {
            loadMoreStatus.textContent = 'Semua produk sudah tampil.';
            loadMoreStatus.style.display = 'block';
        } else {
            loadMoreStatus.style.display = 'none';
        }
    }

    // Render HTML
    if (filtered.length > 0) {
        shopGrid.innerHTML = visibleProducts.map(p => createProductCard(p)).join('');
        shopGrid.style.opacity = '1';
        shopGrid.style.transform = 'translateY(0)';
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

function loadMoreShopProducts() {
    if (isLoadingMore) return;

    const loadMoreBtn = document.getElementById('load-more-btn');
    if (!loadMoreBtn) return;

    const loadMoreLabel = loadMoreBtn.querySelector('.load-more-label');
    const loadMoreSpinner = loadMoreBtn.querySelector('.load-more-spinner');

    isLoadingMore = true;
    if (loadMoreLabel) loadMoreLabel.textContent = 'Memuat...';
    if (loadMoreSpinner) loadMoreSpinner.style.display = 'inline-block';
    loadMoreBtn.disabled = true;

    fetch(`/shop/products?page=${currentPage + 1}&per_page=6`)
        .then(response => response.json())
        .then(data => {
            if (data.products && data.products.length > 0) {
                currentPage += 1;
                products = [...products, ...data.products];
                renderShopPage();
            }

            if (!data.hasMore) {
                loadMoreBtn.style.display = 'none';
                const loadMoreStatus = document.getElementById('load-more-status');
                if (loadMoreStatus) {
                    loadMoreStatus.textContent = 'Semua produk sudah tampil.';
                    loadMoreStatus.style.display = 'block';
                }
            }
        })
        .catch(() => {
            if (loadMoreLabel) loadMoreLabel.textContent = 'Coba Lagi';
        })
        .finally(() => {
            isLoadingMore = false;
            if (loadMoreLabel) loadMoreLabel.textContent = 'Muat Lebih';
            if (loadMoreSpinner) loadMoreSpinner.style.display = 'none';
            loadMoreBtn.disabled = false;
        });
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
            currentPage = 1;
            renderShopPage();
        });
    }

    catCheckboxes.forEach(cb => {
        cb.addEventListener('change', () => {
            activeCategoryFilters = Array.from(catCheckboxes)
                .filter(i => i.checked)
                .map(i => i.value);
            currentPage = 1;
            renderShopPage();
        });
    });

    if (priceSlider) {
        priceSlider.addEventListener('input', (e) => {
            maxPrice = parseInt(e.target.value);
            priceDisplay.textContent = formatRupiah(maxPrice);
            currentPage = 1;
            renderShopPage();
        });
    }

    if (sortSelect) {
        sortSelect.addEventListener('change', (e) => {
            activeSort = e.target.value;
            currentPage = 1;
            renderShopPage();
        });
    }

    const loadMoreBtn = document.getElementById('load-more-btn');
    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', loadMoreShopProducts);
    }

    window.addEventListener('scroll', () => {
        const nearBottom = window.innerHeight + window.scrollY >= document.body.offsetHeight - 400;
        if (nearBottom && hasMoreProducts && !isLoadingMore) {
            loadMoreShopProducts();
        }
    });

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

            currentPage = 1;

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
    document.title = `${product.name} - Toko Barang`;

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
            const selectedPayment = document.querySelector('input[name="payment-option"]:checked')?.value || 'bank';
            const successTitle = document.getElementById('success-title');
            const successMessage = document.getElementById('success-message');
            
            // Show Modal with payment-specific confirmation
            document.getElementById('success-order-id').textContent = orderId;
            if (successTitle && successMessage) {
                if (selectedPayment === 'cod') {
                    successTitle.textContent = 'Pesanan Berhasil Dibuat!';
                    successMessage.innerHTML = `Terima kasih atas pesanan Anda. Kode pesanan Anda adalah <strong id="success-order-id" style="color: var(--accent-primary);">${orderId}</strong>. Pembayaran akan dilakukan saat barang tiba di tempat Anda.`;
                } else {
                    successTitle.textContent = 'Transaksi Berhasil!';
                    successMessage.innerHTML = `Terima kasih atas pesanan Anda. Kode pesanan Anda adalah <strong id="success-order-id" style="color: var(--accent-primary);">${orderId}</strong>. Tim logistik kami akan segera mengemas dan mengirimkan produk Anda.`;
                }
            }
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
