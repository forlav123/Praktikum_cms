<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\AppLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <?php echo e(__('Dashboard')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-6">Ringkasan Toko Anda</h3>
                    
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px;">
                        <!-- Statistik Kategori -->
                        <div style="background-color: #eff6ff; border-left: 4px solid #2563eb; padding: 20px; border-radius: 8px; shadow: 0 2px 4px rgba(0,0,0,0.05);">
                            <p style="color: #1e40af; font-size: 14px; font-weight: bold; margin-bottom: 5px;">TOTAL KATEGORI</p>
                            <h4 style="font-size: 28px; font-weight: 800;"><?php echo e(\App\Models\Category::count()); ?></h4>
                        </div>
                        
                        <!-- Statistik Produk -->
                        <div style="background-color: #fff7ed; border-left: 4px solid #ea580c; padding: 20px; border-radius: 8px; shadow: 0 2px 4px rgba(0,0,0,0.05);">
                            <p style="color: #9a3412; font-size: 14px; font-weight: bold; margin-bottom: 5px;">TOTAL PRODUK</p>
                            <h4 style="font-size: 28px; font-weight: 800;"><?php echo e(\App\Models\Product::count()); ?></h4>
                        </div>
                    </div>

                    <div style="background-color: #f8fafc; padding: 20px; border-radius: 12px; border: 1px solid #e2e8f0;">
                        <h4 style="font-weight: bold; margin-bottom: 15px;">Aksi Cepat:</h4>
                        <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                            <a href="<?php echo e(route('admin.products.create')); ?>" style="background-color: #ea580c; color: white; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-size: 14px; font-weight: bold;">+ Tambah Produk Baru</a>
                            <a href="<?php echo e(route('admin.categories.create')); ?>" style="background-color: #2563eb; color: white; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-size: 14px; font-weight: bold;">+ Tambah Kategori Baru</a>
                            <a href="/" target="_blank" style="background-color: #1e293b; color: white; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-size: 14px; font-weight: bold;">Lihat Toko Publik</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH D:\Praktikum_cms\resources\views/dashboard.blade.php ENDPATH**/ ?>