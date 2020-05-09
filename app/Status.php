<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'status';
    protected $guarded = [];
    public $timestamps = false;

    public function orders()
    {
        return $this->hasMany('App\Order');
    }
}
