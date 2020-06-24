@extends('layouts.admin')

@section('title', config('app.name', 'Laravel').' - Produtos')

@section('content')
<div class="container bg-white p-3 border" style="width: 97%;">
    <div class="row">
        <div class="col-md-12">
            
            <div class="d-flex justify-content-between" style="align-items: center">
                <h5 style="text-transform: uppercase">Lista de Productos: 
                    (Total {{ count($total_products) }})</h5>    
                <?php 
                if(isset($_GET['query'])) {
                    $query = addslashes($_GET['query']);                    
                }                           
                ?>
                <form action="{{ BASE_URL }}/admin/product" method="get">
                    <div class="input-group mb-3">
                    <input type="search" 
                    class="form-control" 
                    name="query"
                    value="{{ (isset($query)) ? $query : '' }}"
                    placeholder="Pesquisar Products">
                    <div class="input-group-append">
                        <button class="btn btn-secondary" 
                        type="submit"> <i class="fa fa-search"></i> </button>
                    </div>
                    </div>
                </form>          
            </div>                 

        </div>

        <div class="col-md-12 boder">

            <a href="{{ BASE_URL }}/admin/product/create" class="btn mb-4 btn-success form-control">
                <i class="fa fa-plus"></i>
                Adicionar Producto
            </a>
            @if(Session::has('success'))
                <p class="mt-4  alert alert-success">{{ Session::get('success') }}</p>
            @elseif(Session::has('warning'))
                <p class="mt-4 alert alert-warning">{{ Session::get('warning') }}</p>
            @endif

            @if(count($products))
            <table class="table table-striped border table-responsive">
                <thead>
                    <tr>
                        <td>Foto</td>
                        <td>Nome</td>
                        <td>Preço, Slug</td>
                        <td>Categoria</td>
                        <td>SubCategoria</td>
                        <td>Estado</td>
                        <td style="width: 150px">Registado por</td>
                        <td>Acções</td>
                    </tr>
                </thead>
                <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>
                            <?php
                            $count = 0;
                            $dafaultImage = BASE_URL."/images/default.png";

                            foreach($product->images as $image) {
                                $count++;
                                $dafaultImage = BASE_URL."/uploads/products/".$image->file;
                                break;
                            }
                            ?>
                            <img style="width: 70px;"  
                            src="{{ $dafaultImage }}" 
                            alt="{{ $product->name }}">
                            
                        </td>
                        <td>
                            <a href="{{ BASE_URL }}/product/{{ $product->slug }}">
                                {{ $product->name }}
                            </a>
                        </td>
                        <td>
                            <b>{{ currencyFormat($product->price) }}</b> <br>
                            {{ $product->slug }}
                        </td>
                        <td>
                            {{ $product->category->name }}
                        </td>
                        <td>
                            {{ $product->subcategory->name }}
                        </td>
                        <td>
                            {{ ($product->status == 1) ? 'Activo' : 'Desativado' }}
                        </td>
                        <td>
                            {{ $product->user->name }}
                        </td>
                        <td>
                            <a href="#" data-toggle="modal" 
                                data-target="#deleteModal{{ $product->id }}">Excluir</a>
                            <a href="{{ BASE_URL }}/admin/product/edit/{{ $product->id }}">Editar</a>

                            <div class="modal fade" id="deleteModal{{ $product->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" 
                                    id="exampleModalLongTitle">Excluir Produto</h5>
                                    
                                </div>
                                <div class="modal-body">
                                    Tens a certeza que desejas deletar o producto: {{ $product->name }}??
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <a href="{{ BASE_URL }}/admin/product/delete/{{$product->id}}" class="btn btn-danger"> <i class="fa fa-trash"></i> Excluir</a>
                                </div>
                                </div>
                            </div>
                            </div>

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div style="width: 100%; overflow-x:auto">
                {{ $products->links() }}
            </div>

            @endif

        </div>
    </div>
</div>
@endsection
