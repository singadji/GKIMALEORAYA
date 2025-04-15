<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Support\Facades\DB;


class GroupWilayah extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'group_wilayah';
    protected $primaryKey = 'id_group_wilayah';
    public $timestamps = true;
    protected $fillable = [
        'nama_group_wilayah',
        'kecamatan',
        'kelurahan',
        'koor_group_wilayah'
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