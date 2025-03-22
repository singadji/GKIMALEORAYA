<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterKomoditas extends Model
{
    use HasFactory;

    protected $tableName = "master_komoditas";

    public function kategori_komoditas()
    {
        return $this->belongsTo(KategoriKomoditas::class, 'id_kategori_komoditas');
    }

    public function harga_pangan()
    {
        return $this->hasMany(HargaPangan::class, 'id_komoditas');
    }
}
