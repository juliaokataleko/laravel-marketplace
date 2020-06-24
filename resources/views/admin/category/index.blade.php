@extends('layouts.admin')

@section('title', config('app.name', 'Laravel').' - Categorias')

@section('content')
<div class="container bg-white px-4 py-4 border">
    <div class="row">
        <div class="col-md-12">
            
            <div class="d-flex justify-content-between" style="align-items: center">
                <h5 style="text-transform: uppercase">Lista de Categorias: (Total {{ count($total_cat) }})</h5>    
                <?php 
                if(isset($_GET['query'])) {
                    $query = addslashes($_GET['query']);                    
                }                           
                ?>
                <form action="{{ BASE_URL }}/admin/category" method="get">
                    <div class="input-group mb-3">
                    <input type="search" 
                    class="form-control" 
                    name="query"
                    value="{{ (isset($query)) ? $query : '' }}"
                    placeholder="Pesquisar Categorias">
                    <div class="input-group-append">
                        <button class="btn btn-secondary" 
                        type="submit"> <i class="fa fa-search"></i> </button>
                    </div>
                    </div>
                </form>          
            </div>                 

        </div>

        <div class="col-md-12 boder">
            <h3>Adicionar Categoria</h3>
            <hr>
            <form action="{{ BASE_URL }}/admin/category" method="post">
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
                            <label for="icon">Ícone</label>
                            <input type="text" class="form-control" 
                            id="icon" name="icon" 
                            placeholder="Digita o nome do ícone">
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

            @if(count($categories))
            <table class="table table-striped border  table-responsive-xl">
                <thead>
                    <tr>
                        <td>Nome</td>
                        <td>Ícone</td>
                        <td>Estado</td>
                        <td>Registado por</td>
                        <td>Acções</td>
                    </tr>
                </thead>
                <tbody>
                @foreach($categories as $cat)
                    <tr>
                        <td>
                            {{ $cat->name }}
                        </td>
                        <td>
                            {!! (null == $cat->icon) ? 'Sem ícone' : "<i class='fa $cat->icon'></i>" !!}
                        </td>
                        <td>
                            {{ ($cat->status == 1) ? 'Activo' : 'Desativado' }}
                        </td>
                        <td>
                            {{ $cat->user->name }}
                        </td>
                        <td>
                            <a href="#" data-toggle="modal" 
                                data-target="#deleteModal{{ $cat->id }}">Excluir</a>
                            <a href="{{ BASE_URL }}/admin/category/edit/{{ $cat->id }}">Editar</a>

                            <div class="modal fade" id="deleteModal{{ $cat->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" 
                                    id="exampleModalLongTitle">Excluir categoria</h5>
                                    
                                </div>
                                <div class="modal-body">
                                    Tens a certeza que desejas deletar a categoria {{ $cat->name }}??
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <a href="{{ BASE_URL }}/admin/category/delete/{{$cat->id}}" class="btn btn-danger"> <i class="fa fa-trash"></i> Excluir</a>
                                </div>
                                </div>
                            </div>
                            </div>

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            {{ $categories->links() }}
            @else
            <hr>
            <h4>Sem Categorias de momento.</h4>
            @endif

        </div>
    </div>
</div>
@endsection
