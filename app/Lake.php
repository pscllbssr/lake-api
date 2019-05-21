<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lake extends Model
{
    protected $fillable = ['key', 'title'];

    public function temperatures()
    {
        return $this->hasMany('App\Temperature')->orderBy('created_at', 'desc')->limit(10);
    }

    public function latestTemperature(){
        return $this->hasOne('App\Temperature')->orderBy('created_at', 'desc');
    }
    
}
