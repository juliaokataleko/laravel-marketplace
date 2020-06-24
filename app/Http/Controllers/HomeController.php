<?php

namespace App\Http\Controllers;

use App\Mail\MyMail;
use App\Mail\EmailRecover;
use App\models\Category;
use App\models\Product;
use App\models\RatingProduct;
use App\models\State;
use App\models\SubCategory;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware(['auth', 'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $category = '';
        $subcategory = '';

        if (isset($_GET['preco'])) {
            $preco = explode('-', $_GET['preco']);
            $min_price = $preco[0];
            $max_price = $preco[1];
        }

        $products = Product::query();

        if (request()->has('categoria') && !empty(request('categoria'))) {
            $products->where('category_id', request('categoria'));
        }

        if (request()->has('q')  && !empty(request('q'))) {
            $products->where('name', 'like', '%' . request('q') . '%');
        }

        if (request()->has('state')  && !empty(request('state'))) {
            $products->where('state_id', request('state'));
        }

        if (request()->has('city')  && !empty(request('city'))) {
            $products->where('city_id', request('city'));
        }

        if (request()->has('preco')) {
            $products->whereBetween('price', [$min_price, $max_price]);
        }

        $featureds = Product::where('featured', 1)
            ->where('status', 1)
            ->where('quantity', '>', 0)
            ->where('featured_limit', '>=', date("Y-m-d"))
            ->with('user')
            ->with('discounts')
            ->with('images')
            ->with('subcategory')
            ->inRandomOrder()
            ->with('category')->take(3)->get();

        $products = $products
            ->with('discounts')
            ->with('images')
            ->with('subcategory')
            ->with('category')
            ->with('ratings')
            ->where('quantity', '>', 0)
            ->orderBy('id', 'desc')->paginate(12)->appends(request()->query());;

        $count = count($products);


        $categories = Category::where('status', 1)
            ->with('user')
            ->with('subcategories')
            ->with('products')->get();

        $states = State::all();

        return view('home', compact(
            'categories',
            'products',
            'featureds',
            'states'
        ));
    }

    public function ofertas(Request $request)
    {
        $category = '';
        $subcategory = '';


        if (isset($_GET['preco'])) {
            $preco = explode('-', $_GET['preco']);
            $min_price = $preco[0];
            $max_price = $preco[1];
        }

        $products = Product::query();

        if (request()->has('categoria') && !empty(request('categoria'))) {
            $products->where('category_id', request('categoria'));
        }

        if (request()->has('q')  && !empty(request('q'))) {
            $products->where('name', 'like', '%' . request('q') . '%');
        }

        if (request()->has('state')  && !empty(request('state'))) {
            $products->where('state_id', request('state'));
        }

        if (request()->has('city')  && !empty(request('city'))) {
            $products->where('city_id', request('city'));
        }

        if (request()->has('preco')) {
            $products->whereBetween('price', [$min_price, $max_price]);
        }

        $featureds = Product::where('featured', 1)
            ->where('status', 1)
            ->where('quantity', '>', 0)
            ->where('featured_limit', '>=', date("Y-m-d"))
            ->with('user')
            ->with('discounts')
            ->with('images')
            ->with('subcategory')
            ->inRandomOrder()
            ->with('category')->take(3)->get();

        $products = $products
            ->with('discounts')
            ->with('images')
            ->with('subcategory')
            ->with('category')
            ->with('ratings')
            ->where('quantity', '>', 0)
            ->orderBy('id', 'desc')->paginate(12)->appends(request()->query());;

        $count = count($products);


        $categories = Category::where('status', 1)
            ->with('user')
            ->with('subcategories')
            ->with('products')->get();

        $states = State::all();

        return view('ofertas', compact(
            'categories',
            'products',
            'featureds',
            'states'
        ));
    }

    // cadastro de users
    public function register(Request $request)
    {
        Validator::extend('username', function ($attr, $value) {
            return preg_match('/^\S*$/u', $value);
        });

        $data = request()->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'username' => ['username', 'required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:5', 'confirmed'],
        ]);

        $data['password'] = Hash::make($data['password']);
        $data['role'] = 3;
        $data['remember_token'] = md5(uniqid(rand(), true));

        if ($save = DB::table('users')->insert($data)) {

            $env = getenv('APP_ENV');
            $token = $data['remember_token'];
            $email = $data['email'];
            $base_url = BASE_URL;
            $link = "href='$base_url/account_confirm?email=$email&token=$token'";

            if ($env === 'local') {
                $request->session()->flash('success', 'Conta criada com sucesso.');
                return redirect(BASE_URL . '/login?email=' . $email);
            } else {

                $message = '<html><style>
                * {font-family: arial; font-size: 17px;}
                body {font-family: arial; font-size: 19px; color: #444;}
                a { color: blue}
                </style><body style="font-family: arial; font-size: 19px; color: #444;">';
                $message .= '<h1 style="background: #000; padding: 14px; color: #fff; font-size: 21px;">' . getenv('APP_NAME') . '!</h1>';
                $message .= '<h1 style="font-family: arial; font-size: 19px; color: #444;">Olá, ' . $data['name'] . '!</h1>';
                $message .= '<p style="font-family: arial; font-size: 19px; color: #444;">Obrigado por se registar na nossa loja.<br><br> Te enviamos 
                este email para confirmares a sua conta.<br><br></p>';
                $message .= '<p style="font-family: arial; font-size: 19px; color: #444;">Clica no botão abaixo para confirmares.<br><br>
                <a style="padding: 10px; font-size:20px; border-radius:6px; 
                background:#000; color: #fff; text-decoration: none; 
                border: 3px solid #000;" ' . $link . '>Confirmar conta</a>.
                </p>';
                $message .= '<h3>Um forte abraço!<br><br>' . getenv('APP_URL') . '</h3>';
                $message .= '<hr/>';
                $message .= '<h3>' . getenv('APP_ADMIN') . '</h3>';
                $message .= '</body></html>';

                $subject = 'Confirmação da sua conta - ' . getenv('APP_NAME');

                if (MyMail::send($email, $message, $subject)) {
                    $request->session()->flash('success', 'Conta criada com sucesso. Verifique seu email dentro de alguns segundos.');
                    return redirect(BASE_URL . '/login?email=' . $email);
                } else dd("Email não enviado...");
            }
        }
    }

    // cadastro de users
    public function resend_verification(Request $request)
    {

        if (Auth::check()) {

            $env = getenv('APP_ENV');

            $email = Auth::user()->email;
            $name = Auth::user()->name;

            $remember_token = md5(uniqid(rand(), true));
            $token = $remember_token;

            $user = User::find(Auth::user()->id);
            $user->remember_token = $remember_token;
            $user->save();

            $base_url = BASE_URL;
            $link = "href='$base_url/account_confirm?email=$email&token=$token'";

            if ($env === 'local') {
                $request->session()->flash('warning', 'Não pode enviar emails no local.');
                return redirect(BASE_URL . '/home');
            } else {

                $message = '<html><style>
                * {font-family: arial; font-size: 17px;}
                body {font-family: arial; font-size: 19px; color: #444;}
                a { color: blue}
                </style><body style="font-family: arial; font-size: 19px; color: #444;">';
                $message .= '<h1 style="background: #000; padding: 14px; color: #fff; font-size: 21px;">' . getenv('APP_NAME') . '!</h1>';
                $message .= '<h1>Olá, ' . $name . '!</h1>';
                $message .= '<p style="font-family: arial; font-size: 19px; color: #444;">Obrigado por se registar na nossa loja.<br><br> Te enviamos 
                este email para confirmares a sua conta.<br><br></p>';
                $message .= '<p style="font-family: arial; font-size: 19px; color: #444;">Clica no botão abaixo para confirmares.<br><br>
                <a style="padding: 10px; font-size:20px; border-radius:6px; 
                background:#000; color: #fff; text-decoration: none; 
                border: 3px solid #000;" ' . $link . '>Confirmar conta</a>.
                </p>';
                $message .= '<h3>Um forte abraço!<br><br>' . getenv('APP_URL') . '</h3>';
                $message .= '<hr/>';
                $message .= '<h3>' . getenv('APP_ADMIN') . '</h3>';
                $message .= '</body></html>';

                $subject = 'Reenvio do email de confirmação da sua conta - ' . getenv('APP_NAME') . '-' . rand(1000, 2000);

                if (MyMail::send($email, $message, $subject)) {
                    $request->session()->flash('success', 'Email de confirmação reenviado com sucesso. Verifique seu email dentro de alguns segundos.');
                    return redirect(BASE_URL);
                } else dd("Email não enviado...");
            }
        }
    }

    public function account_confirm(Request $request)
    {
        $email = $_GET['email'];
        $token = $_GET['token'];

        $user = User::where('email', $email)->where('remember_token', $token)->first();

        if ($user) {

            $remember_token = md5(uniqid(rand(), true));

            $user->remember_token = $remember_token;

            $user->email_verified_at = date("Y-m-d H:i:s");
            $user->save();
        }

        $request->session()->flash('success', 'Conta ativada com successo');
        return redirect('/home');
    }

    public function recover(Request $request)
    {
        if (isset($_POST['email'])) {
            $email = $request->get('email');
            $user = User::where('email', $email)->first();

            if (!$user) {
                $request->session()->flash('warning', 'Este email não foi registado.');
                return view('auth.forgot');
            }

            $env = getenv('APP_ENV');

            if ($env === 'local') {

                $newPass = rand(100000, 900000);
                $dataMail = [];

                $dataMail['name'] = $user->name;
                $dataMail['senha'] = $newPass;

                Mail::to($user->email)->send(new EmailRecover($dataMail));
                $user->password = Hash::make($newPass);
                $user->save();

                $request->session()->flash('success', 'Senha redefinida, visite seu email agora.');
                return redirect(BASE_URL.'/login?email=' . $email);
            } else {
                $newPass = rand(100000, 900000);
                $name = $user->name;
                $user->password = Hash::make($newPass);
                $user->save();
                $base_url = BASE_URL;
               
                $message = '<html><style>
                * {font-family: arial; font-size: 17px;}
                body {font-family: arial; font-size: 19px; color: #444;}
                a { color: blue}
                </style><body style="font-family: arial; font-size: 19px; color: #444;">';
               
                $message .= "<h1>Olá $name!</h1>
                Enviamos uma nova senha para acessar a sua conta <br>

                A sua nova senha é <b>$newPass</b> <br><br>
                <a href='$base_url/login'>
                <h2>Inicie Sessão Agora</h2>
                </a>
                <hr>
                Obrigado por fazer parte de nós. <b>Estamos juntos!</b>";

                $message .= '<h3>Um forte abraço!<br><br>' . getenv('APP_URL') . '</h3>';
                $message .= '<hr/>';
                $message .= '<h3>' . getenv('APP_ADMIN') . '</h3>';
                $message .= '</body></html>';

                $subject =  getenv('APP_NAME') . ' - 
                Redefinição da sua Senha (' . rand(1000, 2000) . ')';

                if (MyMail::send($email, $message, $subject)) {
                    $request->session()->flash('success', 'Email de confirmação reenviado com sucesso. Verifique seu email dentro de alguns segundos.');
                    return redirect(BASE_URL.'/login?email='.$email);
                } else dd("Email não enviado...");
            }
        } else {
            return view('auth.forgot');
        }
    }

    public function product($slug)
    {
        $product = Product::where('slug', '=', $slug)
            ->where('status', 1)
            ->where('quantity', '>', 0)
            ->with('user')
            ->with('discounts')
            ->with('images')
            ->with('subcategory')
            ->with('category')
            ->with('ratings.user')
            ->first();

        if (!$product) dd("nenhum produto achado...");

        $media = 0;

        $totalRatings = count($product->ratings);

        // dd($totalRatings);

        $totalPoints = 0;

        foreach ($product->ratings as $rat) {
            $totalPoints += (int) $rat->stars;
        }

        if ($totalRatings > 0)
            $media = $totalPoints / $totalRatings;

        $rated = new RatingController();

        $rate = $rated->isRated($product, 0);
        $rateId = 0;
        $rateMessage = "";

        if ($rate) {
            $rating = RatingProduct::where('product_id', $product->id)
                ->where('user_id', Auth::user()->id)->first();
            $rateId = $rating->id;
            $rateMessage = $rating->message;
        }

        // dd($rate);

        $me = 0;
        if (Auth::check()) {
            $me = Auth::user()->id;
        }
        // dd($product);

        $otherProducts = Product::where('id', '<>', $product->id)
            ->where('category_id', '=', $product->category_id)
            ->where('subcategory_id', '=', $product->subcategory_id)
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

        return view('product', compact(
            'slug',
            'product',
            'media',
            'rate',
            'rateId',
            'rateMessage',
            'otherProducts',
            'categories'
        ));
    }

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
        return view('subcategory', compact(
            'products',
            'categories',
            'subCategoryName',
            'count'
        ));
    }

    function userPost() {
        $categories = Category::all();
        $states = State::all();
        return view('post-product', compact('categories', 'states'));
    }

    function user($username) {
        $user = User::where('username', $username)->first();
        if($user)  {
            $products = Product::where('user_id', $user->id)
            ->paginate(12);
            return view('user', compact('user', 'products'));
        }
        
    }
}
