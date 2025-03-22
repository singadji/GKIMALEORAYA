<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Support\Facades\DB;


class KategoriBerita extends Model
{
    use HasFactory, SoftDeletes;

    use HasFactory;

    protected $table = 'kategoriberitas';
    protected $primaryKey = 'id_kategori';
    public $timestamps = true;
    protected $fillable = [
        'nama_kategori',
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