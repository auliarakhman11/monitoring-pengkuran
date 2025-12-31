<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    protected $table = 'history';
    protected $fillable = ['berkas_id', 'proses_id', 'user_id', 'selesai'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }


}
