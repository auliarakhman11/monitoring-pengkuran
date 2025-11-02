<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;
    protected $table = 'karyawan';
    protected $fillable = ['nama', 'status', 'no_tlp', 'alamat', 'tgl_masuk', 'cabang_id', 'gapok', 'aktif', 'possition'];

    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'cabang_id', 'id');
    }
}
