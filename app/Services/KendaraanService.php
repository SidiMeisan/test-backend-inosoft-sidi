<?php 
namespace App\Services;

use App\Repositories\KendaraanRepository;
use Illuminate\Support\Collection;

class KendaraanService
{
    protected KendaraanRepository $kendaraanRepository;

    public function __construct(KendaraanRepository $kendaraanRepository)
    {
        $this->kendaraanRepository = $kendaraanRepository;
    }

    public function getStokDanKendaraanByPage(int $page, int $size): array
    {
        return $this->kendaraanRepository->getStokDanKendaraanByPage($page, $size);
    }

    public function jualKendaraan(int $id): bool
    {
        return $this->kendaraanRepository->updateTerjual($id);
    }
}
