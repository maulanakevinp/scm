<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'peran'
    ];

    public $timestamps = false;

    public function users()
    {
        return $this->hasMany('App\User','peran');
    }
}
