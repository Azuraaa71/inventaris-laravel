<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'kode_barang',
        'nama_barang',
        'harga',
        'stok',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}