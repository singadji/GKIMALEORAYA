<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Support\Facades\DB;


class PindahGereja extends Model
{
    use HasFactory, SoftDeletes;

    use HasFactory;

    protected $table = 'pindah_gereja'; 
    protected $primaryKey = 'id_pindah_gereja';
    public $timestamps = true; 
    protected $fillable = ['id_jemaat', 'tanggal', 'dari', 'ke', 'gereja', 'setuju'];

    public function jemaatPindah()
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