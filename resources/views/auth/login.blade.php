@extends('layouts.auth')

@section('content')
<div class="container " style="max-width: 500px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card pt-4 shadow-sm" style="border: 0 !important">

                <h4 class="text-center px-3">Acessa a sua conta!</h4>
                @if(Session::has('success'))
                <p class="mt-4 alert alert-success">{{ Session::get('success') }}</p>
                @elseif(Session::has('warning'))
                <p class="mt-4 alert alert-warning">{{ Session::get('warning') }}</p>
                @endif
                <div class="card-body" >
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <div class="col-md-12">
                                <input id="login" type="text" 
                                placeholder="Usuário ou E-mail" 
                                class="form-control{{ $errors->has('username') || $errors->has('email') ? ' is-invalid' : '' }}"
                                <?php $email = request('email') ?? ''; ?>
                                name="login" value="{{ (old('username') ?: old('email') ?? $email) }}"
                                required autocomplete="off" autofocus>

                                @error('login')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <input id="password" placeholder="Senha" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                                @if (Route::has('password.request'))
                                    <a class="mt-2 btn-link" href="{{ BASE_URL }}/recover">
                                        Esquecí a minha senha.
                                    </a>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        Manter a sessão
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12">
                                <button type="submit" class="btn form-control btn-primary">
                                    Entrar
                                </button>

                                
                            </div>
                        </div>
                    </form>
                    
                </div>
                
            </div>

            <div class="mt-3">
                <a class="mt-3" href="{{ BASE_URL }}/register">Es novo? Criar conta agora</a>
            </div>
           
        </div>
    </div>
</div>
@endsection
