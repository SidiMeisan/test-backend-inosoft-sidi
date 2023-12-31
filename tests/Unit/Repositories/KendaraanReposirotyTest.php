<?php

namespace Tests\Unit\Repositories;

use App\Models\Kendaraan;
use App\Models\Mobil;
use App\Models\Motor;

use App\Repositories\KendaraanRepository;
use App\Repositories\Pagination;
use Tests\TestCase;

class KendaraanRepositoryTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Manually clear the MongoDB collection
        Kendaraan::truncate();
        Mobil::truncate();
        Motor::truncate();
    }

    public function createDummyData(int $count): void
    {
        for ($i = 1; $i <= $count; $i++) {
            $terjual = false;
            $tahun_keluaran = rand(2000, 2023); // Generate a random year between 2000 and 2023
            $warna = ['Merah', 'Biru', 'Hijau', 'Kuning', 'Hitam'][array_rand(['Merah', 'Biru', 'Hijau', 'Kuning', 'Hitam'])]; // Choose a random color from the given array
            $harga = rand(100000000, 500000000); // Generate a random price between 100,000,000 and 500,000,000

            // Create the record
            $kendaraan = new Kendaraan;
            $kendaraan->terjual = $terjual;
            $kendaraan->tahun_keluaran = $tahun_keluaran;
            $kendaraan->warna = $warna;
            $kendaraan->harga = $harga;
            $kendaraan->save();

            $randomNumber = rand(1, 2);

            if ($randomNumber === 1) {
                // Random data for Mobil
                $mobil = new Mobil;
                $mobil->kendaraan_id = $kendaraan->_id;
                $mobil->mesin = 'Mesin Mobil';
                $mobil->kapasitas_penumpang = rand(2, 5);
                $mobil->tipe = ['Sedan', 'SUV', 'Hatchback'][array_rand(['Sedan', 'SUV', 'Hatchback'])];
                $mobil->save();
            } else {
                // Random data for Motor
                $motor = new Motor;
                $motor->kendaraan_id = $kendaraan->_id;
                $motor->mesin = 'Mesin Motor';
                $motor->tipe_suspensi = ['Upside Down', 'Monoshock', 'Teleskopik'][array_rand(['Upside Down', 'Monoshock', 'Teleskopik'])];
                $motor->tipe_transmisi = ['Manual', 'Matic'][array_rand(['Manual', 'Matic'])];
                $motor->save();
            }
        }
    }

    public function testGetStokDanKendaraanByPage()
    {
        $count = 15;
        $this->createDummyData($count);

        $page = 1;
        $size = 10;

        $repository = new KendaraanRepository();

        // Act
        $result = $repository->getStokDanKendaraanByPage($page, $size);

        // Assert
        $this->assertArrayHasKey('stok', $result);
        $this->assertArrayHasKey('data', $result);
        $this->assertArrayHasKey('page', $result);
        $this->assertArrayHasKey('size', $result);

        $this->assertEquals($count, $result['stok']);
        $this->assertCount($size, $result['data']);
        $this->assertEquals($page, $result['page']);
        $this->assertEquals($size, $result['size']);
    }
}