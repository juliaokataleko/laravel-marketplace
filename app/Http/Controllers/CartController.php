<?php

namespace App\Http\Controllers;

use App\models\Product;
use App\models\ProductsPerPurchase;
use App\models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{

    public function index()
    {
        $message = "";
        $products = [];
        $discountValue = 0;
        $total = 0;
        $totalDiscount = 0;

        if(count($_SESSION['itens']) == 0) {
            $message = "carrinho Vazio";
        } else {
            
            foreach($_SESSION['itens'] as $productId => $quantidade) {

                $query = DB::select('select * from products 
                where id = ?', [$productId]);
                
                $product = $query;


                $product2 = array('quantidade' => $quantidade);

                $discount = DB::select('select * from discounts 
                where product_id = ? and status = ?', [$productId, 1]);

                if(count($discount) > 0) {
                    $discountValue = $discount['0']->discount;
                } else {
                    $discountValue = 0;
                }

                $product3 = array('discount' => $discountValue);

                $total_price = ($quantidade * $product['0']->price) - ($quantidade * $discountValue);
                $product4 = array('total_price' => $total_price);
                $total += $total_price;
                // echo $prouctFinal['quantidade'];

                $totalDiscount +=$discountValue * $quantidade;

                $prouctFinal = $product + $product2 + $product3 + $product4;
                if($quantidade >  0) {
                    $products[] = $prouctFinal;
                } else {
                    unset($_SESSION['itens'][$productId]);
                }

                
                
            }

            # dd($products);
        }

        return view('cart', compact('products', 'totalDiscount', 'message', 'total'));
    }


    public function add(Product $product)
    {

        if(isset($product->id)) {
            if(!isset($_SESSION['itens'][$product->id])) {
                if($product->quantity > 0) {
                    $message = "Producto Adicionado com sucesso";
                    $_SESSION['itens'][$product->id] = 1;
                } else {
                    $message = "Não tem stock suficiente";
                }              
            } else {
                foreach($_SESSION['itens'] as $productId => $quantidade) {

                    if($product->id == $productId) {
                        if($product->quantity > $quantidade) {
                            $message = "Producto Adicionado com sucesso";
                            $_SESSION['itens'][$product->id] += 1;
                        } else {
                            $message = "Não tem stock suficiente";
                        }
                        break;
                    }
                }
            }
        }
        $total = count($_SESSION['itens']);
        echo json_encode([
            'message' => $message,
            'total' => $total
            ]);
    }

    public function addMore(Product $product)
    {

        if(isset($product->id)) {
            if(!isset($_SESSION['itens'][$product->id])) {
                if($product->quantity > 0) {
                    $message = "Producto Adicionado com sucesso";
                    $_SESSION['itens'][$product->id] = 1;
                } else {
                    $message = "Não tem stock suficiente";
                }              
            } else {
                foreach($_SESSION['itens'] as $productId => $quantidade) {

                    if($product->id == $productId) {
                        if($product->quantity > $quantidade) {
                            $message = "Producto Adicionado com sucesso";
                            $_SESSION['itens'][$product->id] += 1;
                        } else {
                            $message = "Não tem stock suficiente";
                        }
                        break;
                    }
                }
            }
        }

        
        return redirect()->back()->with('message', $message);
    }

    public function remove(Product $product)
    {

        if(isset($product->id)) {
            if(!isset($_SESSION['itens'][$product->id])) {
                $message = "Produto removido";
            } else {
                $message = "Quantidade do produto diminuida.";
                $_SESSION['itens'][$product->id] -= 1;
            }
        }

        return redirect()->back()->with('message', $message);
    }

    public function removeProduct(Product $product)
    {

        if(isset($product->id)) {
            if(!isset($_SESSION['itens'][$product->id])) {
                $message = "Produto removido";
            } else {
                $message = "Produto removido";
                $_SESSION['itens'][$product->id] = 0;
            }
        }

        return redirect()->back()->with('message', $message);
    }

    public function removeAll()
    {

        $_SESSION['itens'] = [];

        $message = "O seu carrinho de compras foi reiniciado.";

        return redirect()->back()->with('message', $message);
    }

    public function finishPurchase (Request $request) {

        if(!Auth::check()) return redirect()->back()->with('warning', 'Tens que iniciar sessão para finalizar sua compra');

        $message = "";
        $products = [];
        $discountValue = 0;
        $total = 0;
        $totalDiscount = 0;

        if(count($_SESSION['itens']) == 0) {
            $message = "carrinho Vazio";
        } else {
            
            foreach($_SESSION['itens'] as $productId => $quantidade) {
                $query = DB::select('select * from products 
                where id = ?', [$productId]);
                
                $product = $query;


                $product2 = array('quantidade' => $quantidade);

                $discount = DB::select('select * from discounts 
                where product_id = ? and status = ?', [$productId, 1]);

                if(count($discount) > 0) {
                    $discountValue = $discount['0']->discount;
                } else {
                    $discountValue = 0;
                }

                $product3 = array('discount' => $discountValue);

                $total_price = ($quantidade * $product['0']->price) - ($quantidade * $discountValue);
                $product4 = array('total_price' => $total_price);
                $total += $total_price;
                // echo $prouctFinal['quantidade'];

                $totalDiscount +=$discountValue * $quantidade;

                $prouctFinal = $product + $product2 + $product3 + $product4;
                if($quantidade >  0) {
                    $products[] = $prouctFinal;
                } else {
                    unset($_SESSION['itens'][$productId]);
                }
                
            }

            # dd($products);

        }

        $totalValue = $total + $totalDiscount;

        // inserindo os dados na tabela de pedidos...
        if(DB::insert('insert into 
            purchases (user_id,  to_pay, discount, total, created_at) 
            values (?, ?, ?, ?, ?)', [
                Auth::user()->id, $total, 
                $totalDiscount,
                $totalValue,
                date("Y-m-d H:i:s")
            ])) {
            
            $id = DB::getPdo()->lastInsertId();

            foreach($_SESSION['itens'] as $productId => $quantidade) {
                $query = DB::select('select * from products 
                where id = ?', [$productId]);
                
                $product = $query;


                $product2 = array('quantidade' => $quantidade);

                $discount = DB::select('select * from discounts 
                where product_id = ? and status = ?', [$productId, 1]);

                if(count($discount) > 0) {
                    $discountValue = $discount['0']->discount;
                } else {
                    $discountValue = 0;
                }

                $product3 = array('discount' => $discountValue);

                $total_price = ($quantidade * $product['0']->price) - ($quantidade * $discountValue);
                $product4 = array('total_price' => $total_price);
                $total += $total_price;
                // echo $prouctFinal['quantidade'];

                $totalDiscount +=$discountValue * $quantidade;

                $prouctFinal = $product + $product2 + $product3 + $product4;
                if($quantidade >  0) {
                    $products[] = $prouctFinal;
                } else {
                    unset($_SESSION['itens'][$productId]);
                }

                $new_quantity = $product['0']->quantity - $quantidade;

                // colocar apenas na hora de finalizar a compra
                /*
                DB::update("update products set quantity 
                = '$new_quantity' where id = '$productId'");
                */

                if(DB::insert('insert into 
                products_per_purchases (
                    purchase_id, 
                    product_id,
                    quantity,
                    price,
                    user_id, 
                    discount,
                    created_at, 
                    total) 
                values (?, ?, ?, ?, ?, ?, ?, ?)', [
                    $id, 
                    $productId,
                    $quantidade,
                    $product['0']->price,
                    Auth::user()->id, 
                    $discountValue,
                    date("Y-m-d H:i:s"),
                    $total_price
                ])) {
                    
                }
                    
            }

            unset($_SESSION['itens']);

            $message = "O seu pedido foi enviado com sucesso.";

            return redirect()->back()->with('message', $message);
            
        }

    }

    public function purchases()
    {
        $purchases = Purchase::orderBy('id', 'DESC')->with('user')->with('items.product')->paginate(10);
        return view('admin.purchase.index', compact('purchases'));
    }

    public function myPurchases()
    {
        $myPurchases = Purchase::orderBy('id', 'DESC')
        ->where('user_id', Auth::user()->id)
        ->with('user')->with('items')->paginate(10);

        return view('user.my-purchases', compact('myPurchases'));

    }

    public function finish(Purchase $purchase)
    {

        if(!Auth::check()) return redirect()->back()->with('warning', 'Tens que iniciar sessão para finalizar sua compra');

        if($purchase->status == 1) {
            $success = "Compra cancelada.";

            $products = ProductsPerPurchase::where('purchase_id', $purchase->id)->get();

            foreach($products as $pro) {
                $product = Product::findORFail($pro->product_id);
                $product->quantity = $product->quantity + $pro->quantity;
                $product->save();
            }

            $purchase->status = 0;
        } else {
            $success = "Compra confirmada.";
            $products = ProductsPerPurchase::where('purchase_id', $purchase->id)->get();

            foreach($products as $pro) {
                $product = Product::findORFail($pro->product_id);
                $product->quantity = $product->quantity - $pro->quantity;
                $product->save();
            }

            $purchase->status = 1;
        }

        if($purchase->save()) {
            return redirect()->back()->with('success', $success);
        }
    }

}
