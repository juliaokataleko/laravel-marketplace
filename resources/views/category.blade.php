@extends('layouts.app')

@section('title', config('app.name', 'Laravel').' - Categorias')

@section('content')
<div class="container mt-4" id="app">

    @include('includes.categories')

    @if(count($products) > 0)
    <h5 style="background: #0097e6; padding:8px; 
    text-align: center; " class="text-white mb-3">Produtos encontados em {{ $categoryName }} </h5>
    <div class="row">

        @foreach ($products as $product)
            @include('includes.product')
        @endforeach

    </div>

    @else
    <div class="alert alert-danger"> Nenhum produto nesta categoria </div>
    @endif

</div>
<br><br><br>
@endsection