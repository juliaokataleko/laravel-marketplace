@extends('layouts.app')

@section('title', config('app.name', 'Laravel').' - '.$subCategoryName)

@section('content')
<div class="container mt-4" id="app">

    @include('includes.categories')

    @if(count($products) > 0)
    <h5 style="background: #0097e6; padding:8px; 
    text-align: center; " class="text-white mb-3">Produtos encontados na subcategoria {{ $subCategoryName }} </h5>
    <div class="row">

        @foreach ($products as $product)
            @include('includes.product')
        @endforeach

    </div>

    @else
    <div class="alert alert-danger"> Nenhum produto nesta subcategoria </div>
    @endif

</div>
@endsection