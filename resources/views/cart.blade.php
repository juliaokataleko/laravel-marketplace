@extends('layouts.app')
<?php use App\models\Archive; ?>

@section('title', config('app.name', 'Laravel').' - Carrinho de Compras')

@section('content')

<script src="https://www.paypalobjects.com/api/checkout.js"></script>

<div class="container mt-4" id="app">
    <h2>Carrinho de Compras</h2>

    @include('includes.messages')

    @if(count($products) > 0)
    <table class="table table-striped 
    bg-white border" style="width: 100%">
        <thead>
            <tr>
                <td></td>
                <td>Nome</td>
            </tr>
        </thead>
        <tbody>
            <?php $contador = 0; ?>
            @foreach ($products as $key => $product)
            <tr>
                <td>
                    <?php
                    
                    $count = 0;
                    $defaultImage = BASE_URL."/images/product.png";
                    
                    (int)$id = $product["0"]->id;

                    $images = Archive::where('product_id', $id)->get();
                    $totalImages = count($images);

                    # dd($totalImages);

                    foreach($images as $image) {
                        $count++;
                        $defaultImage = BASE_URL."/uploads/products/".$image->file;
                        break;
                    }
                 
                    ?>

                    <a href="{{ BASE_URL }}/product/{{ $product['0']->slug }}"><img style="width: 70px;"
                            src="{{ $defaultImage }}" alt="{{ $product['0']->name }}"></a>


                </td>
                <td>
                    <b>Nome:</b> {{$product['0']->name}} <br>
                    <b>Quantidade:</b> {{$product['quantidade']}} <br>
                    <b>Preço/1:</b> {{currencyFormat($product['0']->price)}} Akz <br>
                    <b>Desconto:</b> {{currencyFormat($product['discount']).' Akz'}} <br>
                    <b>SubTotal:</b> {{currencyFormat($product['total_price'])}} Akz <br>
                </td>
                
            </tr>
			<tr>
			<td colspan="2">
                    <a href="{{ BASE_URL }}/cart/add-more/{{$product['0']->id}}" class="mb-1 btn btn-outline-primary">
                        <i class="fa fa-plus"></i> </a>
                    <a href="{{ BASE_URL }}/cart/remove/{{$product['0']->id}}" class="mb-1 btn btn-outline-danger"> <i
                            class="fa fa-minus"></i> </a>
                    <a href="{{ BASE_URL }}/cart/remove-product/{{$product['0']->id}}"
                        class="mb-1 btn btn-outline-danger"> <i class="fa fa-trash"></i> </a>
                </td>
			</tr>
            <?php $contador++; ?>
            @endforeach
            <tr>

                <td colspan="2" class="text-center">
                    <b> Desconto</b>:
                    {{ currencyFormat($totalDiscount).' Akz' }}
                    <b>
                        <br>
                        <b>SubTotal</b>:
                        {{ currencyFormat($total + $totalDiscount).' Akz' }}
                        <br>
                        <b>Total</b>: {{ currencyFormat($total).' Akz' }}
                    </b>
                </td>
			</tr>
			<tr>
                <td colspan="2" class="text-right">
                   

                    <a href="{{ BASE_URL }}/cart/finish" 
                    class="my-2 btn btn-primary">
                    Finalizar Compra</a>
               
                </td>
            </tr>

            <tr>
                <td colspan="2" class="text-center">
                    <a href="{{ BASE_URL }}/cart/remove-all" class="mt-2 btn 
                btn-danger">Esvaziar Carrinho</a>
                </td>
            </tr>
        </tbody>
    </table>
    @else
    <div class="alert alert-secondary">
        O seu carrinho está vazio
    </div>
    @endif
</div>

@endsection