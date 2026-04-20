<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    public $timestamps = true; // FIX
    protected $table = "produk";
    protected $guarded = ['id'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class); // FIX
    }

    public function fotoProduk()
    {
        return $this->hasMany(FotoProduk::class, 'produk_id'); // RELASI YANG COCOK
    }
}
