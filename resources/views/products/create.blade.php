@extends('layouts.app')

@section('title', 'Tambah Produk · Inventaris Gudang')

@section('content')
<div class="card border-0 shadow-sm p-4 col-lg-8 mx-auto">
    <div class="mb-4">
        <h1 class="h3 mb-1">Tambah Produk Baru</h1>
        <p class="text-muted mb-0">Produk baru dimulai dengan stok nol. Catat stok awal melalui menu Mutasi Stok.</p>
    </div>
    @if ($errors->any())
        <div class="alert alert-danger"><ul class="mb-0">
            @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul></div>
    @endif
    <form action="{{ route('products.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="category_id" class="form-label">Kategori</label>
            <select id="category_id" name="category_id" class="form-select" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->nama_kategori }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="kode_barang" class="form-label">Kode Barang</label>
            <input id="kode_barang" type="text" name="kode_barang" value="{{ old('kode_barang') }}"
                class="form-control" maxlength="100" placeholder="Contoh: BRG-001" required>
        </div>
        <div class="mb-3">
            <label for="nama_barang" class="form-label">Nama Barang</label>
            <input id="nama_barang" type="text" name="nama_barang" value="{{ old('nama_barang') }}"
                class="form-control" maxlength="255" placeholder="Contoh: Laptop Asus" required>
        </div>
        <div class="mb-4">
            <label for="harga" class="form-label">Harga (Rp)</label>
            <input id="harga" type="number" name="harga" value="{{ old('harga') }}"
                class="form-control" min="0" step="1" placeholder="100000" required>
        </div>
        <button class="btn btn-primary" type="submit">Simpan Produk</button>
        <a href="{{ route('products.index') }}" class="btn btn-light">Batal</a>
    </form>
</div>
@endsection
