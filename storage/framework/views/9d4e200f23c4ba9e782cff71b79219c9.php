<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Toko Online - Pemesanan Barang</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-900 antialiased">
    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center">
                    <a href="/" class="text-2xl font-bold tracking-tight text-gray-900">
                        Toko <span class="text-orange-600">Barang</span>
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <?php if(auth()->guard()->check()): ?>
                        <a href="<?php echo e(url('/dashboard')); ?>" class="text-sm font-medium text-gray-700 hover:text-orange-600">Dashboard</a>
                    <?php else: ?>
                        <a href="<?php echo e(route('login')); ?>" class="text-sm font-medium text-gray-700 hover:text-orange-600">Login</a>
                        <a href="<?php echo e(route('register')); ?>" class="px-4 py-2 text-sm font-medium text-white bg-orange-600 rounded-md hover:bg-orange-700 transition">Register</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <header class="bg-gradient-to-r from-orange-600 to-red-600 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl font-extrabold text-white sm:text-6xl">Belanja Online Mudah & Cepat</h1>
            <p class="mt-4 text-xl text-orange-100">Temukan barang impian Anda dengan harga terbaik.</p>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h2 class="text-2xl font-bold text-gray-900 mb-8">Produk Terbaru</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-xl transition duration-300 group">
                    <div class="relative overflow-hidden">
                        <?php if($product->image): ?>
                            <img src="<?php echo e(asset('storage/' . $product->image)); ?>" alt="<?php echo e($product->name); ?>" class="w-full h-56 object-cover group-hover:scale-105 transition duration-500">
                        <?php else: ?>
                            <div class="w-full h-56 bg-gray-100 flex items-center justify-center">
                                <span class="text-gray-400">No Image</span>
                            </div>
                        <?php endif; ?>
                        <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-bold text-orange-600 shadow-sm">
                            <?php echo e($product->category->name); ?>

                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-1 leading-tight">
                            <a href="<?php echo e(route('product.show', $product->slug)); ?>" class="hover:text-orange-600 transition"><?php echo e($product->name); ?></a>
                        </h3>
                        <p class="text-orange-600 font-bold text-xl mb-4">Rp <?php echo e(number_format($product->price, 0, ',', '.')); ?></p>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">Stok: <?php echo e($product->stock); ?></span>
                            <a href="<?php echo e(route('product.show', $product->slug)); ?>" class="px-4 py-2 bg-gray-900 text-white text-xs font-bold rounded-lg hover:bg-orange-600 transition">Detail</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-500 text-lg">Belum ada produk yang tersedia.</p>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <footer class="bg-gray-900 text-gray-400 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-sm">
            &copy; <?php echo e(date('Y')); ?> Toko Barang Online - Praktikum CMS.
        </div>
    </footer>
</body>
</html>
<?php /**PATH D:\Praktikum_cms\resources\views/welcome.blade.php ENDPATH**/ ?>