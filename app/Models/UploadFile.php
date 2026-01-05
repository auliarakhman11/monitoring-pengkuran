<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UploadFile extends Model
{
    use HasFactory;

    protected $table = 'upload_file';
    protected $fillable = ['berkas_id', 'nm_file', 'file_name', 'jenis_file'];
}
