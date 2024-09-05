<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemKategori extends Model
{
    use HasFactory;

    protected $table = 'item_kategoris';
    protected $fillable = [
        'nama_kategori'
    ];

    public function item()
    {
        return $this->hasMany(Item::class);
    }
}
