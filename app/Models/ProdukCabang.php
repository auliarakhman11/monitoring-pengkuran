<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukCabang extends Model
{
    use HasFactory;

    protected $table = 'produk_cabang';
    protected $fillable = ['produk_id', 'cabang_id'];
}
