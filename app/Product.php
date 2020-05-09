<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'nama',
        'harga',
        'foto',
        'satuan',
        'permintaan',
        'minimal_permintaan',
        'persediaan',
        'produksi',
    ];

    public function orders()
    {
        return $this->hasMany('App\Order');
    }
}
