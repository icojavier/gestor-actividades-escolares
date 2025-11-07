@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard</h1>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card text-white bg-primary mb-3">
            <div class="card-body">
                <h5 class="card-title">Total Actividades</h5>
                <p class="card-text display-4">{{ $totalActividades }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-success mb-3">
            <div class="card-body">
                <h5 class="card-title">Total Alumnos</h5>
                <p class="card-text display-4">{{ $totalAlumnos }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-info mb-3">
            <div class="card-body">
                <h5 class="card-title">Total Inscripciones</h5>
                <p class="card-text display-4">{{ $totalInscripciones }}</p>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Actividades Recientes</h5>
            </div>
            <div class="card-body">
                @foreach($actividadesRecientes as $actividad)
                    <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                        <span>{{ $actividad->nombre }}</span>
                        <small class="text-muted">{{ $actividad->dia_semana }} {{ $actividad->hora_inicio->format('H:i') }}</small>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Alumnos Recientes</h5>
            </div>
            <div class="card-body">
                @foreach($alumnosRecientes as $alumno)
                    <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                        <span>{{ $alumno->nombre_completo }}</span>
                        <small class="text-muted">{{ $alumno->curso_academico }}</small>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection