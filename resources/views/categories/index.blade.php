@extends('layouts.app')
@section('title', 'Kategori Barang')
@section('breadcrumb', 'Kategori')
@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-3 mb-4"><div><div class="eyebrow">Pengaturan inventaris</div><h1 class="page-title">Kategori Barang</h1><p class="subtle mb-0">Kelompokkan barang agar lebih mudah ditemukan dan dikelola.</p></div><span class="badge-soft align-self-start align-self-md-auto"><i class="bi bi-collection me-1"></i>{{ $categories->count() }} kategori</span></div>
<div class="row g-4">
    <div class="col-12 col-lg-4"><div class="card p-4"><div class="stat-icon mb-3" style="background:#eef0ff;color:#5367e8"><i class="bi bi-folder-plus"></i></div><h5 class="fw-bold mb-1">Tambah Kategori</h5><p class="small subtle mb-4">Buat kategori baru untuk mengelompokkan inventaris.</p>
        @if($errors->any())<div class="alert alert-danger py-2 small">@foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach</div>@endif
        <form action="{{ route('categories.store') }}" method="POST">@csrf
            <label for="nama_kategori" class="form-label fw-semibold">Nama kategori <span class="text-danger">*</span></label>
            <input id="nama_kategori" type="text" name="nama_kategori" value="{{ old('nama_kategori') }}" class="form-control mb-3 @error('nama_kategori') is-invalid @enderror" placeholder="Contoh: Elektronik" required>
            @error('nama_kategori')<div class="invalid-feedback mb-2">{{ $message }}</div>@enderror
            <button class="btn btn-primary w-100"><i class="bi bi-plus-lg me-2"></i>Simpan Kategori</button>
        </form>
    </div></div>
    <div class="col-12 col-lg-8"><div class="card overflow-hidden"><div class="p-4 border-bottom" style="border-color:var(--line)!important"><h5 class="fw-bold mb-1">Daftar Kategori</h5><p class="small subtle mb-0">Kategori yang digunakan pada data barang.</p></div>
    <div class="table-responsive"><table class="table table-hover align-middle"><thead><tr><th class="ps-4">Kategori</th><th>Jumlah Barang</th><th class="text-end pe-4">Aksi</th></tr></thead><tbody>
    @forelse($categories as $category)
        <tr><td class="ps-4"><div class="d-flex align-items-center gap-3"><span class="item-icon"><i class="bi bi-folder2-open"></i></span><div class="fw-bold">{{ $category->nama_kategori }}</div></div></td><td><span class="badge-soft">{{ $category->products_count ?? $category->products()->count() }} barang</span></td><td class="text-end pe-4">
        <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#deleteCategory{{ $category->id }}" aria-label="Hapus kategori"><i class="bi bi-trash text-danger"></i></button>
        <div class="modal fade" id="deleteCategory{{ $category->id }}" tabindex="-1" aria-hidden="true"><div class="modal-dialog modal-dialog-centered"><div class="modal-content border-0 rounded-4 shadow"><div class="modal-body p-4 text-center"><div class="empty-icon mx-auto" style="background:#ffedf0;color:#d94a5b"><i class="bi bi-folder-x"></i></div><h5 class="fw-bold">Hapus kategori?</h5><p class="subtle">Kategori <strong>{{ $category->nama_kategori }}</strong> dan barang yang terkait dapat ikut terhapus.</p><div class="d-flex justify-content-center gap-2"><button class="btn btn-light" data-bs-dismiss="modal">Batal</button><form action="{{ route('categories.destroy', $category) }}" method="POST">@csrf @method('DELETE')<button class="btn btn-danger">Ya, hapus</button></form></div></div></div></div></div>
        </td></tr>
    @empty<tr><td colspan="3" class="text-center py-5"><div class="empty-icon"><i class="bi bi-folder2"></i></div><h6 class="fw-bold">Belum ada kategori</h6><p class="small subtle mb-0">Gunakan formulir untuk menambahkan kategori pertama.</p></td></tr>@endforelse
    </tbody></table></div></div></div>
</div>
@endsection
