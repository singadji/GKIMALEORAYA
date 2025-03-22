<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterKecamatan extends Model
{
    use HasFactory;

    protected $tableName = "master_kecamatans";
    protected $primaryKey = 'id_kecamatan';
    protected $fillable = [
        'id_kota_kabupaten',
        'kecamatan',
    ];
}
