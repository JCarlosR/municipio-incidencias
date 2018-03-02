@extends('layouts.app')

@section('content')
<div class="panel panel-primary">
    <div class="panel-heading">Tablero</div>

    <div class="panel-body">
        
        @if (auth()->user()->is_support)
        <div class="panel panel-success">
			<div class="panel-heading">
				<h3 class="panel-title">Incidencias asignadas</h3>
			</div>
			<div class="panel-body">
				<table class="table table-bordered">
					<thead>
						<tr class="active">
							<th>Código</th>
							<th>Categoría</th>
							<th>Severidad</th>
							<th>Estado</th>
							<th>Fecha creación</th>
							<th>Cliente</th>
						</tr>
					</thead>
					<tbody id="dashboard_my_incidents">
						@foreach ($my_incidents as $incident)
                            @if($incident->active == 1)
                                <tr>
                                    <td align="center">
                                        <a href="/ver/{{ $incident->id }}">
                                            {{ $incident->id }}
                                        </a>
                                    </td>
                                    <td>{{ $incident->category_name }}</td>
                                    <td>{{ $incident->severity_full }}</td>
                                    <td>{{ $incident->state }}</td>
                                    <td>{{ $incident->created_at }}</td>
                                    <td>{{ $incident->client->name }}</td>
                                </tr>
                            @endif
						@endforeach
					</tbody>
				</table>
			</div>
		</div>

		<div class="panel panel-success">
			<div class="panel-heading">
				<h3 class="panel-title">Incidencias pendientes</h3>
			</div>
			<div class="panel-body">
				<table class="table table-bordered">
					<thead>
						<tr class="active">
							<th>Código</th>
							<th>Categoría</th>
							<th>Severidad</th>
							<th>Estado</th>
							<th>Fecha creación</th>
							<th>Cliente</th>
							<th>Opción</th>
						</tr>
					</thead>
					<tbody id="dashboard_pending_incidents">
						@foreach ($pending_incidents as $incident)
							<tr>
								<td align="center">
									<a href="/ver/{{ $incident->id }}">
										{{ $incident->id }}
									</a>
								</td>
								<td>{{ $incident->category_name }}</td>
								<td>{{ $incident->severity_full }}</td>
								<td>{{ $incident->state }}</td>
								<td>{{ $incident->created_at }}</td>
								<td>{{ $incident->client->name }}</td>
								<td>
									<a href="/ver/{{ $incident->id }}" class="btn btn-primary btn-sm">
										Ver
									</a>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>

		<div class="panel panel-success">
			<div class="panel-heading">
				<h3 class="panel-title">Incidencias reportadas</h3>
			</div>
			<div class="panel-body">
				<table class="table table-bordered">
					<thead>
						<tr class="active">
							<th>Código</th>
							<th>Categoría</th>
							<th>Severidad</th>
							<th>Estado</th>
							<th>Fecha creación</th>
							<th>Cliente</th>
							<th>Responsable</th>
							<th>Opción</th>
						</tr>
					</thead>
					<tbody id="dashboard_by_me">
						@foreach ($incidents_by_me as $incident)
							@if($incident->active == 1)
                                <tr>
                                    <td class="text-center">
                                        {{ $incident->id }}
                                    </td>
                                    <td>{{ $incident->category_name }}</td>
                                    <td>{{ $incident->severity_full }}</td>
                                    <td>{{ $incident->state }}</td>
                                    <td>{{ $incident->created_at }}</td>
                                    <td>{{ $incident->client->name }}</td>
                                    <td>
                                        {{ $incident->support_id ? $incident->support->name : 'Sin asignar' }}
                                    </td>
                                    <td>
                                        <a href="/ver/{{ $incident->id }}" class="btn btn-xs btn-info">
                                            <i class="glyphicon glyphicon-zoom-in"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endif
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
        @endif
        @if(auth()->user()->is_client)
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title">Incidencias reportadas</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr class="active">
                            <th>Código</th>
                            <th>Categoría</th>
                            <th>Severidad</th>
                            <th>Estado</th>
                            <th>Fecha creación</th>
                            <th>Responsable</th>
                            <th>Opción</th>
                        </tr>
                        </thead>
                        <tbody id="dashboard_by_me">
                        @foreach ($incidents_client as $incident)
                            @if($incident->active == 1)
                                <tr>
                                    <td class="text-center">
                                        {{ $incident->id }}
                                    </td>
                                    <td>{{ $incident->category_name }}</td>
                                    <td>{{ $incident->severity_full }}</td>
                                    <td>{{ $incident->state }}</td>
                                    <td>{{ $incident->created_at }}</td>
                                    <td>
                                        {{ $incident->support_id ? $incident->support->name : 'Sin asignar' }}
                                    </td>
                                    <td>
                                        <a href="/ver/{{ $incident->id }}" class="btn btn-xs btn-info">
                                            <i class="glyphicon glyphicon-zoom-in"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
