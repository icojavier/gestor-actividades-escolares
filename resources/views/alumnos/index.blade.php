@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Gestión de Alumnos</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('export.alumnos.all') }}" class="btn btn-danger me-2">
            📄 Exportar PDF
        </a>
        <a href="{{ route('alumnos.create') }}" class="btn btn-primary">
            ➕ Nuevo Alumno
        </a>
    </div>
</div>

@if($alumnos->count() > 0)
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Nombre Completo</th>
                    <th>Curso Académico</th>
                    <th>Edad</th>
                    <th>Actividades Inscritas</th>
                    <th width="220">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($alumnos as $alumno)
                <tr>
                    <td>
                        <strong>{{ $alumno->nombre_completo }}</strong>
                    </td>
                    <td>
                        <span class="badge bg-info">{{ $alumno->curso_academico }}</span>
                    </td>
                    <td>
                        <span class="badge bg-secondary">{{ $alumno->edad }} años</span>
                    </td>
                    <td>
                        @if($alumno->actividades_count > 0)
                            <div class="actividades-list">
                                @foreach($alumno->actividades->take(3) as $actividad)
                                    <span class="badge bg-success mb-1 d-inline-block" 
                                          style="font-size: 0.7em; cursor: help;"
                                          title="{{ $actividad->nombre }} - {{ $actividad->dia_semana }}">
                                        {{ Str::limit($actividad->nombre, 15) }}
                                    </span>
                                    @if(!$loop->last) @endif
                                @endforeach
                                
                                @if($alumno->actividades_count > 3)
                                    <br>
                                    <small class="text-muted">
                                        + {{ $alumno->actividades_count - 3 }} más...
                                    </small>
                                @endif
                            </div>
                        @else
                            <span class="text-muted fst-italic">Sin actividades</span>
                        @endif
                    </td>
                    <td>
                        <div class="btn-group btn-group-sm" role="group">
                            <!-- Botón Ver -->
                            <a href="{{ route('alumnos.show', $alumno->id) }}" class="btn btn-info" title="Ver detalles del alumno">
                                👁️
                            </a>
                            
                            <!-- Botón Editar -->
                            <a href="{{ route('alumnos.edit', $alumno->id) }}" class="btn btn-warning" title="Editar alumno">
                                ✏️
                            </a>
                            
                            <!-- Botón PDF (solo si tiene actividades) -->
                            @if($alumno->actividades_count > 0)
                                <a href="{{ route('export.alumno.actividades', $alumno->id) }}" class="btn btn-success" title="Exportar PDF de actividades">
                                    📄
                                </a>
                            @else
                                <button class="btn btn-outline-secondary" disabled title="No hay actividades para exportar">
                                    📄
                                </button>
                            @endif
                            
                            <!-- Botón Eliminar -->
                            @if($alumno->actividades_count > 0)
                                <button class="btn btn-outline-danger" disabled title="No se puede eliminar - Tiene actividades inscritas">
                                    🗑️
                                </button>
                            @else
                                <form action="{{ route('alumnos.destroy', $alumno->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" 
                                        onclick="return confirm('¿Estás seguro de eliminar al alumno \"{{ $alumno->nombre_completo }}\"?')"
                                        title="Eliminar alumno">
                                        🗑️
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Estadísticas rápidas -->
    <div class="row mt-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary">
                <div class="card-body text-center">
                    <h4 class="card-title">{{ $alumnos->count() }}</h4>
                    <p class="card-text mb-0">Total Alumnos</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success">
                <div class="card-body text-center">
                    <h4 class="card-title">{{ $alumnos->sum('actividades_count') }}</h4>
                    <p class="card-text mb-0">Total Inscripciones</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info">
                <div class="card-body text-center">
                    @php
                        $alumnoMasActivo = $alumnos->sortByDesc('actividades_count')->first();
                    @endphp
                    <h4 class="card-title">{{ $alumnoMasActivo->actividades_count }}</h4>
                    <p class="card-text mb-0" title="{{ $alumnoMasActivo->nombre_completo }}">
                        Más Activo
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning">
                <div class="card-body text-center">
                    @php
                        $alumnosSinActividades = $alumnos->where('actividades_count', 0)->count();
                    @endphp
                    <h4 class="card-title">{{ $alumnosSinActividades }}</h4>
                    <p class="card-text mb-0">Sin Actividades</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Distribución de actividades -->
    <div class="card mt-4">
        <div class="card-header">
            <h5 class="card-title mb-0">📊 Distribución de Actividades por Alumno</h5>
        </div>
        <div class="card-body">
            <div class="row">
                @php
                    $distribucion = [
                        '0 actividades' => $alumnos->where('actividades_count', 0)->count(),
                        '1 actividad' => $alumnos->where('actividades_count', 1)->count(),
                        '2 actividades' => $alumnos->where('actividades_count', 2)->count(),
                        '3+ actividades' => $alumnos->where('actividades_count', '>=', 3)->count(),
                    ];
                @endphp
                
                @foreach($distribucion as $label => $count)
                <div class="col-md-3 mb-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">{{ $label }}</span>
                        <span class="badge bg-primary">{{ $count }} alumnos</span>
                    </div>
                    <div class="progress mt-1" style="height: 8px;">
                        <div class="progress-bar" role="progressbar" 
                             style="width: {{ ($count / $alumnos->count()) * 100 }}%"
                             aria-valuenow="{{ ($count / $alumnos->count()) * 100 }}" 
                             aria-valuemin="0" 
                             aria-valuemax="100">
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

@else
    <div class="alert alert-info">
        <strong>No hay alumnos registrados.</strong> 
        <a href="{{ route('alumnos.create') }}" class="alert-link">Registrar el primer alumno</a>.
    </div>
@endif
@endsection

@push('styles')
<style>
    .table th {
        background-color: #2c3e50;
        color: white;
    }
    .badge {
        font-size: 0.75em;
    }
    .btn-group {
        display: flex;
        flex-wrap: nowrap;
        gap: 2px;
    }
    .btn-group .btn {
        padding: 0.25rem 0.4rem;
        font-size: 0.8rem;
        border-radius: 0.25rem;
        flex: 1;
        min-width: 35px;
    }
    .actividades-list {
        max-width: 200px;
    }
    .progress {
        background-color: #e9ecef;
    }
    .progress-bar {
        background-color: #3498db;
    }
    .card {
        border: none;
        border-radius: 8px;
    }
    .card-title {
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
    }
    .table td {
        vertical-align: middle;
    }
    .btn-outline-secondary:disabled,
    .btn-outline-danger:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
</style>
@endpush