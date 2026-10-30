@extends('layouts.app')

@section('title', 'Mutasi Stok · Inventaris Gudang')

@section('content')
<div class="mb-4">
    <h1 class="h3 mb-1">Transaksi dan Mutasi Stok</h1>
    <p class="text-muted mb-0">Barang masuk dan keluar memperbarui stok secara otomatis dan tercatat pada riwayat.</p>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-3 h-100">
            <div class="small text-muted">Total stok akhir saat ini</div>
            <div class="display-6 fw-semibold">{{ number_format($totalStokSaatIni, 0, ',', '.') }}</div>
            <div class="small text-muted">Akumulasi semua produk aktif</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-3 h-100">
            <div class="small text-muted">Barang masuk bulan ini</div>
            <div class="display-6 fw-semibold text-success">+{{ number_format($totalMasukBulanIni, 0, ',', '.') }}</div>
            <div class="small text-muted">{{ now()->translatedFormat('F Y') }}</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-3 h-100">
            <div class="small text-muted">Barang keluar bulan ini</div>
            <div class="display-6 fw-semibold text-warning">−{{ number_format($totalKeluarBulanIni, 0, ',', '.') }}</div>
            <div class="small text-muted">{{ now()->translatedFormat('F Y') }}</div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm p-3">
            <h2 class="h5 mb-3">Catat Transaksi</h2>
            @if ($errors->any())
                <div class="alert alert-danger"><ul class="mb-0">
                    @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul></div>
            @endif
            <form action="{{ route('stock.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="product_id" class="form-label">Produk</label>
                    <select id="product_id" name="product_id" class="form-select" required>
                        <option value="">-- Pilih Produk --</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}" @selected(old('product_id') == $product->id)>
                                {{ $product->kode_barang }} · {{ $product->nama_barang }} (stok: {{ $product->stok }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="jenis" class="form-label">Jenis Transaksi</label>
                    <select id="jenis" name="jenis" class="form-select" required>
                        <option value="masuk" @selected(old('jenis', 'masuk') === 'masuk')>Barang Masuk</option>
                        <option value="keluar" @selected(old('jenis') === 'keluar')>Barang Keluar</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="jumlah" class="form-label">Jumlah Barang</label>
                    <input id="jumlah" type="number" name="jumlah" value="{{ old('jumlah') }}"
                        class="form-control" min="1" max="2147483647" step="1" required>
                </div>
                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan (opsional)</label>
                    <textarea id="keterangan" name="keterangan" class="form-control" rows="3" maxlength="500"
                        placeholder="Contoh: Pembelian dari pemasok">{{ old('keterangan') }}</textarea>
                </div>
                <button class="btn btn-primary w-100" type="submit" @disabled($products->isEmpty())>Simpan Transaksi</button>
                @if ($products->isEmpty())
                    <p class="small text-muted mt-2 mb-0">Tambahkan produk terlebih dahulu sebelum mencatat stok.</p>
                @endif
            </form>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="d-flex flex-wrap justify-content-between align-items-center p-3 border-bottom">
                <h2 class="h5 mb-0">Riwayat Mutasi Stok</h2>
                <span class="small text-muted">100 transaksi terbaru</span>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr><th class="ps-3">Waktu</th><th>Produk</th><th>Jenis</th>
                            <th class="text-end">Jumlah</th><th>Stok Sebelum → Sesudah</th><th>Petugas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($movements as $movement)
                            <tr>
                                <td class="ps-3 text-nowrap small">{{ $movement->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <div class="fw-semibold">{{ $movement->product?->nama_barang ?? 'Produk tidak tersedia' }}</div>
                                    <div class="small text-muted">{{ $movement->product?->kode_barang ?? '-' }}</div>
                                    @if ($movement->product?->trashed()) <span class="badge text-bg-secondary">Diarsipkan</span> @endif
                                    @if ($movement->keterangan) <div class="small text-muted">{{ $movement->keterangan }}</div> @endif
                                </td>
                                <td>
                                    @php
                                        $movementLabel = match ($movement->jenis) {
                                            'masuk' => 'Masuk',
                                            'keluar' => 'Keluar',
                                            default => 'Saldo Awal',
                                        };
                                        $movementColor = match ($movement->jenis) {
                                            'masuk' => 'text-bg-success',
                                            'keluar' => 'text-bg-warning',
                                            default => 'text-bg-secondary',
                                        };
                                    @endphp
                                    <span class="badge {{ $movementColor }}">{{ $movementLabel }}</span>
                                </td>
                                <td class="text-end fw-semibold">{{ number_format($movement->jumlah, 0, ',', '.') }}</td>
                                <td class="text-nowrap">{{ number_format($movement->stok_sebelum, 0, ',', '.') }} → {{ number_format($movement->stok_sesudah, 0, ',', '.') }}</td>
                                <td class="text-nowrap small">{{ $movement->user?->name ?? 'Sistem / saldo awal' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center text-muted py-5">Belum ada transaksi stok.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
