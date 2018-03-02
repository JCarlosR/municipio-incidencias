@extends('layouts.app')

@section('content')
<div class="panel panel-primary">
    <div class="panel-heading">Lista de clientes</div>

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
            <a href="/cliente/crear" class="btn btn-primary" title="Nuevo cliente">
                Nuevo cliente
            </a>

            <form class="navbar-form navbar-right" role="search">
                <div class="form-group">
                    <input type="text" name="search_client" class="form-control" placeholder="Buscar por cédula o nombre" value="{{ $searchClient }}">
                </div>
                <button type="submit" class="btn btn-default">
                    <i class="glyphicon glyphicon-search"></i>
                </button>
            </form>
        <table class="table table-bordered">
            <thead>
            <tr class="active">
                <th>Nombre</th>
                <th>Cédula</th>
                <th>Opciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($clients as $client)
                <tr>
                    <td>{{ $client->name }}</td>
                    <td>{{ $client->document }}</td>
                    <td>
                        <a href="/cliente/{{ $client->id }}" class="btn btn-sm btn-primary" title="Editar">
                            <span class="glyphicon glyphicon-pencil"></span>
                        </a>
                        <a href="/cliente/{{ $client->id }}/eliminar" class="btn btn-sm btn-danger" title="Dar de baja">
                            <span class="glyphicon glyphicon-remove"></span>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
            {{ $clients->links() }}
    </div>
</div>
@endsection
