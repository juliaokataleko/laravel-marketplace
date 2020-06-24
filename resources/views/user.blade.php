@extends('layouts.app')

@section('title', $user->name . ' - '. config('app.name', 'Laravel'))

@section('content')

<div class="container mt-4" id="app">

    <div class="card">
        <div class="card-body">


            <?php
    if(!null == $user->avatar && file_exists('uploads/avatar/'.$user->avatar)): 
        $image = BASE_URL."/uploads/avatar/{{ $user->avatar }}";
    else: 
        $image = BASE_URL."/images/person.png";
    endif; ?>
            <div class="row pt-4" style="display: flex; 
            flex-direction: row;
    align-items: center; 
    justify-content: center">
                <div class="col-sm-3 mx-3 text-center">
                    <?php
            if(!null == $user->avatar && file_exists('uploads/avatar/'.$user->avatar)): ?>
                    <img style="width: 110px; height: 110px;
                border: 6px solid #048ae4; 
                object-fit: cover; " src="{{ BASE_URL }}/uploads/avatar/{{ $user->avatar }}" class="rounded mb-4"
                        alt="...">
                    <?php else: ?>
                    <img style="width: 110px; height: 110px;;" src="{{ BASE_URL }}/images/person.png"
                        class="rounded mb-4 border" alt="...">
                    <?php endif; ?>
                </div>
                @if($user->about)
                <div class="col-sm-9 text-center mx-4 py-3 mb-4" style="background: rgba(0, 0, 0, 0.5)">
                    {{ $user->about ?? '' }}
                </div>
                @endif
            </div>

            <div class="">
                <ul class="list-group my-4">
                    <li class="list-group-item">
                        <b>Nome: </b> {{ firstLeterToUpper($user->name)  }}
                    </li>
                    <li class="list-group-item">
                        <b>Email: </b> {{ $user->email }}
                    </li>
                    <li class="list-group-item">
                        <b>Usuário: @</b>{{ $user->username }}
                    </li>
                    <li class="list-group-item">
                        <b>Telefone: </b>{{ (!empty($user->phone)) ? $user->phone : 'Sem Telefone' }}
                    </li>
                    <li class="list-group-item">
                        <b>Gênero:
                        </b>{{ (!empty($user->gender)) ? gender($user->gender) : 'Sem gênero' }}
                    </li>

                    <li class="list-group-item">
                        <b>Cidade:
                        </b>{{ (!empty($user->birth_place)) ? $user->birth_place : 'Sem Cidade' }}
                    </li>


                </ul>

            </div>
        </div>
    </div>
            @if(count($products))
            <h5 style="padding:8px; 
                text-align: center; " class="text-dark my-3 bg-yellow">Produtos de {{ $user->name }}</h5>

            <div class="row">

                @foreach ($products as $product)
                @include('includes.product')
                @endforeach

            </div>

            <div style="width: 100%; overflow-x:auto">
                {{ $products->links() }}
            </div>

            @endif

       
</div>

@endsection