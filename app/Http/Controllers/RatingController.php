<?php

namespace App\Http\Controllers;

use App\models\Product;
use App\models\RatingProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function add(Product $product, $stars)
    {

        if(Auth::check()):
        
        if($this->isRated($product, $stars) == false){
            $rating = new RatingProduct();
            $rating->user_id = Auth::user()->id;
            $rating->product_id = $product->id;
            $rating->stars = $stars;
            $rating->save();
        } else if($this->isRated($product, $stars) == 1){
            $id = $product->id;
            $rating = RatingProduct::where('product_id', $id)
            ->where('user_id', Auth::user()->id)->first();
            
            $rating->stars = $stars;
            $rating->save();
        }

        endif;
        
        return redirect()->back();
        
    }

    public function isRated($product, $stars) {

        if(Auth::check()) {
        $rating = RatingProduct::where('product_id', $product->id)
        ->where('user_id', Auth::user()->id)->first();

        if($rating) {
            if($stars == 0) 
                return true;
            else {
                if($rating->stars == $stars) {
                    return true;
                } else {
                    $_SESSION['rate'] = $rating->id;
                    return 1;
                }
            }
            
        } else {
            return false;
        }
        } else {
            return false;
        }
    }

    public function update(Request $request, RatingProduct $rate)
    {
        if(Auth::check()):
        $rate->message = $request->get("message");
        $rate->save();
        endif;
        
        return redirect()->back();
    }

    public function destroy(RatingProduct $rate)
    {
        echo "A pagina funcionou...";
        # dd($rate);
        $rate->delete();
        return redirect()->back();
    }

    public function destroyAdmin($id)
    {
        $rate = RatingProduct::findOrFail($id);
        $rate->delete();
        return redirect()->back();
    }
}
