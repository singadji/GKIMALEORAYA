<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterKelurahan extends Model
{
    use HasFactory;

    protected $tableName = "master_kelurahans";
    protected $primaryKey = 'id_kelurahan';
    protected $fillable = [
        'id_kecamatan',
        'kelurahan',
    ];
}
