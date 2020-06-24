@extends('layouts.auth')

@section('content')
<div class="container " style="max-width: 500px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card pt-4 shadow-sm" style="border: 0 !important">

                <h4 class="text-center px-3">Recuperar Conta!</h4>
                @if(Session::has('success'))
                <p class="mt-4 alert alert-success">{{ Session::get('success') }}</p>
                @elseif(Session::has('warning'))
                <p class="mt-4 alert alert-warning">{{ Session::get('warning') }}</p>
                @endif
                <div class="card-body">

                    <form action="{{ BASE_URL }}/recover" method="post">
                        @csrf

                        <div class="input-group mb-3">
                            <input type="text" class="form-control" 
                            placeholder="RDigite o email" 
                            name="email" id="email" required>
                            <div class="input-group-append">
                              <button class="btn btn-outline-secondary" type="submit">Solicitar</button>
                            </div>
                          </div>
                    </form>


                </div>
            </div>

            <div class="mt-3">
                <a class="mt-3" href="{{ BASE_URL }}/login">Voltar na página de login</a>
            </div>

        </div>
    </div>
</div>
@endsection