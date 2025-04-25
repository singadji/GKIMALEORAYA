<?php
namespace App\ViewModels;

use Illuminate\Support\Collection;

class JemaatViewModel
{
    public function __construct(
        public Collection $jemaatList
    ) {}

    public function formatted()
    {
        return $this->jemaatList->map(function ($item) {
            $item->is_kk = $item->kkJemaat !== null;
            $item->badge_class = match (true) {
                $item->status_aktif === 'Atestasi Keluar' && $item->atestasiJemaat->keluar === 1 => 'bg-gradient-danger',
                $item->status_aktif === 'ke' && $item->pindahJemaat->ke === 1 => 'bg-gradient-danger',
                $item->status_aktif === 'Meninggal Dunia' => 'bg-gradient-purple',
                $item->status_aktif === 'Bukan Anggota' => 'bg-gradient-warning',
                $item->status_aktif === 'Pasif' => 'bg-primary',
                $item->status_aktif === 'Aktif' => 'bg-gradient-success',
                default => 'bg-gradient-default',
            };
            return $item;
        });
    }
}
