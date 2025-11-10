@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">{{ $alumno->nombre_completo }}</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <!-- Botón IMPRIMIR (si tiene actividades) -->
        @if($alumno->actividades_count > 0)
        <a href="{{ route('export.alumno.actividades', $alumno->id) }}" class="btn btn-danger me-2">
            <i class="bi bi-printer"></i> Imprimir
        </a>
        @endif

        <!-- Botón EDITAR -->
        <a href="{{ route('alumnos.edit', $alumno->id) }}" class="btn btn-warning me-2">
            Editar
        </a>

        <!-- Botón ELIMINAR -->
        <form action="{{ route('alumnos.destroy', $alumno->id) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-dark"
                onclick="return confirm('¿Estás seguro de eliminar este alumno?')">
                Eliminar
            </button>
        </form>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row">
    <div class="col-md-8">
        <!-- Información del Alumno -->
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h5 class="card-title mb-0">
                    <i class="bi bi-person-badge"></i>
                    Información del Alumno
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Nombre Completo:</strong><br>
                        <span class="fs-5">{{ $alumno->nombre_completo }}</span></p>

                        <p><strong>Curso Académico:</strong><br>
                        <span class="badge bg-info fs-6">{{ $alumno->curso_academico }}</span></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Edad:</strong><br>
                        <span class="badge bg-secondary fs-6">{{ $alumno->edad }} años</span></p>

                        <p><strong>Total de Actividades:</strong><br>
                        <span class="badge bg-success fs-6">{{ $alumno->actividades_count ?? 0 }}</span></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actividades Inscritas -->
        @if($alumno->actividades_count > 0)
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">
                    <i class="bi bi-calendar-check"></i>
                    Actividades Inscritas
                </h5>
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
                            @php
                                $inscripcion = $alumno->inscripciones->where('actividad_id', $actividad->id)->first();
                            @endphp
                            <tr>
                                <td>
                                    <strong>{{ $actividad->nombre }}</strong>
                                    @if($actividad->descripcion)
                                    <br><small class="text-muted">{{ Str::limit($actividad->descripcion, 50) }}</small>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $actividad->dia_semana }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">
                                        {{ $actividad->hora_inicio->format('H:i') }} - {{ $actividad->hora_finalizacion->format('H:i') }}
                                    </span>
                                </td>
                                <td>
                                    @if($inscripcion)
                                    <form action="{{ route('inscripciones.destroy', $inscripcion->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('¿Estás seguro de desinscribir a {{ $alumno->nombre_completo }} de {{ $actividad->nombre }}?')">
                                            Desinscribir
                                        </button>
                                    </form>
                                    @else
                                    <span class="text-muted small">Sin inscripción</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @else
        <div class="card">
            <div class="card-body text-center py-5">
                <div class="mb-3">
                    <i class="bi bi-calendar-x display-1 text-muted"></i>
                </div>
                <h4 class="text-muted">No hay actividades inscritas</h4>
                <p class="text-muted">Este alumno no está inscrito en ninguna actividad.</p>
                <a href="{{ route('inscripciones.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Inscribir en Actividad
                </a>
            </div>
        </div>
        @endif
    </div>

    <div class="col-md-4">
        <!-- Panel de acciones rápidas -->
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="card-title mb-0">Acciones Rápidas</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    @if($alumno->actividades_count > 0)
                    <a href="{{ route('export.alumno.actividades', $alumno->id) }}" class="btn btn-danger">
                        <i class="bi bi-printer"></i> Imprimir Actividades
                    </a>
                    @endif
                    <a href="{{ route('inscripciones.create') }}" class="btn btn-success">
                        <i class="bi bi-plus-circle"></i> Inscribir en Actividad
                    </a>
                    <a href="{{ route('alumnos.edit', $alumno->id) }}" class="btn btn-warning">
                        <i class="bi bi-pencil"></i> Editar Alumno
                    </a>
                    <a href="{{ route('alumnos.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Volver a Alumnos
                    </a>
                </div>
            </div>
        </div>

        <!-- Información adicional -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Información Adicional</h5>
            </div>
            <div class="card-body">
                <p class="small text-muted">
                    <i class="bi bi-info-circle"></i>
                    El alumno fue registrado el:<br>
                    <strong>{{ $alumno->created_at->format('d/m/Y H:i') }}</strong>
                </p>
                @if($alumno->updated_at != $alumno->created_at)
                <p class="small text-muted">
                    <i class="bi bi-clock-history"></i>
                    Última actualización:<br>
                    <strong>{{ $alumno->updated_at->format('d/m/Y H:i') }}</strong>
                </p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
