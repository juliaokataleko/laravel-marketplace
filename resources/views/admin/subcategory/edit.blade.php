@extends('layouts.admin')

@section('title', config('app.name', 'Laravel').' - Editar SubCategoria')

@section('content')
<div class="container bg-white px-4 py-4 border">
    <div class="row">

        <div class="col-md-12 boder">
            <h3>Editar Categoria</h3>
            <form action="{{ BASE_URL }}/admin/subcategory/edit/{{$subcategory->id}}" method="post">
                @csrf
                <div class="row">

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="name">Nome</label>
                            <input type="text" class="form-control" 
                            id="name" name="name" 
                            value="{{ $subcategory->name }}"
                            placeholder="Insere o nome">
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="icon">Categoria</label>
                            <select name="category_id" id="category" 
                            class="form-control">
                            <option value="" disabled>Selecione uma Categoria</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}" {{ ($cat->id == $subcategory->category_id) ? 'selected':'' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        </div>                        
                    </div>

                    <div class="col-md-3">
                        <label for="">Estado</label> <br>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input"  {{ ($subcategory->status == 1) ? 'checked': '' }} 
                            type="radio" name="status" id="status1" value="1">
                            <label class="form-check-label" for="status1">Activo</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" 
                            {{ ($subcategory->status == 2) ? 'checked': '' }} id="status2" value="2">
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
