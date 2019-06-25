<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model 
{

    protected $table = 'restaurants';
    public $timestamps = true;
    protected $fillable = array('name', 'region_id', 'email', 'password', 'status', 'min_price', 'delivery_cost', 'phone', 'whatsapp', 'image', 'api_token', 'pin_code', 'delivery_way','category_id');

    protected $hidden=array('password','pin_code','api_token');

    public function categories()
    {
        return $this->belongsToMany('App\Category','category_restaurant','restaurant_id','category_id');
    }

    public function offers()
    {
        return $this->hasMany('App\Offer','restaurant_id');
    }

    public function region()
    {
        return $this->belongsTo('App\Region');
    }

    public function items()
    {
        return $this->hasMany('App\Item','restaurant_id');
    }

    public function orders()
    {
        return $this->hasMany('App\Order');
    }

    public function payments()
    {
        return $this->hasMany('App\Payment','restaurant_id');
    }

    public function rates()
    {
        return $this->hasMany('App\Rate','restaurant_id');
    }

    public function notifications(){
        return $this->morphMany('App\Notification','notifiable');
    }


    public function tokens()
    {
        return $this->morphMany('App\Token','tokenable');
    }



}