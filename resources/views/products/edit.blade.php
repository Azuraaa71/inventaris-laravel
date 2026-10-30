@extends('layouts.app')

@section('title', 'Edit Produk · Inventaris Gudang')

@section('content')
<div class="card border-0 shadow-sm p-4 col-lg-8 mx-auto">
    <div class="mb-4">
        <h1 class="h3 mb-1">Edit Data Produk</h1>
        <p class="text-muted mb-0">Stok tidak dapat diedit dari formulir ini. Gunakan transaksi masuk atau keluar.</p>
    </div>
    @if ($errors->any())
        <div class="alert alert-danger"><ul class="mb-0">
            @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul></div>
    @endif
    <form action="{{ route('products.update', $product) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="category_id" class="form-label">Kategori</label>
            <select id="category_id" name="category_id" class="form-select" required>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>{{ $category->nama_kategori }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="kode_barang" class="form-label">Kode Barang</label>
            <input id="kode_barang" type="text" name="kode_barang"
                value="{{ old('kode_barang', $product->kode_barang) }}" class="form-control" maxlength="100" required>
        </div>
        <div class="mb-3">
            <label for="nama_barang" class="form-label">Nama Barang</label>
            <input id="nama_barang" type="text" name="nama_barang"
                value="{{ old('nama_barang', $product->nama_barang) }}" class="form-control" maxlength="255" required>
        </div>
        <div class="mb-4">
            <label for="harga" class="form-label">Harga (Rp)</label>
            <input id="harga" type="number" name="harga"
                value="{{ old('harga', $product->harga) }}" class="form-control" min="0" step="1" required>
        </div>
        <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
        <a href="{{ route('products.index') }}" class="btn btn-light">Batal</a>
    </form>
</div>
@endsection
