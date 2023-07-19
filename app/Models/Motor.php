<?php

namespace App\Models;

use App\Models\Kendaraan;

class Motor extends Kendaraan
{
    
    protected $connection = 'mongodb2';
    protected $collection = 'Motor';

    protected $fillable = ['mesin', 'tipe_suspensi', 'tipe_transmisi'];

    public static function motorRules()
    {
        return [
            'mesin' => ['required', 'string', 'max:255'],
            'tipe_suspensi' => ['required', 'in:suspensi_depan,suspensi_belakang,suspensi_ganda'],
            'tipe_transmisi' => ['required', 'in:manual,otomatis'],
        ];
    }

    public function validate($data)
    {
        return validator($data, self::motorRules())->validate();
    }
}
