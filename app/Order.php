<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model 
{

    protected $table = 'orders';
    public $timestamps = true;
    protected $fillable = array('restaurant_id', 'status', 'address', 'order_number', 'price', 'delivery_cost', 'total', 'client_phone', 'client_id', 'privte_order', 'total_summation', 'payment');

    public function items()
    {
        return $this->belongsToMany('App\Item')->withPivot('price','notes','quantity');
    }

    public function cards()
    {
        return $this->hasMany('App\Card');
    }

    public function client(){
        return $this->belongsTo('App\Client');
    }

    public function restaurant(){
        return $this->belongsTo('App\Restaurant');
    }

}