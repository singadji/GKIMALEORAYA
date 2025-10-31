<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Support\Facades\DB;


class Jemaat extends Model
{
    use HasFactory, SoftDeletes;

    use HasFactory;

    protected $table = 'jemaat'; // Nama tabel di database
    protected $primaryKey = 'id_jemaat'; // Primary Key

    public $timestamps = true; // Aktifkan timestamps jika ada created_at dan updated_at

    protected $fillable = [
        'nia', 
        'nama_jemaat', 
        'gender', 
        'telepon', 
        'asal_gereja',
        'tanggal_terdaftar', 
        'tempat_lahir', 
        'tanggal_lahir', 
        'tanggal_baptis',
        'tanggal_sidi', 
        'tanggal_nikah', 
        'status_aktif', 
        'status_menikah',
        'keterangan'
    ];

    // Hubungan langsung ke KK Jemaat (jika jemaat adalah kepala keluarga)
    public function kkJemaat()
    {
        return $this->hasOne(KkJemaat::class, 'id_jemaat', 'id_jemaat');
    }

    // Hubungan melalui HubunganKeluarga untuk mendapatkan KK Jemaat (jika jemaat bukan kepala keluarga)
    public function hubunganKeluarga()
    {
        return $this->hasOne(HubunganKeluarga::class, 'id_jemaat', 'id_jemaat');
    }

    public function atestasiJemaat()
    {
        return $this->hasOne(Atestasi::class, 'id_jemaat', 'id_jemaat');
    }

    public function atestasiJemaatKeluar()
    {
        return $this->hasOne(Atestasi::class, 'id_jemaat', 'id_jemaat')->where('keluar', 1);
    }
   
    public function pindahJemaat()
    {
        return $this->hasOne(PindahGereja::class, 'id_jemaat', 'id_jemaat');
    }
    
    public function pindahJemaatKeluar()
    {
        return $this->hasOne(PindahGereja::class, 'id_jemaat', 'id_jemaat')->where('ke', 1  );
    }

    public function meninggalJemaat()
    {
        return $this->hasOne(MeninggalDunia::class, 'id_jemaat', 'id_jemaat');
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