<?php

namespace App\Http\Controllers;

use App\models\Category;
use App\models\Discount;
use App\models\Archive;
use App\models\Product;
use App\models\RatingProduct;
use App\models\State;
use App\models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (isset($_GET['query'])) {
            $query = addslashes($_GET['query']);

            $products = Product::with('user')->with('images')
                ->with('subcategory')->with('category')->where('name', $query)
                ->orWhere('name', 'like', '%' . $_GET['query'] . '%')
                ->orderBy('id', 'desc')->paginate(10)->appends(request()->query());
        } else {
            $products = Product::with('user')->with('images')->with('subcategory')
                ->with('category')->orderBy('id', 'desc')->paginate(10)->appends(request()->query());
        }

        $total_products = Product::all();

        return view('admin.product.index', compact('products', 'total_products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $states = State::all();

        return view('admin.product.create', 
        compact('categories', 'states'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        # dd($request->all());

        $data = request()->validate([
            'name' => 'required',
            'category_id' => 'required',
            'featured' => 'required',
            'quantity' => 'required',
            'video_frame' => '',
            'subcategory_id' => 'required',
            'description' => '',
            'price' => 'required',
            'quality' => 'required',
            'status' => 'required',
            'city_id' => '',
            'state_id' => ''
        ]);

        $data['slug'] = slug($data['name']);

        $slugCheck = Product::where('slug', $data['slug'])->get();

        if (count($slugCheck) > 0) {
            $data['slug'] = slug($data['name']) . '-' . date("His");
        }

        $data['quantity'] = (int)$data['quantity'];

        $data['user_id'] = Auth::user()->id;

        // dd($data);

        if ($product = Product::create($data)) {

            $dataDiscount = ([
                'product_id' => $product->id,
                'discount' => 0,
            ]);

            auth()->user()->discounts()->create($dataDiscount);

            $request->session()->flash('success', 'Producto registado com successo');
            return redirect(BASE_URL.'/admin/product');
        }

        $request->session()->flash('warning', 'Falha ao registar um producto');
        return redirect(BASE_URL.'/admin/product');
    }

    public function userStore(Request $request)
    {

        # dd($request->all());

        $data = request()->validate([
            'name' => 'required',
            'category_id' => 'required',
            'quantity' => 'required',
            'video_frame' => '',
            'subcategory_id' => 'required',
            'description' => '',
            'price' => 'required',
            'quality' => 'required',
            'status' => 'required',
            'city_id' => '',
            'state_id' => ''
        ]);

        $data['slug'] = slug($data['name']);

        $slugCheck = Product::where('slug', $data['slug'])->get();

        if (count($slugCheck) > 0) {
            $data['slug'] = slug($data['name']) . '-' . date("His");
        }

        $data['quantity'] = (int)$data['quantity'];

        $data['user_id'] = Auth::user()->id;

        // dd($data);

        if ($product = Product::create($data)) {

            $dataDiscount = ([
                'product_id' => $product->id,
                'discount' => 0,
            ]);

            auth()->user()->discounts()->create($dataDiscount);

            $request->session()->flash('success', 'Producto registado com successo');
            return redirect(BASE_URL.'/profile');
        }

        $request->session()->flash('warning', 'Falha ao registar um producto');
        return redirect(BASE_URL.'/profile');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $product = Product::
        where('slug', '=', $slug)
        ->where('status', 1)
        ->where('quantity', '>', 0)
        ->with('user')
        ->with('discounts')
        ->with('images')
        ->with('subcategory')
        ->with('category')
        ->with('ratings.user')
        ->first();

        
        $media = 0;
        
        $totalRatings = count($product->ratings);

        // dd($totalRatings);
        
        $totalPoints = 0;

        foreach($product->ratings as $rat) {
            $totalPoints += $rat->stars;
        }

        if($totalRatings > 0)
            $media = $totalPoints / $totalRatings;

        $rated = new RatingController();

        $rate = $rated->isRated($product, 0);
        $rateId = 0;
        $rateMessage = "";

        if($rate) {
            $rating = RatingProduct::where('product_id', $product->id)
            ->where('user_id', Auth::user()->id)->first();
            $rateId = $rating->id;
            $rateMessage = $rating->message;
        }
        
        // dd($rate);

        $me = 0;
        if(Auth::check()) {
            $me = Auth::user()->id;
        }
        // dd($product);

        $otherProducts = Product::where('category_id', '=', $product->category_id)
        ->orWhere('subcategory_id', '=', $product->subcategory_id)
        ->where('id', '<>', $product->id)
        ->where('status', 1)
        ->where('quantity', '>', 0)
        ->with('user')
        ->with('discounts')
        ->with('images')
        ->with('subcategory')
        ->with('category')
        ->inRandomOrder()
        ->take(8)
        ->get();
        
        $categories = Category::where('status', 1)->with('user')
        ->with('subcategories')->with('products')->get();

        return view('product', compact('slug', 
        'product', 
        'media',
        'rate',
        'rateId',
        'rateMessage',
        'otherProducts',
        'categories'));        
    }

    public function getProduct($slug)
    {
    
        $product = Product::
        where('slug', '=', $slug)
        ->where('status', 1)
        ->where('quantity', '>', 0)
        ->with('user')
        ->with('discounts')
        ->with('images')
        ->with('subcategory')
        ->with('category')
        ->with('ratings.user')
        ->first();

        
        $media = 0;
        
        $totalRatings = count($product->ratings);

        // dd($totalRatings);
        
        $totalPoints = 0;

        foreach($product->ratings as $rat) {
            $totalPoints += $rat->stars;
        }

        if($totalRatings > 0)
            $media = $totalPoints / $totalRatings;

        $rated = new RatingController();

        $rate = $rated->isRated($product, 0);
        $rateId = 0;
        $rateMessage = "";

        if($rate) {
            $rating = RatingProduct::where('product_id', $product->id)
            ->where('user_id', Auth::user()->id)->first();
            $rateId = $rating->id;
            $rateMessage = $rating->message;
        }

        $me = 0;
        if(Auth::check()) {
            $me = Auth::user()->id;
        }
        // dd($product);

        $otherProducts = Product::where('category_id', '=', $product->category_id)
        ->orWhere('subcategory_id', '=', $product->subcategory_id)
        ->where('id', '<>', $product->id)
        ->where('status', 1)
        ->where('quantity', '>', 0)
        ->with('user')
        ->with('discounts')
        ->with('images')
        ->with('subcategory')
        ->with('category')
        ->inRandomOrder()
        ->take(8)
        ->get();

        echo json_encode([
            'product' => $product, 
            'rate' => $rate,
            'rateId' => $rateId,
            'me' => $me,
            'media' => $media,
            'rateMessage' => $rateMessage,
            'otherProducts' => $otherProducts
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        $states = State::all();
        $query = SubCategory::find($product->subcategory_id);

        // dd($query);

        $subCatName = $query->name;

        $product = Product::with('images')->find($product->id);

        $discount = Discount::where('product_id', $product->id)->first();

        # dd($discount);
        return view('admin.product.edit', 
        compact('product', 'discount', 'states', 'subCatName', 'categories'));
    }

    public function editUserProduct(Product $product)
    {
        $product = Product::where('user_id', Auth::user()->id)
        ->where('id', $product->id)->firstOrFail();

        $categories = Category::all();
        $states = State::all();
        $query = SubCategory::find($product->subcategory_id);

        // dd($query);

        $subCatName = $query->name;

        $product = Product::with('images')->find($product->id);

        $discount = Discount::where('product_id', $product->id)->first();

        # dd($discount);
        return view('edit-product', 
        compact('product', 'discount', 'states', 'subCatName', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Product $product, Request $request)
    {
        $data = request()->validate([
            'name' => 'required',
            'category_id' => 'required',
            'subcategory_id' => 'required',
            'description' => '',
            'video_frame' => '',
            'featured' => 'required',
            'quantity' => 'required',
            'price' => 'required',
            'quality' => 'required',
            'status' => 'required',
            'city_id' => '',
            'state_id' => ''
        ]);

        $data['updated_at'] = date("Y-m-d H:i:s");

        $data['slug'] = slug($data['name']);

        $slugCheck = Product::where('slug', $data['slug'])->get();

        if (count($slugCheck) > 1) {
            $data['slug'] = slug($data['name']) . '-' . date("His");
        }

        $save = DB::table('products')
            ->where('id', $product->id)
            ->update($data);

        $dataDiscount = request()->validate([
            'discount' => 'required',
            'status_discount' => '',
            'date_finish' => ''
        ]);

        if ($dataDiscount['status_discount'] == 1) {
            $dataDiscount = request()->validate([
                'discount' => 'required',
                'status_discount' => '',
                'date_finish' => 'after:today'
            ]);
        }

        $dataDiscount['status'] = $dataDiscount['status_discount'];

        unset($dataDiscount['status_discount']);

        # dd($dataDiscount);

        $save = DB::table('discounts')
            ->where('product_id', $product->id)
            ->update($dataDiscount);

        if (isset($_FILES['fotos'])) {
            $fotos = $_FILES['fotos'];
        } else {
            $fotos = array();
        }

        // carregar fotos
        // dd($fotos);

        if (count($fotos) > 0) {
            for ($q = 0; $q < count($fotos['tmp_name']); $q++) {
                $tipo = $fotos['type'][$q];
                if (in_array($tipo, array('image/jpeg', 'image/png'))) {
                    $tmpname = md5(time() . rand(0, 9999)) . '.jpg';
                    move_uploaded_file($fotos['tmp_name'][$q], 'uploads/products/' . $tmpname);

                    list($width_orig, $height_orig) = getimagesize('uploads/products/' . $tmpname);
                    $ratio = $width_orig / $height_orig;

                    // $width = 500;
                    // $height = 500;

                    // if ($width / $height > $ratio) {
                    //     $width = $height * $ratio;
                    // } else {
                    //     $height = $width * $ratio;
                    // }


                    $width = $width_orig;
                    $height = $height_orig;

                    // if ($width > $height) {
                    //     $width = $height;
                    // } else {
                    //     $height = $width;
                    // }

                    $img = imagecreatetruecolor($width, $height);
                    if ($tipo == 'image/jpeg') {
                        $origi = imagecreatefromjpeg('uploads/products/' . $tmpname);
                    } else if ($tipo == 'image/png') {
                        $origi = imagecreatefrompng('uploads/products/' . $tmpname);
                    }

                    imagecopyresampled($img, $origi, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
                    imagejpeg($img, 'uploads/products/' . $tmpname, 80);

                    $dataImage = ([
                        'file' => $tmpname,
                        'product_id' => $product->id
                    ]);

                    if (auth()->user()->images()->create($dataImage)) {
                    }
                }
            }
        }

        if ($save) {
            $request->session()->flash('success', 'Producto actualizado com sucesso.');
            return redirect()->back();
        } else {
            echo "Algo correu mal...";
        }
    }

    public function userUpdateProduct(Product $product, Request $request)
    {
        $product = Product::where('user_id', Auth::user()->id)
        ->where('id', $product->id)->firstOrFail();

        $data = request()->validate([
            'name' => 'required',
            'category_id' => 'required',
            'subcategory_id' => 'required',
            'description' => '',
            'video_frame' => '',
            'quantity' => 'required',
            'price' => 'required',
            'quality' => 'required',
            'status' => 'required',
            'city_id' => '',
            'state_id' => ''
        ]);

        $data['updated_at'] = date("Y-m-d H:i:s");

        $data['slug'] = slug($data['name']);

        $slugCheck = Product::where('slug', $data['slug'])->get();

        if (count($slugCheck) > 1) {
            $data['slug'] = slug($data['name']) . '-' . date("His");
        }

        $save = DB::table('products')
            ->where('id', $product->id)
            ->update($data);

        if (isset($_FILES['fotos'])) {
            $fotos = $_FILES['fotos'];
        } else {
            $fotos = array();
        }

        // carregar fotos
        // dd($fotos);

        if (count($fotos) > 0) {
            for ($q = 0; $q < count($fotos['tmp_name']); $q++) {
                $tipo = $fotos['type'][$q];
                if (in_array($tipo, array('image/jpeg', 'image/png'))) {
                    $tmpname = md5(time() . rand(0, 9999)) . '.jpg';
                    move_uploaded_file($fotos['tmp_name'][$q], 'uploads/products/' . $tmpname);

                    list($width_orig, $height_orig) = getimagesize('uploads/products/' . $tmpname);
                    $ratio = $width_orig / $height_orig;

                    // $width = 500;
                    // $height = 500;

                    // if ($width / $height > $ratio) {
                    //     $width = $height * $ratio;
                    // } else {
                    //     $height = $width * $ratio;
                    // }


                    $width = $width_orig;
                    $height = $height_orig;

                    // if ($width > $height) {
                    //     $width = $height;
                    // } else {
                    //     $height = $width;
                    // }

                    $img = imagecreatetruecolor($width, $height);
                    if ($tipo == 'image/jpeg') {
                        $origi = imagecreatefromjpeg('uploads/products/' . $tmpname);
                    } else if ($tipo == 'image/png') {
                        $origi = imagecreatefrompng('uploads/products/' . $tmpname);
                    }

                    imagecopyresampled($img, $origi, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
                    imagejpeg($img, 'uploads/products/' . $tmpname, 80);

                    $dataImage = ([
                        'file' => $tmpname,
                        'product_id' => $product->id
                    ]);

                    if (auth()->user()->images()->create($dataImage)) {
                    }
                }
            }
        }

        if ($save) {
            $request->session()->flash('success', 'Producto actualizado com sucesso.');
            return redirect()->back();
        } else {
            echo "Algo correu mal...";
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, Request $request)
    {
        if ($product->user_id == Auth::user()->id || Auth::user()->role == 1) {

            $product = Product::with('images')->find($product->id);

            $discount = Discount::where('product_id', $product->id)->first();
            $discount->delete();

            foreach ($product->images as $image) {
                if (null != $image->file && file_exists('uploads/products/' . $image->file)) {
                    if (unlink('uploads/products/' . $image->file)) {
                    }
                }
            }

            $product->delete();
            $request->session()->flash('success', 'Producto excluído com sucesso.');
            return redirect()->back();
        }

        $request->session()->flash('warning', 'Não pode efectuar esta acção.');
        return redirect()->back();
    }

    public function imageGelete(Archive $image, Request $request)
    {
        
        # dd($image->product->user->id);

        if($image->product->user->id == Auth::user()->id) {
            
            if (null != $image->file && file_exists('uploads/products/' . $image->file)) {
                if (unlink('uploads/products/' . $image->file)) {
                }
            }

            $image->delete();

            $request->session()->flash('success', 'Imagem excluída com sucesso.');
            return redirect()->back();
        }

        $request->session()->flash('warning', 'Não pode excluir esta imagem.');
        return redirect()->back();
    }

    // carregando produtos com vue
    public function getProducts(Request $request)
    {

        $products = Product::with('user')
            ->orderBy('id', 'DESC')
            ->where('status', 1)
            ->where('quantity', '>', 0)
            ->with('discounts')
            ->with('images')
            ->with('subcategory')
            ->with('category')->take(4)->get();

        $totalProducts = Product::with('user')
            ->where('status', 1)
            ->where('quantity', '>', 0)
            ->with('discounts')
            ->with('images')
            ->with('subcategory')
            ->with('category')->get();

        $featureds = Product::where('featured', 1)
            ->where('status', 1)
            ->where('quantity', '>', 0)
            ->with('user')
            ->with('discounts')
            ->with('images')
            ->with('subcategory')
            ->with('category')->take(3)->get();

        $count = count($products);
        $totalCount = count($totalProducts);

        echo json_encode(['products' => $products, 
                        'featureds' => $featureds, 
                        'count' => $count,
                        'totalCount' => $totalCount
        ]);
    }

    // carregando produtos com vue
    public function getMoreProducts(Request $request, $count, $next)
    {
        $item_per_page = $count + $next;

        $products = Product::where('status', 1)
            ->where('quantity', '>', 0)
            ->with('user')
            ->with('discounts')
            ->with('images')
            ->with('subcategory')
            ->with('category')->take($item_per_page)->get();
       

        $count = count($products);

        echo json_encode([
            'products' => $products,
            'count' => $count
        ]);
    }

    // carregando produtos com vue
    public function search(Request $request, $count, $next)
    {
        $item_per_page = $count + $next;

        $query = $request->get('q');

        if(!empty($request->get('cat'))) {
            $products = Product::where('name', $query)
            ->where('category_id', $request->get('cat'))
            ->orWhere('name', 'like', '%' . $query . '%')
            ->with('user')
                ->with('discounts')
                ->with('images')
                ->with('subcategory')
                ->with('category')->take($item_per_page)->get();
        } else {
            $products = Product::where('name', $query)
            ->orWhere('name', 'like', '%' . $query . '%')
            ->with('user')
                ->with('discounts')
                ->with('images')
                ->with('subcategory')
                ->with('category')->take($item_per_page)->get();
        }


        $count = count($products);

        echo json_encode([
            'products' => $products,
            'count' => $count
        ]);
    }

    // filtrando produtos por subcategoria
    public function getByCategory(Request $request, $slug)
    {
        $category = Category::where('slug', $slug)->first();

        $products = Product::where('category_id', $category->id)
            ->where('status', 1)
            ->where('quantity', '>', 0)
            ->with('user')
            ->with('discounts')
            ->with('images')
            ->with('subcategory')
            ->with('category')->take(40)->get();

        $count = count($products);

        /*
        echo json_encode([
            'products' => $products,
            'count' => $count
        ]);
        */

        $categoryName = $category->name;
        $categories = Category::where('status', 1)->with('user')
        ->with('subcategories')->with('products')->get();
        return view('category', compact('products', 'categories', 'categoryName', 'count'));
    }

    // filtrando produtos por subcategoria
    public function getBySubCategory(Request $request, $subcategory)
    {
        $slug = $subcategory;

        $subcategory = SubCategory::where('slug', $slug)->first();

        
        $products = Product::where('subcategory_id', $subcategory->id)
            ->where('status', 1)
            ->where('quantity', '>', 0)
            ->with('user')
            ->with('discounts')
            ->with('images')
            ->with('subcategory')
            ->with('category')->take(40)->get();

        $count = count($products);
        // dd($products);
        /*
        echo json_encode([
            'products' => $products,
            'count' => $count
        ]);
        */

        $subCategoryName = $subcategory->name;
        $categories = Category::where('status', 1)->with('user')
        ->with('subcategories')->with('products')->get();
        return view('subcategory', compact('products', 'categories', 
        'subCategoryName', 'count'));
    }

    
}
