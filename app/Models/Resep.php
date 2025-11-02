<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resep extends Model
{
    use HasFactory;

    protected $table = 'resep';
    
    protected $fillable = ['produk_id','bahan_id','takaran'];

    public function bahan()
    {
        return $this->belongsTo(Bahan::class,'bahan_id','id');
    }

    public function hargaBahan()
    {
        return $this->hasMany(HargaBahan::class,'bahan_id','bahan_id');
    }

}
