<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model 
{

    protected $table = 'notifications';
    public $timestamps = true;
    protected $fillable = array('title', 'content', 'date', 'time', 'restaurant_id', 'client_id');

    public function notifiable(){
        return $this->morphTo('notifiable');
    }

}