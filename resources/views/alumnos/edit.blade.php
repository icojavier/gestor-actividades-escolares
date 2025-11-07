@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Editar Alumno: {{ $alumno->nombre_completo }}</h1>
</div>

<div class="row">
    <div class="col-md-8">
        <form action="{{ route('alumnos.update', $alumno) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label for="nombre_completo" class="form-label">Nombre Completo *</label>
                <input type="text" class="form-control @error('nombre_completo') is-invalid @enderror" 
                       id="nombre_completo" name="nombre_completo" value="{{ old('nombre_completo', $alumno->nombre_completo) }}" required>
                @error('nombre_completo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="curso_academico" class="form-label">Curso Académico *</label>
                        <select class="form-select @error('curso_academico') is-invalid @enderror" 
                                id="curso_academico" name="curso_academico" required>
                            <option value="">Seleccionar curso</option>
                            @foreach($cursos as $curso)
                                <option value="{{ $curso }}" {{ old('curso_academico', $alumno->curso_academico) == $curso ? 'selected' : '' }}>
                                    {{ $curso }}
                                </option>
                            @endforeach
                        </select>
                        @error('curso_academico')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="edad" class="form-label">Edad *</label>
                        <input type="number" class="form-control @error('edad') is-invalid @enderror" 
                               id="edad" name="edad" value="{{ old('edad', $alumno->edad) }}" min="6" max="18" required>
                        @error('edad')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Actualizar Alumno</button>
                <a href="{{ route('alumnos.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection