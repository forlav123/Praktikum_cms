<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Menyimpan pesanan baru dari halaman checkout.
     */
    public function store(Request $request)
    {
        // Lepas session lock secepat mungkin agar tidak memblok request lain
        session()->save();

        try {
            $request->validate([
                'customer_name'    => 'required|string|max:255',
                'customer_email'   => 'required|email|max:255',
                'customer_phone'   => 'required|string|max:50',
                'shipping_address' => 'required|string',
                'city'             => 'required|string|max:100',
                'zip_code'         => 'required|string|max:20',
                'payment_method'   => 'required|string',
                'items'            => 'required|array|min:1',
                'items.*.product_name' => 'required|string',
                'items.*.quantity'     => 'required|integer|min:1',
                'items.*.price'        => 'required|numeric|min:0',
            ]);

            // Hitung total
            $subtotal = 0;
            foreach ($request->items as $item) {
                $subtotal += $item['price'] * $item['quantity'];
            }
            $tax   = round($subtotal * 0.11);
            $total = $subtotal + $tax;

            // Buat kode pesanan unik
            $orderCode = 'ORD-' . strtoupper(Str::random(8));

            // Simpan order ke database
            $order = Order::create([
                'order_code'       => $orderCode,
                'user_id'          => auth()->id(),
                'customer_name'    => $request->customer_name,
                'customer_email'   => $request->customer_email,
                'customer_phone'   => $request->customer_phone,
                'shipping_address' => $request->shipping_address,
                'city'             => $request->city,
                'zip_code'         => $request->zip_code,
                'payment_method'   => $request->payment_method,
                'subtotal'         => $subtotal,
                'tax'              => $tax,
                'total'            => $total,
                'status'           => 'pending',
            ]);

            // Simpan item pesanan
            foreach ($request->items as $item) {
                OrderItem::create([
                    'order_id'     => $order->id,
                    'product_id'   => $item['product_id'] ?? null,
                    'product_name' => $item['product_name'],
                    'quantity'     => $item['quantity'],
                    'price'        => $item['price'],
                    'subtotal'     => $item['price'] * $item['quantity'],
                ]);
            }

            return response()->json([
                'success'    => true,
                'order_code' => $orderCode,
                'message'    => 'Pesanan berhasil disimpan!',
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid.',
                'errors'  => $e->errors(),
            ], 422);

        } catch (\Exception $e) {
            \Log::error('Order store error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan server: ' . $e->getMessage(),
            ], 500);
        }
    }
}
