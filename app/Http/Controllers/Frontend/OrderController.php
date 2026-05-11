<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Stock;
use App\Models\StockLog;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function products(Request $request)
    {
        $query = Product::with(['stock', 'category']);

        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('nama_kategori', $request->category);
            });
        }

        $products = $query->get();

        return view('frontend.products', compact('products'));
    }

    public function addToCart(Request $request)
    {
        $product = \App\Models\Product::with('stock')->findOrFail($request->product_id);

        $stok = $product->stock->stok ?? 0;
        $jumlahBaru = (int) $request->jumlah;

        $cart = session()->get('cart', []);

        $jumlahLama = isset($cart[$product->id]) ? $cart[$product->id]['jumlah'] : 0;
        $totalJumlah = $jumlahLama + $jumlahBaru;

        if ($stok <= 0) {
            return back()->with('error', 'Stok produk sedang habis.');
        }

        if ($totalJumlah > $stok) {
            return back()->with('error', 'Stok tidak cukup. Stok tersedia hanya ' . $stok . ' item.');
        }

        if (isset($cart[$product->id])) {
            $cart[$product->id]['jumlah'] = $totalJumlah;
            $cart[$product->id]['subtotal'] = $cart[$product->id]['harga'] * $totalJumlah;
        } else {
            $cart[$product->id] = [
                'product_id' => $product->id,
                'nama_barang' => $product->nama_barang,
                'harga' => $product->harga_jual,
                'jumlah' => $jumlahBaru,
                'subtotal' => $product->harga_jual * $jumlahBaru,
                'foto' => $product->foto,
            ];
        }

        session()->put('cart', $cart);

        if ($request->query('redirect') === 'checkout') {
            return redirect()->route('checkout.index');
        }

        return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function cart()
    {
        $cart = session()->get('cart', []);
        $cartItems = [];
        $total = 0;

        foreach ($cart as $item) {
            $product = Product::find($item['product_id']);

            if ($product) {
                $subtotal = $product->harga_jual * $item['jumlah'];

                $cartItems[] = [
                    'product_id' => $product->id,
                    'nama_barang' => $product->nama_barang,
                    'harga' => $product->harga_jual,
                    'jumlah' => $item['jumlah'],
                    'subtotal' => $subtotal,
                    'foto' => $product->foto,
                ];

                $total += $subtotal;
            }
        }

        return view('frontend.cart', compact('cartItems', 'total'));
    }

    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);
        $selectedItems = $request->selected_items ?? [];

        if (empty($selectedItems)) {
            return redirect()->route('cart.index')->with('error', 'Pilih produk terlebih dahulu.');
        }

        $cartItems = [];
        $total = 0;

        foreach ($selectedItems as $productId) {
            if (!isset($cart[$productId])) {
                continue;
            }

            $product = \App\Models\Product::find($productId);

            if (!$product) {
                continue;
            }

            $jumlah = $cart[$productId]['jumlah'] ?? 1;
            $harga = $product->harga_jual;
            $subtotal = $harga * $jumlah;

            $cartItems[$productId] = [
                'product_id' => $productId,
                'nama_barang' => $product->nama_barang,
                'foto' => $product->foto,
                'harga' => $harga,
                'jumlah' => $jumlah,
                'subtotal' => $subtotal,
            ];

            $total += $subtotal;
        }

        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'Produk yang dipilih tidak ditemukan.');
        }

        session()->put('checkout_items', $cartItems);
        session()->put('checkout_total', $total);

        return view('frontend.checkout', compact('cartItems', 'total'));
    }

    public function processCheckout(Request $request)
    {
        $request->validate([
            'nama_customer' => 'required|string|max:255',
            'bukti_pembayaran' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        DB::beginTransaction();

        try {
            $cart = session('checkout_items', []);

            if (empty($cart)) {
                throw new \Exception('Keranjang kosong');
            }

            $path = null;

            if ($request->hasFile('bukti_pembayaran')) {
                $path = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');
            }

            $order = Order::create([
                'user_id' => auth()->id(),
                'nama_customer' => $request->nama_customer,
                'status' => 'menunggu',
                'bukti_pembayaran' => $path,
            ]);

            foreach ($cart as $item) {
                $product = Product::find($item['product_id']);
                $stock = Stock::where('product_id', $product->id)->first();

                if (!$stock || $stock->stok < $item['jumlah']) {
                    throw new \Exception('Stok tidak cukup');
                }

                $stock->stok -= $item['jumlah'];
                $stock->save();

                StockLog::create([
                    'product_id' => $product->id,
                    'tipe' => 'keluar',
                    'jumlah' => $item['jumlah'],
                    'tanggal' => now(),
                ]);

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'jumlah' => $item['jumlah'],
                    'harga' => $product->harga_jual,
                ]);
            }

            $cartSession = session()->get('cart', []);

            foreach ($cart as $item) {
                unset($cartSession[$item['product_id']]);
            }

            session()->put('cart', $cartSession);
            session()->forget('checkout_items');
            session()->forget('checkout_total');

            DB::commit();

            return redirect()->route('checkout.success')->with('success', 'Pesanan berhasil dibuat');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function myOrders()
    {
        $orders = Order::with(['items.product'])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('frontend.my-orders', compact('orders'));
    }

    public function myOrderDetail($id)
    {
        $order = Order::with(['items.product'])
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        return view('frontend.my-order-detail', compact('order'));
    }

    public function removeFromCart($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Produk berhasil dihapus dari keranjang');
    }

    public function updateCart(Request $request, $id)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['jumlah'] = $request->jumlah;
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Jumlah produk berhasil diupdate');
    }

    public function increaseCart($id)
    {
        $cart = session()->get('cart', []);

        if (!isset($cart[$id])) {
            return back()->with('error', 'Produk tidak ditemukan di keranjang.');
        }

        $product = \App\Models\Product::with('stock')->findOrFail($id);
        $stok = $product->stock->stok ?? 0;

        if ($cart[$id]['jumlah'] >= $stok) {
            return back()->with('error', 'Stok tidak cukup. Stok tersedia hanya ' . $stok . ' item.');
        }

        $cart[$id]['jumlah']++;
        $cart[$id]['subtotal'] = $cart[$id]['jumlah'] * $cart[$id]['harga'];

        session()->put('cart', $cart);

        return back()->with('success', 'Jumlah produk berhasil ditambah.');
    }

    public function decreaseCart($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            if ($cart[$id]['jumlah'] > 1) {
                $cart[$id]['jumlah'] -= 1;
                session()->put('cart', $cart);
            } else {
                unset($cart[$id]);
                session()->put('cart', $cart);
            }
        }

        return redirect()->route('cart.index');
    }

    public function productDetail($id)
    {
        $product = \App\Models\Product::with(['category', 'stock'])->findOrFail($id);

        return view('frontend.detail', compact('product'));
    }
}
