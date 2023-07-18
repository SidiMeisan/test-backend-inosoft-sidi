<?php

namespace App\Repositories;

use App\Models\Kendaraan;
use App\Repositories\Pagination;
use Jenssegers\Mongodb\Query\Builder as MongoBuilder;

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

    // Implement other methods
}
