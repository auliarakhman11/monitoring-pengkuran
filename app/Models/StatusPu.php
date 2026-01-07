<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusPu extends Model
{
    use HasFactory;

    protected $table = 'status_pu';
    protected $fillable = ['petugas_id','tgl','status'];

    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id', 'id');
    }

}
