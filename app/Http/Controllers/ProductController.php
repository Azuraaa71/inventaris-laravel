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
        $query = Product::with('category')->latest();

        if (request('q')) {
            $term = request('q');
            $query->where(function ($builder) use ($term) {
                $builder->where('nama_barang', 'like', "%{$term}%")
                    ->orWhere('kode_barang', 'like', "%{$term}%")
                    ->orWhereHas('category', function ($categoryQuery) use ($term) {
                        $categoryQuery->where('nama_kategori', 'like', "%{$term}%");
                    });
            });
        }

        if (request('stok') === 'low') {
            $query->where('stok', '>', 0)->where('stok', '<=', 5);
        } elseif (request('stok') === 'empty') {
            $query->where('stok', '<=', 0);
        }

        $products = $query->paginate(8)->withQueryString();
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalUnits = Product::sum('stok');
        $lowStock = Product::where('stok', '>', 0)->where('stok', '<=', 5)->count();
        return view('products.index', compact('products', 'totalProducts', 'totalCategories', 'totalUnits', 'lowStock'));
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
            'category_id' => 'required|exists:categories,id',
            'kode_barang'  => 'required|unique:products',
            'nama_barang'  => 'required',
            'harga'        => 'required|numeric|min:0',
            'stok'         => 'required|integer|min:0',
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
            'category_id' => 'required|exists:categories,id',
            'kode_barang'  => 'required|unique:products,kode_barang,'.$product->id,
            'nama_barang'  => 'required',
            'harga'        => 'required|numeric|min:0',
            'stok'         => 'required|integer|min:0',
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