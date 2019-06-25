<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model 
{

    protected $table = 'settings';
    public $timestamps = true;
    protected $fillable = array('facebook_url', 'android_app_url', 'instagram_url', 'twitter_url', 'about_app');

}