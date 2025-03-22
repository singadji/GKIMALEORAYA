<?php

namespace App\Services;

use App\Models\MasterPasar;
use App\Models\MasterKomoditas;
use App\Models\HargaPangan;
use App\Models\KategoriKomoditas;

use Carbon\Carbon;

class RekapitulasiService
{
    public static function getDataRataHargaPerKomoditas($request)
    {
        if ($request->bulan==1) {
            return null;
        }

        if($request->bulan=='')
        {
            $Now  = HargaPangan::select('bulan', 'tahun')
                ->join('harga_pangan_details', 'harga_pangan_details.id_harga_pangan', '=',  'harga_pangans.id')
                ->orderby('bulan','desc')
                ->groupby('id_komoditas')
                ->first();
            
            $bulan1 = $Now->bulan - 1;
            $tahun1 = $Now->tahun;

            $hargapangan = HargaPangan::with('detail')
                ->where('tahun', $tahun1)
                ->where('bulan', $bulan1)
                ->get();
        }
        else{
        $bulan = $request->bulan - 1;

        $hargapangan = HargaPangan::with('detail')
            ->where('tahun', $request->tahun)
            ->where('bulan', $bulan)
            ->get();
        }
        $komoditas = MasterKomoditas::get();

        $data = [];
        $data['tahun'] = $request->tahun;
        $data['bulan'] = $request->bulan;
        foreach ($komoditas as $kom) {
            $row = [];
            $row['id_komoditas'] = $kom->id;
            $row['nama'] = $kom->nama;

            $totalHargaSeluruhPasar = 0;
            $jumlahPembagiHarga = 0;
            foreach ($hargapangan as $hp) {
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

    public static function getDataRataHargaPerKomoditasSekarang($request)
    {
        if($request->bulan=='')
        {
            $Now  = HargaPangan::select('bulan', 'tahun')
            ->join('harga_pangan_details', 'harga_pangan_details.id_harga_pangan', '=',  'harga_pangans.id')
            ->orderby('bulan','desc')
            ->groupby('id_komoditas')
            ->groupby('id_pasar')
            ->first();
        
            $bulan1 = $Now->bulan;
            $tahun1 = $Now->tahun;

            $hargapanganS = HargaPangan::with('detail')
                ->where('tahun', $tahun1)
                ->where('bulan', $bulan1)
                ->get();
        }
        else{
            $hargapanganS = HargaPangan::with('detail')
                ->where('tahun', $request->tahun)
                ->where('bulan', $request->bulan)
                ->get();
        }
        $komoditasS = MasterKomoditas::get();

        $dataS = [];
        $dataS['tahun'] = $request->tahun;
        $dataS['bulan'] = $request->bulan;
        foreach ($komoditasS as $komS) {
            $rowS = [];
            $rowS['id_komoditas'] = $komS->id;
            $rowS['nama'] = $komS->nama;

            $totalHargaSeluruhPasarS = 0;
            $jumlahPembagiHargaS = 0;
            foreach ($hargapanganS as $hpS) {
                foreach ($hpS->detail as $detail) {
                    if ($detail->id_komoditas==$komS->id) {
                        $totalHargaSeluruhPasarS += $detail->harga;
                        $jumlahPembagiHargaS++;
                    }
                }
            }
            $rowS['harga_total_sekarang'] = $totalHargaSeluruhPasarS;
            $rowS['jumlah_pembagi_sekarang'] = $jumlahPembagiHargaS;
            
            $rowS['harga_rata_sekarang'] = 0;
            if ($jumlahPembagiHargaS!=0) {
                $rowS['harga_rata_sekarang'] = $totalHargaSeluruhPasarS / $jumlahPembagiHargaS;
            }

            $dataS['detail'][] = $rowS;
        }

        return $dataS;
    }

    public static function getRekapData($request, $dataRataHargaPerKomoditas, $dataRataHargaPerKomoditasSekarang)
    {
        $pasar = MasterPasar::get();
        $kategoriKomoditas = MasterKomoditas::get();
        
        if(isset($request)){
            $hargapangan = HargaPangan::with('detail')
            ->where('tahun', $request->tahun)
            ->where('bulan', $request->bulan)
            ->get();
        }
        if($request->bulan=='')
        {
           
        $Now  = HargaPangan::select('bulan', 'tahun')
        ->join('harga_pangan_details', 'harga_pangan_details.id_harga_pangan', '=',  'harga_pangans.id')
            ->orderby('bulan','desc')
            ->groupby('id_komoditas')
            ->first();
        
        $bulan1 = $Now->bulan - 1;
        $tahun1 = $Now->tahun;

        $hargapangan = HargaPangan::with('detail')
            ->where('tahun', $tahun1)
            ->where('bulan', $bulan1)
            ->get();

        }
        
        $data = [];
        //foreach ($kategoriKomoditas as $kategori) {
            
            foreach ($kategoriKomoditas as $komoditas) {
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
                    
                    $filterPasar = $hargapangan->filter(function($item, $key) use($p) {
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
                }
                
                $rowKomoditas['rata'] = 0;
                if (!is_null($dataRataHargaPerKomoditasSekarang)) {
                    foreach ($dataRataHargaPerKomoditasSekarang['detail'] as $rataHargaS) {
                        if ($rataHargaS['id_komoditas'] == $komoditas->id) {
                            $rowKomoditas['rata'] = $rataHargaS['harga_rata_sekarang'];
                            break;
                        }
                    }
                }

                //$rowKomoditas['rata'] = $totalHargaSeluruhPasar / $jumlahPasar;

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
                    $rowKomoditas['icon'] = "bi bi-arrows-collapse";
                    $rowKomoditas['color'] = "text-primary";
                } elseif ($rowKomoditas['rata'] > $rowKomoditas['rata_bulan_lalu']) {
                    $rowKomoditas['icon'] = "bi bi-arrow-up-circle-fill";
                    $rowKomoditas['color'] = "text-danger";
                } else {
                    $rowKomoditas['icon'] = "bi bi-arrow-down-circle-fill";
                    $rowKomoditas['color'] = "text-success";
                }

                $row['detail'][] = $rowKomoditas;
            }

            $data[] = $row;
        //}

        return $data;
    }
    

    public static function getDataRataHargaPerKomoditasHome()
    {
        $Now  = HargaPangan::select('bulan', 'tahun')
            ->join('harga_pangan_details', 'harga_pangan_details.id_harga_pangan', '=',  'harga_pangans.id')
            ->orderby('bulan','desc')
            ->groupby('id_komoditas')
            ->first();
        
        $bulan = Carbon::now()->format('n') - 1; //harga sebelumnya
        $tahun = Carbon::now()->format('Y');
        
        $hargapangan = HargaPangan::with('detail')
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->get();
        
        $komoditas = MasterKomoditas::get();

        $data = [];
        $data['tahun'] = $tahun;
        $data['bulan'] = $bulan;
        foreach ($komoditas as $kom) {
            $row = [];
            $row['id_komoditas'] = $kom->id;
            $row['nama'] = $kom->nama;

            $totalHargaSeluruhPasar = 0;
            $jumlahPembagiHarga = 0;
            foreach ($hargapangan as $hp) {
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

    public static function getDataRataHargaPerKomoditasSekarangHome()
    {
        $Now  = HargaPangan::select('bulan', 'tahun')
        ->join('harga_pangan_details', 'harga_pangan_details.id_harga_pangan', '=',  'harga_pangans.id')
            ->orderby('bulan','desc')
            ->groupby('id_komoditas')
            ->first();
        
            $bulan = Carbon::now()->format('n'); //harga sekarang
            $tahun = Carbon::now()->format('Y');
        
        $hargapanganS = HargaPangan::with('detail')
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->get();
        
        $komoditasS = MasterKomoditas::get();

        $dataS = [];
        $dataS['tahun'] = $tahun;
        $dataS['bulan'] = $bulan;
        foreach ($komoditasS as $komS) {
            $rowS = [];
            $rowS['id_komoditas'] = $komS->id;
            $rowS['nama'] = $komS->nama;

            $totalHargaSeluruhPasarS = 0;
            $jumlahPembagiHargaS = 0;
            foreach ($hargapanganS as $hpS) {
                foreach ($hpS->detail as $detail) {
                    if ($detail->id_komoditas==$komS->id) {
                        $totalHargaSeluruhPasarS += $detail->harga;
                        $jumlahPembagiHargaS++;
                    }
                }
            }
            $rowS['harga_total_sekarang'] = $totalHargaSeluruhPasarS;
            $rowS['jumlah_pembagi_sekarang'] = $jumlahPembagiHargaS;
            
            $rowS['harga_rata_sekarang'] = 0;
            if ($jumlahPembagiHargaS!=0) {
                $rowS['harga_rata_sekarang'] = $totalHargaSeluruhPasarS / $jumlahPembagiHargaS;
            }

            $dataS['detail'][] = $rowS;
        }

        return $dataS;
    }

    public static function getRekapDataHome($dataRataHargaPerKomoditasHome, $dataRataHargaPerKomoditasSekarangHome)
    {
        $pasar = MasterPasar::get();
        $kategoriKomoditas = MasterKomoditas::get();
            
        $Now = HargaPangan::select('tahun','bulan')->join('harga_pangan_details', 'harga_pangan_details.id_harga_pangan', '=',  'harga_pangans.id')->orderby('tahun', 'desc')->groupby('id_komoditas')->first();
        
        $bulan1 = Carbon::now()->format('n');
        $tahun1 = Carbon::now()->format('Y');

        $hargapangan = HargaPangan::with('detail')
            ->where('tahun', $tahun1)
            ->where('bulan', $bulan1)
            ->get();
        
        $data = [];
        //foreach ($kategoriKomoditas as $kategori) {
            
            foreach ($kategoriKomoditas as $komoditas) {
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
                    
                    $filterPasar = $hargapangan->filter(function($item, $key) use($p) {
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
                }
                
                $rowKomoditas['rata'] = 0;
                if (!is_null($dataRataHargaPerKomoditasSekarangHome)) {
                    foreach ($dataRataHargaPerKomoditasSekarangHome['detail'] as $rataHargaS) {
                        if ($rataHargaS['id_komoditas'] == $komoditas->id) {
                            $rowKomoditas['rata'] = $rataHargaS['harga_rata_sekarang'];
                            break;
                        }
                    }
                }

                //$rowKomoditas['rata'] = $totalHargaSeluruhPasar / $jumlahPasar;

                $rowKomoditas['rata_bulan_lalu'] = 0;
                if (!is_null($dataRataHargaPerKomoditasHome)) {
                    foreach ($dataRataHargaPerKomoditasHome['detail'] as $rataHarga) {
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
                    $rowKomoditas['icon'] = "bi bi-arrows-collapse";
                    $rowKomoditas['color'] = "text-secondary";
                } elseif ($rowKomoditas['rata'] > $rowKomoditas['rata_bulan_lalu']) {
                    $rowKomoditas['icon'] = "bi bi-arrow-up-circle-fill";
                    $rowKomoditas['color'] = "text-danger";
                } else {
                    $rowKomoditas['icon'] = "bi bi-arrow-down-circle-fill";
                    $rowKomoditas['color'] = "text-success";
                }

                $row['detail'][] = $rowKomoditas;
            }

            $data[] = $row;
        //}

        return $data;
    }
    
}

