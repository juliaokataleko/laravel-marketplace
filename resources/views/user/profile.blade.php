@extends('layouts.app')

@section('title', Auth::user()->name .' - '.config('app.name', 'Laravel'))

@section('content')
<div class="container mt-md-3">
    <div class="card">
        <div class="card-body">

            <?php
    if(!null == Auth::user()->avatar && file_exists('uploads/avatar/'.Auth::user()->avatar)): 
        $image = BASE_URL."/uploads/avatar/{{ Auth::user()->avatar }}";
    else: 
        $image = BASE_URL."/images/person.png";
    endif; ?>
            <div class="row pt-4" style="display: flex; 
            flex-direction: row;
    align-items: center; 
    justify-content: center">
                <div class="col-sm-3 mx-3 text-center">
                    <?php
            if(!null == Auth::user()->avatar && file_exists('uploads/avatar/'.Auth::user()->avatar)): ?>
                    <img style="width: 110px; height: 110px;
                border: 6px solid #048ae4; 
                object-fit: cover; " src="{{ BASE_URL }}/uploads/avatar/{{ Auth::user()->avatar }}"
                        class="rounded mb-4" alt="...">
                    <?php else: ?>
                    <img style="width: 110px; height: 110px;;" src="{{ BASE_URL }}/images/person.png"
                        class="rounded mb-4 border" alt="...">
                    <?php endif; ?>
                </div>
                <div class="col-sm-9 text-center mx-4 py-3 mb-4" style="background: rgba(0, 0, 0, 0.5)">
                    <h3 class="text-light">Meu Perfil</h3>
                    <a href="{{ BASE_URL }}/profile/photo" class="text-light">Alterar Foto de Perfil</a> <br>
                    <a href="{{ BASE_URL }}/{{ Auth::user()->username }}" 
                        class="btn btn-primary mb-2">Minha Galeria</a>
                        <a href="{{ BASE_URL }}/promocoes" 
                            class="btn btn-primary mb-2">Pedidos de Promoção</a>
                </div>
            </div>

            @if(Session::has('success'))
            <p class="mt-4  alert alert-success">{{ Session::get('success') }}</p>
            @elseif(Session::has('warning'))
            <p class="mt-4 alert alert-warning">{{ Session::get('warning') }}</p>
            @endif

            <div class="">
                <ul class="list-group my-4">
                    <li class="list-group-item">
                        <b>Nome: </b> {{ firstLeterToUpper(Auth::user()->name)  }}
                    </li>
                    <li class="list-group-item">
                        <b>Email: </b> {{ Auth::user()->email }}
                    </li>
                    <li class="list-group-item">
                        <b>Usuário: @</b>{{ Auth::user()->username }}
                    </li>
                    <li class="list-group-item">
                        <b>Telefone: </b>{{ (!empty(Auth::user()->phone)) ? Auth::user()->phone : 'Sem Telefone' }}
                    </li>
                    <li class="list-group-item">
                        <b>Gênero:
                        </b>{{ (!empty(Auth::user()->gender)) ? gender(Auth::user()->gender) : 'Sem gênero' }}
                    </li>

                    <li class="list-group-item">
                        <b>Aniversário: </b>
                        {{ (!empty(Auth::user()->birth_day)) ? dateFormat(Auth::user()->birth_day) : 'Sem Data de Aniversário' }}
                    </li>

                    <li class="list-group-item">
                        <b>Cidade:
                        </b>{{ (!empty(Auth::user()->birth_place)) ? Auth::user()->birth_place : 'Sem Cidade' }}
                    </li>

                    <li class="list-group-item">
                        <b>Nível: </b>{{ (!empty(Auth::user()->role)) ? userLevel(Auth::user()->role) : 'Sem imagem' }}
                    </li>

                </ul>

            </div>

            <div class="row">
                <div class="col-sm-12 text-center">
                    <a href="{{ BASE_URL }}/profile/edit">Editar Perfil</a> <br>
                    <a class="btn text-white bg-primary mt-3" data-toggle="modal" data-target="#exampleModalCenter">
                        Editar Senha
                    </a>

                    <a class="nav-link active" href="{{ route('logout') }}" onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i> {{ __('Sair') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        </div>



        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">

                <div class="modal-content">
                    <form action="{{ BASE_URL }}/profile/change-password" method="post">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Alterar senha</h5>

                        </div>
                        <div class="modal-body">

                            @csrf
                            <div class="form-group">
                                <input type="password" class="form-control" name="password" id="password"
                                    aria-describedby="pwHelp" placeholder="Digite a senha actual">
                                <small id="pwHelp" class="form-text text-muted">
                                    Introduza a senha actual da sua conta
                                </small>
                            </div>

                            <div class="form-group">
                                <input type="password" class="form-control" id="npassword" name="npassword"
                                    aria-describedby="npwHelp" placeholder="Nova senha">
                                <small id="npwHelp" class="form-text text-muted">
                                    Introduza a nova senha
                                </small>
                            </div>

                            <div class="form-group">
                                <input type="password" name="cpassword" class="form-control" id="cpassword"
                                    aria-describedby="cpwHelp" placeholder="Confirmar Nova Senha">
                                <small id="cpwHelp" class="form-text text-muted">
                                    Confirme a nova senha
                                </small>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection