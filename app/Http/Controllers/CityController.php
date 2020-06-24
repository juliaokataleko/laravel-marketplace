<?php

namespace App\Http\Controllers;

use App\models\City;
use App\models\State;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $states = State::all();
        $cityTotal = City::all();
        $cities = City::paginate(10);
        return view('admin.locations.city', 
        compact('states', 'cityTotal', 'cities'));
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
            'state_id' => 'required',
        ]);

        if(auth()->user()->cities()->create($data)) {
            $request->session()->flash('success', 'Cidade registada com successo');
            return redirect()->back();
        }

        $request->session()->flash('warning', 'Falha ao registar');
        return redirect()->back();
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
    public function update(Request $request, City $city)
    {
        # dd($request->all());
        $data = request()->validate([
            'name' => 'required|string|min:2',
            'active' => 'required',
            'state_id' => 'required',
        ]);

        $save = DB::table('cities')
            ->where('id', $city->id)
            ->update($data);
        
        if ($save) {
            $request->session()->flash('success', 'Cidade actualizada com sucesso.');
            return redirect()->back();
        } 

        $request->session()->flash('warning', 'Algo correu mal.');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, City $city)
    {
        if($city->user_id == Auth::user()->id || Auth::user()->role == 1){
            $city->delete();
            $request->session()->flash('success', 'Cidade excluída com sucesso.');
            return redirect()->back();
        }
        return redirect()->back();
    }
}
