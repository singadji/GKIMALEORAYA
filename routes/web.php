<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\MenuController;
use App\Http\Controllers\Web\ArtikelController;
use App\Http\Controllers\Web\IdentitasWebController;
use App\Http\Controllers\Web\FotoController;
use App\Http\Controllers\Web\VideoController;
use App\Http\Controllers\Web\ManajemenUserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Administrasi\JemaatController;
use App\Http\Controllers\Administrasi\KKController;
use App\Http\Controllers\Administrasi\BaptisanController;
use App\Http\Controllers\Administrasi\PindahGerejaKeluarController;
use App\Http\Controllers\Administrasi\ModulController;
use App\Http\Controllers\Laporan\LaporanController;
use App\Http\Controllers\Master\WilayahController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\PageController;

Route::get('/', [MainController::class, 'index'])->name('index.get');
Route::post('/', [MainController::class, 'index'])->name('index.post');
Route::get('/login', function () { return view('login'); });
Route::get('berita-kegiatan', [PageController::class, 'news'])->name('news');
Route::get('berita-kegiatan/{id}', [PageController::class, 'baca'])->name('baca');
Route::get('foto', [PageController::class, 'foto'])->name('foto');
Route::get('video', [PageController::class, 'video'])->name('video');
Route::get('{link_menu}', [PageController::class, 'detail'])->name('detail');

Auth::routes();

// [SECURITY] Rate limiting pada login (5 percobaan per menit)
Route::middleware('throttle:5,1')->group(function () {
    Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login');
});

Route::middleware(['auth', 'active'])->group(function () {
    Route::get('admin/home', [DashboardController::class, 'index'])->name('admin.home');
    Route::post('admin/home', [DashboardController::class, 'index'])->name('admin.home');
    Route::get('admin/{detail}', [DashboardController::class, 'detail'])->name('admin.detail');
    Route::get('laporan/jemaat-wilayah/{wilayah?}', [LaporanController::class, 'laporanJemaatWilayah'])
            ->name('laporan.jemaat-wilayah');
        Route::get('laporan/jemaat-tanggal-daftar', [LaporanController::class, 'laporanJemaatPeriode'])->name('laporan.jemaat-tanggal-daftar');
        Route::get('laporan/jemaat-tanggal-lahir', [LaporanController::class, 'laporanJemaatTanggalLahir'])->name('laporan.jemaat-tanggal-lahir');
        Route::get('laporan/meninggal', [LaporanController::class, 'laporanMeninggal'])->name('laporan.meninggal');
        Route::get('laporan/atestasi-keluar', [LaporanController::class, 'laporanAtestasiKeluar'])->name('laporan.atestasi-keluar');
        Route::get('laporan/{detail}', [LaporanController::class, 'detail'])->name('laporan.detail');

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
            // [SECURITY] User update hanya bisa diakses Administrator
            Route::get('user/update/{par1}', [UserController::class, 'index'])->name('user.update.get');
            Route::post('user/update/{par1}', [UserController::class, 'index'])->name('user.update.post');
            Route::get('identitas-web', [IdentitasWebController::class, 'index'])->name('identitas-web.get');
            Route::post('identitas-web', [IdentitasWebController::class, 'index'])->name('identitas-web.post');
        });

        Route::prefix('administrasi')->name('administrasi.')->group(function () {
                    Route::post('data-jemaat/import', [JemaatController::class, 'import'])->name('data-jemaat.import');
                    Route::get('data-jemaat/cetak/{par1}', [JemaatController::class, 'cetakJemaat'])->name('data-jemaat.cetak');
                    Route::get('anggota-baptisan', [BaptisanController::class, 'index'])->name('anggota-baptisan');
                    Route::get('data-jemaat/search-jemaat', [JemaatController::class, 'search']);
                                        Route::get('data-jemaat/json/{id}', [JemaatController::class, 'getJemaatJson'])->name('data-jemaat.json');
                                        Route::post('data-jemaat/simpan-jemaat', [JemaatController::class, 'simpan'])->name('data-jemaat.simpan');
                    Route::resource('data-jemaat', JemaatController::class);

                    // Atestasi Keluar Pindah
                    Route::resource('pindah-gereja-keluar', PindahGerejaKeluarController::class)->except(['show']);
                    Route::get('pindah-gereja-keluar/cetak/{id}', [PindahGerejaKeluarController::class, 'cetak'])->name('pindah-gereja-keluar.cetak');
                    Route::post('pindah-gereja-keluar/{id}/setuju', [PindahGerejaKeluarController::class, 'setuju'])->name('pindah-gereja-keluar.setuju');

                    Route::resource('kk', KKController::class);
                    Route::delete('kk/{id}', [KKController::class, 'destroy'])->name('data-kk.destroy');
                    Route::get('kk/createFromJemaat/{id}', [KKController::class, 'createFromJemaat'])->name('data-kk.createFromJemaat');
                });

        Route::prefix('master')->name('master.')->group(function () {
            Route::resource('grup-wilayah', WilayahController::class);
        });

        Route::prefix('admin')->name('admin.')->group(function () {
            Route::resource('modul', ModulController::class)->except(['show']);
            Route::post('modul/{id}/toggle-aktif', [ModulController::class, 'toggleAktif'])->name('modul.toggle-aktif');
            Route::post('modul/{id}/toggle-publish', [ModulController::class, 'togglePublish'])->name('modul.toggle-publish');
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
    });
});

Route::middleware('auth')->group(function () {
    Route::get('download/excel/import/{filename}', function ($filename) {
        $filename = basename($filename);
        $filePath = storage_path('app/public/import-template/' . $filename);
        $realPath = realpath($filePath);
        $allowedDir = realpath(storage_path('app/public/import-template'));

        if (!$realPath || !$allowedDir || strpos($realPath, $allowedDir) !== 0 || !File::exists($realPath)) {
            abort(404);
        }
        return response()->download($realPath);
    })->name('download.template.excel.import');
});

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout');
