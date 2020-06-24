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

<body id="">

    @include('includes.header')

    @include('includes.messages')

    <section>
        <div class="content">
            <br> <br> <br>
            <h2>
                {{ getenv('APP_NAME') }}
            </h2>
            <p>
                {{--  Comprar e vender nunca foi tão fácil. <br>
                Um ambiente fácil e seguro foi preprado para
                facilitar a venda e aquisição de produtos para si
                e para toda Angola. <br><br>  --}}
                Encontre os productos que precisa pelos melhores preços. <br><br>
                O seu mercado agora está aí sempre consigo. Onde 
                você vai, ele vai.
                <br> <br>
                <a href="{{ BASE_URL }}/vender" class="btn-lg btn-primary form-control shadow-lg">Vender Agora</a>
            </p>
        </div>
    </section>

    <div class="destaques">
        <div >

            <div >

                    @if(count(request()->all()) == 0)
                    <h5 style="padding:8px; 
                    text-align: center; background: #f8aa01; width: 80%; margin: 0 auto" 
                    class="text-white mt-sm-4 mb-4 p-3 text-center">PATROCINADOS</h5>
                    <div class="row">

                        @foreach ($featureds as $product)
                        @include('includes.product')
                        @endforeach

                    </div>

                    <div class="text-center">
                        <a href="{{ BASE_URL }}/ofertas" style="margin: 0 auto" class="btn-lg btn-primary">Mais Ofertas</a>
                    </div>
                    
                    @endif

            </div>

        </div>
    </div>

    <div class="recursos">
        <div class="box">
            <i class="fa fa-list"></i>
            <h2>Produtos</h2>
            <p>Publique e encontre produtos com categorias, 
                preços e de diversos locais de Angola</p>
        </div>
        <div class="box">
            <i class="fa fa-location-arrow"></i>
            <h2>Locais</h2>
            <p>
                Não importa onde você está. Estamos em todas 
                as províncias e todas as cidades de Angola. <br><br>
                Agora todos os negócios podem estar connectados
            </p>
        </div>
        <div class="box">
            <i class="fa fa-paper-plane"></i>
            <h2>Mensagens</h2>
            <p>
                A comunicação é a chave de todos os negócios. Por isso preparamos 
                um chat privado onde compradores e vendedores podem discutir com segurança.
            </p>
        </div>
    </div>

    <div class="categorias">
        
        <div>
            <h2>CATEGORIAS</h2>
            @foreach ($categories as $cat)
            <a class="btn btn-secondary mr-2" 
            href="{{ BASE_URL }}/category/{{ $cat->slug }}">
                 {{ $cat->name }} </a>
                 @foreach($cat->subcategories as $sub)
                    <a class="btn btn-primary mr-2" 
                    href="{{ BASE_URL }}/subcategory/{{ $sub->slug }}"> 
                    {{ $sub->name }}</a>
                @endforeach
            @endforeach
        </div>
        
    </div>

    <footer>
        <ul>
            <li><a href="{{ BASE_URL }}/ofertas">Ofertas</a></li>
            <li><a href="{{ BASE_URL }}/profile">Meu Perfil</a></li>
            <li><a href="{{ BASE_URL }}/vender">Vender</a></li>
            <li><a href="{{ BASE_URL }}/profile">Definições</a></li>
            @auth()
            <li>
                <a href="{{ route('logout') }}" onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
					 {{ __('Terminar Sessão') }}
				</a>

				<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
					@csrf
				</form>
            </li>
            @else
            <li><a href="{{ BASE_URL }}/login">Entrar</a></li>
            <li><a href="{{ BASE_URL }}/register">Abrir Conta</a></li>
            @endauth
            
        </ul>
        <ul>
            <li><a href="{{ BASE_URL }}/perguntas-frequentes">Perguntas frequentes</a></li>
            <li><a href="{{ BASE_URL }}/about"> Sobre Nós</a></li>
            <li><a href="{{ BASE_URL }}/contact"> Contactos</a></li>
            <li><a href="{{ BASE_URL }}/termos-e-condicoes">Política de Privacidade</a></li>
        </ul>
        <div class="copy">
            &copy; <?php echo date("Y"); ?>, {{ getenv('APP_NAME') }}
        </div>
    </footer>

    <script>
        $(function() {
            //$('#example').append("Texto para aquele div");
            $('#categoria').change(function(e) {
                console.log(e);
                const category_id = e.target.value;
                // ajax
                $.get('{{ BASE_URL}}/subcat?category_id=' + category_id, function(data){
                //console.log(data);
                $('#subcategoria').empty();
                $.each(data, function(index, subCatObj) {
                    $('#subcategoria').append('<option value="'+subCatObj.id+'">'+subCatObj.name+'</option>');
                });
                });
            });

            $('#state').change(function(e) {
                console.log(e);
                const state_id = e.target.value;
                // ajax
                $.get('{{ BASE_URL}}/city?state_id=' + state_id, function(data){
                //console.log(data);
                $('#city').empty();
                $.each(data, function(index, cityObj) {
                    $('#city').append('<option value="'+cityObj.id+'">'+cityObj.name+'</option>');
                });
                });
            });
        });
    
    </script>

</body>

</html>