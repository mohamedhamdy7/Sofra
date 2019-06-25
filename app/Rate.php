<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model 
{

    protected $table = 'rates';
    public $timestamps = true;
    protected $fillable = array('client_id', 'restaurant_id', 'comment', 'rate', 'date');

    public function restaurant()
    {
        return $this->belongsTo('App\Restaurant');
    }
    public function client()
    {
        return $this->belongsTo('App\Client');
    }

}