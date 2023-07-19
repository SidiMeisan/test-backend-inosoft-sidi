<?php

namespace App\Repositories;

use App\Models\Kendaraan;
use App\Models\Mobil;
use App\Models\Motor;

use App\Repositories\Pagination;
use Jenssegers\Mongodb\Query\Builder as MongoBuilder;

class KendaraanRepository
{
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
    
        // Menggabungkan data Mobil dan Motor dengan data Kendaraan
        foreach ($data as &$item) {
            $kendaraanId = $item['_id'];
            $item['jenis'] = [];
            
            foreach ($mobilData as $mobil) {
                if ($mobil['kendaraan_id'] === $kendaraanId) {
                    $item['jenis'][] = [
                        'tipe' => 'Mobil',
                        'spesifikasi_tambahan' => $mobil
                    ];
                    break;
                }
            }
            
            foreach ($motorData as $motor) {
                if ($motor['kendaraan_id'] === $kendaraanId) {
                    $item['jenis'][] = [
                        'tipe' => 'Motor',
                        'spesifikasi_tambahan' => $motor
                    ];
                    break;
                }
            }
        }
    
        return array_merge([
            'stok' => $stok,
            'data' => $data,
        ], $pagination->toArray());
    }
    

    // Implement other methods
}
