@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        🎯 {{ $actividad->nombre }}
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('actividades.edit', $actividad->id) }}" class="btn btn-warning me-2">
            ✏️ Editar
        </a>
        <form action="{{ route('actividades.destroy', $actividad->id) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger"
                onclick="return confirm('¿Estás seguro de eliminar la actividad \"{{ $actividad->nombre }}\"?')">
                <i class="bi bi-trash"></i> Eliminar
            </button>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <!-- Información principal de la actividad -->
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">📋 Información de la Actividad</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-muted">Descripción</h6>
                        <p class="lead">{{ $actividad->descripcion }}</p>

                        <h6 class="text-muted mt-3">Día de la Semana</h6>
                        <p>
                            <span class="badge bg-info fs-6">{{ $actividad->dia_semana }}</span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">Horario</h6>
                        <p>
                            <span class="fs-5">
                                {{ $actividad->hora_inicio->format('H:i') }} - {{ $actividad->hora_finalizacion->format('H:i') }}
                            </span>
                        </p>

                        <h6 class="text-muted mt-3">Duración</h6>
                        <p>
                            @php
                                $inicio = \Carbon\Carbon::parse($actividad->hora_inicio);
                                $fin = \Carbon\Carbon::parse($actividad->hora_finalizacion);
                                $duracion = $inicio->diff($fin)->format('%H:%I');
                            @endphp
                            <span class="badge bg-success fs-6">{{ $duracion }} horas</span>
                        </p>

                        <h6 class="text-muted mt-3">Alumnos Inscritos</h6>
                        <p>
                            <span class="badge bg-primary fs-6">{{ $actividad->alumnos_count }} alumnos</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Vista previa de alumnos inscritos -->
        @if($actividad->alumnos_count > 0)
        <div class="card mt-4">
            <div class="card-header d-flex justify-content-between align-items-center bg-success text-white">
                <h5 class="card-title mb-0">👥 Alumnos Inscritos (Vista Previa)</h5>
                <div>
                    <a href="{{ route('actividades.alumnos', $actividad->id) }}" class="btn btn-light btn-sm me-2">
                        👀 Ver Lista Completa
                    </a>
                    <a href="{{ route('export.actividad.alumnos', $actividad->id) }}" class="btn btn-warning btn-sm">
                        📄 Exportar PDF
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Curso</th>
                                <th>Edad</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($actividad->alumnos->take(5) as $alumno)
                            <tr>
                                <td>{{ $alumno->nombre_completo }}</td>
                                <td><span class="badge bg-info">{{ $alumno->curso_academico }}</span></td>
                                <td><span class="badge bg-secondary">{{ $alumno->edad }} años</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($actividad->alumnos_count > 5)
                <div class="text-center mt-2">
                    <small class="text-muted">
                        Mostrando 5 de {{ $actividad->alumnos_count }} alumnos.
                        <a href="{{ route('actividades.alumnos', $actividad->id) }}">Ver todos</a>
                    </small>
                </div>
                @endif
            </div>
        </div>
        @else
        <div class="card mt-4">
            <div class="card-body text-center py-5">
                <div class="mb-3">
                    <i class="bi bi-people display-1 text-muted"></i>
                </div>
                <h4 class="text-muted">No hay alumnos inscritos</h4>
                <p class="text-muted">Esta actividad no tiene alumnos inscritos actualmente.</p>
                <a href="{{ route('inscripciones.create') }}" class="btn btn-primary btn-lg">
                    ➕ Inscribir Primer Alumno
                </a>
            </div>
        </div>
        @endif
    </div>

    <!-- Sidebar de acciones y estadísticas -->
    <div class="col-md-4">
        <!-- Panel de acciones rápidas -->
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="card-title mb-0">⚡ Acciones Rápidas</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('actividades.edit', $actividad->id) }}" class="btn btn-warning">
                        ✏️ Editar Actividad
                    </a>
                    <a href="{{ route('inscripciones.create') }}" class="btn btn-success">
                        ➕ Inscribir Alumnos
                    </a>

                    @if($actividad->alumnos_count > 0)
                    <a href="{{ route('actividades.alumnos', $actividad->id) }}" class="btn btn-primary">
                        👥 Ver Todos los Alumnos
                    </a>
                    <a href="{{ route('export.actividad.alumnos', $actividad->id) }}" class="btn btn-danger">
                        📄 Exportar Lista PDF
                    </a>
                    @endif

                    <a href="{{ route('actividades.index') }}" class="btn btn-secondary">
                        📋 Volver al Listado
                    </a>
                </div>
            </div>
        </div>

        <!-- Panel de estadísticas -->
        <div class="card mt-3">
            <div class="card-header bg-success text-white">
                <h5 class="card-title mb-0">📊 Estadísticas</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Total de Alumnos:</strong>
                    <span class="badge bg-primary float-end fs-6">{{ $actividad->alumnos_count }}</span>
                </div>

                @if($actividad->alumnos_count > 0)
                    @php
                        $cursosCount = $actividad->alumnos->groupBy('curso_academico')->map->count();
                        $edadPromedio = $actividad->alumnos->avg('edad');
                        $edadMinima = $actividad->alumnos->min('edad');
                        $edadMaxima = $actividad->alumnos->max('edad');
                    @endphp

                    <div class="mb-3">
                        <strong>Edad Promedio:</strong>
                        <span class="badge bg-success float-end fs-6">{{ number_format($edadPromedio, 1) }} años</span>
                    </div>

                    <div class="mb-3">
                        <strong>Rango de Edades:</strong>
                        <span class="badge bg-info float-end fs-6">{{ $edadMinima }} - {{ $edadMaxima }} años</span>
                    </div>

                    <hr>
                    <strong>Distribución por Cursos:</strong>
                    @foreach($cursosCount->take(3) as $curso => $count)
                    <div class="mb-2">
                        <small>{{ $curso }}:</small>
                        <span class="badge bg-secondary float-end">{{ $count }}</span>
                    </div>
                    @endforeach

                    @if($cursosCount->count() > 3)
                    <div class="text-center">
                        <small class="text-muted">
                            y {{ $cursosCount->count() - 3 }} curso(s) más
                        </small>
                    </div>
                    @endif
                @else
                    <p class="text-muted text-center mb-0">No hay datos estadísticos disponibles</p>
                @endif
            </div>
        </div>

        <!-- Información de la actividad -->
        <div class="card mt-3">
            <div class="card-header bg-secondary text-white">
                <h5 class="card-title mb-0">ℹ️ Información</h5>
            </div>
            <div class="card-body">
                <div class="mb-2">
                    <small><strong>Creado:</strong> {{ $actividad->created_at->format('d/m/Y H:i') }}</small>
                </div>
                <div class="mb-2">
                    <small><strong>Actualizado:</strong> {{ $actividad->updated_at->format('d/m/Y H:i') }}</small>
                </div>
                <hr>
                <p class="small text-muted mb-0">
                    <i class="bi bi-info-circle"></i>
                    Esta actividad se realiza todos los <strong>{{ $actividad->dia_semana }}</strong> en el horario indicado.
                </p>
            </div>
        </div>

        <!-- Panel de exportación -->
        @if($actividad->alumnos_count > 0)
        <div class="card mt-3">
            <div class="card-header bg-danger text-white">
                <h5 class="card-title mb-0">📄 Exportación</h5>
            </div>
            <div class="card-body">
                <p class="small">
                    Exporta la lista completa de alumnos inscritos en formato PDF.
                </p>
                <div class="d-grid">
                    <a href="{{ route('export.actividad.alumnos', $actividad->id) }}" class="btn btn-outline-danger btn-sm">
                        📋 Generar Reporte PDF
                    </a>
                </div>
                <hr>
                <p class="small text-muted mb-0">
                    El PDF incluirá toda la información de los alumnos y estadísticas de la actividad.
                </p>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
    .btn {
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }

    .btn:active {
        transform: translateY(0);
        box-shadow: 0 1px 2px rgba(0,0,0,0.1);
    }

    .btn-group .btn {
        min-width: 80px;
        margin: 0 3px;
        border-radius: 6px;
    }

    /* Botón VER - Azul profesional */
    .btn-info {
        background: linear-gradient(145deg, #17a2b8, #138496);
        color: white;
    }

    .btn-info:hover {
        background: linear-gradient(145deg, #138496, #117a8b);
    }

    /* Botón EDITAR - Amarillo/naranja */
    .btn-warning {
        background: linear-gradient(145deg, #ffc107, #e0a800);
        color: #212529;
    }

    .btn-warning:hover {
        background: linear-gradient(145deg, #e0a800, #d39e00);
    }

    /* Botón IMPRIMIR - Rojo */
    .btn-danger {
        background: linear-gradient(145deg, #dc3545, #c82333);
        color: white;
    }

    .btn-danger:hover {
        background: linear-gradient(145deg, #c82333, #bd2130);
    }

    /* Botón ELIMINAR - Gris oscuro */
    .btn-dark {
        background: linear-gradient(145deg, #343a40, #23272b);
        color: white;
    }

    .btn-dark:hover {
        background: linear-gradient(145deg, #23272b, #1a1e21);
    }

    /* Botón deshabilitado */
    .btn:disabled {
        opacity: 0.6;
        transform: none !important;
        box-shadow: none !important;
    }

    /* Efecto de carga en botones */
    .btn-loading {
        position: relative;
        color: transparent;
    }

    .btn-loading::after {
        content: '';
        position: absolute;
        width: 16px;
        height: 16px;
        top: 50%;
        left: 50%;
        margin-left: -8px;
        margin-top: -8px;
        border: 2px solid #ffffff;
        border-radius: 50%;
        border-right-color: transparent;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }
</style>
@endpush
