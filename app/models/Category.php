<?php

namespace App\models;

use App\User;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name', 'icon', 'status', 
        'user_id', 'slug'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subcategories() {
        return $this->hasMany(SubCategory::class);
    }

    public function products() {
        return $this->hasMany(Product::class);
    }

}
