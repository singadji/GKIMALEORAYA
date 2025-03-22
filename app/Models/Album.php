<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Support\Facades\DB;

class Album extends Model
{
    use HasFactory, SoftDeletes;
  
    protected $table = 'albums';
    protected $primaryKey = 'id_album';
    public $timestamps = true;
    protected $fillable = [
        'nama_album',
        'keterangan',
        'publish',
        'slug'
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

    public static function getIda() {

        $query = Album::select('*')
                    ->orderby('id_album', 'DESC')
                    ->limit(1)
                    ->first();
        return $query;
	
	}
}
