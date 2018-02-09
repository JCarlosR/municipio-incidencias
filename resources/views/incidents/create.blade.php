@extends('layouts.app')

@section('content')
<div class="panel panel-primary">
    <div class="panel-heading">Reportar incidencia</div>

    <div class="panel-body">
        @if (session('notification'))
            <div class="alert alert-info alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
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
        @if(auth()->user()->is_support_level_one)
            <form action="" method="POST">
                {{ csrf_field() }}

                <div class="form-group">
                    <label for="category_id">Categoría</label>
                    <select name="category_id" class="form-control">
                        <option value="">General</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="severity">Severidad</label>
                    <select name="severity" class="form-control">
                        <option value="M">Menor</option>
                        <option value="N">Normal</option>
                        <option value="A">Alta</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="document">Cliente (cédula)</label>
                    <input type="text" name="document" class="form-control" value="{{ old('document') }}">
                </div>
                <div class="form-group">
                    <label for="title">Título</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}">
                </div>
                <div class="form-group">
                    <label for="description">Descripción</label>
                    <textarea name="description" class="form-control">{{ old('description') }}</textarea>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary">Registrar incidencia</button>
                </div>
            </form>
        @else
                <div class="alert alert-dismissible alert-info">
                    Solo pueden <strong>registrar</strong> usuarios de soporte de nivel 1.
                </div>
        @endif
    </div>
</div>
@endsection
