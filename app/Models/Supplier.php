<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'nama_supplier',
        'email',
        'no_telp',
        'alamat'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
