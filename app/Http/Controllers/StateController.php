<?php

namespace App\Http\Controllers;

use App\models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $states = State::paginate(10);
        $statesTotal = State::all();
        return view('admin.locations.state', compact('states', 'statesTotal'));
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
        ]);

        if(auth()->user()->states()->create($data)) {
            $request->session()->flash('success', 'Estado registado com successo');
            return redirect(BASE_URL.'/admin/states');
        }

        $request->session()->flash('warning', 'Falha ao registar um estado.');
        return redirect(BASE_URL.'/admin/states');
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
    public function update(Request $request, State $state)
    {
        $data = request()->validate([
            'name' => 'required|string|min:2',
            'active' => 'required',
        ]);

        $save = DB::table('states')
            ->where('id', $state->id)
            ->update($data);
        
        if ($save) {
            $request->session()->flash('success', 'Estado actualizado com sucesso.');
            return redirect(BASE_URL.'/admin/states');
        } 

        $request->session()->flash('warning', 'Algo correu mal.');
        return redirect(BASE_URL.'/admin/states');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(State $state, Request $request)
    {
        if($state->user_id == Auth::user()->id || Auth::user()->role == 1){
            $state->delete();
            $request->session()->flash('success', 'Estado excluído com sucesso.');
            return redirect(BASE_URL.'/admin/states');
        }
        return redirect(BASE_URL.'/admin/states');
    }
}
