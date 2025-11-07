@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">{{ $alumno->nombre_completo }}</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        {{-- Agregar este botón --}}
        @if($alumno->actividades_count > 0)
        <a href="{{ route('export.alumno.actividades', $alumno->id) }}" class="btn btn-danger me-2">
            📄 Exportar PDF
        </a>
        @endif
        <a href="{{ route('alumnos.edit', $alumno->id) }}" class="btn btn-warning me-2">
            Editar
        </a>
        <form action="{{ route('alumnos.destroy', $alumno->id) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" 
                onclick="return confirm('¿Estás seguro de eliminar este alumno?')">
                Eliminar
            </button>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Información del Alumno</h5>
                <dl class="row">
                    <dt class="col-sm-3">Curso Académico:</dt>
                    <dd class="col-sm-9">{{ $alumno->curso_academico }}</dd>

                    <dt class="col-sm-3">Edad:</dt>
                    <dd class="col-sm-9">{{ $alumno->edad }} años</dd>

                    <dt class="col-sm-3">Total Actividades:</dt>
                    <dd class="col-sm-9">
                        <span class="badge bg-success">{{ $alumno->actividades_count }}</span>
                    </dd>
                </dl>
            </div>
        </div>

        @if($alumno->actividades_count > 0)
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Actividades Inscritas</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Actividad</th>
                                <th>Día</th>
                                <th>Horario</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($alumno->actividades as $actividad)
                            <tr>
                                <td>{{ $actividad->nombre }}</td>
                                <td>{{ $actividad->dia_semana }}</td>
                                <td>{{ $actividad->hora_inicio->format('H:i') }} - {{ $actividad->hora_finalizacion->format('H:i') }}</td>
                                <td>
                                    <!-- CORREGIR ESTA LÍNEA: Buscar la inscripción directamente -->
                                    <form action="{{ route('inscripciones.destroy', $alumno->inscripciones()->where('actividad_id', $actividad->id)->first()) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" 
                                            onclick="return confirm('¿Estás seguro de eliminar esta inscripción?')">
                                            Desinscribir
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection