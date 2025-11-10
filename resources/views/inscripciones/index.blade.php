@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Gestión de Inscripciones</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('inscripciones.create') }}" class="btn btn-primary">
            ➕ Nueva Inscripción
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
                    🔍 Buscar
                </button>
                @if(request('search'))
                    <a href="{{ route('inscripciones.index') }}" class="btn btn-outline-danger">
                        ✕ Limpiar
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
                    <th>Alumno</th>
                    <th>Actividad</th>
                    <th>Fecha de Inscripción</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($inscripciones as $inscripcion)
                <tr>
                    <td>
                        <strong>{{ $inscripcion->alumno->nombre }} {{ $inscripcion->alumno->apellido }}</strong>
                        <br>
                        <small class="text-muted">{{ $inscripcion->alumno->curso }}</small>
                    </td>
                    <td>
                        <strong>{{ $inscripcion->actividad->nombre }}</strong>
                        <br>
                        <small class="text-muted">{{ $inscripcion->actividad->dia_semana }}</small>
                    </td>
                    <td>
                        {{ \Carbon\Carbon::parse($inscripcion->fecha_inscripcion)->format('d/m/Y') }}
                    </td>
                    <td>
                        @if($inscripcion->estado == 'Aceptada')
                            <span class="badge bg-success">{{ $inscripcion->estado }}</span>
                        @elseif($inscripcion->estado == 'Pendiente')
                            <span class="badge bg-warning text-dark">{{ $inscripcion->estado }}</span>
                        @elseif($inscripcion->estado == 'Cancelada')
                            <span class="badge bg-danger">{{ $inscripcion->estado }}</span>
                        @else
                            <span class="badge bg-secondary">{{ $inscripcion->estado }}</span>
                        @endif
                    </td>
                    <td>
                        <div class="btn-group" role="group">
                            <a href="{{ route('inscripciones.show', $inscripcion->id) }}" class="btn btn-info btn-sm text-white" title="Ver detalles">
                                <i class="bi bi-eye me-2"></i> Ver
                            </a>
                            <form action="{{ route('inscripciones.destroy', $inscripcion->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm text-white"
                                    onclick="return confirm('¿Estás seguro de eliminar esta inscripción?')"
                                    title="Eliminar inscripción">
                                    <i class="bi bi-trash"></i> Eliminar
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
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

<!-- Estadísticas rápidas -->
@if($inscripciones->count() > 0 && !request('search'))
<div class="card mt-4">
    <div class="card-header">
        <h5 class="card-title mb-0">📊 Resumen de Inscripciones</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                <div class="text-center">
                    <h4 class="text-primary">{{ $inscripciones->count() }}</h4>
                    <small class="text-muted">Total Inscripciones</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="text-center">
                    <h4 class="text-success">{{ $inscripciones->where('estado', 'Aceptada')->count() }}</h4>
                    <small class="text-muted">Aceptadas</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="text-center">
                    <h4 class="text-warning">{{ $inscripciones->where('estado', 'Pendiente')->count() }}</h4>
                    <small class="text-muted">Pendientes</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="text-center">
                    <h4 class="text-danger">{{ $inscripciones->where('estado', 'Cancelada')->count() }}</h4>
                    <small class="text-muted">Canceladas</small>
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
    .badge {
        font-size: 0.75em;
        transition: all 0.3s ease;
    }
    .badge:hover {
        transform: scale(1.05);
    }
    .btn-group .btn {
        margin-right: 2px;
    }
</style>
@endpush
