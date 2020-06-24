<?php

namespace App\models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class NewsLetter extends Model
{
    protected $fillable = [
        'email', 'message', 'status', 
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function userSend()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

}
