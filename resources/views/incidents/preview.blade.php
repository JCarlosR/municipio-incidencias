@extends('layouts.app')

@section('content')
<div id="printableArea">
    <div class="panel panel-primary">
        <div class="panel-heading">Incidencia generada</div>

        <div class="panel-body">
            @if (session('notification'))
                <div class="alert alert-success">
                    {{ session('notification') }}
                </div>
            @endif

            <table class="table table-bordered">
                <thead>
                    <tr class="active">
                        <th>Número</th>
                        <th>Nombre del usuario</th>
                        <th>Tiempo estimado</th>
                        <th>Tipo de incidencia</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td id="incident_key">{{ $incident->id }}</td>
                        <td id="incident_project">{{ $incident->client->name }}</td>
                        <td id="incident_category">
                            @if( $count_days == 0)
                            @else
                                {{ $count_days }}
                                @if ($count_days == 1) día @else días @endif
                            @endif
                            @if( $count_hours == 0)
                            @else
                                @if($count_days == 0) @else , @endif
                                {{ $count_hours }}
                                @if ($count_hours == 1) hora @else horas @endif
                            @endif
                            @if( $count_minutes == 0)
                            @else
                                @if($count_hours == 0 && $count_days == 0) @else , @endif
                                {{ $count_minutes }}
                                @if ($count_minutes == 1) minuto @else minutos @endif
                            @endif
                        </td>
                        <td id="incident_created_at">{{ $incident->project->name }}</td>
                    </tr>
                </tbody>
                <thead>
                    <tr class="active">
                        <th>Fecha de registro</th>
                        <th colspan="2"># de incidencias sin atender en la cola</th>
                        <th>Nivel de atención</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td id="incident_responsible">{{ $incident->created_at }}</td>
                        <td colspan="2">{{ $incident_count }}</td>
                        <td>{{ $incident->level->name }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="pull-right">
    <a href="/home" class="btn btn-default">Volver</a>
    <button onclick="printDiv('printableArea')" class="btn btn-success waves-effect waves-light"><i class="glyphicon glyphicon-print"></i> Imprimir</button>
</div>
@endsection

@section('scripts')
    <script>
        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }
    </script>
@endsection
