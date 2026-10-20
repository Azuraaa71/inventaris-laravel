<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // READ: Menampilkan daftar produk
    public function index()
    {
        $products = Product::with('category')->latest()->get();
        return view('products.index', compact('products'));
    }

    // CREATE (Form): Menampilkan form tambah produk
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    // CREATE (Store): Menyimpan data ke database
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required',
            'kode_barang'  => 'required|unique:products',
            'nama_barang'  => 'required',
            'harga'        => 'required|numeric',
            'stok'         => 'required|integer',
        ]);

        Product::create($validated);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    // EDIT (Form): Menampilkan form edit produk
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    // UPDATE: Memperbarui data produk
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => 'required',
            'kode_barang'  => 'required|unique:products,kode_barang,'.$product->id,
            'nama_barang'  => 'required',
            'harga'        => 'required|numeric',
            'stok'         => 'required|integer',
        ]);

        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Data produk berhasil diperbarui!');
    }

    // DELETE: Menghapus data produk
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus!');
    }
}