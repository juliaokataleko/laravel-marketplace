<?php

namespace App\models;

use App\User;
use Illuminate\Database\Eloquent\Model;

$table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('article_id');
            $table->text('comment', 200);
            $table->integer('status')->default(0);
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
class Comment extends Model
{
    protected $fillable = [
        'comment', 'name', 'user_id', 
        'email', 'status', 'phone'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
