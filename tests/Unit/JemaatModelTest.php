<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Jemaat;
use App\Models\KkJemaat;
use App\Models\HubunganKeluarga;
use App\Models\Atestasi;
use App\Models\PindahGereja;
use App\Models\MeninggalDunia;

class JemaatModelTest extends TestCase
{
    /** @test */
    public function jemaat_model_has_correct_table_and_primary_key()
    {
        $jemaat = new Jemaat();
        $this->assertEquals('jemaat', $jemaat->getTable());
        $this->assertEquals('id_jemaat', $jemaat->getKeyName());
    }

    /** @test */
    public function jemaat_model_has_correct_fillable_fields()
    {
        $jemaat = new Jemaat();
        $expected = [
            'nia', 'nama_jemaat', 'gender', 'telepon', 'asal_gereja',
            'tanggal_terdaftar', 'tempat_lahir', 'tanggal_lahir',
            'tanggal_baptis', 'tanggal_sidi', 'tanggal_nikah',
            'status_aktif', 'status_menikah', 'keterangan',
        ];
        $this->assertEquals($expected, $jemaat->getFillable());
    }

    /** @test */
    public function jemaat_model_has_soft_deletes()
    {
        $jemaat = new Jemaat();
        $this->assertTrue(method_exists($jemaat, 'forceDelete'));
    }

    /** @test */
    public function kk_jemaat_model_has_correct_table()
    {
        $kk = new KkJemaat();
        $this->assertEquals('kk_jemaat', $kk->getTable());
    }

    /** @test */
    public function hubungan_keluarga_model_has_correct_fillable()
    {
        $hub = new HubunganKeluarga();
        $expected = ['id_kk_jemaat', 'id_jemaat', 'hubungan_keluarga'];
        $this->assertEquals($expected, $hub->getFillable());
    }

    /** @test */
    public function atestasi_model_has_correct_fillable()
    {
        $atestasi = new Atestasi();
        $expected = ['id_jemaat', 'tanggal', 'masuk', 'keluar', 'gereja', 'setuju'];
        $this->assertEquals($expected, $atestasi->getFillable());
    }

    /** @test */
    public function pindah_gereja_model_has_correct_fillable()
    {
        $pindah = new PindahGereja();
        $expected = ['id_jemaat', 'tanggal', 'dari', 'ke', 'gereja', 'setuju'];
        $this->assertEquals($expected, $pindah->getFillable());
    }

    /** @test */
    public function meninggal_dunia_model_has_correct_fillable()
    {
        $md = new MeninggalDunia();
        $expected = ['id_jemaat', 'tanggal', 'alamat'];
        $this->assertEquals($expected, $md->getFillable());
    }
}
