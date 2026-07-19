<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modul extends Model
{
    use HasFactory;

    protected $table = 'moduls';
    protected $primaryKey = 'id_modul';
    public $timestamps = true;
    protected $fillable = [
        'nama_modul',
        'link_modul',
        'publish',
        'aktif',
        'role',
        'icon',
        'par',
        'role_id',
        'slug',
        'folder',
    ];

    public function parent()
    {
        return $this->belongsTo(Modul::class, 'par', 'id_modul');
    }

    public function children()
    {
        return $this->hasMany(Modul::class, 'par', 'id_modul');
    }

    public static function tree()
    {
        return static::with(implode('.', array_fill(0, 10, 'children')))
            ->where('par', 0)
            ->orderBy('id_modul')
            ->get();
    }
}
