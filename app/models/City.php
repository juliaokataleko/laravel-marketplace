<?php

namespace App\models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function products() {
        return $this->hasMany(Product::class);
    }
}
