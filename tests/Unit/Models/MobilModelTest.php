<?php

namespace Tests\Unit\Models;

use Illuminate\Validation\ValidationException;

use App\Models\Kendaraan;
use App\Models\Mobil;
use Tests\TestCase;
use Tests\Unit\Models\ValidationTestBase;

class MobilTest extends ValidationTestBase
{
    protected $model = Mobil::class;

    public function validationDataProvider(): array
    {
        return [
            [
                'data' => [
                    'mesin' => '1.5L',
                    'kapasitas_penumpang' => 5,
                    'tipe' => 'Sedan',
                ],
                'shouldPass' => true,
            ],
            [
                'data' => [
                    'mesin' => '2.0L',
                    'kapasitas_penumpang' => -4,
                    'tipe' => 'Hatchback',
                ],
                'shouldPass' => false,
            ],
            [
                'data' => [
                    'mesin' => '1.8L',
                    'kapasitas_penumpang' => 1000,
                    'tipe' => 'SUV',
                ],
                'shouldPass' => false,
            ],
            // Tambahkan contoh data dan harapan validasi lainnya sesuai kebutuhan
        ];
    }
}