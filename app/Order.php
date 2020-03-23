<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'product_id', 'permintaan','persediaan','produksi'
    ];

    public function product()
    {
        return $this->belongsTo('App\Product');
    }
}
