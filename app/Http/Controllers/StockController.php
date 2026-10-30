<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class StockController extends Controller
{
    public function index(): View
    {
        $products = Product::query()->orderBy('nama_barang')->get();
        $movements = StockMovement::query()
            ->with(['product' => fn ($query) => $query->withTrashed(), 'user'])
            ->latest()->limit(100)->get();
        $monthStart = now()->startOfMonth();
        $totalMasukBulanIni = StockMovement::query()->where('jenis', 'masuk')->where('created_at', '>=', $monthStart)->sum('jumlah');
        $totalKeluarBulanIni = StockMovement::query()->where('jenis', 'keluar')->where('created_at', '>=', $monthStart)->sum('jumlah');
        $totalStokSaatIni = Product::query()->sum('stok');

        return view('stock.index', compact('products', 'movements', 'totalMasukBulanIni', 'totalKeluarBulanIni', 'totalStokSaatIni'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'jenis' => ['required', Rule::in(['masuk', 'keluar'])],
            'jumlah' => ['required', 'integer', 'min:1', 'max:2147483647'],
            'keterangan' => ['nullable', 'string', 'max:500'],
        ]);

        DB::transaction(function () use ($validated, $request): void {
            $product = Product::query()->lockForUpdate()->findOrFail($validated['product_id']);
            $stockBefore = (int) $product->stok;
            $quantity = (int) $validated['jumlah'];
            $stockAfter = $validated['jenis'] === 'masuk' ? $stockBefore + $quantity : $stockBefore - $quantity;
            if ($stockAfter < 0) {
                throw ValidationException::withMessages(['jumlah' => 'Stok tidak mencukupi. Stok tersedia saat ini: '.$stockBefore.'.']);
            }
            if ($stockAfter > 2147483647) {
                throw ValidationException::withMessages(['jumlah' => 'Jumlah transaksi melebihi kapasitas stok yang didukung.']);
            }

            $product->forceFill(['stok' => $stockAfter])->save();
            StockMovement::create([
                'product_id' => $product->id,
                'user_id' => $request->user()->id,
                'jenis' => $validated['jenis'],
                'jumlah' => $quantity,
                'stok_sebelum' => $stockBefore,
                'stok_sesudah' => $stockAfter,
                'keterangan' => $validated['keterangan'] ?? null,
            ]);
        }, 3);

        return redirect()->route('stock.index')->with('success', 'Transaksi stok berhasil disimpan.');
    }
}
