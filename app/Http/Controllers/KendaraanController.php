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

    // Tambahkan method untuk megubah kendaraan menjadi terjual
    public function updateTerjual($id)
    {
        $result = $this->kendaraanService->updateTerjual($id);

        return response()->json($result);
    }

    public function getTerjualKendaraanByPage(Request $request, $jenis)
    {
        $page = $request->query('page', 1);
        $size = $request->query('size', 10);

        $result = $this->kendaraanService->getTerjualKendaraanByPage($page, $size, $jenis);

        return response()->json($result);
    }
}
