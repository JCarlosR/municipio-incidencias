@extends('layouts.app')

@section('content')
<div class="panel panel-primary">
    <div class="panel-heading">Editar proceso</div>

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

            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $project->name) }}">
            </div>
            <div class="form-group">
                <label for="description">Descripción</label>
                <input type="text" name="description" class="form-control" value="{{ old('description', $project->description) }}">
            </div>
            <div class="form-group">
                <label for="start">Fecha de inicio</label>
                <input type="date" name="start" class="form-control" value="{{ old('start', $project->start) }}">
            </div>
            <div class="form-group">
                <button class="btn btn-primary">Guardar proceso</button>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-md-5">
        <div class="panel panel-success">
            <div class="panel-heading">Categorías</div>
            <div class="panel-body">
                <button class="btn btn-sm btn-success waves-effect waves-light" data-toggle="modal" data-target="#modalNewCategory"><i class="glyphicon glyphicon-plus"></i> Añadir categoría</button>
                <p></p>
                <table class="table table-bordered">
                    <thead>
                    <tr class="active">
                        <th>Nombre</th>
                        <th class="col-sm-4">Opciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td>{{ $category->name }}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary" title="Editar" data-category="{{ $category->id }}">
                                    <span class="glyphicon glyphicon-pencil"></span>
                                </button>
                                <a href="/categoria/{{ $category->id }}/eliminar" class="btn btn-sm btn-danger" title="Dar de baja">
                                    <span class="glyphicon glyphicon-remove"></span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="panel panel-success">
            <div class="panel-heading">Niveles</div>
            <div class="panel-body">
                <button class="btn btn-sm btn-success waves-effect waves-light" data-toggle="modal" data-target="#modalNewLevel"><i class="glyphicon glyphicon-plus"></i> Añadir nivel</button>
                <p></p>
                <table class="table table-bordered">
                    <thead>
                        <tr class="active">
                            <th>#</th>
                            <th>Nivel</th>
                            <th>Días</th>
                            <th>Horas</th>
                            <th>Min</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($levels as $key => $level)
                        <tr>
                            <td>N{{ $key+1 }}</td>
                            <td>{{ $level->name }}</td>
                            <td class="text-center">{{ $level->days }}</td>
                            <td class="text-center">{{ $level->hours }}</td>
                            <td class="text-center">{{ $level->minutes }}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary" title="Editar" data-level="{{ $level->id }}">
                                    <span class="glyphicon glyphicon-pencil"></span>
                                </button>
                                <a href="/nivel/{{ $level->id }}/eliminar" class="btn btn-sm btn-danger" title="Dar de baja">
                                    <span class="glyphicon glyphicon-remove"></span>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>        

    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="modalEditCategory">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Editar categoría</h4>
      </div>
      <form action="/categoria/editar" method="POST">
          {{ csrf_field() }}
          <div class="modal-body">        
            <input type="hidden" name="category_id" id="category_id" value="">
            <div class="form-group">
                <label for="name">Nombre de la categoría</label>
                <input type="text" class="form-control" name="name" id="category_name" required>
            </div>        
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Guardar cambios</button>
          </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="modalNewCategory">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Nueva categoría</h4>
            </div>
            <form action="/categorias" method="POST">
                {{ csrf_field() }}
                <div class="modal-body">
                    <input type="hidden" name="project_id" value="{{ $project->id }}">
                    <div class="form-group">
                        <label for="name">Nombre de la categoría</label>
                        <input type="text" name="name" placeholder="Ingrese nombre" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="modalEditLevel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Editar nivel</h4>
      </div>
      <form action="/nivel/editar" method="POST">
          {{ csrf_field() }}
          <div class="modal-body">        
            <input type="hidden" name="level_id" id="level_id" value="">
            <div class="form-group">
                <label for="name">Nombre del nivel</label>
                <input type="text" required class="form-control" name="name" id="level_name">
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="days">Días</label>
                        <input type="number" min="0" class="form-control" name="days" id="level_day">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="hours">Horas</label>
                        <input type="number" min="0" max="23" class="form-control" name="hours" id="level_hour">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="minutes">Minutos</label>
                        <input type="number" min="0" max="59" class="form-control" name="minutes" id="level_minute">
                    </div>
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Guardar cambios</button>
          </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="modalNewLevel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Nuevo nivel</h4>
            </div>
            <form action="/niveles" method="POST" class="form-group">
                {{ csrf_field() }}
                <input type="hidden" name="project_id" value="{{ $project->id }}">
                <div class="modal-body">
                    <div class="form-group">
                        <p>Niveles</p>
                        <input type="text" required name="name" placeholder="Ingrese nombre" class="form-control">
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <p>Días</p>
                                <input type="number" min="0" name="days" placeholder="" class="form-control" value="0">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <p>Horas</p>
                                <input type="number" min="0" max="23" name="hours" placeholder="" class="form-control" value="0">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <p>Minutos</p>
                                <input type="number" min="0" max="59" name="minutes" placeholder="" class="form-control" value="0">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('/js/admin/projects/edit.js') }}"></script>
@endsection