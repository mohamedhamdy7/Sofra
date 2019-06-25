<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model 
{

    protected $table = 'offers';
    public $timestamps = true;
    protected $fillable = array('name', 'restaurant_id', 'price', 'description', 'image', 'start_from', 'end_at');

    public function restaurant()
    {
        return $this->belongsTo('App\Restaurant','restaurant_id');
    }
}
