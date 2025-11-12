@extends('layouts.app')

@section('content')
<div class="container py-3">

    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
        <h1 class="h3 mb-0">
            <text-primary me-2"></i> Detalles de la Inscripción
        </h1>
        <div>
            <a href="{{ route('inscripciones.index') }}" class="btn btn-outline-secondary me-2">
                <i class="bi bi-arrow-left"></i> Volver a la lista
            </a>
            <form action="{{ route('inscripciones.destroy', $inscripcion->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger"
                    onclick="return confirm('¿Estás seguro de eliminar esta inscripción?')">
                    <i class="bi bi-trash"></i> Eliminar
                </button>
            </form>
        </div>
    </div>

    {{-- Información de la Inscripción --}}
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-header bg-primary bg-gradient text-white fw-semibold">
            <i class="bi bi-card-list me-1"></i> Información de la Inscripción
        </div>
        <div class="card-body bg-light">
            <div class="row g-3">
                <div class="col-md-4">
                    <p class="mb-1 fw-bold text-muted">ID:</p>
                    <p class="mb-0">{{ $inscripcion->id }}</p>
                </div>
                <div class="col-md-4">
                    <p class="mb-1 fw-bold text-muted">Fecha de Inscripción:</p>
                    <p class="mb-0">{{ \Carbon\Carbon::parse($inscripcion->fecha_inscripcion)->format('d/m/Y') }}</p>
                </div>                
            </div>
        </div>
    </div>

    {{-- Información del Alumno --}}
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-header bg-success bg-gradient text-white fw-semibold">
            <i class="bi bi-person-fill me-1"></i> Información del Alumno
        </div>
        <div class="card-body bg-light">
            <div class="row g-3">
                <div class="col-md-4">
                    <p class="mb-1 fw-bold text-muted">Nombre:</p>
                    <p class="mb-0">{{ $inscripcion->alumno->nombre_completo }}</p>
                </div>
                <div class="col-md-4">
                    <p class="mb-1 fw-bold text-muted">Curso Académico:</p>
                    <p class="mb-0">{{ $inscripcion->alumno->curso_academico ?? 'No especificado' }}</p>
                </div>
                <div class="col-md-4">
                    <p class="mb-1 fw-bold text-muted">Edad:</p>
                    <p class="mb-0">{{ $inscripcion->alumno->edad ? $inscripcion->alumno->edad . ' años' : 'No disponible' }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Información de la Actividad --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-info bg-gradient text-white fw-semibold">
            <i class="bi bi-calendar-event me-1"></i> Información de la Actividad
        </div>
        <div class="card-body bg-light">
            <div class="row g-3">
                <div class="col-md-3">
                    <p class="mb-1 fw-bold text-muted">Nombre:</p>
                    <p class="mb-0">{{ $inscripcion->actividad->nombre }}</p>
                </div>
                <div class="col-md-5">
                    <p class="mb-1 fw-bold text-muted">Descripción:</p>
                    <p class="mb-0 text-muted">{{ $inscripcion->actividad->descripcion ?? 'Sin descripción' }}</p>
                </div>
                <div class="col-md-2">
                    <p class="mb-1 fw-bold text-muted">Día de la Semana:</p>
                    <span class="badge bg-info text-dark">{{ $inscripcion->actividad->dia_semana }}</span>
                </div>
                <div class="col-md-2">
                    <p class="mb-1 fw-bold text-muted">Horario:</p>
                    <p class="mb-0">
                        {{ $inscripcion->actividad->hora_inicio->format('H:i') }} - 
                        {{ $inscripcion->actividad->hora_finalizacion->format('H:i') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('styles')
<style>
    .card {
        border-radius: 12px;
    }
    .card-header {
        border-top-left-radius: 12px !important;
        border-top-right-radius: 12px !important;
    }
    .card-body {
        border-bottom-left-radius: 12px !important;
        border-bottom-right-radius: 12px !important;
    }
    .fw-bold.text-muted {
        font-size: 0.9rem;
    }
    .badge {
        font-size: 0.85rem;
        padding: 0.4em 0.6em;
    }
</style>
@endpush
