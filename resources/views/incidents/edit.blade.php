@extends('layouts.app')

@section('content')
<div class="panel panel-primary">
    <div class="panel-heading">Dashboard</div>

    <div class="panel-body">
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if(auth()->user()->id == $incident->creator_id && $incident->level_id == $first->id && $incident->support_id == NULL)
        <form action="" method="POST">
            {{ csrf_field() }}
            
            <div class="form-group">
                <label for="category_id">Categoría</label>
                <select name="category_id" class="form-control">
                    <option value="">General</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @if($incident->category_id == $category->id) selected @endif>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="severity">Severidad</label>
                <select name="severity" class="form-control">
                    <option value="M" @if($incident->severity=='M') selected @endif>Menor</option>
                    <option value="N" @if($incident->severity=='N') selected @endif>Normal</option>
                    <option value="A" @if($incident->severity=='A') selected @endif>Alta</option>
                </select>
            </div>
            <div class="form-group">
                <label for="document">Cliente (cédula)</label>
                <input type="text" name="document" class="form-control" value="{{ old('document', $incident->client->document) }}" disabled>
            </div>
            <div class="form-group">
                <label for="description">Descripción</label>
                <textarea name="description" class="form-control">{{ old('description', $incident->description) }}</textarea>
            </div>
            <div class="form-group">
                <button class="btn btn-primary">Guardar cambios</button>
            </div>
        </form>
        @else
            <div class="alert alert-dismissible alert-info">
                La incidencia está siendo <strong>atendida</strong>, por lo que no podrá ser editada.
            </div>
        @endif
    </div>
</div>
@endsection
