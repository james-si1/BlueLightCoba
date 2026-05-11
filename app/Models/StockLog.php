<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'tipe',
        'jumlah',
        'tanggal',
        'keterangan',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
