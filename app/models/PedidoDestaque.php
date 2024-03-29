<?php

namespace App\Models;

use App\models\Product;
use App\User;
use Illuminate\Database\Eloquent\Model;

class PedidoDestaque extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
