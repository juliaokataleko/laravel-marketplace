<?php

namespace App\models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class ProductsPerPurchase extends Model
{

    protected $fillable = [
        'user_id', 'purchase_id', 'product_id', 
        'price', 'quantity', 'discount', 'total'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    public function product() {
        return $this->belongsTo(Product::class);
    }


}
