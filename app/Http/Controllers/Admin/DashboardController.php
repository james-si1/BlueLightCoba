<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Stock;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProduk = Product::count();
        $totalSupplier = Supplier::count();
        $totalPesanan = Order::count();
        $totalStok = Stock::sum('stok');

        $totalPendapatan = OrderItem::selectRaw('SUM(jumlah * harga) as total')
            ->value('total') ?? 0;

        return view('admin.dashboard', compact(
            'totalProduk',
            'totalSupplier',
            'totalPesanan',
            'totalStok',
            'totalPendapatan'
        ));
    }

    public function __construct()
    {
        $this->middleware(['auth', 'role:admin,pegawai']);
    }
}
