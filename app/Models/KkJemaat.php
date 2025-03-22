<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Support\Facades\DB;


class KkJemaat extends Model
{
    use HasFactory, SoftDeletes;

    use HasFactory;

    protected $table = 'kk_jemaat'; // Nama tabel di database
    protected $primaryKey = 'id_jemaat'; // Primary Key

    public $timestamps = true; // Aktifkan timestamps jika ada created_at dan updated_at

    protected $fillable = ['id_group_wilayah', 'id_jemaat', 'alamat'];

    // Kepala keluarga
    public function jemaatKK()
    {
        return $this->belongsTo(Jemaat::class, 'id_jemaat', 'id_jemaat');
    }

    // Hubungan ke hubungan keluarga
    public function anggotaKeluarga()
    {
        return $this->hasMany(HubunganKeluarga::class, 'id_kk_jemaat', 'id_kk_jemaat');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->updated_by = Auth::id();
        });

        static::updating(function ($model) {
            $model->updated_by = Auth::id();
        });

        static::deleting(function ($model) {
            $model->updated_by = Auth::id();
            $model->save();
        });
    }
}