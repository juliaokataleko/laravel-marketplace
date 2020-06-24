<?php

namespace App\Http\Controllers;

use App\models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
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

            $categories = Category::orderBy('id', 'DESC')->with('user')->where('name', $query)
            ->orWhere('name', 'like', '%' . $_GET['query'] . '%')
            ->paginate(10)->appends(request()->query());

        } else {
            $categories = Category::orderBy('id', 'DESC')->with('user')->paginate(10)->appends(request()->query());
        }

        $total_cat = Category::all();
        
        return view('admin.category.index', compact('categories', 'total_cat'));

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
            'icon' => '',
        ]);

        $data['slug'] = slug($data['name']);

        $slugCheck = Category::where('slug', $data['slug'])->get();

        if (count($slugCheck) > 0) {
            $data['slug'] = slug($data['name']) . '-' . date("His");
        }

        if(auth()->user()->categories()->create($data)) {
            $request->session()->flash('success', 'Categoria criada com successo');
            return redirect(BASE_URL.'/admin/category');
        }

        $request->session()->flash('warning', 'Falha ao criar uma categoria');
        return redirect(BASE_URL.'/admin/category');
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
    public function edit(Category $category, Request $request)
    {
        # dd($category);
        return view('admin.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Category $category, Request $request)
    {
        $data = request()->validate([
            'name' => 'required|string|min:2',
            'icon' => '',
            'status' => 'required',
        ]);

        $data['slug'] = slug($data['name']);

        $slugCheck = Category::where('slug', $data['slug'])->get();

        if (count($slugCheck) > 0) {
            $data['slug'] = slug($data['name']) . '-' . date("His");
        }

        $save = DB::table('categories')
            ->where('id', $category->id)
            ->update($data);
        
        if ($save) {
            $request->session()->flash('success', 'Categoria actualizada com sucesso.');
            return redirect(BASE_URL.'/admin/category');
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
    public function destroy(Category $category, Request $request)
    {
        if($category->user_id == Auth::user()->id || Auth::user()->role == 1){
            $category->delete();
            $request->session()->flash('success', 'Categoria excluída com sucesso.');
            return redirect(BASE_URL.'/admin/category');
        }
    }
}
