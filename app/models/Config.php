<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    protected $fillable = [
        'name', 'url', 
        'slogan', 
        'num_pages', 
        'about', 
        'privacy_policy'
    ];

    public static function num_pages() {
        $config = Config::first();
        return $config->num_pages;
    }
}
