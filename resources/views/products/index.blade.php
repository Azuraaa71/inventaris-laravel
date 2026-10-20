@extends('layouts.app')
@section('title', 'Daftar Barang')
@section('breadcrumb', 'Ringkasan & Barang')
@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-3 mb-4">
    <div><div class="eyebrow">Workspace / Inventaris</div><h1 class="page-title">Daftar Inventaris Barang</h1><p class="subtle mb-0">Pantau dan kelola seluruh barang dengan lebih mudah.</p></div>
    <a href="{{ route('products.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-2"></i>Tambah Barang</a>
</div>
<div class="row g-3 mb-4">
    <div class="col-12 col-sm-6 col-xl-3"><div class="card stat-card"><div class="d-flex justify-content-between align-items-start mb-3"><span class="stat-label">Total jenis barang</span><span class="stat-icon" style="background:#eef0ff;color:#5367e8"><i class="bi bi-box-seam"></i></span></div><div class="stat-value">{{ number_format($totalProducts) }}</div><div class="small subtle mt-2">Item terdaftar</div></div></div>
    <div class="col-12 col-sm-6 col-xl-3"><div class="card stat-card"><div class="d-flex justify-content-between align-items-start mb-3"><span class="stat-label">Total kategori</span><span class="stat-icon" style="background:#e8f8f0;color:#239765"><i class="bi bi-collection"></i></span></div><div class="stat-value">{{ number_format($totalCategories) }}</div><div class="small subtle mt-2">Kelompok barang</div></div></div>
    <div class="col-12 col-sm-6 col-xl-3"><div class="card stat-card"><div class="d-flex justify-content-between align-items-start mb-3"><span class="stat-label">Total unit stok</span><span class="stat-icon" style="background:#fff3e5;color:#d88724"><i class="bi bi-stack"></i></span></div><div class="stat-value">{{ number_format($totalUnits) }}</div><div class="small subtle mt-2">Akumulasi semua stok</div></div></div>
    <div class="col-12 col-sm-6 col-xl-3"><div class="card stat-card"><div class="d-flex justify-content-between align-items-start mb-3"><span class="stat-label">Stok menipis</span><span class="stat-icon" style="background:#ffedf0;color:#d94a5b"><i class="bi bi-exclamation-triangle"></i></span></div><div class="stat-value">{{ number_format($lowStock) }}</div><div class="small subtle mt-2">Barang dengan stok ≤ 5</div></div></div>
</div>
<div class="card overflow-hidden">
    <div class="p-3 p-lg-4 border-bottom" style="border-color:var(--line)!important">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
            <div><h5 class="fw-bold mb-1">Semua Barang</h5><div class="small subtle">Data inventaris yang tersimpan di sistem</div></div>
            <form action="{{ route('products.index') }}" method="GET" class="d-flex flex-column flex-sm-row gap-2">
                <div class="input-group"><span class="input-group-text bg-white border-end-0" style="border-color:#e5e9f2;border-radius:10px 0 0 10px"><i class="bi bi-search subtle"></i></span><input type="search" name="q" value="{{ request('q') }}" class="form-control border-start-0" placeholder="Cari barang, kode..." aria-label="Cari barang" style="min-width:190px;border-radius:0 10px 10px 0"></div>
                <select name="stok" class="form-select" style="min-width:145px" aria-label="Filter stok"><option value="">Semua stok</option><option value="low" @selected(request('stok') === 'low')>Stok menipis</option><option value="empty" @selected(request('stok') === 'empty')>Stok habis</option></select>
                <button class="btn btn-light" type="submit">Filter</button>
                @if(request('q') || request('stok'))<a href="{{ route('products.index') }}" class="btn btn-light" title="Reset filter"><i class="bi bi-arrow-counterclockwise"></i></a>@endif
            </form>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead><tr><th class="ps-4">Barang</th><th>Kode</th><th>Kategori</th><th>Harga</th><th>Stok</th><th class="text-end pe-4">Aksi</th></tr></thead>
            <tbody>
            @forelse($products as $product)
                <tr>
                    <td class="ps-4"><div class="d-flex align-items-center gap-3"><span class="item-icon"><i class="bi bi-box2"></i></span><div><div class="fw-bold">{{ $product->nama_barang }}</div><div class="small subtle">ID #{{ $product->id }}</div></div></div></td>
                    <td><span class="small fw-semibold text-secondary">{{ $product->kode_barang }}</span></td>
                    <td><span class="badge-soft">{{ $product->category->nama_kategori ?? 'Tanpa kategori' }}</span></td>
                    <td class="fw-semibold text-nowrap">Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                    <td>@if($product->stok <= 0)<span class="badge badge-empty">Habis</span>@elseif($product->stok <= 5)<span class="badge badge-low">{{ $product->stok }} unit · Menipis</span>@else<span class="badge badge-stock">{{ $product->stok }} unit</span>@endif</td>
                    <td class="text-end pe-4"><div class="dropdown"><button class="btn btn-light btn-sm" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Aksi barang"><i class="bi bi-three-dots"></i></button><ul class="dropdown-menu dropdown-menu-end"><li><a class="dropdown-item" href="{{ route('products.edit', $product) }}"><i class="bi bi-pencil me-2 text-primary"></i>Edit barang</a></li><li><button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#deleteProduct{{ $product->id }}"><i class="bi bi-trash me-2"></i>Hapus barang</button></li></ul></div>
                        <div class="modal fade" id="deleteProduct{{ $product->id }}" tabindex="-1" aria-labelledby="deleteLabel{{ $product->id }}" aria-hidden="true"><div class="modal-dialog modal-dialog-centered"><div class="modal-content border-0 rounded-4 shadow"><div class="modal-body p-4 text-center"><div class="empty-icon mx-auto" style="background:#ffedf0;color:#d94a5b"><i class="bi bi-trash3"></i></div><h5 class="fw-bold" id="deleteLabel{{ $product->id }}">Hapus barang ini?</h5><p class="subtle">Barang <strong>{{ $product->nama_barang }}</strong> akan dihapus dari inventaris.</p><div class="d-flex justify-content-center gap-2"><button class="btn btn-light" data-bs-dismiss="modal">Batal</button><form action="{{ route('products.destroy', $product) }}" method="POST">@csrf @method('DELETE')<button class="btn btn-danger"><i class="bi bi-trash me-1"></i>Ya, hapus</button></form></div></div></div></div></div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center py-5"><div class="empty-icon"><i class="bi bi-inbox"></i></div><h6 class="fw-bold">{{ request('q') || request('stok') ? 'Data tidak ditemukan' : 'Belum ada barang' }}</h6><p class="subtle small mb-3">{{ request('q') || request('stok') ? 'Coba ubah kata kunci atau filter stok.' : 'Mulai dengan menambahkan barang pertama ke inventaris.' }}</p>@if(!request('q') && !request('stok'))<a href="{{ route('products.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i>Tambah barang</a>@endif</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($products->hasPages() || $products->total() > 0)<div class="d-flex flex-column flex-sm-row align-items-center justify-content-between gap-3 px-4 py-3 border-top"><div class="small subtle">Menampilkan <strong>{{ $products->firstItem() ?? 0 }}–{{ $products->lastItem() ?? 0 }}</strong> dari <strong>{{ $products->total() }}</strong> barang</div>{{ $products->links('pagination::bootstrap-5') }}</div>@endif
</div>
@endsection
