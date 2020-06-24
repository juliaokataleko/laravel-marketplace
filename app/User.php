<?php

namespace App;

use App\models\Archive;
use App\models\Category;
use App\models\City;
use App\models\Discount;
use App\models\ImagePerProduct;
use App\models\Product;
use App\models\ProductsPerPurchase;
use App\models\Purchase;
use App\models\State;
use App\models\SubCategory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    // use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'username', 
        'gender', 'phone', 'role',
        'birth_day', 'birth_place', 
        'password', 'remember_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function categories() {
        return $this->hasMany(Category::class);
    }

    public function subcategories() {
        return $this->hasMany(SubCategory::class);
    }

    public function products() {
        return $this->hasMany(Product::class);
    }

    public function discounts() {
        return $this->hasMany(Discount::class);
    }

    public function images()
    {
        return $this->hasMany(Archive::class);
    }

    public function items_per_purchase()
    {
        return $this->hasMany(ProductsPerPurchase::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function states() {
        return $this->hasMany(State::class);
    }

    public function cities() {
        return $this->hasMany(City::class);
    }

    public function pedidos()
    {
        return $this->hasMany(PedidoDestaque::class);
    }
}
