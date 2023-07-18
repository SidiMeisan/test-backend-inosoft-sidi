<?php

namespace App\Http\Controllers;

use App\Services\KendaraanService;

use Illuminate\Http\Request;
use App\Models\Kendaraan;

class KendaraanController extends Controller
{
    protected KendaraanService $kendaraanService;

    public function __construct(KendaraanService $kendaraanService)
    {
        $this->kendaraanService = $kendaraanService;
    }

    // Tambahkan method untuk mengambil stok kendaraan
    public function getStokDanKendaraanByPage(Request $request)
    {
        $page = $request->query('page', 1);
        $size = $request->query('size', 10);

        $result = $this->kendaraanService->getStokDanKendaraanByPage($page, $size);

        return response()->json($result);
    }
}
