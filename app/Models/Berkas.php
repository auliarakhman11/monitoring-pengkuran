<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berkas extends Model
{
    use HasFactory;

    protected $table = 'berkas';
    protected $fillable = ['proses_id', 'no_berkas', 'tahun', 'kelurahan', 'alamat', 'nm_pemohon', 'no_tlp', 'tgl', 'tgl_pengukuran', 'ket', 'user_id', 'void', 'file_name', 'jenis_file'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function pengukuran()
    {
        return $this->hasMany(Pengukuran::class, 'berkas_id', 'id')->where('pengukuran.void',0);
    }

    public function history()
    {
        return $this->hasMany(History::class, 'berkas_id', 'id');
    }
}
