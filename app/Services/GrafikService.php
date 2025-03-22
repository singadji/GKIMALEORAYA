<?php

namespace App\Services;

use App\Models\MasterPasar;
use App\Models\HargaPangan;
use App\Models\MasterKomoditas;

use Carbon\Carbon;

class GrafikService
{
    public static function getDataRataHargaPerKomoditasAll()
    {
        $date = Carbon::now();
        
        $tahun = $date->format('Y');

        $hargaPangan = HargaPangan::with('detail')
            ->where('tahun', $tahun)
            ->get();

        $komoditas = MasterKomoditas::get();

        $data = [];
        $data['tahun'] = $request->tahun;
        //$data['bulan'] = $request->bulan;
        
        foreach ($komoditas as $kom) {
            $row = [];
            $row['id_komoditas'] = $kom->id;
            $row['nama_komoditas'] = $kom->nama_komoditas;

            $totalHargaSeluruhPasar = 0;
            $jumlahPembagiHarga = 0;
            foreach ($hargaPangan as $hp) {
                foreach ($hp->detail as $detail) {
                    if ($detail->id_komoditas==$kom->id) {
                        $totalHargaSeluruhPasar += $detail->harga;
                        $jumlahPembagiHarga++;
                    }
                }
            }
            $row['harga_total'] = $totalHargaSeluruhPasar;
            $row['jumlah_pembagi'] = $jumlahPembagiHarga;
            
            $row['harga_rata'] = 0;
            if ($jumlahPembagiHarga!=0) {
                $row['harga_rata'] = $totalHargaSeluruhPasar / $jumlahPembagiHarga;
            }

            $data['detail'][] = $row;
        }

        return $data;
    }

    public static function getRekapData($request, $dataRataHargaPerKomoditas)
    {
        $date = Carbon::now();
        
        $tahun = $date->format('Y');

        
        $pasar = MasterPasar::get();
        $komoditas = MasterKomoditas::get();
        $hargaPangan = HargaPangan::with('detail')
            ->where('tahun', $tahun)
            ->get();

        $data = [];
        foreach ($kategoriKomoditas as $kategori) {
            $row = [];
            $row['jenis'] = $kategori->nama;
            
            foreach ($kategori->komoditas as $komoditas) {
                $rowKomoditas = [];
                $rowKomoditas['nama'] = $komoditas->nama;
                $rowKomoditas['satuan'] = $komoditas->satuan;
                
                $totalHargaSeluruhPasar = 0;
                $jumlahPasar = 0;

                foreach ($pasar as $p) {
                    $totalHargaPasar = 0;
                    $jumlahPembagiHarga = 0;

                    $rowPasar = [];
                    $rowPasar['id_pasar'] = $p->id;
                    $rowPasar['nama_pasar'] = $p->nama;
                    
                    $filterPasar = $hasilPantau->filter(function($item, $key) use($p) {
                        if ($item->id_pasar==$p->id) {
                            return $item;
                        }
                    });

                    foreach ($filterPasar as $fp) {
                        foreach ($fp->detail as $fpd) {
                            if ($fpd->id_komoditas==$komoditas->id) {
                                $totalHargaPasar += $fpd->harga;
                                $jumlahPembagiHarga++;
                            }
                        }
                    }

                    $rowPasar['harga'] = 0;
                    if ($jumlahPembagiHarga!=0) {
                        $rowPasar['harga'] = $totalHargaPasar / $jumlahPembagiHarga;
                    }

                    $rowKomoditas['detail'][] = $rowPasar;
                    $totalHargaSeluruhPasar += $rowPasar['harga'];
                    $jumlahPasar++;
                }
                
                $rowKomoditas['rata'] = $totalHargaSeluruhPasar / $jumlahPasar;

                $rowKomoditas['rata_bulan_lalu'] = 0;
                if (!is_null($dataRataHargaPerKomoditas)) {
                    foreach ($dataRataHargaPerKomoditas['detail'] as $rataHarga) {
                        if ($rataHarga['id_komoditas'] == $komoditas->id) {
                            $rowKomoditas['rata_bulan_lalu'] = $rataHarga['harga_rata'];
                            break;
                        }
                    }
                }

                $rowKomoditas['selisih'] = $rowKomoditas['rata'] - $rowKomoditas['rata_bulan_lalu'];

                $rowKomoditas['persen'] = 0;
                if ($rowKomoditas['rata']!=0) {
                    $rowKomoditas['persen'] = abs(round($rowKomoditas['selisih'] * 100 / $rowKomoditas['rata'], 2));
                }

                if ($rowKomoditas['rata'] == $rowKomoditas['rata_bulan_lalu']) {
                    $rowKomoditas['icon'] = "fa-minus";
                    $rowKomoditas['color'] = "text-secondary";
                } elseif ($rowKomoditas['rata'] > $rowKomoditas['rata_bulan_lalu']) {
                    $rowKomoditas['icon'] = "fa-angle-double-up";
                    $rowKomoditas['color'] = "text-danger";
                } else {
                    $rowKomoditas['icon'] = "fa-angle-double-down";
                    $rowKomoditas['color'] = "text-success";
                }

                $row['detail'][] = $rowKomoditas;
            }

            $data[] = $row;
        }

        return $data;
    }
}
