@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h2">
    <i class="bi bi-card-checklist"></i>
    Listado de Inscripciones</h1>
    <div>
        <!-- Botón Añadir Inscripción (VERDE) a la derecha -->
        <a href="{{ route('inscripciones.create') }}" class="btn btn-success me-2">
            <i class="bi bi-plus-circle"></i> Añadir Inscripción
        </a>
        <!-- Botón Exportar PDF (ROJO) a la derecha -->
        <a href="{{ route('export.inscripciones') }}" class="btn btn-danger">
            <i class="bi bi-file-pdf"></i> Exportar PDF
        </a>
    </div>
</div>

<!-- Barra de búsqueda -->
<div class="row mb-4">
    <div class="col-md-6">
        <form action="{{ route('inscripciones.index') }}" method="GET">
            <div class="input-group">
                <input type="text" name="search" class="form-control"
                       placeholder="Buscar por alumno o actividad..."
                       value="{{ request('search') }}">
                <button class="btn btn-outline-secondary" type="submit">
                    <i class="bi bi-search"></i> Buscar
                </button>
                @if(request('search'))
                    <a href="{{ route('inscripciones.index') }}" class="btn btn-outline-danger">
                        <i class="bi bi-x-circle"></i> Limpiar
                    </a>
                @endif
            </div>
        </form>
    </div>
</div>

@if($inscripciones->count() > 0)
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th class="text-center">Alumno</th>
                    <th class="text-center">Actividad</th>
                    <th class="text-center">Fecha de Inscripción</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($inscripciones as $inscripcion)
                    <tr>
                        <td class="text-center">
                            <!-- Mostrar nombre completo del alumno -->
                            {{ $inscripcion->alumno->nombre_completo ?? 'N/A' }}
                        </td>
                        <td class="text-center">
                            {{ $inscripcion->actividad->nombre ?? 'N/A' }}
                        </td>
                        <td class="text-center">
                            {{ $inscripcion->created_at->format('d/m/Y') }}
                        </td>
                        <td class="text-center">
                            <div class="btn-group" role="group">
                                <a href="{{ route('inscripciones.show', $inscripcion->id) }}"
                                class="btn btn-info btn-sm me-2 text-white"
                                title="Ver detalles">
                                    <i class="bi bi-eye me-2"></i> Ver
                                </a>
                                <form action="{{ route('inscripciones.destroy', $inscripcion->id) }}"
                                    method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('¿Estás seguro de eliminar esta inscripción?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
                                        <i class="bi bi-trash"></i> Eliminar
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">
                            <i class="fas fa-inbox fa-2x mb-2"></i><br>
                            No hay inscripciones registradas
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if(request('search'))
        <div class="alert alert-info">
            <strong>Resultados de búsqueda:</strong> Se encontraron {{ $inscripciones->count() }} inscripción(es) para "{{ request('search') }}"
        </div>
    @endif

@else
    <div class="alert alert-info">
        @if(request('search'))
            <strong>No se encontraron resultados:</strong> No hay inscripciones que coincidan con "{{ request('search') }}"
            <br>
            <a href="{{ route('inscripciones.index') }}" class="alert-link">Ver todas las inscripciones</a>
        @else
            <strong>No hay inscripciones registradas.</strong>
            <a href="{{ route('inscripciones.create') }}" class="alert-link">Crear la primera inscripción</a>.
        @endif
    </div>
@endif

<!-- Estadísticas rápidas (sin estado) -->
@if($inscripciones->count() > 0 && !request('search'))
<div class="card mt-4">
    <div class="card-header">
        <h5 class="card-title mb-0">📊 Resumen de Inscripciones</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="text-center">
                    <h4 class="text-primary">{{ $inscripciones->count() }}</h4>
                    <small class="text-muted">Total Inscripciones</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@push('styles')
<style>
    .table th {
        background-color: #2c3e50;
        color: white;
    }
    .btn-group .btn {
        margin-right: 2px;
    }
</style>
@endpush
