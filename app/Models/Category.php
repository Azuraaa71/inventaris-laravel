<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = ['nama_kategori'];

    public function products(): HasMany
    {
        // Produk yang diarsipkan tetap memiliki relasi untuk menjaga audit transaksi.
        return $this->hasMany(Product::class)->withTrashed();
    }
}
