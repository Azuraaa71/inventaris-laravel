@extends('layouts.app')

@section('title', 'Kategori · Inventaris Gudang')

@section('content')
<div class="mb-3">
    <h1 class="h3 mb-1">Kategori Barang</h1>
    <p class="text-muted mb-0">Kategori membantu mengelompokkan produk inventaris.</p>
</div>
<div class="row g-4">
    @if (auth()->user()->isAdmin())
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm p-3">
                <h2 class="h5 mb-3">Tambah Kategori</h2>
                @if ($errors->any())
                    <div class="alert alert-danger"><ul class="mb-0">
                        @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                    </ul></div>
                @endif
                <form action="{{ route('categories.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nama_kategori" class="form-label">Nama Kategori</label>
                        <input id="nama_kategori" type="text" name="nama_kategori"
                            value="{{ old('nama_kategori') }}" class="form-control"
                            maxlength="100" placeholder="Contoh: Elektronik" required>
                    </div>
                    <button class="btn btn-primary w-100" type="submit">Simpan Kategori</button>
                </form>
            </div>
        </div>
    @endif
    <div class="{{ auth()->user()->isAdmin() ? 'col-lg-8' : 'col-12' }}">
        <div class="card border-0 shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr><th class="ps-3">#</th><th>Nama Kategori</th><th class="text-center">Jumlah Produk</th>
                            @if (auth()->user()->isAdmin()) <th class="text-end pe-3">Aksi</th> @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $index => $category)
                            <tr>
                                <td class="ps-3">{{ $index + 1 }}</td>
                                <td class="fw-semibold">{{ $category->nama_kategori }}</td>
                                <td class="text-center">{{ $category->products_count }}</td>
                                @if (auth()->user()->isAdmin())
                                    <td class="text-end pe-3">
                                        <form action="{{ route('categories.destroy', $category) }}" method="POST"
                                            onsubmit="return confirm('Hapus kategori ini? Kategori yang masih dipakai tidak dapat dihapus.')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger" type="submit">Hapus</button>
                                        </form>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr><td colspan="{{ auth()->user()->isAdmin() ? 4 : 3 }}" class="text-center text-muted py-5">Belum ada kategori barang.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
