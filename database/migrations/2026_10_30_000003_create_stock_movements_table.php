<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_movements', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('product_id')->constrained()->restrictOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('jenis', 10);
            $table->unsignedInteger('jumlah');
            $table->unsignedInteger('stok_sebelum');
            $table->unsignedInteger('stok_sesudah');
            $table->string('keterangan', 500)->nullable();
            $table->timestamps();
            $table->index(['product_id', 'created_at']);
            $table->index(['user_id', 'created_at']);
        });

        // Saldo lama dicatat secara terpisah agar tidak dihitung sebagai pembelian bulan ini.
        $now = now();
        DB::table('products')->where('stok', '>', 0)->orderBy('id')->chunkById(500, function ($products) use ($now): void {
            $rows = [];
            foreach ($products as $product) {
                $rows[] = [
                    'product_id' => $product->id,
                    'user_id' => null,
                    'jenis' => 'saldo_awal',
                    'jumlah' => $product->stok,
                    'stok_sebelum' => 0,
                    'stok_sesudah' => $product->stok,
                    'keterangan' => 'Saldo awal saat aktivasi pencatatan mutasi stok',
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
            DB::table('stock_movements')->insert($rows);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};
