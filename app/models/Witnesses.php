<?php

namespace App\models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Witnesses extends Model
{
    protected $fillable = [
        'user_name', 'message', 'status', 
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
