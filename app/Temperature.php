<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Temperature extends Model
{

    protected $fillable = ['value'];

    public function lake()
    {
        return $this->belongsTo('App\Lake');
    }    
}