@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Detalles de la Inscripción</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('inscripciones.index') }}" class="btn btn-secondary me-2">
            ← Volver a la lista
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

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Información de la Inscripción</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>ID:</th>
                        <td>{{ $inscripcion->id }}</td>
                    </tr>
                    <tr>
                        <th>Fecha de Inscripción:</th>
                        <td>{{ \Carbon\Carbon::parse($inscripcion->fecha_inscripcion)->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <th>Estado:</th>
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
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Información del Alumno</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Nombre:</th>
                        <td>{{ $inscripcion->alumno->nombre }} {{ $inscripcion->alumno->apellido }}</td>
                    </tr>
                    <tr>
                        <th>Curso:</th>
                        <td>{{ $inscripcion->alumno->curso }}</td>
                    </tr>
                    <tr>
                        <th>Email:</th>
                        <td>{{ $inscripcion->alumno->email ?? 'No especificado' }}</td>
                    </tr>
                    <tr>
                        <th>Teléfono:</th>
                        <td>{{ $inscripcion->alumno->telefono ?? 'No especificado' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Información de la Actividad</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Nombre:</th>
                        <td>{{ $inscripcion->actividad->nombre }}</td>
                    </tr>
                    <tr>
                        <th>Descripción:</th>
                        <td>{{ $inscripcion->actividad->descripcion }}</td>
                    </tr>
                    <tr>
                        <th>Día de la semana:</th>
                        <td><span class="badge bg-info">{{ $inscripcion->actividad->dia_semana }}</span></td>
                    </tr>
                    <tr>
                        <th>Horario:</th>
                        <td>
                            @if($inscripcion->actividad->hora_inicio && $inscripcion->actividad->hora_finalizacion)
                                {{ \Carbon\Carbon::parse($inscripcion->actividad->hora_inicio)->format('H:i') }} -
                                {{ \Carbon\Carbon::parse($inscripcion->actividad->hora_finalizacion)->format('H:i') }}
                            @else
                                Horario no definido
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
    }
    .table th {
        width: 30%;
        background-color: #f8f9fa;
    }
</style>
@endpush
