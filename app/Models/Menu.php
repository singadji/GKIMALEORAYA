<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = "menus";
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_parent',
        'nama_menu',
        'link_menu',
        'slug',
        'isi_menu',
        'posisi',
        'publish',
        'gambar',
        'dokumen',
        'video',
        'highlight',
        'uuid',
    ];
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'uuid'
            ]
        ];
    }
    
    public function parent()
        {
            return $this->hasOne('App\Models\menu', 'id', 'id_parent')->where('publish', 'Y')->orderBy('posisi');
        }

        public function children()
        {
            return $this->hasMany('App\Models\menu', 'id_parent', 'id')->where('publish', 'Y')->orderBy('posisi');
        }

        public static function tree()
        {
            return static::with(implode('.', array_fill(0, 100, 'children')))->where('id_parent', '=', '0')->where('publish', 'Y')->orderBy('posisi')->get();
        }

    public static function getHighlight(){
        $query = menu::select('*')
            ->where('highlight','Y')
            ->get();
        return $query;
    }

    public static function getMenu() {

        $query = menu::select('*')
            ->where('publish','Y')
            ->orderBy('posisi')
            ->get();
        return $query;
        
    }

}
