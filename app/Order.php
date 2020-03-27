<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'product_id', 'keterangan', 'permintaan','persediaan','produksi', 'bukti_transfer', 'alasan_penolakan'
    ];

    public function product()
    {
        return $this->belongsTo('App\Product');
    }
}
