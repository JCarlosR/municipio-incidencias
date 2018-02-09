@extends('layouts.app')

@section('content')
<div class="panel panel-primary">
    <div class="panel-heading">Incidencia</div>

    <div class="panel-body">
        @if (session('notification'))
            <div class="alert alert-success">
                {{ session('notification') }}
            </div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Proceso</th>
                    <th>Categoría</th>
                    <th>Fecha de envío</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td id="incident_key">{{ $incident->id }}</td>
                    <td id="incident_project">{{ $incident->project->name }}</td>
                    <td id="incident_category">{{ $incident->category_name }}</td>
                    <td id="incident_created_at">{{ $incident->created_at }}</td>
                </tr>
            </tbody>
            <thead>
                <tr>
                    <th>Asignada a</th>
                    <th>Nivel</th>
                    <th>Estado</th>
                    <th>Severidad</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td id="incident_responsible">{{ $incident->support_name }}</td>
                    <td>{{ $incident->level->name }}</td>
                    <td id="incident_state">{{ $incident->state }}</td>
                    <td id="incident_severity">{{ $incident->severity_full }}</td>
                </tr>
            </tbody>
        </table>

        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th>Título</th>
                    <td id="incident_summary">{{ $incident->title }}</td>
                </tr>
                <tr>
                    <th>Descripción</th>
                    <td id="incident_description">{{ $incident->description }}</td>
                </tr>
                <tr>
                    <th>Adjuntos</th>
                    <td id="incident_attachment">No se han adjuntado archivos</td>
                </tr>
            </tbody>
        </table>

        @if ($incident->support_id == null && $incident->active && auth()->user()->canTake($incident))
        <a href="/incidencia/{{ $incident->id }}/atender" class="btn btn-primary btn-sm" id="incident_btn_apply">
            Atender incidencia
        </a>
        @endif


            @if ($incident->active)
                @if($take_incident)
                    <a href="/incidencia/{{ $incident->id }}/resolver" class="btn btn-info btn-sm" id="incident_btn_solve">
                        Marcar como resuelto
                    </a>
                @endif
                @if (auth()->user()->id == $incident->creator_id)
                    <a href="/incidencia/{{ $incident->id }}/editar" class="btn btn-success btn-sm" id="incident_btn_edit">
                        Editar incidencia
                    </a>
                @endif
            @else
                @if($take_incident)
                    <a href="/incidencia/{{ $incident->id }}/abrir" class="btn btn-info btn-sm" id="incident_btn_open">
                        Volver a abrir incidencia
                    </a>
                @endif
            @endif


        @if (auth()->user()->id == $incident->support_id && $incident->active)
        <a href="/incidencia/{{ $incident->id }}/derivar" class="btn btn-danger btn-sm" id="incident_btn_derive">
            Derivar al siguiente nivel
        </a>
        @endif

        @if (auth()->user()->id == $incident->creator_id && $incident->active)
            <a href="/vista/{{ $incident->id }}" class="btn btn-default btn-sm pull-right">
                Vista de impresión
            </a>
        @endif
    </div>
</div>

    @include('layouts.chat')

    <div class="panel panel-primary">
        <div class="panel-heading">
            <h5>Historial</h5>
        </div>
        <div class="panel-body">
            <p>
                <a data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                    Ver historial de cambios
                </a>
            </p>
            <div class="collapse" id="collapseExample">
                <div class="card card-block">
                    <table class="table table-bordered">
                        <thead>
                        <tr class="active">
                            <th>Descripción</th>
                            <th>Fecha y Hora</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($incident_histories as $incident_history)
                            <tr>
                                <td>{{ $incident_history->description }}</td>
                                <td>{{ $incident_history->created_at }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
