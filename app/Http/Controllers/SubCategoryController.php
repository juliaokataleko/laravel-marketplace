<?php

namespace App\Http\Controllers;

use App\models\SubCategory;
use App\models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if(isset($_GET['query'])) {
            $query = addslashes($_GET['query']);

            $subcategories = SubCategory::orderBy('id', 'DESC')
            ->with('user')->with('category')
            ->where('name', $query)
            ->orWhere('name', 'like', '%' . $_GET['query'] . '%')
            ->paginate(10)->appends(request()->query());

        } else {
            $subcategories = SubCategory::orderBy('id', 'DESC')->with('user')->with('category')
            ->paginate(10)->appends(request()->query());
        }

        $total_subcat = SubCategory::all();
        $categories = Category::all();
        
        return view('admin.subcategory.index', compact('subcategories', 'categories', 'total_subcat'));

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
        $data = request()->validate([
            'name' => 'required',
            'category_id' => 'required',
        ]);

        $data['slug'] = slug($data['name']);

        $slugCheck = SubCategory::where('slug', $data['slug'])->get();

        if (count($slugCheck) > 0) {
            $data['slug'] = slug($data['name']) . '-' . date("His");
        }

        if(auth()->user()->subcategories()->create($data)) {
            $request->session()->flash('success', 'Subcategoria criada com successo');
            return redirect('/admin/subcategory');
        }

        $request->session()->flash('warning', 'Falha ao criar uma categoria');
        return redirect('/admin/category');
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
    public function edit(SubCategory $subcategory, Request $request)
    {
        # dd($category);
        $categories = Category::all();
        return view('admin.subcategory.edit', compact('subcategory', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SubCategory $subcategory, Request $request)
    {
        $data = request()->validate([
            'name' => 'required|string|min:2',
            'category_id' => '',
            'status' => 'required',
        ]);

        $data['slug'] = slug($data['name']);

        $slugCheck = SubCategory::where('slug', $data['slug'])->get();

        if (count($slugCheck) > 0) {
            $data['slug'] = slug($data['name']) . '-' . date("His");
        }

        $save = DB::table('sub_categories')
            ->where('id', $subcategory->id)
            ->update($data);
        
        if ($save) {
            $request->session()->flash('success', 'Subcategoria actualizada com sucesso.');
            return redirect('/admin/subcategory');
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
    public function destroy(SubCategory $subcategory, Request $request)
    {
        if($subcategory->user_id == Auth::user()->id || Auth::user()->role == 1){
            $subcategory->delete();
            $request->session()->flash('success', 'Subcategoria excluída com sucesso.');
            return redirect('/admin/subcategory');
        }
    }
}