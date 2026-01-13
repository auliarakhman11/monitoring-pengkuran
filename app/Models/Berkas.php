<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berkas extends Model
{
    use HasFactory;

    protected $table = 'berkas';
    protected $fillable = ['proses_id', 'urutan', 'permohonan_id', 'no_sistem', 'no_berkas', 'tahun', 'kelurahan', 'alamat', 'nm_pemohon', 'kuasa', 'no_tlp', 'tgl', 'tgl_pengukuran', 'ket', 'user_id', 'void', 'file_name', 'jenis_file', 'kendala', 'jml_bidang'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function proses()
    {
        return $this->belongsTo(Proses::class, 'proses_id', 'id');
    }

    public function pengukuran()
    {
        return $this->hasMany(Pengukuran::class, 'berkas_id', 'id')->where('pengukuran.void', 0);
    }

    public function history()
    {
        return $this->hasMany(History::class, 'berkas_id', 'id');
    }

    public function uploadFile()
    {
        return $this->hasMany(UploadFile::class, 'berkas_id', 'id');
    }

    public function permohonan()
    {
        return $this->belongsTo(Permohonan::class, 'permohonan_id', 'id');
    }
}
