<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @yield('title', 'Sistema de Compras e Vendas Online')
    </title>

    <!-- Scripts -->

    <!-- Fonts -->

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('/images/logo.png') }}" />
    <script src="{{ asset('js/app.js') }}"></script>
    <script defer src="{{ asset('js/script.js') }}"></script>
</head>
<style>
    a {
        color: #444 !important;
        font-size: 14px
    }
</style>

<body id="" style="margin-top:3em; background: #eee; ">

    <div class="text-center">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ BASE_URL }}/images/logo.png" 
            width="120px" alt="{{ config('app.name', 'Laravel') }}"
                style="display:inline">
        </a>
    </div>

    <div id="">

        <div class="py-1">
            @yield('content')
        </div>

        <div id="form" style="display: none">

            <div id="searchBox" class="searchBox bg-white p-3" style="width: 95%; max-width: 400px">
                <button onclick="closeSearch()" class="btn 
                text-white btn-secondary form-control mb-3">Fechar A Pesquisa</button>
                <form action="/" method="GET">
                    <div class="form-group">
                        <select name="cat" id="cat" class="form-control">
                            <option value="">Selecione uma categoria</option>
                            <?php 
                          $categories = App\models\Category::all();
                          ?>
                            @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="q" name="q" placeholder="O que procuras?">
                    </div>
                    <button type="submit" class="btn form-control btn-primary"> <i class="fa fa-search"></i> </button>
                </form>
            </div>
        </div>

        <div id="search">
        </div>

        <div id="success" class="text-white"></div>

    </div>

</body>

</html>