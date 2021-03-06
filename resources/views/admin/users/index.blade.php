@extends('layouts.app')

@section('content')
<div class="panel panel-primary">
    <div class="panel-heading">Usuarios</div>

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

        <form action="" method="POST">
            {{ csrf_field() }}

            <label>Datos personales</label>
            <div class="row">
                <div class="col-sm-8">
                    <div class="form-group">
                        <label for="name">Nombre</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="cellphone">Celular</label>
                        <input type="number" name="cellphone" class="form-control" value="{{ old('cellphone') }}">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}">
            </div>
            <div class="form-group">
                <label for="address">Dirección</label>
                <input type="text" name="address" class="form-control" value="{{ old('address') }}">
            </div>
            <label>Datos de la cuenta</label>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="document">Cédula</label>
                        <input type="text" name="document" class="form-control" value="{{ old('document') }}">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type="text" name="password" class="form-control" value="{{ old('password', str_random(8)) }}">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <button class="btn btn-primary">Registrar usuario</button>
            </div>
        </form>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Cédula</th>
                    <th>Nombre</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->document }}</td>
                    <td>{{ $user->name }}</td>
                    <td>
                        <a href="/usuario/{{ $user->id }}" class="btn btn-sm btn-primary" title="Editar">
                            <span class="glyphicon glyphicon-pencil"></span>
                        </a>
                        <a href="/usuario/{{ $user->id }}/eliminar" class="btn btn-sm btn-danger" title="Dar de baja">
                            <span class="glyphicon glyphicon-remove"></span>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
