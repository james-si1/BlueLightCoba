<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Stock;
use App\Models\StockLog;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['items.product', 'user'])->latest()->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:menunggu,diproses,siap diambil,selesai,dibatalkan',
        ]);

        $order = Order::with('items.product')->findOrFail($id);
        $statusLama = $order->status;
        $statusBaru = $request->status;

        if ($statusLama === 'selesai' && $statusBaru === 'dibatalkan') {
            return redirect()->route('admin.orders.index')
                ->with('error', 'Pesanan yang sudah selesai tidak dapat dibatalkan.');
        }

        DB::beginTransaction();

        try {
            if ($statusBaru === 'siap diambil' && !$order->kode_pengambilan) {
                $order->kode_pengambilan = 'BLUELIGHT-' . rand(1000, 9999);
            }

            if ($statusBaru === 'dibatalkan' && $statusLama !== 'dibatalkan') {
                foreach ($order->items as $item) {
                    $stock = Stock::firstOrCreate(
                        ['product_id' => $item->product_id],
                        ['stok' => 0]
                    );

                    $stock->stok += $item->jumlah;
                    $stock->save();

                    StockLog::create([
                        'product_id' => $item->product_id,
                        'tipe' => 'masuk',
                        'jumlah' => $item->jumlah,
                        'tanggal' => now(),
                        'keterangan' => 'Pengembalian stok dari pesanan dibatalkan',
                    ]);
                }
            }

            $order->status = $statusBaru;
            $order->save();

            DB::commit();

            return redirect()->route('admin.orders.index')
                ->with('success', 'Status pesanan berhasil diupdate');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('admin.orders.index')
                ->with('error', 'Gagal update status: ' . $e->getMessage());
        }
    }

    private function hitungLaporan($ordersQuery, $orderItemsQuery)
    {
        $totalPesanan = (clone $ordersQuery)->count();
        $totalBarang = (clone $orderItemsQuery)->sum('jumlah');

        $totalPendapatan = (clone $orderItemsQuery)
            ->selectRaw('SUM(jumlah * harga) as total')
            ->value('total') ?? 0;

        $items = (clone $orderItemsQuery)->get();

        $totalKeuntungan = 0;

        foreach ($items as $item) {
            $modal = $item->product->harga_modal ?? 0;
            $jual = $item->harga ?? 0;
            $totalKeuntungan += ($jual - $modal) * $item->jumlah;
        }

        return compact(
            'totalPesanan',
            'totalBarang',
            'totalPendapatan',
            'totalKeuntungan'
        );
    }

    private function ordersDetail($ordersQuery)
    {
        return (clone $ordersQuery)
            ->with(['items.product', 'user'])
            ->latest()
            ->get();
    }

    private function stockLogsByDate($tanggal)
    {
        return StockLog::with('product')
            ->where('tipe', 'keluar')
            ->where('keterangan', 'Offline/Manual')
            ->whereDate('tanggal', $tanggal)
            ->latest()
            ->get();
    }

    private function stockLogsByRange($start, $end)
    {
        return StockLog::with('product')
            ->where('tipe', 'keluar')
            ->where('keterangan', 'Offline/Manual')
            ->whereBetween('tanggal', [$start, $end])
            ->latest()
            ->get();
    }

    private function stockLogsByMonth($year, $month)
    {
        return StockLog::with('product')
            ->where('tipe', 'keluar')
            ->where('keterangan', 'Offline/Manual')
            ->whereYear('tanggal', $year)
            ->whereMonth('tanggal', $month)
            ->latest()
            ->get();
    }

    private function stockLogsByYear($year)
    {
        return StockLog::with('product')
            ->where('tipe', 'keluar')
            ->where('keterangan', 'Offline/Manual')
            ->whereYear('tanggal', $year)
            ->latest()
            ->get();
    }

    public function print($id)
    {
        $order = Order::with(['items.product', 'user'])->findOrFail($id);

        return view('admin.orders.print', compact('order'));
    }

    public function destroy($id)
    {
        $order = Order::with('items')->findOrFail($id);

        DB::beginTransaction();

        try {
            $order->items()->delete();
            $order->delete();

            DB::commit();

            return redirect()->route('admin.orders.index')
                ->with('success', 'Pesanan berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('admin.orders.index')
                ->with('error', 'Gagal menghapus pesanan: ' . $e->getMessage());
        }
    }

    public function laporanHarian(Request $request)
    {
        $tanggal = $request->tanggal ?? now()->format('Y-m-d');

        $ordersQuery = Order::whereDate('created_at', $tanggal);
        $orderItemsQuery = OrderItem::with('product')->whereDate('created_at', $tanggal);

        $data = $this->hitungLaporan($ordersQuery, $orderItemsQuery);
        $orders = $this->ordersDetail($ordersQuery);
        $stockLogs = $this->stockLogsByDate($tanggal);

        return view('admin.laporan.harian', array_merge($data, [
            'tanggal' => $tanggal,
            'orders' => $orders,
            'stockLogs' => $stockLogs,
        ]));
    }

    public function laporanMingguan(Request $request)
    {
        $minggu = $request->minggu ?? now()->format('Y-\WW');

        [$year, $week] = explode('-W', $minggu);

        $startOfWeek = Carbon::now()
            ->setISODate((int) $year, (int) $week)
            ->startOfWeek();

        $endOfWeek = Carbon::now()
            ->setISODate((int) $year, (int) $week)
            ->endOfWeek();

        $ordersQuery = Order::whereBetween('created_at', [$startOfWeek, $endOfWeek]);
        $orderItemsQuery = OrderItem::with('product')->whereBetween('created_at', [$startOfWeek, $endOfWeek]);

        $data = $this->hitungLaporan($ordersQuery, $orderItemsQuery);
        $orders = $this->ordersDetail($ordersQuery);
        $stockLogs = $this->stockLogsByRange($startOfWeek, $endOfWeek);

        return view('admin.laporan.mingguan', array_merge($data, [
            'minggu' => $minggu,
            'orders' => $orders,
            'stockLogs' => $stockLogs,
        ]));
    }

    public function laporanBulanan(Request $request)
    {
        $bulan = $request->bulan ?? now()->format('Y-m');

        [$year, $month] = explode('-', $bulan);

        $ordersQuery = Order::whereYear('created_at', $year)
            ->whereMonth('created_at', $month);

        $orderItemsQuery = OrderItem::with('product')
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month);

        $data = $this->hitungLaporan($ordersQuery, $orderItemsQuery);
        $orders = $this->ordersDetail($ordersQuery);
        $stockLogs = $this->stockLogsByMonth($year, $month);

        return view('admin.laporan.bulanan', array_merge($data, [
            'bulan' => $bulan,
            'orders' => $orders,
            'stockLogs' => $stockLogs,
        ]));
    }

    public function laporanTahunan(Request $request)
    {
        $tahun = $request->tahun ?? now()->format('Y');

        $ordersQuery = Order::whereYear('created_at', $tahun);
        $orderItemsQuery = OrderItem::with('product')->whereYear('created_at', $tahun);

        $data = $this->hitungLaporan($ordersQuery, $orderItemsQuery);
        $orders = $this->ordersDetail($ordersQuery);
        $stockLogs = $this->stockLogsByYear($tahun);

        return view('admin.laporan.tahunan', array_merge($data, [
            'tahun' => $tahun,
            'orders' => $orders,
            'stockLogs' => $stockLogs,
        ]));
    }

    public function laporanHarianPdf(Request $request)
    {
        $tanggal = $request->tanggal ?? now()->format('Y-m-d');

        $ordersQuery = Order::whereDate('created_at', $tanggal);
        $orderItemsQuery = OrderItem::with('product')->whereDate('created_at', $tanggal);

        $data = $this->hitungLaporan($ordersQuery, $orderItemsQuery);
        $orders = $this->ordersDetail($ordersQuery);
        $stockLogs = $this->stockLogsByDate($tanggal);

        $pdf = Pdf::loadView('admin.laporan.pdf', array_merge($data, [
            'judul' => 'Laporan Penjualan Harian',
            'periode' => $tanggal,
            'orders' => $orders,
            'stockLogs' => $stockLogs,
        ]));

        return $pdf->download('laporan-harian-' . $tanggal . '.pdf');
    }

    public function laporanMingguanPdf(Request $request)
    {
        $minggu = $request->minggu ?? now()->format('Y-\WW');

        [$year, $week] = explode('-W', $minggu);

        $startOfWeek = Carbon::now()
            ->setISODate((int) $year, (int) $week)
            ->startOfWeek();

        $endOfWeek = Carbon::now()
            ->setISODate((int) $year, (int) $week)
            ->endOfWeek();

        $ordersQuery = Order::whereBetween('created_at', [$startOfWeek, $endOfWeek]);
        $orderItemsQuery = OrderItem::with('product')->whereBetween('created_at', [$startOfWeek, $endOfWeek]);

        $data = $this->hitungLaporan($ordersQuery, $orderItemsQuery);
        $orders = $this->ordersDetail($ordersQuery);
        $stockLogs = $this->stockLogsByRange($startOfWeek, $endOfWeek);

        $pdf = Pdf::loadView('admin.laporan.pdf', array_merge($data, [
            'judul' => 'Laporan Penjualan Mingguan',
            'periode' => $minggu,
            'orders' => $orders,
            'stockLogs' => $stockLogs,
        ]));

        return $pdf->download('laporan-mingguan-' . $minggu . '.pdf');
    }

    public function laporanBulananPdf(Request $request)
    {
        $bulan = $request->bulan ?? now()->format('Y-m');

        [$year, $month] = explode('-', $bulan);

        $ordersQuery = Order::whereYear('created_at', $year)
            ->whereMonth('created_at', $month);

        $orderItemsQuery = OrderItem::with('product')
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month);

        $data = $this->hitungLaporan($ordersQuery, $orderItemsQuery);
        $orders = $this->ordersDetail($ordersQuery);
        $stockLogs = $this->stockLogsByMonth($year, $month);

        $pdf = Pdf::loadView('admin.laporan.pdf', array_merge($data, [
            'judul' => 'Laporan Penjualan Bulanan',
            'periode' => $bulan,
            'orders' => $orders,
            'stockLogs' => $stockLogs,
        ]));

        return $pdf->download('laporan-bulanan-' . $bulan . '.pdf');
    }

    public function laporanTahunanPdf(Request $request)
    {
        $tahun = $request->tahun ?? now()->format('Y');

        $ordersQuery = Order::whereYear('created_at', $tahun);
        $orderItemsQuery = OrderItem::with('product')->whereYear('created_at', $tahun);

        $data = $this->hitungLaporan($ordersQuery, $orderItemsQuery);
        $orders = $this->ordersDetail($ordersQuery);
        $stockLogs = $this->stockLogsByYear($tahun);

        $pdf = Pdf::loadView('admin.laporan.pdf', array_merge($data, [
            'judul' => 'Laporan Penjualan Tahunan',
            'periode' => $tahun,
            'orders' => $orders,
            'stockLogs' => $stockLogs,
        ]));

        return $pdf->download('laporan-tahunan-' . $tahun . '.pdf');
    }
}
