// System Management for Shopping Cart using localStorage

const CART_STORAGE_KEY = 'cms_ecommerce_cart';

// Get cart items
function getCart() {
    const cart = localStorage.getItem(CART_STORAGE_KEY);
    return cart ? JSON.parse(cart) : [];
}

// Save cart items
function saveCart(cart) {
    localStorage.setItem(CART_STORAGE_KEY, JSON.stringify(cart));
    updateCartBadge();
}

// Add item to cart
// Mode 1 (halaman statis): addToCart(productId, quantity)
// Mode 2 (halaman dinamis Laravel): addToCart(productId, name, price, image)
function addToCart(productId, nameOrQty = 1, price = null, image = null) {
    productId = parseInt(productId);
    
    let product;
    
    // Jika dipanggil dari halaman dinamis Laravel (ada parameter name & price)
    if (price !== null && typeof nameOrQty === 'string') {
        const productName = nameOrQty;
        const productPrice = parseFloat(price);
        const productImage = image || 'https://via.placeholder.com/300?text=No+Image';
        
        product = {
            id: productId,
            name: productName,
            price: productPrice,
            image: productImage,
            stock: 9999, // stock tidak divalidasi di mode ini
            category: '',
            slug: '',
        };
        
        let cart = getCart();
        const existingIndex = cart.findIndex(item => item.id === productId);
        
        if (existingIndex > -1) {
            cart[existingIndex].quantity += 1;
            showNotification(`${product.name} telah ditambahkan ke keranjang.`, 'success');
        } else {
            cart.push({ ...product, quantity: 1 });
            showNotification(`${product.name} berhasil ditambahkan ke keranjang.`, 'success');
        }
        
        saveCart(cart);
        return true;
    }
    
    // Mode lama: addToCart(productId, quantity) — mencari dari variabel products global
    const quantity = parseInt(nameOrQty) || 1;
    
    // Cek apakah variabel products global tersedia
    if (typeof products === 'undefined') {
        showNotification('Gagal menambahkan produk.', 'error');
        return false;
    }
    
    // Find product in database
    product = products.find(p => p.id === productId);
    if (!product) {
        showNotification('Produk tidak ditemukan!', 'error');
        return false;
    }

    let cart = getCart();
    const existingIndex = cart.findIndex(item => item.id === productId);

    if (existingIndex > -1) {
        const newQty = cart[existingIndex].quantity + quantity;
        if (newQty > product.stock) {
            showNotification(`Stok tidak mencukupi! Hanya tersisa ${product.stock} item.`, 'warning');
            cart[existingIndex].quantity = product.stock;
        } else {
            cart[existingIndex].quantity = newQty;
            showNotification(`${product.name} telah ditambahkan ke keranjang.`, 'success');
        }
    } else {
        if (quantity > product.stock) {
            showNotification(`Stok tidak mencukupi! Hanya tersisa ${product.stock} item.`, 'warning');
            cart.push({
                ...product,
                quantity: product.stock
            });
        } else {
            cart.push({
                ...product,
                quantity: quantity
            });
            showNotification(`${product.name} berhasil ditambahkan ke keranjang.`, 'success');
        }
    }

    saveCart(cart);
    return true;
}

// Update item quantity
function updateCartQuantity(productId, quantity) {
    productId = parseInt(productId);
    quantity = parseInt(quantity);
    
    if (quantity <= 0) {
        removeFromCart(productId);
        return;
    }

    let cart = getCart();
    const itemIndex = cart.findIndex(item => item.id === productId);

    if (itemIndex > -1) {
        // Cek stok jika variabel products tersedia
        if (typeof products !== 'undefined') {
            const product = products.find(p => p.id === productId);
            if (product && quantity > product.stock) {
                showNotification(`Stok terbatas! Maksimal ${product.stock} item.`, 'warning');
                cart[itemIndex].quantity = product.stock;
            } else {
                cart[itemIndex].quantity = quantity;
            }
        } else {
            cart[itemIndex].quantity = quantity;
        }
        saveCart(cart);
        // Refresh cart display if on cart page
        if (window.location.pathname === '/cart' || window.location.pathname.includes('cart.html')) {
            renderCartPage();
        }
    }
}

// Remove item from cart
function removeFromCart(productId) {
    productId = parseInt(productId);
    let cart = getCart();
    const item = cart.find(item => item.id === productId);
    
    cart = cart.filter(item => item.id !== productId);
    saveCart(cart);
    
    if (item) {
        showNotification(`${item.name} dihapus dari keranjang.`, 'info');
    }

    // Refresh cart display if on cart page
    if (window.location.pathname === '/cart' || window.location.pathname.includes('cart.html')) {
        renderCartPage();
    }
}

// Clear cart
function clearCart() {
    localStorage.removeItem(CART_STORAGE_KEY);
    updateCartBadge();
    
    // Refresh cart display if on cart page
    if (window.location.pathname === '/cart' || window.location.pathname.includes('cart.html')) {
        renderCartPage();
    }
}

// Update cart badge count in navbar
function updateCartBadge() {
    const cart = getCart();
    const totalCount = cart.reduce((sum, item) => sum + item.quantity, 0);
    const badges = document.querySelectorAll('.cart-badge');
    
    badges.forEach(badge => {
        badge.textContent = totalCount;
        if (totalCount > 0) {
            badge.style.display = 'flex';
            badge.classList.add('pulse-animation');
            setTimeout(() => {
                badge.classList.remove('pulse-animation');
            }, 300);
        } else {
            badge.style.display = 'none';
        }
    });
}

// Show animated notification popup
function showNotification(message, type = 'success') {
    // Check if notification container exists, otherwise create it
    let container = document.getElementById('notification-container');
    if (!container) {
        container = document.createElement('div');
        container.id = 'notification-container';
        document.body.appendChild(container);
    }

    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    
    let icon = 'check-circle';
    if (type === 'warning') icon = 'exclamation-triangle';
    if (type === 'error') icon = 'times-circle';
    if (type === 'info') icon = 'info-circle';

    notification.innerHTML = `
        <i class="fas fa-${icon}"></i>
        <div class="notification-content">
            <p>${message}</p>
        </div>
    `;

    container.appendChild(notification);

    // Trigger entrance animation
    setTimeout(() => {
        notification.classList.add('show');
    }, 10);

    // Remove notification after 3.5 seconds
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 3500);
}

// Run on page load
document.addEventListener('DOMContentLoaded', () => {
    updateCartBadge();
});
