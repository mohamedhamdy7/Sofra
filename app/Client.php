<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model 
{

    protected $table = 'clients';
    public $timestamps = true;
    protected $fillable = array('name', 'email', 'phone', 'region_id', 'description', 'password', 'image', 'api_token', 'pin_code');
    protected $hidden = array('api_token', 'pin_code','password');



    public function region()
    {
        return $this->belongsTo('App\Region');
    }

    public function rates()
    {
        return $this->hasMany('App\Rate','client_id');
    }

    public function orders()
    {
        return $this->hasMany('App\Order');
    }

    public function cards()
    {
        return $this->hasMany('App\Card');
    }



    public function notifications(){
        return $this->morphMany('App\Notification','notifiable');
    }

    public function tokens()
    {
        return $this->morphMany('App\Token','tokenable');
    }

}