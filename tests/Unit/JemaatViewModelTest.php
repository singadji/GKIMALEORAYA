<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\ViewModels\JemaatViewModel;
use Illuminate\Support\Collection;

class JemaatViewModelTest extends TestCase
{
    /** @test */
    public function it_assigns_correct_badge_class_based_on_status()
    {
        $testCases = [
            ['status_aktif' => 'Aktif', 'expected' => 'bg-gradient-success'],
            ['status_aktif' => 'Pasif', 'expected' => 'bg-primary'],
            ['status_aktif' => 'Meninggal Dunia', 'expected' => 'bg-gradient-purple'],
            ['status_aktif' => 'Bukan Anggota', 'expected' => 'bg-gradient-warning'],
            ['status_aktif' => 'Pindah Gereja', 'pindahJemaat' => (object)['ke' => 1], 'expected' => 'bg-gradient-danger'],
            ['status_aktif' => 'Atestasi Keluar', 'atestasiJemaat' => (object)['keluar' => 1], 'expected' => 'bg-gradient-danger'],
            ['status_aktif' => 'Tidak Jelas', 'expected' => 'bg-gradient-default'],
        ];

        foreach ($testCases as $case) {
            $item = (object)[
                'status_aktif' => $case['status_aktif'],
                'pindahJemaat' => $case['pindahJemaat'] ?? null,
                'atestasiJemaat' => $case['atestasiJemaat'] ?? null,
                'kkJemaat' => null,
            ];

            $viewModel = new JemaatViewModel(Collection::make([$item]));
            $formatted = $viewModel->formatted()->first();

            $this->assertEquals(
                $case['expected'],
                $formatted->badge_class,
                "Failed asserting for status: {$case['status_aktif']}"
            );
        }
    }
}
