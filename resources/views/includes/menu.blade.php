	@if (auth()->check())
		<div class="panel-footer" align="center">
				<div class="user-box">
					<form action="{{ url('/profile/image') }}" id="avatarForm">
						{{ csrf_field() }}
						<input type="file" style="display: none" id="avatarInput">
					</form>
					<div class="wrap">
						<div class="user-img">
							@if(auth()->user()->image)
								<img src="{{ asset('images/users/'.auth()->id().'.'.auth()->user()->image ) }}" alt="user-img" id="avatarImage" title="{{ auth()->user()->name }}" class="img-circle  img-responsive">
							@else
								<img src="{{ asset('images/users/0.jpg') }}" alt="user-img" id="avatarImage" title="{{ auth()->user()->name }}" class="img-circle img-responsive">
							@endif
						</div>
						<div class="text_over_image" id="textToEdit">Editar</div>
					</div>
					<h5>{{ auth()->user()->name }}</h5>
				</div>
		</div>
	@endif
	<div class="panel panel-primary">
	<div class="panel-heading">Menú</div>
	<div class="panel-body">
		<ul class="nav nav-pills nav-stacked">
			@if (auth()->check())
				<li @if(request()->is('home')) class="active" @endif>
					<a href="/home">Tablero</a>
				</li>

				{{-- @if (! auth()->user()->is_client) --}}
				{{-- <li @if(request()->is('ver')) class="active" @endif> --}}
				{{-- <a href="/ver">Ver incidencias</a> --}}
				{{-- </li> --}}
				{{-- @endif --}}

				@if (auth()->user()->is_support)
					<li @if(request()->is('cliente')) class="active" @endif>
						<a href="/cliente">Registrar cliente</a>
					</li>
				@endif

				@if (auth()->user()->is_support_level_one)
					<li @if(request()->is('reportar')) class="active" @endif>
						<a href="/reportar">Reportar incidencia</a>
					</li>
				@endif

				@if (auth()->user()->is_admin)
				<li role="presentation" class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
						Administración <span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li><a href="/incidencias">Incidencias</a></li>
						<li><a href="/usuarios">Usuarios</a></li>
						<li><a href="/proyectos">Procesos</a></li>
						<li><a href="/config">Configuración</a></li>
					</ul>
				</li>
				@endif
			@else
				<li @if(request()->is('/')) class="active" @endif><a href="/">Bienvenido</a></li>
				<li @if(request()->is('instrucciones')) class="active" @endif><a href="/instrucciones">Instrucciones</a></li>
				<li @if(request()->is('acerca-de')) class="active" @endif><a href="/acerca-de">Créditos</a></li>
			@endif
		</ul>
	</div>
</div>
