<?php

namespace App\Repositories;

use App\Models\Kendaraan;
use App\Repositories\Pagination;

use Illuminate\Database\Eloquent\Builder;

class KendaraanRepository
{
    public function getStokDanKendaraanByPage(int $page, int $size): array
    {
        $stok = Kendaraan::where('terjual', false)->count();

        $pagination = new Pagination($page, $size);
    
        $query = Kendaraan::where('terjual', false)
            ->orderBy('created_at', 'desc');
    
        $query = $pagination->applyPagination($query);
    
        $data = $query->get()->toArray();
    
        return array_merge([
            'stok' => $stok,
            'data' => $data,
        ], $pagination->toArray());
    }

    // Implementasikan metode-metode lainnya
}
