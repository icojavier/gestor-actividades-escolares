@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Gestión de Actividades</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('export.actividades.all') }}" class="btn btn-danger me-2">
            <i class="bi bi-file-pdf"></i> Exportar PDF
        </a>
        <a href="{{ route('actividades.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Nueva Actividad
        </a>
    </div>
</div>

<!-- Barra de búsqueda -->
<div class="row mb-4">
    <div class="col-md-6">
        <form action="{{ route('actividades.index') }}" method="GET">
            <div class="input-group">
                <input type="text" name="search" class="form-control"
                       placeholder="Buscar actividades por nombre, descripción o día..."
                       value="{{ request('search') }}">
                <button class="btn btn-outline-secondary" type="submit">
                    🔍 Buscar
                </button>
                @if(request('search'))
                    <a href="{{ route('actividades.index') }}" class="btn btn-outline-danger">
                        ✕ Limpiar
                    </a>
                @endif
            </div>
        </form>
    </div>
</div>

@if($actividades->count() > 0)
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th class="text-center">Nombre</th>
                    <th class="text-center">Descripción</th>
                    <th class="text-center">Día</th>
                    <th class="text-center">Horario</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($actividades as $actividad)
                <tr>
                    <td class="text-center">{{ $actividad->nombre }}</td>
                    <td>{{ $actividad->descripcion }}</td>
                    <td class="text-center">
                        <span class="badge bg-info">{{ $actividad->dia_semana }}</span>
                    </td>
                    <td class="text-center">
                        @if($actividad->hora_inicio && $actividad->hora_fin)
                            {{ \Carbon\Carbon::parse($actividad->hora_inicio)->format('H:i') }} - {{ \Carbon\Carbon::parse($actividad->hora_fin)->format('H:i') }}
                        @else
                            <span class="text-muted">Horario no definido</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <div class="btn-group" role="group">
                            <a href="{{ route('actividades.show', $actividad->id) }}"
                            class="btn btn-info me-2 btn-sm text-white"
                            title="Ver detalles">
                                <i class="bi bi-eye"></i> Ver
                            </a>
                            <a href="{{ route('actividades.edit', $actividad->id) }}"
                            class="btn btn-warning me-2 btn-sm text-white"
                            title="Editar actividad">
                                <i class="bi bi-pencil"></i> Editar
                            </a>
                            <form action="{{ route('actividades.destroy', $actividad->id) }}"
                                method="POST"
                                class="d-inline"
                                onsubmit="return confirm('¿Estás seguro de eliminar esta actividad?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm text-white" title="Eliminar actividad">
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
            <strong>Resultados de búsqueda:</strong> Se encontraron {{ $actividades->count() }} actividad(es) para "{{ request('search') }}"
        </div>
    @endif

@else
    <div class="alert alert-info">
        @if(request('search'))
            <strong>No se encontraron resultados:</strong> No hay actividades que coincidan con "{{ request('search') }}"
            <br>
            <a href="{{ route('actividades.index') }}" class="alert-link">Ver todas las actividades</a>
        @else
            <strong>No hay actividades registradas.</strong>
            <a href="{{ route('actividades.create') }}" class="alert-link">Crear la primera actividad</a>.
        @endif
    </div>
@endif

<!-- Estadísticas rápidas -->
@if($actividades->count() > 0 && !request('search'))
<div class="card mt-4">
    <div class="card-header">
        <h5 class="card-title mb-0">📊 Resumen de Actividades</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <div class="text-center">
                    <h4 class="text-primary">{{ $actividades->count() }}</h4>
                    <small class="text-muted">Total Actividades</small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center">
                    <h4 class="text-success">{{ $actividades->sum('alumnos_count') }}</h4>
                    <small class="text-muted">Total Inscripciones</small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center">
                    @php
                        $actividadMasPopular = $actividades->sortByDesc('alumnos_count')->first();
                    @endphp
                    <h4 class="text-info">{{ $actividadMasPopular->alumnos_count }}</h4>
                    <small class="text-muted">Más popular: {{ Str::limit($actividadMasPopular->nombre, 15) }}</small>
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
