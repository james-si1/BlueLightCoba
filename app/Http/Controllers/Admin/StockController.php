<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\StockLog;

class StockController extends Controller
{
    public function index()
    {
        $stocks = Stock::with('product')->get();
        return view('admin.stocks.index', compact('stocks'));
    }

    public function updateStock(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'tipe' => 'required|in:masuk,keluar',
            'jumlah' => 'required|integer|min:1',
        ]);

        $stock = Stock::firstOrCreate(
            ['product_id' => $request->product_id],
            ['stok' => 0]
        );

        if ($request->tipe === 'masuk') {
            $stock->stok += $request->jumlah;
        } else {
            if ($stock->stok < $request->jumlah) {
                return back()->with('error', 'Stok tidak cukup untuk dikurangi.');
            }

            $stock->stok -= $request->jumlah;
        }

        $stock->save();

        StockLog::create([
            'product_id' => $request->product_id,
            'tipe' => $request->tipe,
            'jumlah' => $request->jumlah,
            'tanggal' => now(),
            'keterangan' => 'Offline/Manual',
        ]);

        return back()->with('success', 'Stok berhasil diupdate dan tercatat sebagai Offline/Manual.');
    }
}
