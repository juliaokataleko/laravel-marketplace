@extends('layouts.admin')

@section('title', config('app.name', 'Laravel').' - Editar Categoria')

@section('content')
<div class="container bg-white px-4 py-4 border">
    <div class="row">

        <div class="col-md-12 boder">
            <h3>Editar Categoria</h3>
            <form action="{{ BASE_URL }}/admin/category/edit/{{$category->id}}" method="post">
                @csrf
                <div class="row">

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="name">Nome</label>
                            <input type="text" class="form-control" 
                            id="name" name="name" 
                            value="{{ $category->name }}"
                            placeholder="Insere o nome">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="icon">Ícone</label>
                            <input type="text" class="form-control" 
                            id="icon" name="icon" 
                            value="{{ $category->icon }}"
                            placeholder="Digita o nome do ícone">
                        </div>                        
                    </div>
                    <div class="col-md-3">
                        <label for="">Estado</label> <br>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input"  {{ ($category->status == 1) ? 'checked': '' }} 
                            type="radio" name="status" id="status1" value="1">
                            <label class="form-check-label" for="status1">Activo</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" 
                            {{ ($category->status == 2) ? 'checked': '' }} id="status2" value="2">
                            <label class="form-check-label" for="status2">Inativo</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Actualizar</label>
                            <button class="btn btn-primary form-control">
                                Actualizar
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


        </div>
    </div>
</div>
@endsection
