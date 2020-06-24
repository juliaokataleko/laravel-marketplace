<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\models\Category;
use App\models\Product;
use App\models\SubCategory;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Product::class, function (Faker $faker) {

    $userId = User::all()->pluck('id')->toArray();
    $categoryId = Category::all()->pluck('id')->toArray();
    $subCategoryId = SubCategory::all()->pluck('id')->toArray();

    return [
        'user_id'     => $faker->randomElement($userId),
        'category_id' => $faker->randomElement($categoryId),    
        'subcategory_id' => $faker->randomElement($$subCategoryId),  
        'name' => $faker->name,    
        'slug' => Str::random(30),
        'price' => 200000,
    ];
    
});
