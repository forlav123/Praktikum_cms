<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Pesanan — {{ $order->order_code }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Info Pelanggan --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-base font-bold text-gray-900 mb-4 border-b pb-2">Informasi Pelanggan</h3>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-3 text-sm">
                    <div>
                        <dt class="text-gray-500 font-medium">Nama</dt>
                        <dd class="text-gray-900">{{ $order->customer_name }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500 font-medium">Email</dt>
                        <dd class="text-gray-900">{{ $order->customer_email }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500 font-medium">No. Telepon</dt>
                        <dd class="text-gray-900">{{ $order->customer_phone }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500 font-medium">Metode Pembayaran</dt>
                        <dd class="text-gray-900 capitalize">{{ $order->payment_method }}</dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="text-gray-500 font-medium">Alamat Pengiriman</dt>
                        <dd class="text-gray-900">{{ $order->shipping_address }}, {{ $order->city }}, {{ $order->zip_code }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500 font-medium">Tanggal Pesanan</dt>
                        <dd class="text-gray-900">{{ $order->created_at->format('d F Y, H:i') }} WIB</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500 font-medium">Status Saat Ini</dt>
                        <dd>
                            <span style="
                                background-color: {{ $order->status_color }}22;
                                color: {{ $order->status_color }};
                                border: 1px solid {{ $order->status_color }}55;
                                padding: 3px 12px;
                                border-radius: 999px;
                                font-size: 13px;
                                font-weight: 600;
                            ">
                                {{ $order->status_label }}
                            </span>
                        </dd>
                    </div>
                </dl>
            </div>

            {{-- Daftar Barang --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-base font-bold text-gray-900 mb-4 border-b pb-2">Barang yang Dipesan</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase text-xs">Produk</th>
                                <th class="px-4 py-3 text-center font-medium text-gray-500 uppercase text-xs">Qty</th>
                                <th class="px-4 py-3 text-right font-medium text-gray-500 uppercase text-xs">Harga Satuan</th>
                                <th class="px-4 py-3 text-right font-medium text-gray-500 uppercase text-xs">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($order->items as $item)
                                <tr>
                                    <td class="px-4 py-3 text-gray-900 font-medium">{{ $item->product_name }}</td>
                                    <td class="px-4 py-3 text-center text-gray-600">{{ $item->quantity }}</td>
                                    <td class="px-4 py-3 text-right text-gray-600">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-right text-gray-900 font-semibold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50">
                            <tr>
                                <td colspan="3" class="px-4 py-2 text-right text-xs text-gray-500">Subtotal Produk</td>
                                <td class="px-4 py-2 text-right font-semibold text-gray-800">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="px-4 py-2 text-right text-xs text-gray-500">PPN (11%)</td>
                                <td class="px-4 py-2 text-right text-gray-800">Rp {{ number_format($order->tax, 0, ',', '.') }}</td>
                            </tr>
                            <tr class="border-t-2 border-gray-300">
                                <td colspan="3" class="px-4 py-3 text-right font-bold text-gray-900">Total Pembayaran</td>
                                <td class="px-4 py-3 text-right font-bold text-indigo-700 text-base">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            {{-- Update Status --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-base font-bold text-gray-900 mb-4 border-b pb-2">Update Status Pesanan</h3>
                <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="flex items-center gap-4">
                    @csrf
                    @method('PATCH')
                    <select name="status" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        @foreach(['pending' => 'Menunggu', 'processing' => 'Diproses', 'shipped' => 'Dikirim', 'completed' => 'Selesai', 'cancelled' => 'Dibatalkan'] as $value => $label)
                            <option value="{{ $value }}" {{ $order->status === $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit"
                            style="background-color: #2563eb; color: white; padding: 8px 20px; border-radius: 8px; border: none; cursor: pointer; font-weight: 600; font-size: 14px;">
                        Simpan Status
                    </button>
                    <a href="{{ route('admin.orders.index') }}"
                       style="color: #6b7280; text-decoration: none; font-size: 14px;">
                        ← Kembali ke Daftar
                    </a>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
