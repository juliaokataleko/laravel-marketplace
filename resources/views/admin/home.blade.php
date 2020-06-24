@extends('layouts.admin')

@section('title', ' Painel de Controle - ' . config('app.name', 'Laravel'))

@section('content')

<style>
    .col-md-4 i, .col-md-12 i {
        font-size: 40px;
        color: #e67e22
    }
</style>

<div class="container bg-white px-4 py-4 border">
    <h2>PAINEL DE CONTROLE</h2>
    <a href="{{ BASE_URL }}/admin/config">Configurações</a>

    <div class="row p-3">

        <div class="col-md-4 py-4 text-center border">
            <i class="fa fa-user-friends"></i>
            <hr>
            <a href="{{ BASE_URL }}/admin/users"> Usuários: {{ count($users) }}</a>
        </div>

        <div class="col-md-4 py-4 text-center border">
            <i class="fab fa-product-hunt"></i>
            <hr>
            <a href="{{ BASE_URL }}/admin/product"> Produtos: {{ count($products) }} </a>
        </div>
    

        <div class="col-md-4 py-4 text-center border">
            <i class="fa fa-list"></i>
            <hr>
            <a href="{{ BASE_URL }}/admin/category"> Categorias: {{ count($categories) }} </a>
        </div>
   
        <div class="col-md-4 py-4 text-center border">
            <i class="fa fa-list-alt"></i>
            <hr>
            <a href="{{ BASE_URL }}/admin/subcategory"> SubCategorias: {{ count($subcategories) }} </a>
        </div>
    
        <div class="col-md-4 py-4 text-center border">
            <i class="fa fa-star"></i>
            <hr>
            <a href="{{ BASE_URL }}/admin/ratings"> Classificações: {{ count($ratings) }} </a>
        </div>

        <div class="col-md-4 py-4 text-center border">
            <i class="fa fa-shopping-cart"></i>
            <hr>
            <a href="{{ BASE_URL }}/admin/purchases"> Compras: {{ count($purchases) }} </a>
        </div>
        <div class="col-md-4 py-4 text-center border">
            <i class="fa fa-images"></i>
            <hr>
            <a href="#"> Ficheiros: {{ count($files) }}</a>
        </div>

        <div class="col-md-4 py-4 text-center border">
            <i class="fa fa-location-arrow"></i>
            <hr>
            <a href="{{ BASE_URL }}/admin/states"> Estados: {{ count($states) }} </a>
        </div>

        <div class="col-md-4 py-4 text-center border">
            <i class="fa fa-location-arrow"></i>
            <hr>
            <a href="{{ BASE_URL }}/admin/cities"> Cidades: {{ count($cities) }} </a>
        </div>

    </div>

</div>
@endsection
