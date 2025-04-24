<?php
namespace App\ViewModels;

class JemaatDetailViewModel
{
    public function __construct(
        public $jemaat,
        public $kepalaKeluarga,
        public $anggotaKeluarga,
        public $id_kk,
        public $kk_jemaat
    ) {}

    public function aksiUrl(): string
    {
        return route('administrasi.data-jemaat.update', $this->jemaat->id_jemaat);
    }

    public function backButton(): string
    {
        return '<a href="' . route('administrasi.data-jemaat.index') . '" class="btn btn-secondary bg-gradient-secondary btn-sm mt-3 ms-auto">Kembali</a>';
    }
}
