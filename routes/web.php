<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Web\MenuController;
use App\Http\Controllers\Web\ArtikelController;
use App\Http\Controllers\Web\KategoriArtikelController;
use App\Http\Controllers\Web\IdentitasWebController;
use App\Http\Controllers\Web\FotoController;
use App\Http\Controllers\Web\VideoController;
use App\Http\Controllers\Web\ManajemenUserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Administrasi\JemaatController;
use App\Http\Controllers\Auth\MfaController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\WilayahController;
  
Route::get('/', function () {
    return view('template');
});
//require __DIR__.'/auth.php';

Route::get('/', [MainController::class, 'index'])->name('index.get');
Route::post('/', [MainController::class, 'index'])->name('index.post');
Route::get('/login', function () { return view('login');});
Route::get('berita-kegiatan', [PageController::class, 'news'])->name('news');
Route::get('berita-kegiatan/{id}', [PageController::class, 'baca'])->name('baca');
Route::get('foto', [PageController::class, 'foto'])->name('foto');
Route::get('video', [PageController::class, 'video'])->name('video');
Route::get('{link_menu}', [PageController::class, 'detail'])->name('detail');

Auth::routes();
Route::middleware('auth')->group(function () {
    Route::get('/mfa/enable', [MfaController::class, 'enableMfa'])->name('mfa.enable');
    Route::get('/mfa/verify', [MfaController::class, 'verifyMfa'])->name('mfa.verify');
    Route::get('/mfa/verify', function () {
        return view('auth.verify');
    })->name('mfa.verify');
    Route::post('/mfa/verify', [MfaController::class, 'verifyMfa'])->name('mfa.verify.post');
    Route::middleware('verify.otp')->group(function () {
        Route::get('/admin/home', function () {
            return view('admin/dashboard/dashboard');
        })->name('dashboard/dashboard');
    });
});

Route::middleware(['auth', 'active', 'verify.otp'])->group(function () {
    Route::get('admin/home', function() {
        return view('admin/dashboard/dashboard');
    });     

    Route::group(['middleware' => ['auth']], function () {
        Route::get('getkecamatan', [WilayahController::class, 'getKecamatan']);
        Route::get('getkelurahan/{id}', [WilayahController::class, 'getKelurahan']);
        // Administrator-only routes
        Route::middleware(['role:Administrator'])->group(function () {
            Route::prefix('web')->name('web.')->group(function () {
                Route::resource('menu', MenuController::class);
                Route::get('menu/publish/{par1}', [MenuController::class, 'publish'])->name('menu.publish');
                Route::get('menu/notpublish/{par1}', [MenuController::class, 'notpublish'])->name('menu.notpublish');
                Route::resource('manajemen-user', ManajemenUserController::class);
                Route::get('manajemen-user/publish/{par1}', [ManajemenUserController::class, 'publish'])->name('manajemen-user.publish');
                Route::get('manajemen-user/notpublish/{par1}', [ManajemenUserController::class, 'notpublish'])->name('manajemen-user.notpublish');
                Route::get('identitas-web', [IdentitasWebController::class, 'index'])->name('identitas-web.get');
                Route::post('identitas-web', [IdentitasWebController::class, 'index'])->name('identitas-web.post');
            });
        });
        // User, Administrator routes
        Route::prefix('web')->name('web.')->middleware(['role:User,Administrator'])->group(function () {
            Route::resource('video', VideoController::class);
            Route::get('video/publish/{par1}', [VideoController::class, 'publish'])->name('video.publish');
            Route::get('video/notpublish/{par1}', [VideoController::class, 'notpublish'])->name('video.notpublish');
            Route::resource('album-foto', FotoController::class);
            Route::get('album-foto/publish/{par1}', [FotoController::class, 'publish'])->name('album-foto.publish');
            Route::get('album-foto/notpublish/{par1}', [FotoController::class, 'notpublish'])->name('album-foto.notpublish');
            Route::post('album-foto/simpan', [FotoController::class, 'simpan'])->name('album-foto.simpan');
            Route::delete('album-foto/delete/{par1}', [FotoController::class, 'delete'])->name('album-foto.delete');
            Route::resource('berita-kegiatan', ArtikelController::class);
            Route::get('berita-kegiatan/publish/{par1}', [ArtikelController::class, 'publish'])->name('berita-kegiatan.publish');
            Route::get('berita-kegiatan/notpublish/{par1}', [ArtikelController::class, 'notpublish'])->name('berita-kegiatan.notpublish');
            Route::get('berita-kegiatan/isslider/{par1}', [ArtikelController::class, 'isslider'])->name('berita-kegiatan.isslider');
            Route::get('berita-kegiatan/noslider/{par1}', [ArtikelController::class, 'noslider'])->name('berita-kegiatan.noslider');
            Route::get('user/update/{par1}', [UserController::class, 'index'])->name('user.update.get');
            Route::post('user/update/{par1}', [UserController::class, 'index'])->name('user.update.post');
        });

        Route::prefix('administrasi')->name('administrasi.')->middleware(['role:Administrator'])->group(function () {
            Route::resource('data-jemaat', JemaatController::class);
        });
    });
});

Route::get('download/excel/import/{filename}', function ($filename) {
    // Replace with the actual path to your Excel files
    $filePath = storage_path('app/public/import-template/' . $filename);
    if (!File::exists($filePath)) {
        abort(404); 
    }
    return response()->download($filePath);
})->name('download.template.excel.import');

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login'); // Redirect ke halaman login setelah logout
})->name('logout');
