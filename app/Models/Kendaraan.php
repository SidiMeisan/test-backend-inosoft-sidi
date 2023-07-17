<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Kendaraan extends Model
{
    protected $connection = 'mongodb2';
    protected $collection = 'Kendaraan';
    protected $fillable = ['tahun_keluaran', 'warna', 'harga'];
}
