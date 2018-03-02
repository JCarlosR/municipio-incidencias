@extends('layouts.app')

@section('content')
<div class="panel panel-primary">
    <div class="panel-heading">Editar cliente</div>

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
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="name">Nombre</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $client->name) }}">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="document">Cédula</label>
                        <input type="text" name="document" class="form-control" value="{{ old('document', $client->document) }}" disabled>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $client->email) }}">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="address">Dirección</label>
                        <input type="text" name="address" class="form-control" value="{{ old('address', $client->address) }}">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="cellphone">Celular</label>
                        <input type="number" name="cellphone" class="form-control" value="{{ old('cellphone', $client->cellphone) }}">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="password">Contraseña <em>Ingresar solo si se desea modificar</em></label>
                        <input type="text" name="password" class="form-control" value="{{ old('password') }}">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <button class="btn btn-success">Guardar usuario</button>
                <a href="/cliente" class="btn btn-default" title="Volver">Volver</a>
            </div>
        </form>

    </div>
</div>
@endsection

@section('scripts')
    <script src="/js/admin/users/edit.js"></script>
@endsection