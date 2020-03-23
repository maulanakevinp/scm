<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'nama',
        'harga',
        'foto',
        'permintaan_min',
        'permintaan_max',
        'persediaan',
        'persediaan_min',
        'persediaan_max',
        'produksi',
        'produksi_min',
        'produksi_max',
    ];

    public function orders()
    {
        return $this->hasMany('App\Order');
    }
}
