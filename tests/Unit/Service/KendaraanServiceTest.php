<?php

namespace Tests\Unit\Services;

use App\Repositories\KendaraanRepository;
use App\Services\KendaraanService;
use Tests\TestCase;

class KendaraanServiceTest extends TestCase
{
    public function testGetStokDanKendaraanByPage()
    {
        // Mock the KendaraanRepository
        $kendaraanRepository = $this->getMockBuilder(KendaraanRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        // Set up the expected method calls and return values
        $expectedPage = 1;
        $expectedSize = 3;
        $expectedResult = [
            'stok' => 15,
            'data' => [
                [
                    '_id' => '64b60c7b20f115479201c682',
                    'terjual' => false,
                    'tahun_keluaran' => 2013,
                    'warna' => 'Hitam',
                    'harga' => 201665894,
                    'updated_at' => '2023-07-18T03:52:27.248+00:00',
                    'created_at' => '2023-07-18T03:52:27.248+00:00',
                ],
                [
                    '_id' => '64b60c7b20f115479201c683',
                    'terjual' => false,
                    'tahun_keluaran' => 2020,
                    'warna' => 'Kuning',
                    'harga' => 358188274,
                    'updated_at' => '2023-07-18T03:52:27.311+00:00',
                    'created_at' => '2023-07-18T03:52:27.311+00:00',
                ],
                [
                    '_id' => '64b60c7b20f115479201c684',
                    'terjual' => false,
                    'tahun_keluaran' => 2019,
                    'warna' => 'Biru',
                    'harga' => 160468122,
                    'updated_at' => '2023-07-18T03:52:27.338+00:00',
                    'created_at' => '2023-07-18T03:52:27.338+00:00',
                ],
            ], // Add your expected data here
            'page' => $expectedPage,
            'size' => $expectedSize,
        ];
        $kendaraanRepository->expects($this->once())
            ->method('getStokDanKendaraanByPage')
            ->with($expectedPage, $expectedSize)
            ->willReturn($expectedResult);

        // Create an instance of KendaraanService using the mocked KendaraanRepository
        $kendaraanService = new KendaraanService($kendaraanRepository);

        // Call the method being tested
        $result = $kendaraanService->getStokDanKendaraanByPage($expectedPage, $expectedSize);

        // Assert the result
        $this->assertEquals($expectedResult, $result);
    }

    // public function testJualKendaraan()
    // {
    //     // Mock the KendaraanRepository
    //     $kendaraanRepository = $this->getMockBuilder(KendaraanRepository::class)
    //         ->disableOriginalConstructor()
    //         ->getMock();

    //     // Set up the expected method calls and return values
    //     $expectedId = 1;
    //     $expectedResult = true;
    //     $kendaraanRepository->expects($this->once())
    //         ->method('updateTerjual')
    //         ->with($expectedId)
    //         ->willReturn($expectedResult);

    //     // Create an instance of KendaraanService using the mocked KendaraanRepository
    //     $kendaraanService = new KendaraanService($kendaraanRepository);

    //     // Call the method being tested
    //     $result = $kendaraanService->jualKendaraan($expectedId);

    //     // Assert the result
    //     $this->assertEquals($expectedResult, $result);
    // }
}
