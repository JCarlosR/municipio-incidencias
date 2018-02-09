@extends('layouts.app')

@section('content')
<div class="panel panel-primary">
    <div class="panel-heading">Incidencias</div>

    <div class="panel-body">
        @if (session('notification'))
            <div class="alert alert-success">
                {{ session('notification') }}
            </div>
        @endif

        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form class="navbar-form navbar-left" role="search">
            <div class="form-group">
                <select class="form-control" name="state">
                    <option value="" >Buscar por estado</option>
                    <option value="Resuelto" @if($searchState == 'Resuelto') selected @endif>Resuelto</option>
                    <option value="Asignado" @if($searchState == 'Asignado') selected @endif>Asignado</option>
                    <option value="Pendiente" @if($searchState == 'Pendiente') selected @endif>Pendiente</option>

                </select>
            </div>
            <button type="submit" class="btn btn-default">
                <i class="glyphicon glyphicon-search"></i>
            </button>
        </form>
        <form class="navbar-form navbar-right" role="search">
            <div class="form-group">
                <input type="text" name="document" class="form-control" placeholder="Buscar por cédula" value="{{ $searchIncident }}">
            </div>
            <button type="submit" class="btn btn-default">
                <i class="glyphicon glyphicon-search"></i>
            </button>
        </form>
        <table class="table table-bordered">
            <thead>
                <tr class="active">
                    <th>Titulo</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th>Cliente</th>
                    <th>Cédula</th>
                    <th>Opción</th>
                </tr>
            </thead>
            <tbody>
                    @foreach ($incidents as $incident)
                        <tr>
                            <td>{{ $incident->title }}</td>
                            <td>{{ $incident->description }}</td>
                            <td>{{ $incident->state }}</td>
                            <td>{{ $incident->client->name }}</td>
                            <td>{{ $incident->client->document }}</td>
                            <td>
                                <a href="/incidencia/{{ $incident->id }}" class="btn btn-xs btn-info">
                                    <i class="glyphicon glyphicon-zoom-in"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
            </tbody>
        </table>
            {{ $incidents->links() }}
    </div>
</div>
@endsection
