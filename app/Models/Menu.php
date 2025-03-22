<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Support\Facades\DB;


class Menu extends Model
{
    use HasFactory, SoftDeletes;

    use HasFactory;

    protected $table = 'menus';
    protected $primaryKey = 'id_menu';
    public $timestamps = true;
    protected $fillable = [
        'id_menu',
        'id_parent',
        'nama_menu',
        'link_menu',
        'isi_menu',
        'posisi',
        'publish',
        'gambar',
        'dokumen',
        'video',
        'highlight',
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
    
    public function parent()
        {
            return $this->hasOne('App\Models\Menu', 'id_menu', 'id_parent')->where('publish', 'Y')->orderBy('posisi');
        }

        public function children()
        {
            return $this->hasMany('App\Models\Menu', 'id_parent', 'id_menu')->where('publish', 'Y')->orderBy('posisi');
        }

        public static function tree()
        {
            return static::with(implode('.', array_fill(0, 100, 'children')))->where('id_parent', '=', '0')->where('publish', 'Y')->orderBy('posisi')->get();
        }

    public static function getHighlight(){
        $query = Menu::select('*')
            ->where('highlight','Y')
            ->get();
        return $query;
    }

    public static function getMenu() {

        $query = Menu::select('*')
            ->where('publish','Y')
            ->orderBy('posisi')
            ->get();
        return $query;
        
    }

}
