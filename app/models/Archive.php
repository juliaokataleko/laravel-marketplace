<?php

namespace App\models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Archive extends Model
{
    protected $fillable = [
        'file', 'status', 'user_id', 
        'product_id', 'article_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
