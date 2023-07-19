<?php

namespace App\Models;

use App\Models\Kendaraan;

class Mobil extends Kendaraan
{
    protected $connection = 'mongodb2';
    protected $collection = 'Mobil';

    protected $fillable = ['kendaraan_id', 'mesin', 'kapasitas_penumpang', 'tipe'];

    public static function mobilRules()
    {
        return [
            'mesin' => ['required', 'string', 'max:255'],
            'kapasitas_penumpang' => ['required', 'integer', 'min:1', 'max:10'],
            'tipe' => ['required', 'string', 'max:255'],
        ];
    }

    public function validate($data)
    {
        return validator($data, self::mobilRules())->validate();
    }
}
