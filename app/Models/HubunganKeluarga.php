<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Support\Facades\DB;


class HubunganKeluarga extends Model
{
    use HasFactory, SoftDeletes;

    use HasFactory;

    protected $table = 'hubungan_keluarga'; // Nama tabel di database
    protected $primaryKey = 'id_hub_kel'; // Primary Key

    public $timestamps = true; // Aktifkan timestamps jika ada created_at dan updated_at

    protected $fillable = ['id_kk_jemaat', 'id_jemaat', 'hubungan_keluarga'];

    // Hubungan ke KK Jemaat
    public function kkJemaat()
    {
        return $this->belongsTo(KkJemaat::class, 'id_kk_jemaat', 'id_kk_jemaat');
    }

    public function jemaat()
    {
        return $this->belongsTo(Jemaat::class, 'id_jemaat', 'id_jemaat');
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