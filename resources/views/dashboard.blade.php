<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- ===== STATISTIK RINGKASAN ===== --}}
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px;">

                <div style="background-color: #eff6ff; border-left: 4px solid #2563eb; padding: 20px; border-radius: 8px;">
                    <p style="color: #1e40af; font-size: 13px; font-weight: bold; margin-bottom: 5px; letter-spacing: 0.05em;">TOTAL KATEGORI</p>
                    <h4 style="font-size: 28px; font-weight: 800;">{{ \App\Models\Category::count() }}</h4>
                </div>

                <div style="background-color: #fff7ed; border-left: 4px solid #ea580c; padding: 20px; border-radius: 8px;">
                    <p style="color: #9a3412; font-size: 13px; font-weight: bold; margin-bottom: 5px; letter-spacing: 0.05em;">TOTAL PRODUK</p>
                    <h4 style="font-size: 28px; font-weight: 800;">{{ \App\Models\Product::count() }}</h4>
                </div>

                <div style="background-color: #f0fdf4; border-left: 4px solid #16a34a; padding: 20px; border-radius: 8px;">
                    <p style="color: #15803d; font-size: 13px; font-weight: bold; margin-bottom: 5px; letter-spacing: 0.05em;">TOTAL PESANAN</p>
                    <h4 style="font-size: 28px; font-weight: 800;">{{ \App\Models\Order::count() }}</h4>
                </div>

                <div style="background-color: #fefce8; border-left: 4px solid #ca8a04; padding: 20px; border-radius: 8px;">
                    <p style="color: #a16207; font-size: 13px; font-weight: bold; margin-bottom: 5px; letter-spacing: 0.05em;">MENUNGGU DIPROSES</p>
                    <h4 style="font-size: 28px; font-weight: 800;">{{ \App\Models\Order::where('status','pending')->count() }}</h4>
                </div>
            </div>

            {{-- ===== AKSI CEPAT ===== --}}
            <div style="background-color: #f8fafc; padding: 20px; border-radius: 12px; border: 1px solid #e2e8f0; margin-bottom: 30px;">
                <h4 style="font-weight: bold; margin-bottom: 15px;">Aksi Cepat:</h4>
                <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                    <a href="{{ route('admin.products.create') }}" style="background-color: #ea580c; color: white; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-size: 14px; font-weight: bold;">+ Tambah Produk</a>
                    <a href="{{ route('admin.categories.create') }}" style="background-color: #2563eb; color: white; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-size: 14px; font-weight: bold;">+ Tambah Kategori</a>
                    <a href="{{ route('admin.orders.index') }}" style="background-color: #16a34a; color: white; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-size: 14px; font-weight: bold;">📋 Lihat Semua Pesanan</a>
                    <a href="/" target="_blank" style="background-color: #1e293b; color: white; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-size: 14px; font-weight: bold;">🌐 Lihat Toko Publik</a>
                </div>
            </div>

            {{-- ===== PESANAN TERBARU ===== --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                    <h3 style="font-size: 16px; font-weight: 700; color: #111827;">Pesanan Pelanggan Terbaru</h3>
                    <a href="{{ route('admin.orders.index') }}" style="color: #2563eb; font-size: 13px; font-weight: 600; text-decoration: none;">Lihat Semua →</a>
                </div>

                @php
                    $recentOrders = \App\Models\Order::with('items')->latest()->take(8)->get();
                @endphp

                @if($recentOrders->isEmpty())
                    <div style="text-align: center; padding: 40px 0; color: #9ca3af;">
                        <p style="font-size: 14px;">Belum ada pesanan masuk.</p>
                        <p style="font-size: 12px; margin-top: 4px;">Pesanan dari pelanggan akan muncul di sini setelah mereka checkout.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200" style="font-size: 14px;">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-widest">Kode Pesanan</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-widest">Nama Pelanggan</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-widest">Barang</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-widest">Total</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-widest">Status</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-widest">Waktu</th>
                                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-widest">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @foreach($recentOrders as $order)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-4 py-3 font-bold text-indigo-700">{{ $order->order_code }}</td>
                                        <td class="px-4 py-3 text-gray-900">
                                            {{ $order->customer_name }}
                                            <div style="font-size: 12px; color: #9ca3af;">{{ $order->customer_email }}</div>
                                        </td>
                                        <td class="px-4 py-3 text-gray-600">
                                            {{-- Daftar nama barang --}}
                                            @foreach($order->items as $item)
                                                <div style="font-size: 13px;">
                                                    {{ $item->product_name }}
                                                    <span style="color: #9ca3af;">×{{ $item->quantity }}</span>
                                                </div>
                                            @endforeach
                                        </td>
                                        <td class="px-4 py-3 font-semibold text-gray-900">
                                            Rp {{ number_format($order->total, 0, ',', '.') }}
                                        </td>
                                        <td class="px-4 py-3">
                                            <span style="
                                                background-color: {{ $order->status_color }}22;
                                                color: {{ $order->status_color }};
                                                border: 1px solid {{ $order->status_color }}55;
                                                padding: 2px 10px;
                                                border-radius: 999px;
                                                font-size: 12px;
                                                font-weight: 600;
                                                white-space: nowrap;
                                            ">{{ $order->status_label }}</span>
                                        </td>
                                        <td class="px-4 py-3 text-gray-500" style="font-size: 12px;">
                                            {{ $order->created_at->diffForHumans() }}
                                        </td>
                                        <td class="px-4 py-3 text-right">
                                            <a href="{{ route('admin.orders.show', $order) }}"
                                               style="background-color: #2563eb; color: white; padding: 4px 12px; border-radius: 6px; text-decoration: none; font-size: 12px; font-weight: 600;">
                                                Detail
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
