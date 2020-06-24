<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sub_categories')->insert([
            'name' => 'Gestão E Evendas',
            'slug' => 'gestao-e-vendas',
            'category_id' => 1,
            'user_id' => 1,
        ]);

        DB::table('sub_categories')->insert([
            'name' => 'Empresas',
            'slug' => 'empresas',
            'category_id' => 1,
            'user_id' => 1
        ]);

        DB::table('sub_categories')->insert([
            'name' => 'Comunicação',
            'slug' => 'comunicacao',
            'category_id' => 1,
            'user_id' => 1
        ]);

        DB::table('sub_categories')->insert([
            'name' => 'Agilidade',
            'slug' => 'agilidade',
            'category_id' => 1,
            'user_id' => 1
        ]);

        DB::table('sub_categories')->insert([
            'name' => 'Redes Sociais',
            'slug' => 'redes-sociais',
            'category_id' => 2,
            'user_id' => 1
        ]);

        DB::table('sub_categories')->insert([
            'name' => 'MarktPlaces',
            'slug' => 'marketplaces',
            'category_id' => 2,
            'user_id' => 1
        ]);

        DB::table('sub_categories')->insert([
            'name' => 'E-commerce',
            'slug' => 'e-commerce',
            'category_id' => 2,
            'user_id' => 1
        ]);
    }
}
