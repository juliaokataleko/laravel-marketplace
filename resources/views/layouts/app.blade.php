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
    body {
        font-family: arial;
    }

    .page-container {
        position: relative;
        min-height: 100vh;
    }

    .content-wrap {
        padding-bottom: 12rem;
        /* Footer height */
    }

    footer {
        margin-top: 5em;
        position: absolute;
        bottom: 0;
        width: 100%;
        /* Footer height */
    }

    @media (max-width: 900px) {
        .content-wrap {
            padding-bottom: 18rem;
            /* Footer height */
        }
    }
</style>

<body id="" style=" background: #eee;">
    
    <div class="page-container">

        <div class="content-wrap" style="">

            @include('includes.header')

            <br><br>

            <div class="py-1">
                @yield('content')
            </div>

        </div>

        @include('includes.footer')



    </div>

</body>

</html>