@extends('layouts.admin')

@section('title', config('app.name', 'Laravel').' - SubCategorias')

@section('content')
<div class="container bg-white px-4 py-4 border">
    <div class="row">
        <div class="col-md-12">
            
            <div class="d-flex justify-content-between" style="align-items: center">
                <h5 style="text-transform: uppercase">Lista de Subcategorias: 
                    (Total {{ count($total_subcat) }})</h5>    
                <?php 
                if(isset($_GET['query'])) {
                    $query = addslashes($_GET['query']);                    
                }                           
                ?>
                <form action="{{ BASE_URL }}/admin/subcategory" method="get">
                    <div class="input-group mb-3">
                    <input type="search" 
                    class="form-control" 
                    name="query"
                    value="{{ (isset($query)) ? $query : '' }}"
                    placeholder="Pesquisar Subategorias">
                    <div class="input-group-append">
                        <button class="btn btn-secondary" 
                        type="submit"> <i class="fa fa-search"></i> </button>
                    </div>
                    </div>
                </form>          
            </div>                 

        </div>

        <div class="col-md-12 boder">
            <h3>Adicionar Subcategoria</h3>
            <hr>
            <form action="{{ BASE_URL }}/admin/subcategory" method="post">
                @csrf
                <div class="row">

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="name">Nome</label>
                            <input type="text" class="form-control" 
                            id="name" name="name" 
                            placeholder="Insere o nome">
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="icon">Categoria</label>
                            <select name="category_id" id="category_id" 
                            class="form-control">
                            <option value="" selected disabled>Selecione uma Categoria</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        </div>                        
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Adicionar</label>
                            <button class="btn btn-primary form-control">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            @if(Session::has('success'))
                <p class="mt-4  alert alert-success">{{ Session::get('success') }}</p>
            @elseif(Session::has('warning'))
                <p class="mt-4 alert alert-warning">{{ Session::get('warning') }}</p>
            @endif

            @if(count($subcategories))
            <table class="table table-striped border table-responsive-xl">
                <thead>
                    <tr>
                        <td>Nome</td>
                        <td>Categoria</td>
                        <td>Estado</td>
                        <td>Registado por</td>
                        <td>Acções</td>
                    </tr>
                </thead>
                <tbody>
                @foreach($subcategories as $subcat)
                    <tr>
                        <td>
                            {{ $subcat->name }}
                        </td>
                        <td>
                            {{ ($subcat->category->name ?? 'Sem categoria' ) }}
                        </td>
                        <td>
                            {{ ($subcat->status == 1) ? 'Activo' : 'Desativado' }}
                        </td>
                        <td>
                            {{ $subcat->user->name }}
                        </td>
                        <td>
                            <a href="#" data-toggle="modal" 
                                data-target="#deleteModal{{ $subcat->id }}">Excluir</a>
                            <a href="{{ BASE_URL }}/admin/subcategory/edit/{{ $subcat->id }}">Editar</a>

                            <div class="modal fade" id="deleteModal{{ $subcat->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" 
                                    id="exampleModalLongTitle">Excluir categoria</h5>
                                    
                                </div>
                                <div class="modal-body">
                                    Tens a certeza que desejas deletar a subcategoria: {{ $subcat->name }}??
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <a href="{{ BASE_URL }}/admin/subcategory/delete/{{$subcat->id}}" class="btn btn-danger"> <i class="fa fa-trash"></i> Excluir</a>
                                </div>
                                </div>
                            </div>
                            </div>

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            {{ $subcategories->links() }}
            @else
            <hr>
            <h4>Sem subcategorias de momento.</h4>
            @endif

        </div>
    </div>
</div>
@endsection
