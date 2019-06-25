<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

//use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model 
{

    //use SoftDeletes;
    protected $table = 'cities';
    public $timestamps = true;
    protected $fillable = array('name');

    public function regions()
    {
        return $this->hasMany('App\Region','city_id');
    }

}