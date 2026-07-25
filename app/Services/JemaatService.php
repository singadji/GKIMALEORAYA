<?php
namespace App\Services;

use App\Models\Jemaat;
use App\Models\Atestasi;
use App\Models\PindahGereja;
use App\Models\MeninggalDunia;
use App\Models\HubunganKeluarga;
use App\Models\KkJemaat;
use Illuminate\Support\Facades\DB;

class JemaatService
{
    public function getJemaatList($statusFilter = null)
    {
        $query = Jemaat::with([
            'kkJemaat',
            'hubunganKeluarga.kkJemaat',
            'atestasiJemaatKeluar',
            'pindahJemaatKeluar',
        ])->select('id_jemaat', 'nia', 'nama_jemaat', 'gender', 'telepon', 'tempat_lahir', 'tanggal_lahir', 'tanggal_baptis', 'tanggal_sidi', 'tanggal_nikah', 'asal_gereja', 'tanggal_terdaftar', 'status_aktif', 'status_menikah', 'keterangan', 'updated_by')
          ->orderBy('nia');

        if ($statusFilter && $statusFilter !== 'semua') {
            $query->where('status_aktif', $statusFilter);
        }

        return $query->get();
    }

    public function getJemaatQuery()
    {
        return Jemaat::with([
            'kkJemaat',
            'hubunganKeluarga.kkJemaat',
            'atestasiJemaatKeluar',
            'pindahJemaatKeluar',
        ])->select('id_jemaat', 'nia', 'nama_jemaat', 'gender', 'telepon', 'tempat_lahir', 'tanggal_lahir', 'tanggal_baptis', 'tanggal_sidi', 'tanggal_nikah', 'asal_gereja', 'tanggal_terdaftar', 'status_aktif', 'status_menikah', 'keterangan', 'updated_by')
          ->orderBy('nia');
    }

    public function getJemaatDetail($id)
    {
        $jemaat = Jemaat::with([
            'kkJemaat',
            'hubunganKeluarga.kkJemaat',
            'atestasiJemaat',
            'atestasiJemaat.jemaatAtestasi',
            'pindahJemaat',
            'pindahJemaat.jemaatPindah'
        ])->where('id_jemaat', $id)->firstOrFail();

        $kk_jemaat = KkJemaat::select('id_jemaat')->get();
        $isAnggotaH = str_starts_with($jemaat->nia, 'H-');

        if ($isAnggotaH) {
            $hubungan = HubunganKeluarga::where('id_jemaat', $id)->with('kkJemaat')->first();
            $kepalaKeluarga = $hubungan?->kkJemaat;
            $id_kk = $hubungan?->id_kk_jemaat;
        } else {
            $kk = KkJemaat::where('id_jemaat', $jemaat->id_jemaat)->first();
            if ($kk) {
                $kepalaKeluarga = $kk;
                $id_kk = $kk->id_kk_jemaat;
            } else {
                $hubungan = HubunganKeluarga::where('id_jemaat', $id)->with('kkJemaat')->first();
                $kepalaKeluarga = $hubungan?->kkJemaat;
                $id_kk = $hubungan?->id_kk_jemaat;
            }
        }

        $anggotaKeluarga = HubunganKeluarga::where('id_kk_jemaat', $id_kk)->with('jemaat')->get();

        return compact('jemaat', 'kepalaKeluarga', 'anggotaKeluarga', 'id_kk', 'kk_jemaat');
    }

    public function getStats()
    {
        $allJemaat = Jemaat::select('id_jemaat', 'status_aktif', 'gender')->get();

        return [
            'total_jemaat' => $allJemaat->count(),
            'aktif' => $allJemaat->where('status_aktif', 'Aktif')->count(),
            'meninggal' => $allJemaat->where('status_aktif', 'Meninggal Dunia')->count(),
            'atestasi' => $allJemaat->where('status_aktif', 'Atestasi Keluar')->count(),
            'pasif' => $allJemaat->where('status_aktif', 'Pasif')->count(),
            'bukan_anggota' => $allJemaat->where('status_aktif', 'Bukan Anggota')->count(),
            'tidak_aktif' => $allJemaat->where('status_aktif', 'Tidak Aktif')->count(),
            'laki' => $allJemaat->where('gender', 'L')->count(),
            'perempuan' => $allJemaat->where('gender', 'P')->count(),
            'kk' => Jemaat::whereHas('kkJemaat')->count(),
        ];
    }

    // di App\Services\JemaatService.php
    public function JumlahJemaat($tahunAkhir)
    {
        $Jaktif = DB::selectOne("
            SELECT COUNT(id_jemaat) AS total
            FROM jemaat
            WHERE status_aktif = 'Aktif'
                AND deleted_at IS NULL
        ");

        // Count distinct jemaat with atestasi keluar records (matching detail query logic)
        $Jatestasi = DB::table('atestasi')
            ->where('keluar', 1)
            ->where('tanggal', '<=', $tahunAkhir)
            ->join('jemaat', 'atestasi.id_jemaat', '=', 'jemaat.id_jemaat')
            ->distinct('jemaat.id_jemaat')
            ->count();

        $Jpasif = Jemaat::where('status_aktif', 'Pasif')->count();
        $JbukanAnggota = Jemaat::where('status_aktif', 'Bukan Anggota')->count();
        $Jmeninggal = Jemaat::where('status_aktif', 'Meninggal Dunia')->count();
        $Jkk = Jemaat::where('status_aktif', 'Aktif')->whereHas('kkJemaat')->count();

        $baptisan = Jemaat::with(['kkJemaat', 'hubunganKeluarga.kkJemaat'])
            ->whereNotIn('status_aktif', ['Atestasi Keluar', 'Meninggal Dunia', 'Bukan Anggota', 'Pindah Gereja'])
            ->where(function ($query) {
                $query->whereNull('tanggal_sidi')
                      ->orWhere('tanggal_sidi', '1900-01-01');
            })
            ->where(function ($query) {
                $query->whereNotNull('tanggal_baptis')
                      ->where('tanggal_baptis', '!=', '1900-01-01');
            })
            ->where('tanggal_lahir', '<=', now()->subYears(15))
            ->where('tanggal_lahir', '!=', '1900-01-01')
            ->count();

        return [
            'total_jemaat' => $Jaktif->total,
            'atestasi_keluar' => $Jatestasi,
            'pasif' => $Jpasif,
            'bukan_anggota' => $JbukanAnggota,
            'meninggal' => $Jmeninggal,
            'jemaat_kk' => $Jkk,
            'baptisan' => $baptisan,
        ];
    }

}
