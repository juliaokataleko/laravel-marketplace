<?php

namespace App\Http\Controllers;

use App\models\Archive;
use App\models\Category;
use App\models\City;
use App\models\Config;
use App\models\ImagePerProduct;
use App\models\Product;
use App\models\Purchase;
use App\models\RatingProduct;
use App\models\State;
use App\models\SubCategory;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
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
        $categories = Category::all();
        $subcategories = SubCategory::all();
        $products = Product::all();
        $users = User::all();
        $purchases = Purchase::all();
        $ratings = RatingProduct::all();
        $files = Archive::all();
        $states = State::all();
        $cities = City::all();

        return view('admin.home', compact(
            'categories',
            'subcategories',
            'products',
            'users',
            'ratings',
            'purchases',
            'files',
            'states',
            'cities'
        ));
    }

    public function config(Request $request) {

        $config = Config::first();

        if ($request->isMethod('post')) {

            $data = request()->validate([
                'name' => 'required|string',
                'slogan' => 'required',
                'url' => '',
                'num_pages' => '',
                'about' => '',
                'privacy_policy' => '',
            ]);
    
            $save = DB::table('configs')
                ->where('id', $config->id)
                ->update($data);

            $request->session()->flash('success', 
                'Configurações actualizadas');
        }
        
        # dd($request->all());
        $config = Config::first();
        return view('admin.config', compact('config'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
