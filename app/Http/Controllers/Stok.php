<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    use HasFactory;

    protected $table = 'stok';
    protected $fillable = ['kode', 'invoice_id', 'penjualan_id', 'produk_id', 'cabang_id', 'delivery_id', 'bahan_id', 'qty', 'harga', 'tgl', 'admin', 'transaksi', 'jenis', 'void', 'tutup'];

    public function bahan()
    {
        return $this->belongsTo(Bahan::class, 'bahan_id', 'id');
    }

    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'cabang_id', 'id');
    }
}
