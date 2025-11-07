@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="bi bi-people-fill"></i>
        Alumnos Inscritos en: {{ $actividad->nombre }}
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('export.actividad.alumnos', $actividad->id) }}" class="btn btn-danger me-2">
            📄 Exportar PDF
        </a>
        <a href="{{ route('actividades.show', $actividad->id) }}" class="btn btn-secondary">
            ← Volver a la Actividad
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <!-- Información de la actividad -->
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Información de la Actividad</h5>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Descripción:</strong><br>{{ $actividad->descripcion }}</p>
                        <p><strong>Día:</strong> {{ $actividad->dia_semana }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Horario:</strong> {{ $actividad->hora_inicio->format('H:i') }} - {{ $actividad->hora_finalizacion->format('H:i') }}</p>
                        <p><strong>Total de Alumnos:</strong> <span class="badge bg-primary">{{ $actividad->alumnos->count() }}</span></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lista de alumnos -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="bi bi-list-ul"></i>
                    Lista de Alumnos Inscritos
                </h5>
                <span class="badge bg-primary fs-6">{{ $actividad->alumnos->count() }} alumnos</span>
            </div>
            <div class="card-body">
                @if($actividad->alumnos->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Nombre Completo</th>
                                    <th>Curso Académico</th>
                                    <th>Edad</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($actividad->alumnos as $index => $alumno)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
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
                                        <a href="{{ route('alumnos.show', $alumno->id) }}" class="btn btn-info btn-sm">
                                            👁️ Ver
                                        </a>
                                        @php
                                            $inscripcion = App\Models\Inscripcion::where('alumno_id', $alumno->id)
                                                ->where('actividad_id', $actividad->id)
                                                ->first();
                                        @endphp
                                        @if($inscripcion)
                                        <form action="{{ route('inscripciones.destroy', $inscripcion) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" 
                                                onclick="return confirm('¿Estás seguro de desinscribir a {{ $alumno->nombre_completo }} de esta actividad?')">
                                                🗑️ Desinscribir
                                            </button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <div class="mb-3">
                            <i class="bi bi-people display-1 text-muted"></i>
                        </div>
                        <h4 class="text-muted">No hay alumnos inscritos</h4>
                        <p class="text-muted">Esta actividad no tiene alumnos inscritos actualmente.</p>
                        <a href="{{ route('inscripciones.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Inscribir Alumnos
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Panel de acciones rápidas -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-lightning"></i>
                    Acciones Rápidas
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('export.actividad.alumnos', $actividad->id) }}" class="btn btn-danger">
                        <i class="bi bi-file-pdf"></i> Exportar Lista PDF
                    </a>
                    <a href="{{ route('inscripciones.create') }}" class="btn btn-success">
                        <i class="bi bi-plus-circle"></i> Inscribir Nuevo Alumno
                    </a>
                    <a href="{{ route('actividades.show', $actividad->id) }}" class="btn btn-info">
                        <i class="bi bi-info-circle"></i> Ver Detalles Actividad
                    </a>
                    <a href="{{ route('actividades.index') }}" class="btn btn-secondary">
                        <i class="bi bi-list-ul"></i> Todas las Actividades
                    </a>
                </div>
            </div>
        </div>

        <!-- Estadísticas -->
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-graph-up"></i>
                    Estadísticas
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Total de Alumnos:</strong>
                    <span class="badge bg-primary float-end fs-6">{{ $actividad->alumnos->count() }}</span>
                </div>
                
                @if($actividad->alumnos->count() > 0)
                    @php
                        $cursosCount = $actividad->alumnos->groupBy('curso_academico')->map->count();
                        $edadPromedio = $actividad->alumnos->avg('edad');
                    @endphp
                    
                    <div class="mb-3">
                        <strong>Edad Promedio:</strong>
                        <span class="badge bg-success float-end fs-6">{{ number_format($edadPromedio, 1) }} años</span>
                    </div>
                    
                    <hr>
                    <strong>Distribución por Cursos:</strong>
                    @foreach($cursosCount as $curso => $count)
                    <div class="mb-2">
                        <small>{{ $curso }}:</small>
                        <span class="badge bg-info float-end">{{ $count }}</span>
                    </div>
                    @endforeach
                @else
                    <p class="text-muted text-center mb-0">No hay datos estadísticos</p>
                @endif
            </div>
        </div>

        <!-- Información de exportación -->
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-download"></i>
                    Exportación
                </h5>
            </div>
            <div class="card-body">
                <p class="small text-muted">
                    <i class="bi bi-info-circle"></i>
                    El PDF exportado incluirá:
                </p>
                <ul class="small">
                    <li>Información completa de la actividad</li>
                    <li>Lista de todos los alumnos inscritos</li>
                    <li>Datos de curso y edad de cada alumno</li>
                    <li>Fecha y hora de generación del reporte</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .table th {
        background-color: #343a40;
        color: white;
    }
    .badge {
        font-size: 0.75em;
    }
</style>
@endpush