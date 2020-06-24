<?php

namespace App\Http\Controllers;

use App\Models\PedidoDestaque;
use App\models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PedidoDestaqueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pedidos = PedidoDestaque::paginate(10);
        return view('admin.ads.index', compact('pedidos'));
    }

    public function promocoes()
    {
        $pedidos = PedidoDestaque::where('user_id', Auth::user()->id)->paginate(10);
        return view('user.promocoes', compact('pedidos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Product $product)
    {
        if($product->user_id == Auth::user()->id) {
            $pedido = new PedidoDestaque();
            $pedido->user_id = $product->user_id;
            $pedido->product_id = $product->id;
            if($pedido->save()) return redirect()->back()->with('success', 'Pedido de Promoção enviado com sucesso. Aguarde o contacto de um funcionário. <b>Obrigado</b>');
        } else return redirect()->back();
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

    public function activar(Request $request, $id)
    {
        $pedido = PedidoDestaque::findOrFail($id);
        $message = $pedido->status == 0 ? 'Producto activo com sucesso' : 'Producto removido dos Anúncios';
        $pedido->status = !$pedido->status;

        if($pedido->status == 1) {
            $pedido->valor = $_POST['valor'];
            $pedido->employer_id = Auth::user()->id;
        }

        if($pedido->save()) {
            if(isset($_POST['end']) && $pedido->status == 1) {

                $data = request()->validate([
                    'end' => 'required|after:today',
                ]);

                $product = Product::find($pedido->product_id);
                $product->featured = 1;
                $product->featured_limit = $data ['end'];
                $product->save();
            } else {
                $product = Product::find($pedido->product_id);
                $product->featured = 0;
                $product->featured_limit =null;
                $product->save();
            }
            # dd($product);
            return redirect()->back()->with('success', $message);
        }

        return redirect()->back()->with('warning', 'Alguma coisa correu mal.');
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
    public function destroy(Request $request, $id)
    {
        $pedido = PedidoDestaque::findOrFail($id);
        if($pedido->user_id == Auth::user()->id || Auth::user()->role == 1){
            $pedido->delete();
            $request->session()->flash('success', 'Pedido excluído com sucesso.');
            return redirect()->back();
        }
    }
}
