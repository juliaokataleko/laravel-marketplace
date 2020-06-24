<?php

namespace App\models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class RatingProduct extends Model
{
    //
    protected $fillable = [
        'user_id', 'product_id', 'stars', 
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
