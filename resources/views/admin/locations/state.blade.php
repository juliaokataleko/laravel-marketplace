@extends('layouts.admin')

@section('title', config('app.name', 'Laravel').' - Categorias')

@section('content')
<?php 
use App\models\State;
?>
<div class="container bg-white px-4 py-4 border">
    <div class="row">
        <div class="col-md-12">
            
            <div class="d-flex justify-content-between" style="align-items: center">
                <h5 style="text-transform: uppercase">Lista de Estados/Províncias: (Total {{ count($statesTotal) }})</h5>            
            </div>                 

        </div>

        <div class="col-md-12 boder">
            
            @if(request('id'))
            <h3>Editar Estado/Província</h3>
            <hr>
            <?php 
            $state = State::findOrFail(request('id')); 
            ?>
            <form action="{{ BASE_URL }}/admin/state/edit/{{ $state->id }}" method="post">
                @csrf
                <div class="row">

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="name">Nome</label>
                            <input type="text" class="form-control" 
                            id="name" name="name" 
                            value="{{ $state->name }}"
                            placeholder="Insere o nome">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="">Estado</label> <br>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input"  {{ ($state->active == 1) ? 'checked': '' }} 
                            type="radio" name="active" id="status1" value="1">
                            <label class="form-check-label" for="status1">Activo</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" 
                            type="radio" name="active" 
                            {{ ($state->active == 0) ? 'checked': '' }} 
                            id="status2" value="0">
                            <label class="form-check-label" 
                            for="status2">Inativo</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleInputEmail1">...</label>
                            <button class="btn btn-primary form-control">
                                Actualizar
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            @else
            <h3>Adicionar Estado/Província</h3>
            <hr>
            <form action="{{ BASE_URL }}/admin/state" method="post">
                @csrf
                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Nome</label>
                            <input type="text" class="form-control" 
                            id="name" name="name" 
                            placeholder="Insere o nome">
                        </div>
                    </div>
                    <div class="col-md-6">
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

            @if(Session::has('success'))
                <p class="mt-4  alert alert-success">{{ Session::get('success') }}</p>
            @elseif(Session::has('warning'))
                <p class="mt-4 alert alert-warning">{{ Session::get('warning') }}</p>
            @endif

            @if(count($states))
            <table class="table table-striped border  table-responsive-xl">
                <thead>
                    <tr>
                        <td>Nome</td>
                        <td>Estado</td>
                        <td>Registado por</td>
                        <td>Acções</td>
                    </tr>
                </thead>
                <tbody>
                @foreach($states as $state)
                    <tr>
                        <td>
                            {{ $state->name }}
                        </td>
                        <td>
                            {{ ($state->active == 1) ? 'Activo' : 'Desativado' }}
                        </td>
                        <td>
                            {{ $state->user->name }}
                        </td>
                        <td>
                            <a href="#" data-toggle="modal" class="btn btn-danger"
                                data-target="#deleteModal{{ $state->id }}"> 
                                <i class="fa fa-trash"></i> </a>
                            <a class="btn btn-primary" 
                            href="{{ BASE_URL }}/admin/states?id={{ $state->id }}"><i class="fa fa-edit"></i></a>

                            <div class="modal fade" id="deleteModal{{ $state->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" 
                                    id="exampleModalLongTitle">Excluir estado </h5>
                                    
                                </div>
                                <div class="modal-body">
                                    Tens a certeza que desejas deletar a província: {{ $state->name }}??
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <a href="{{ BASE_URL }}/admin/state/delete/{{$state->id}}" class="btn btn-danger"> <i class="fa fa-trash"></i> Excluir</a>
                                </div>
                                </div>
                            </div>
                            </div>

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            {{ $states->links() }}
            @else
            <hr>
            <h4>Sem dados de momento.</h4>
            @endif

        </div>
    </div>
</div>
@endsection
