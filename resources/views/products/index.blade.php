@extends('layouts.app')

@section('title', 'Daftar Produk · Inventaris Gudang')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">
    <div>
        <h1 class="h3 mb-1">Daftar Inventaris Barang</h1>
        <p class="text-muted mb-0">Pantau produk, kategori, harga, dan jumlah stok saat ini.</p>
    </div>
    @if (auth()->user()->isAdmin())
        <a href="{{ route('products.create') }}" class="btn btn-primary">+ Tambah Produk</a>
    @endif
</div>
<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-3">Kode</th><th>Nama Barang</th><th>Kategori</th>
                    <th class="text-end">Harga</th><th class="text-center">Stok Akhir</th>
                    @if (auth()->user()->isAdmin()) <th class="text-end pe-3">Aksi</th> @endif
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr>
                        <td class="ps-3 fw-semibold">{{ $product->kode_barang }}</td>
                        <td>{{ $product->nama_barang }}</td>
                        <td><span class="badge text-bg-light border">{{ $product->category->nama_kategori ?? '-' }}</span></td>
                        <td class="text-end">Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                        <td class="text-center">
                            <span class="badge {{ $product->stok > 0 ? 'text-bg-success' : 'text-bg-secondary' }}">
                                {{ number_format($product->stok, 0, ',', '.') }}
                            </span>
                        </td>
                        @if (auth()->user()->isAdmin())
                            <td class="text-end pe-3">
                                <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Arsipkan produk ini? Stok harus nol.')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" type="submit">Arsipkan</button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr><td colspan="{{ auth()->user()->isAdmin() ? 6 : 5 }}" class="text-center text-muted py-5">
                        Belum ada produk. Admin dapat menambahkan produk melalui tombol Tambah Produk.
                    </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
