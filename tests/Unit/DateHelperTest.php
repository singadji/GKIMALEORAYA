<?php

namespace Tests\Unit;

use Tests\TestCase;

class DateHelperTest extends TestCase
{
    /** @test */
    public function tanggal_indo_returns_indonesian_date_format()
    {
        $result = tanggalIndo('2024-01-15');
        $this->assertIsString($result);
        $this->assertNotEmpty($result);
    }

    /** @test */
    public function parse_tanggal_indo_parses_indonesian_date()
    {
        $result = parseTanggalIndo('15 Januari 2024');
        $this->assertIsString($result);
    }
}
