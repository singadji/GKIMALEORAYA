<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Support\Facades\DB;


class Berita extends Model
{
    use HasFactory, SoftDeletes;

    use HasFactory;

    protected $table = 'beritas';
    protected $primaryKey = 'id_berita';
    public $timestamps = true;
    protected $fillable = [
        'id_kategori',
        'id_user',
        'tanggal',
        'judul',
        'isi',
        'gambar',
        'publish',
        'isslider',
        'baca',
        'created_at',
        'updated_at',
        'slug',
        'deleted_at',
        'created_by',
        'updated_by',
        'link_youtube',
        'uuid',
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

        // static::deleting(function ($model) {
        //     $model->updated_by = Auth::id();
        //     $model->save();
        // });
    }

    public static function getAll() {
        $sql = Berita::select('*')
            ->join('kategoriberitas', 'kategoriberitas.id_kategori', '=', 'beritas.id_kategori')
            ->join('users', 'users.id', '=', 'beritas.id_user')
            ->orderBy('beritas.id_berita', 'desc')
            ->get();
        return $sql;
    }

    public static function getArt() {
        $sql = Berita::select('*')
            ->join('kategoriberitas', 'kategoriberitas.id_kategori', '=', 'beritas.id_kategori')
            ->join('users', 'users.id', '=', 'beritas.id_user')
            ->where('publish','1')
            ->orderBy('id_berita', 'desc')
            ->paginate(6);
            //->get();

        return $sql;
    }

    public static function getArtB() {

        $sql = Berita::select('*')
            ->join('kategoriberitas', 'kategoriberitas.id_kategori', '=', 'beritas.id_kategori')
            ->join('users', 'users.id', '=', 'beritas.id_user')
            ->where('publish', '1')
            ->inRandomOrder() // Randomizes the order
            ->limit(6)
            ->get();

return $sql;
    }
}