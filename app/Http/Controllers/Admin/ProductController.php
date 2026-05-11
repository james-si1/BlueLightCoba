<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Stock;
use App\Models\Category;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['supplier', 'category'])->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $suppliers = Supplier::all();
        $categories = Category::all();
        return view('admin.products.create', compact('suppliers', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required',
            'supplier_id' => 'required',
            'category_id' => 'required',
            'harga_modal' => 'required',
            'harga_jual' => 'required',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('products', 'public');
        }

        $product = Product::create($data);

        Stock::create([
            'product_id' => $product->id,
            'stok' => 0
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Berhasil tambah produk');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $suppliers = Supplier::all();
        $categories = Category::all();

        return view('admin.products.edit', compact('product', 'suppliers', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'nama_barang' => 'required',
            'supplier_id' => 'required',
            'category_id' => 'required',
            'harga_modal' => 'required',
            'harga_jual' => 'required',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Berhasil update');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        Stock::where('product_id', $product->id)->delete();

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Berhasil hapus');
    }
}
