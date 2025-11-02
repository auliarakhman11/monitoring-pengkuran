<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Harga extends Model
{
    use HasFactory;

    protected $table = 'harga';
    protected $fillable = ['produk_id','delivery_id','harga'];

    public function delivery()
    {
        return $this->belongsTo(Delivery::class,'delivery_id','id');
    }
}
