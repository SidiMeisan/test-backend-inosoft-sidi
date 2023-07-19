<?php

namespace App\Repositories;

use App\Models\Kendaraan;
use App\Models\Mobil;
use App\Models\Motor;

use App\Repositories\Pagination;

class KendaraanRepository
{
    private function getMobilData()
    {
        return Mobil::get()->toArray();
    }

    private function getMotorData()
    {
        return Motor::get()->toArray();
    }

    private function mergeMobilDataWithJenis($data, $mobilData)
    {
        $terjualMobil = 0;
    
        foreach ($data as &$item) {
            $kendaraanId = $item['_id'];
            
            foreach ($mobilData as $mobil) {
                if ($mobil['kendaraan_id'] === $kendaraanId) {
                    $item['jenis'][] = [
                        'tipe' => 'Mobil',
                        'spesifikasi_tambahan' => $mobil
                    ];
                    $terjualMobil++;
                    break;
                }
            }
        }
    
        return ['data' => $data, 'terjual_mobil' => $terjualMobil];
    }
    
    private function mergeMotorDataWithJenis($data, $motorData)
    {
        $terjualMotor = 0;
    
        foreach ($data as &$item) {
            $kendaraanId = $item['_id'];
            
            foreach ($motorData as $motor) {
                if ($motor['kendaraan_id'] === $kendaraanId) {
                    $item['jenis'][] = [
                        'tipe' => 'Motor',
                        'spesifikasi_tambahan' => $motor
                    ];
                    $terjualMotor++;
                    break;
                }
            }
        }
    
        return ['data' => $data, 'terjual_motor' => $terjualMotor];
    }
    
    public function getStokDanKendaraanByPage(int $page, int $size): array
    {
        // Menghitung jumlah stok kendaraan yang belum terjual
        $stok = Kendaraan::where('terjual', false)->count();
    
        // Membuat objek Pagination dengan halaman dan ukuran halaman yang ditentukan
        $pagination = new Pagination($page, $size);
    
        // Membuat query untuk mengambil data kendaraan yang belum terjual dan diurutkan berdasarkan waktu pembuatan
        $query = Kendaraan::where('terjual', false)
            ->orderBy('created_at', 'desc');
    
        // Menggunakan objek Pagination untuk menerapkan paginasi pada query
        $query = $pagination->applyPagination($query);
    
        // Mengambil data kendaraan yang sudah dipaginasi dan mengubahnya menjadi array
        $data = $query->get()->toArray();
    
        // Ambil data Mobil
        $mobilData = Mobil::get()->toArray();
    
        // Ambil data Motor
        $motorData = Motor::get()->toArray();
    
        // Menggabungkan data Mobil dengan data Kendaraan
        $resultMobil = $this->mergeMobilDataWithJenis($data, $mobilData);
        $data = $resultMobil['data'];
        $stokMobil = $resultMobil['terjual_mobil'];
    
        // Menggabungkan data Motor dengan data Kendaraan
        $resultMotor = $this->mergeMotorDataWithJenis($data, $motorData);
        $data = $resultMotor['data'];
        $stokMotor = $resultMotor['terjual_motor'];
    
        return array_merge([
            'stok' => $stok,
            'mobil_stok' => $stokMobil,
            'motor_stok' => $stokMotor,
            'data' => $data,
        ], $pagination->toArray());
    }
    
    public function updateTerjual(string $id): array
    {
        // Membuat query untuk mengupdate data kendaraan berdasarkan ID
        Kendaraan::where('_id', $id)
            ->update([
                'terjual' => true
            ]);
        
        $query = Kendaraan::where('_id', $id)
        ->orderBy('created_at', 'desc');
    
        // Mengambil data kendaraan yang sudah dipaginasi dan mengubahnya menjadi array
        $data = $query->get()->toArray();
    
        // Ambil data Mobil
        $mobilData = $this->getMobilData();

        // Ambil data Motor
        $motorData = $this->getMotorData();
        
        // Menggabungkan data Mobil dengan data Kendaraan
        $resultMobil = $this->mergeMobilDataWithJenis($data, $mobilData);
        $data = $resultMobil['data'];
    
        // Menggabungkan data Motor dengan data Kendaraan
        $resultMotor = $this->mergeMotorDataWithJenis($data, $motorData);
        $data = $resultMotor['data'];
    
        return array_merge([
            'data' => $data,
        ]);
    }
    
    public function getTerjualKendaraanByPage(int $page, int $size, string $jenis): array
    {
        // Membuat objek Pagination dengan halaman dan ukuran halaman yang ditentukan
        $pagination = new Pagination($page, $size);
    
        // Membuat query untuk mengambil data kendaraan yang terjual dan diurutkan berdasarkan waktu pembuatan
        $query = Kendaraan::where('terjual', true)
            ->orderBy('created_at', 'desc');
    
        // Menggunakan objek Pagination untuk menerapkan paginasi pada query
        $query = $pagination->applyPagination($query);
    
        // Mengambil data kendaraan yang sudah dipaginasi dan mengubahnya menjadi array
        $data = $query->get()->toArray();
    
        // Ambil data Mobil dan Motor sesuai jenis
        $mobilData = $jenis === 'Mobil' ? $this->getMobilData() : [];
        $motorData = $jenis === 'Motor' ? $this->getMotorData() : [];
    
        // Menggabungkan data Mobil atau Motor dengan data Kendaraan
        $result = $jenis === 'Mobil'
            ? $this->mergeMobilDataWithJenis($data, $mobilData)
            : $this->mergeMotorDataWithJenis($data, $motorData);
    
        $data = $result['data'];
        $terjualCount = $jenis === 'Mobil' ? $result['terjual_mobil'] : $result['terjual_motor'];
    
        $response = [
            'data' => $data,
        ];
    
        if ($jenis === 'Mobil') {
            $response['mobil_terjual'] = $terjualCount;
        } elseif ($jenis === 'Motor') {
            $response['motor_terjual'] = $terjualCount;
        }
    
        return array_merge($response, $pagination->toArray());
    }    
}
