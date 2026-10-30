<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        $products = Product::query()->with('category')->orderBy('nama_barang')->get();
        return view('products.index', compact('products'));
    }

    public function create(): View
    {
        $categories = Category::query()->orderBy('nama_kategori')->get();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'kode_barang' => ['required', 'string', 'max:100', 'unique:products,kode_barang'],
            'nama_barang' => ['required', 'string', 'max:255'],
            'harga' => ['required', 'integer', 'min:0'],
        ]);

        Product::create($validated);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan. Catat stok awal melalui transaksi stok.');
    }

    public function edit(Product $product): View
    {
        $categories = Category::query()->orderBy('nama_kategori')->get();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'kode_barang' => ['required', 'string', 'max:100', Rule::unique('products', 'kode_barang')->ignore($product->id)],
            'nama_barang' => ['required', 'string', 'max:255'],
            'harga' => ['required', 'integer', 'min:0'],
        ]);

        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Data produk berhasil diperbarui.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        if ((int) $product->stok !== 0) {
            return back()->withErrors(['product' => 'Produk hanya dapat diarsipkan ketika stoknya sudah nol.']);
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produk berhasil diarsipkan.');
    }
}
