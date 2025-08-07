<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Support\Facades\DB;


class MeninggalDunia extends Model
{
    use HasFactory, SoftDeletes;

    use HasFactory;

    protected $table = 'meninggal_dunia'; 
    protected $primaryKey = 'id_meninggal_dunia';
    public $timestamps = true; 
    protected $fillable = ['id_jemaat', 'tanggal', 'alamat'];

    public function jemaatMeninggaal()
    {
        return $this->belongsTo(Jemaat::class, 'id_jemaat', 'id_jemaat');
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