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

    <script src="{{ asset('js/app.js') }}" defer></script>
    <script async src="{{ asset('js/jquery.js') }}"></script>
    <!-- Fonts -->
    <link rel="icon" type="image/png" href="{{ asset('/images/logo.png') }}" />

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <style>
        .container {
            max-width: 899px;
        }

        .nav-link {
            text-transform: uppercase !important;
            font-size: 15px !important;
            background: rgb(6, 96, 148);

        }
    </style>
</head>

<body style="margin-top:3em; background: #eee">

    <nav class="navbar fixed-top navbar-expand-lg 
    navbar-dark " style="background: #066094;">
        <a class="navbar-brand" href="{{ BASE_URL }}/admin">Painel de Controlo</a>

        <button class="navbar-toggler text-white" style="padding: 0; border: 0" type="button" data-toggle="collapse"
            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="{{ __('Toggle navigation') }}">
            <i class="fa fa-bars"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="{{ BASE_URL }}/admin/users">Usuários</a>
                </li>

                <li class="nav-item active">
                    <a class="nav-link" href="{{ BASE_URL }}/admin/product">Productos</a>
                </li>

                <li class="nav-item active">
                    <a class="nav-link" href="{{ BASE_URL }}/admin/category">Categorias</a>
                </li>

                <li class="nav-item active">
                    <a class="nav-link" href="{{ BASE_URL }}/admin/subcategory">Subcategorias</a>
                </li>

                <li class="nav-item active">
                    <a class="nav-link" href="{{ BASE_URL }}/admin/ads">Promoções</a>
                </li>

                <li class="nav-item active">
                    <a class="nav-link" href="{{ BASE_URL }}/admin/ratings">Classificações</a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">

                <li class="nav-item">
                    <a class="nav-link" href="{{ BASE_URL }}/"> <i class="fa fa-home"></i> Início</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ BASE_URL }}/admin/config">Configurações</a>
                </li>
            </ul>

        </div>
    </nav>
    <div id="app">
        <main class="py-4">
            @yield('content')
        </main>
    </div>

</body>

</html>