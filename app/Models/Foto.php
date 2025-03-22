<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Support\Facades\DB;


class Foto extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'fotos';
    protected $primaryKey = 'id_foto';
    public $timestamps = true;
    protected $fillable = [
        'id_album',
        'id_user',
        'judul_foto',
        'foto'
    ];

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