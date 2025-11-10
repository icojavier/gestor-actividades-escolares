@extends('layouts.app')

@section('content')
<!-- Header Centrado -->
<div class="d-flex justify-content-center align-items-center pt-4 pb-5 mb-5">
    <h1 class="h1 text-center mb-0 text-dark" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.1);">
        <i class="bi bi-speedometer2 me-3"></i>
        Gestor de Actividades Escolares
    </h1>
</div>

<!-- Tarjetas Principales -->
<div class="row mb-5">
    <!-- Tarjeta Actividades - Morado Oscuro -->
    <div class="col-md-4 mb-4">
        <div class="card dashboard-card card-actividades">
            <div class="card-body text-center py-5">
                <div class="mb-4">
                    <i class="bi bi-calendar-event display-1" style="color: #5e35b1;"></i>
                </div>
                <h3 class="card-title fw-bold mb-3" style="color: #5e35b1;">Actividades</h3>
                <p class="card-text text-muted mb-4 fs-5">
                    Gestiona las actividades extraescolares disponibles
                </p>
                <a href="{{ route('actividades.index') }}" class="btn btn-actividades btn-lg px-4 py-2">
                    <i class="bi bi-eye me-2"></i>Ver Actividades
                </a>
            </div>
        </div>
    </div>

    <!-- Tarjeta Alumnos - Verde Oscuro -->
    <div class="col-md-4 mb-4">
        <div class="card dashboard-card card-alumnos">
            <div class="card-body text-center py-5">
                <div class="mb-4">
                    <i class="bi bi-people display-1" style="color: #2e7d32;"></i>
                </div>
                <h3 class="card-title fw-bold mb-3" style="color: #2e7d32;">Alumnos</h3>
                <p class="card-text text-muted mb-4 fs-5">
                    Administra el listado de alumnos registrados
                </p>
                <a href="{{ route('alumnos.index') }}" class="btn btn-alumnos btn-lg px-4 py-2">
                    <i class="bi bi-eye me-2"></i>Ver Alumnos
                </a>
            </div>
        </div>
    </div>

    <!-- Tarjeta Inscripciones - Gris Oscuro -->
    <div class="col-md-4 mb-4">
        <div class="card dashboard-card card-inscripciones">
            <div class="card-body text-center py-5">
                <div class="mb-4">
                    <i class="bi bi-clipboard-check display-1" style="color: #455a64;"></i>
                </div>
                <h3 class="card-title fw-bold mb-3" style="color: #455a64;">Inscripciones</h3>
                <p class="card-text text-muted mb-4 fs-5">
                    Gestiona las inscripciones de alumnos a actividades
                </p>
                <a href="{{ route('inscripciones.create') }}" class="btn btn-inscripciones btn-lg px-4 py-2">
                    <i class="bi bi-eye me-2"></i>Ver Inscripciones
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Estadísticas Rápidas -->
<div class="row mb-5">
    <div class="col-12">
        <div class="card stat-card">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="card-title mb-0 text-dark fw-bold fs-4">
                    <i class="bi bi-graph-up me-2"></i>
                    Resumen General del Sistema
                </h5>
            </div>
            <div class="card-body py-4">
                <div class="row text-center">
                    <div class="col-md-4">
                        <div class="border-end border-light">
                            <h2 class="fw-bold display-4" style="color: #5e35b1;">{{ $totalActividades }}</h2>
                            <p class="text-muted mb-0 fs-5">Total Actividades</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="border-end border-light">
                            <h2 class="fw-bold display-4" style="color: #2e7d32;">{{ $totalAlumnos }}</h2>
                            <p class="text-muted mb-0 fs-5">Total Alumnos</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <h2 class="fw-bold display-4" style="color: #455a64;">{{ $totalInscripciones }}</h2>
                        <p class="text-muted mb-0 fs-5">Total Inscripciones</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Actividades y Alumnos Recientes -->
<div class="row mt-5">
    <div class="col-md-6 mb-4">
        <div class="card dashboard-card">
            <div class="card-header text-white py-3" style="background: linear-gradient(145deg, #5e35b1, #4527a0);">
                <h5 class="card-title mb-0 fw-bold">
                    <i class="bi bi-calendar-check me-2"></i>
                    Actividades Recientes
                </h5>
            </div>
            <div class="card-body">
                @if($actividadesRecientes->count() > 0)
                    @foreach($actividadesRecientes as $actividad)
                        <div class="d-flex justify-content-between align-items-center border-bottom py-3">
                            <div>
                                <strong class="fs-5" style="color: #5e35b1;">{{ $actividad->nombre }}</strong>
                                <br>
                                <small class="text-muted">
                                    <i class="bi bi-calendar me-1"></i>{{ $actividad->dia_semana }}
                                    <i class="bi bi-clock ms-2 me-1"></i>{{ $actividad->hora_inicio->format('H:i') }}
                                </small>
                            </div>
                            <span class="badge px-3 py-2 fw-bold" style="background: linear-gradient(145deg, #5e35b1, #4527a0);">
                                {{ $actividad->alumnos_count ?? 0 }} alumnos
                            </span>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted text-center mb-0 py-4 fs-5">No hay actividades registradas</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card dashboard-card">
            <div class="card-header text-white py-3" style="background: linear-gradient(145deg, #2e7d32, #1b5e20);">
                <h5 class="card-title mb-0 fw-bold">
                    <i class="bi bi-person-plus me-2"></i>
                    Alumnos Recientes
                </h5>
            </div>
            <div class="card-body">
                @if($alumnosRecientes->count() > 0)
                    @foreach($alumnosRecientes as $alumno)
                        <div class="d-flex justify-content-between align-items-center border-bottom py-3">
                            <div>
                                <strong class="fs-5" style="color: #2e7d32;">{{ $alumno->nombre_completo }}</strong>
                                <br>
                                <small class="text-muted">
                                    <i class="bi bi-book me-1"></i>{{ $alumno->curso_academico }}
                                    <i class="bi bi-person me-1 ms-2"></i>{{ $alumno->edad }} años
                                </small>
                            </div>
                            <span class="badge px-3 py-2 fw-bold" style="background: linear-gradient(145deg, #2e7d32, #1b5e20);">
                                {{ $alumno->actividades_count ?? 0 }} actividades
                            </span>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted text-center mb-0 py-4 fs-5">No hay alumnos registrados</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Acciones Rápidas -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card dashboard-card">
            <div class="card-header text-white py-3" style="background: linear-gradient(145deg, #0d1b3e, #152a5e);">
                <h5 class="card-title mb-0 fw-bold">
                    <i class="bi bi-lightning me-2"></i>
                    Acciones Rápidas
                </h5>
            </div>
            <div class="card-body py-4">
                <div class="row">
                    <div class="col-md-4 text-center mb-3">
                        <a href="{{ route('actividades.create') }}" class="btn btn-actividades btn-lg w-100 py-3 fs-5">
                            <i class="bi bi-plus-circle me-2"></i>Nueva Actividad
                        </a>
                    </div>
                    <div class="col-md-4 text-center mb-3">
                        <a href="{{ route('alumnos.create') }}" class="btn btn-alumnos btn-lg w-100 py-3 fs-5">
                            <i class="bi bi-person-plus me-2"></i>Nuevo Alumno
                        </a>
                    </div>
                    <div class="col-md-4 text-center mb-3">
                        <a href="{{ route('inscripciones.create') }}" class="btn btn-inscripciones btn-lg w-100 py-3 fs-5">
                            <i class="bi bi-clipboard-plus me-2"></i>Nueva Inscripción
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
