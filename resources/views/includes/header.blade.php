<div id="slideout-menu" style="margin-top: 58px !important">
    <ul>
        <li>
            <a href="{{ BASE_URL }}">
                {{ getenv('APP_NAME') }}
            </a>
        </li>
        <li><a href="{{ BASE_URL }}/vender">Vender</a></li>
        <li><a href="{{ BASE_URL }}/ofertas">Ofertas</a></li>
        @auth()
        {{-- <li><a href="{{ BASE_URL }}/messages"> <i class="fa fa-paper-plane"></i>  Mensagens</a></li>
         --}}
        <li><a href="{{ BASE_URL }}/profile">Perfil</a></li>
        <li>
            <a href="{{ route('logout') }}" onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">
                Sair
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>
        @if(Auth::check() && Auth::user()->role == 1)
        <li>
            <a href="{{ BASE_URL }}/admin" data-abc="true">Dash </span></a>
        </li>
        @endif
        @else
        <li><a href="{{ BASE_URL }}/login">Entrar</a></li>
        <li><a href="{{ BASE_URL }}/register">Abrir Conta</a></li>
        @endauth
    </ul>
</div>
<nav class="bg-primary fixed-top">
    <div id="logo-img">
        <a href="{{ BASE_URL }}">
            {{ getenv('APP_NAME') }}
        </a>
        @auth()
        {{-- <a href="{{ BASE_URL }}/messages"> 
            <span class="mobile"><i class="fa fa-paper-plane"></i> </span>
            <span class="desktop"><i class="fa fa-paper-plane"></i>  Mensagens</span>  </a> --}}
        @endauth
    </div>
    <div id="menu-icon">
        <i class="fa fa-bars"></i>
    </div>
    <ul>
        <li><a href="{{ BASE_URL }}/vender">Vender</a></li>
        <li><a href="{{ BASE_URL }}/ofertas">Ofertas</a></li>
        @auth()
        <li><a href="{{ BASE_URL }}/profile">Perfil</a></li>
        @if(Auth::check() && Auth::user()->role == 1)
        <li>
            <a href="{{ BASE_URL }}/admin" data-abc="true">Dash </span></a>
        </li>
        @endif
        @else
        <li><a href="{{ BASE_URL }}/login">Entrar</a></li>
        <li><a href="{{ BASE_URL }}/register">Abrir Conta</a></li>
        @endauth

    </ul>
</nav>