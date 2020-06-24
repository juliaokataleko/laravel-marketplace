<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class SubCategory extends Model
{
    //
    protected $fillable = [
        'name', 'icon', 'status', 
        'user_id', 'category_id', 'slug'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
