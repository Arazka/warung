<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $table = 'penjualans';
    protected $fillable = [
        'item_id','kuantiti','total_harga','waktu_penjualan'
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
