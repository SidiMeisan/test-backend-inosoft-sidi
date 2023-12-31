<?php

namespace Tests\Unit\Models;

use Illuminate\Validation\ValidationException;

use App\Models\Kendaraan;
use Tests\TestCase;
use Tests\Unit\Models\ValidationTestBase;

class KendaraanTest extends ValidationTestBase
{
    protected $model = Kendaraan::class;
    
    public function validationDataProvider(): array
    {
        return [
            [
                'data' => [
                    'tahun_keluaran' => 2022,
                    'warna' => 'Red',
                    'harga' => 50000,
                ],
                'shouldPass' => true,
            ],
            [
                'data' => [
                    'tahun_keluaran' => 1890,
                    'warna' => 'Merah',
                    'harga' => 250000000,
                ],
                'shouldPass' => false,
            ],
            [
                'data' => [
                    'tahun_keluaran' => 2024,
                    'warna' => 'Merah',
                    'harga' => 250000000,
                ],
                'shouldPass' => false,
            ],
            [
                'data' => [
                    'warna' => 'Merah',
                    'harga' => 250000000,
                ],
                'shouldPass' => false,
            ],
            [
                'data' => [
                    'tahun_keluaran' => 's2022',
                    'warna' => 'Merah',
                    'harga' => 250000000,
                ],
                'shouldPass' => false,
            ],
            [
                'data' => [
                    'tahun_keluaran' => true,
                    'warna' => 'Merah',
                    'harga' => 250000000,
                ],
                'shouldPass' => false,
            ],
            [
                'data' => [
                    'tahun_keluaran' => 2022,
                    'harga' => 250000000,
                ],
                'shouldPass' => false,
            ],
            [
                'data' => [
                    'tahun_keluaran' => 2022,
                    'warna' => true,
                    'harga' => 250000000,
                ],
                'shouldPass' => false,
            ],
            [
                'data' => [
                    'tahun_keluaran' => 2022,
                    'warna' => 000000,
                    'harga' => 250000000,
                ],
                'shouldPass' => false,
            ],
            [
                'data' => [
                    'tahun_keluaran' => 2022,
                    'warna' => 'Merah',
                    'harga' => -250000000,
                ],
                'shouldPass' => false,
            ],
            [
                'data' => [
                    'tahun_keluaran' => 2022,
                    'warna' => 'Merah',
                    'harga' => true,
                ],
                'shouldPass' => false,
            ],
            [
                'data' => [
                    'tahun_keluaran' => 2022,
                    'warna' => 'Merah',
                    'harga' => 'as250000000',
                ],
                'shouldPass' => false,
            ],
        ];
    }
}