@extends('layouts.admin')

@section('title', config('app.name', 'Laravel').' - Usuários')

@section('content')
<div class="container bg-white px-4 py-4 border" style="width: 95%">
    <div class="row">
        <div class="col-md-12">
            @if(Session::has('success'))
                <p class="alert alert-success">{{ Session::get('success') }}</p>
            @elseif(Session::has('warning'))
                <p class="alert alert-warning">{{ Session::get('warning') }}</p>
            @endif
            <div class="d-flex justify-content-between" style="align-items: center">
                <h5 style="text-transform: uppercase">Lista de usuários</h5>    
                <?php 
                if(isset($_GET['query'])) {
                    $query = addslashes($_GET['query']);
                    $users = App\User::orderBy('id', 'DESC')->where('name', $query)
                    ->orWhere('name', 'like', '%' . $_GET['query'] . '%')->paginate(10)->appends(request()->query());
                } else {
                    $users = App\User::orderBy('id', 'DESC')->paginate(10)->appends(request()->query()); 
                }                            
                ?>
                <form action="{{ BASE_URL }}/admin/users" method="get">
                    <div class="input-group mb-3">
                    <input type="search" 
                    class="form-control" 
                    name="query"
                    value="{{ (isset($query)) ? $query : '' }}"
                    placeholder="Pesquisar usuários">
                    <div class="input-group-append">
                        <button class="btn btn-secondary" 
                        type="submit"> <i class="fa fa-search"></i> </button>
                    </div>
                    </div>
                </form>          
            </div>
            
            
            
            @if(count($users))
            <table style="white-space: nowrap;" class="table table-striped bg-white border table-responsive">
                <thead>
                    <tr>
                        <td>Nome</td>
                        <td style="width: 100px">Email</td>
                        <td>Telefone</td>
                        <td>Categoria</td>
                        <td>Estado</td>
                        <td style="width: 230px">Acções</td>
                    </tr>
                </thead>
            <tbody>
            @foreach($users as $user) 
            <tr>
                <td>
                    {{ $user->name }} <br>
                    <b>Localização: </b>{{ $user->birth_place }}
                </td>
                <td>
                    {{ $user->email }} <br>
                    <a data-toggle="modal" 
                    data-target="#deleteUser{{ $user->id }}" 
                    style="cursor: pointer"
                    class="text-danger">Eliminar Usuário</a>
                    <div class="modal fade" id="deleteUser{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" 
                            id="exampleModalLongTitle">Excluir usuário</h5>
                        </div>
                        <div class="modal-body">
                            Tens a certeza que desejas <br> deletar o usuário {{ $user->name }}??
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <a href="{{ BASE_URL }}/admin/user/delete/{{$user->id}}" class="btn btn-danger"> <i class="fa fa-trash"></i> Excluir</a>
                        </div>
                        </div>
                    </div>
                    </div>

                </td>
                <td style="width: 120px !important">
                    {{ $user->phone }}
                    {{ '@'.$user->username }}
                </td>
                <td>{{ userLevel($user->role) }}</td>
                <td>{{ null == $user->email_verified_at ? 
                    'Conta não activa' : 'Ativado' }}</td>
                <td>
                    <a href="{{ BASE_URL }}/admin/active-toggle/{{ $user->id }}">
                        {!! ($user->email_verified_at == null) ? 
                            '<span class="text-success">Activar Conta</span>' : 
                            '<span class="text-danger">Desativar Conta</span>' !!}
                    </a>
                    <br>
                    {{-- @if($user->role == 1)
                        <a href="#">Tornar Funcionário</a>
                        <a href="#">Tornar Utilizador</a>
                    @elseif($user->role == 2)
                        <a href="#">Tornar Admni</a>
                        <a href="#">Tornar Utilizador</a>
                    @elseif($user->role == 3)
                        <a href="#">Tornar Admni</a>
                        <a href="#">Tornar Funcionário</a>
                    @endif
                    <br>
                    <a href="#">Desativar conta</a> --}}
                    
                    <a href="{{ BASE_URL }}/admin/toadmin/{{ $user->id }}">
                        {{ ($user->role == 1) ? 'Remover Como Admin' : 'Tornar Admin' }}
                    </a>
                </td>
            </tr>
            
            @endforeach
            </tbody>
            </table>
            @endif

            <br>
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
