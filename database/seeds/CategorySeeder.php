<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            'name' => 'Software',
            'slug' => 'software',
            'user_id' => 1
        ]);

        DB::table('categories')->insert([
            'name' => 'Aplicativos',
            'slug' => 'aplicativos',
            'user_id' => 1
        ]);

        DB::table('categories')->insert([
            'name' => 'Jogos',
            'slug' => 'jogos',
            'user_id' => 1
        ]);

        DB::table('categories')->insert([
            'name' => 'Segurança',
            'slug' => 'seguranca',
            'user_id' => 1
        ]);
    }
}
