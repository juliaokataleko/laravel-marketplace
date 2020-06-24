<?php

use App\models\Category;
use App\models\Product;
use App\models\SubCategory;
use App\User;
use Illuminate\Database\Seeder;

use Illuminate\Support\Str;

use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        for($i = 0; $i < 200; $i++) {

            $f = 0;
            if($i < 3)
                $f = 1;

            $product = DB::table('products')->insert([
                'user_id'     => 1,
                'category_id' => 1,    
                'subcategory_id' => 1,  
                'name' => "Nome do producto $i",   
                'description' => 'O Lorem Ipsum é um texto modelo da indústria 
                tipográfica e de impressão. O Lorem Ipsum tem vindo a ser o texto 
                padrão usado por estas indústrias desde o ano de 1500, quando uma 
                misturou os caracteres de um texto para criar um espécime de livro. 
                Este texto não só sobreviveu 5 séculos, mas também o salto para a 
                tipografia electrónica, mantendo-se essencialmente inalterada. Foi 
                popularizada nos anos 60 com a disponibilização das folhas de 
                Letraset, que continham passagens com Lorem Ipsum, e mais 
                recentemente com os programas de publicação 
                como o Aldus PageMaker que incluem versões do Lorem Ipsum.', 
                'slug' => "slug-$i",
                'price' => '25000',
                'quantity' => 50,
                'featured' => $f
            ]);

            $p = Product::orderBy('id', 'desc')->first();
            
            $statusD = 0;
            $d = 0;
            $finish = date('Y-m-d', strtotime("+30 days"));

            if($i < 5) {
                $statusD = 1;
                $d = 1000;
            }

            DB::table('discounts')->insert([
                'user_id'     => $p->user_id,
                'product_id' => $p->id,    
                'discount' => $d,
                'status' => $statusD,
                'date_finish' => $finish 
            ]);

        }
        
    }

}
