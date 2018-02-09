@extends('layouts.app')

@section('content')
<div class="panel panel-primary">
    <div class="panel-heading">Incidencia: {{ $incident->title }}</div>

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
                    <th>Proyecto</th>
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
    </div>
</div>

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
