@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Editar Actividad: {{ $actividad->nombre }}</h1>
</div>

<div class="row">
    <div class="col-md-8">
        <form action="{{ route('actividades.update', $actividad) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre de la Actividad *</label>
                <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
                       id="nombre" name="nombre" value="{{ old('nombre', $actividad->nombre) }}" required>
                @error('nombre')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción *</label>
                <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                          id="descripcion" name="descripcion" rows="3" required>{{ old('descripcion', $actividad->descripcion) }}</textarea>
                @error('descripcion')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="dia_semana" class="form-label">Día de la Semana *</label>
                        <select class="form-select @error('dia_semana') is-invalid @enderror" 
                                id="dia_semana" name="dia_semana" required>
                            <option value="">Seleccionar día</option>
                            <option value="Lunes" {{ old('dia_semana', $actividad->dia_semana) == 'Lunes' ? 'selected' : '' }}>Lunes</option>
                            <option value="Martes" {{ old('dia_semana', $actividad->dia_semana) == 'Martes' ? 'selected' : '' }}>Martes</option>
                            <option value="Miércoles" {{ old('dia_semana', $actividad->dia_semana) == 'Miércoles' ? 'selected' : '' }}>Miércoles</option>
                            <option value="Jueves" {{ old('dia_semana', $actividad->dia_semana) == 'Jueves' ? 'selected' : '' }}>Jueves</option>
                            <option value="Viernes" {{ old('dia_semana', $actividad->dia_semana) == 'Viernes' ? 'selected' : '' }}>Viernes</option>
                            <option value="Sábado" {{ old('dia_semana', $actividad->dia_semana) == 'Sábado' ? 'selected' : '' }}>Sábado</option>
                        </select>
                        @error('dia_semana')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="hora_inicio" class="form-label">Hora de Inicio *</label>
                        <input type="time" class="form-control @error('hora_inicio') is-invalid @enderror" 
                               id="hora_inicio" name="hora_inicio" value="{{ old('hora_inicio', $actividad->hora_inicio->format('H:i')) }}" required>
                        @error('hora_inicio')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="hora_finalizacion" class="form-label">Hora de Finalización *</label>
                        <input type="time" class="form-control @error('hora_finalizacion') is-invalid @enderror" 
                               id="hora_finalizacion" name="hora_finalizacion" value="{{ old('hora_finalizacion', $actividad->hora_finalizacion->format('H:i')) }}" required>
                        @error('hora_finalizacion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Actualizar Actividad</button>
                <a href="{{ route('actividades.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection