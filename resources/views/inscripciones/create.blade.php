@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Gestión de Inscripciones</h1>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Nueva Inscripción</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('inscripciones.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="alumno_id" class="form-label">Seleccionar Alumno *</label>
                        <select class="form-select @error('alumno_id') is-invalid @enderror" 
                                id="alumno_id" name="alumno_id" required>
                            <option value="">Seleccionar alumno</option>
                            @foreach($alumnos as $alumno)
                                <option value="{{ $alumno->id }}" {{ old('alumno_id') == $alumno->id ? 'selected' : '' }}>
                                    {{ $alumno->nombre_completo }} - {{ $alumno->curso_academico }}
                                </option>
                            @endforeach
                        </select>
                        @error('alumno_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="actividad_id" class="form-label">Seleccionar Actividad *</label>
                        <select class="form-select @error('actividad_id') is-invalid @enderror" 
                                id="actividad_id" name="actividad_id" required>
                            <option value="">Seleccionar actividad</option>
                            @foreach($actividades as $actividad)
                                <option value="{{ $actividad->id }}" {{ old('actividad_id') == $actividad->id ? 'selected' : '' }}>
                                    {{ $actividad->nombre }} - {{ $actividad->dia_semana }} {{ $actividad->hora_inicio->format('H:i') }}
                                </option>
                            @endforeach
                        </select>
                        @error('actividad_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Registrar Inscripción</button>
                        <a href="{{ route('dashboard') }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Inscripciones Existentes</h5>
            </div>
            <div class="card-body">
                @if($inscripciones->count() > 0)
                    <div class="list-group">
                        @foreach($inscripciones as $inscripcion)
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $inscripcion->alumno->nombre_completo }}</strong><br>
                                <small class="text-muted">{{ $inscripcion->actividad->nombre }}</small>
                            </div>
                            <form action="{{ route('inscripciones.destroy', $inscripcion) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" 
                                    onclick="return confirm('¿Estás seguro de eliminar esta inscripción?')">
                                    ×
                                </button>
                            </form>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted">No hay inscripciones registradas.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection