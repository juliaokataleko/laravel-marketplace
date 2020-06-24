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