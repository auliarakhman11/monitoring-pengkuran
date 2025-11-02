<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bahan extends Model
{
    use HasFactory;

    protected $table = 'bahan';

    protected $fillable = ['bahan', 'satuan_id', 'jenis', 'aktif', 'jenis_bahan_id', 'possition'];

    public function satuan()
    {
        return $this->belongsTo(Satuan::class, 'satuan_id', 'id');
    }
    public function jenisBahan()
    {
        return $this->belongsTo(JenisBahan::class, 'jenis_bahan_id', 'id');
    }
}
