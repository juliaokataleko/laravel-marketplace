<?php

namespace App\models;
use App\User;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cities() {
        return $this->hasMany(City::class);
    }

    public function products() {
        return $this->hasMany(Product::class);
    }
}
