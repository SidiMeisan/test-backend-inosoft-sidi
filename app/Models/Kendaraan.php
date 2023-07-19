<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Validation\Rule;

class Kendaraan extends Model
{
    protected $connection = 'mongodb2';
    protected $collection = 'Kendaraan';
    protected $fillable = ['tahun_keluaran', 'warna', 'harga', 'terjual'];

    public static function rules()
    {
        return [
            'tahun_keluaran' => ['required', 'integer', 'min:1900', 'max:' . date('Y')],
            'warna' => ['required', 'string', 'max:255'],
            'harga' => ['required', 'numeric', 'min:0'],
        ];
    }

    public function validate($data)
    {
        return validator($data, self::rules())->validate();
    }
}
