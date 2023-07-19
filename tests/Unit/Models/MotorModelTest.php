<?php

namespace Tests\Unit\Models;

use Illuminate\Validation\ValidationException;

use App\Models\Kendaraan;
use App\Models\Motor;
use Tests\TestCase;
use Tests\Unit\Models\ValidationTestBase;

class MotorTest extends ValidationTestBase
{
    protected $model = Motor::class;

    public function validationDataProvider(): array
    {
        return [
            [
                'data' => [
                    'mesin' => 'V8',
                    'tipe_suspensi' => 'suspensi_depan',
                    'tipe_transmisi' => 'manual',
                ],
                'shouldPass' => true,
            ],
            [
                'data' => [
                    'mesin' => '',
                    'tipe_suspensi' => 'suspensi_ganda',
                    'tipe_transmisi' => 'otomatis',
                ],
                'shouldPass' => false,
            ],
            [
                'data' => [
                    'mesin' => '4 Cylinder',
                    'tipe_suspensi' => 'suspensi_belakang',
                    'tipe_transmisi' => 'CVT',
                ],
                'shouldPass' => false,
            ],
            // Tambahkan contoh data dan harapan validasi lainnya sesuai kebutuhan
        ];
    }
}