<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;

    protected $table = 'pembelians';
    protected $fillable = [
        'item_id','kuantiti','total_harga','waktu_pembelian'
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
