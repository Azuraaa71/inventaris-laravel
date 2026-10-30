<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Normalisasi saldo lama agar tidak ada stok negatif saat aturan baru aktif.
        DB::table('products')->where('stok', '<', 0)->update(['stok' => 0]);

        Schema::table('products', function (Blueprint $table): void {
            $table->integer('stok')->default(0)->change();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table): void {
            $table->dropSoftDeletes();
            $table->integer('stok')->default(null)->change();
        });
    }
};
