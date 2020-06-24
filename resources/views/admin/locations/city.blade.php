@extends('layouts.admin')

@section('title', config('app.name', 'Laravel').' - Cidades')

@section('content')

<?php use App\models\City; ?>

<div class="container bg-white px-4 py-4 border">

    <div class="row">

        <div class="col-md-12">
            
            <div class="d-flex justify-content-between" style="align-items: center">
                <h5 style="text-transform: uppercase">Lista de Cidades: 
                    (Total {{ count($cityTotal) }})</h5>         
            </div>                 

        </div>

        <div class="col-md-12 boder">

            @if(request('id'))
            <h3>Editar Cidade</h3>
            <hr>
            <?php 
            $city = City::findOrFail(request('id')); 
            ?>

            <form action="{{ BASE_URL }}/admin/city/edit/{{$city->id}}" method="post">
                @csrf
                <div class="row">

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="name">Nome</label>
                            <input type="text" class="form-control" 
                            id="name" name="name" 
                            value="{{ $city->name }}"
                            placeholder="Insere o nome">
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="icon">Categoria</label>
                            <select name="state_id" id="state_id" 
                            class="form-control">
                            <option value="" disabled>Selecione uma província</option>
                            @foreach ($states as $state)
                                <option value="{{ $state->id }}" {{ ($state->id == $city->category_id) ? 'selected':'' }}>{{ $state->name }}</option>
                            @endforeach
                        </select>
                        </div>                        
                    </div>

                    <div class="col-md-3">
                        <label for="">Estado</label> <br>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input"  {{ ($city->active == 1) ? 'checked': '' }} 
                            type="radio" name="active" id="status1" value="1">
                            <label class="form-check-label" for="status1">Activo</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" 
                            type="radio" name="active" 
                            {{ ($city->active == 0) ? 'checked': '' }} id="status2" value="0">
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

            @else

            <h3>Adicionar cidade</h3>

            <hr>

            <form action="{{ BASE_URL }}/admin/city" method="post">
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
                            <label for="icon">Estado</label>
                            <select name="state_id" id="state_id" 
                            class="form-control">
                            <option value="" selected disabled>Selecione uma Estado</option>
                            @foreach ($states as $state)
                                <option value="{{ $state->id }}">{{ $state->name }}</option>
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

            @endif

            @include('includes.messages')

            @if(count($cities))
            
            <table class="table table-striped border table-responsive-xl">
                <thead>
                    <tr>
                        <td>Nome</td>
                        <td>Província</td>
                        <td>Estado</td>
                        <td>Registado por</td>
                        <td>Acções</td>
                    </tr>
                </thead>
                <tbody>
                @foreach($cities as $city)
                    <tr>
                        <td>
                            {{ $city->name }}
                        </td>
                        <td>
                            {{ ($city->state->name ?? 'Sem estado' ) }}
                        </td>
                        <td>
                            {{ ($city->active == 1) ? 'Activo' : 'Desativado' }}
                        </td>
                        <td>
                            {{ $city->user->name ?? 'Sem usuário' }}
                        </td>
                        <td>
                            <a href="#" data-toggle="modal" 
                                data-target="#deleteModal{{ $city->id }}">Excluir</a>
                            <a href="{{ BASE_URL }}/admin/city?id={{ $city->id }}">Editar</a>

                            <div class="modal fade" id="deleteModal{{ $city->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" 
                                    id="exampleModalLongTitle">Excluir cidade</h5>
                                    
                                </div>
                                <div class="modal-body">
                                    Tens a certeza que desejas deletar a cidade: {{ $city->name }}??
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <a href="{{ BASE_URL }}/admin/city/delete/{{$city->id}}" class="btn btn-danger"> <i class="fa fa-trash"></i> Excluir</a>
                                </div>
                                </div>
                            </div>
                            </div>

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            {{ $cities->links() }}

            @else
            <hr>
            <h4>Sem dados de momento.</h4>
            @endif

        </div>

    </div>
</div>

@endsection