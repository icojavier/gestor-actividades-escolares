@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="bi bi-people"></i>
        Gestión de Alumnos
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('alumnos.create') }}" class="btn btn-success me-2">
            <i class="bi bi-plus-circle"></i> Nuevo Alumno
        </a>
        <a href="{{ route('export.alumnos.all') }}" class="btn btn-danger">
            <i class="bi bi-file-pdf"></i> Exportar PDF
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="bi bi-list-ul"></i>
            Lista de Alumnos Registrados
        </h5>
    </div>
    <div class="card-body">
        @if($alumnos->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Nombre Completo</th>
                            <th>Curso Académico</th>
                            <th>Edad</th>
                            <th>Actividades</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($alumnos as $alumno)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <strong>{{ $alumno->nombre_completo }}</strong>
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $alumno->curso_academico }}</span>
                            </td>
                            <td>
                                <span class="badge bg-secondary">{{ $alumno->edad }} años</span>
                            </td>
                            <td>
                                <span class="badge bg-success">{{ $alumno->actividades_count ?? 0 }}</span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <!-- Botón VER -->
                                    <a href="{{ route('alumnos.show', $alumno->id) }}"
                                       class="btn btn-info btn-sm me-1 text-white"
                                       title="Ver detalles">
                                       <i class="bi bi-eye me-2"></i> Ver
                                    </a>

                                    <!-- Botón EDITAR -->
                                    <a href="{{ route('alumnos.edit', $alumno->id) }}"
                                       class="btn btn-warning btn-sm me-1 text-white"
                                       title="Editar alumno">
                                        <i class="bi bi-pencil"></i> Editar
                                    </a>

                                    <!-- Botón IMPRIMIR (solo si tiene actividades) -->
                                    @if($alumno->actividades_count > 0)
                                    <a href="{{ route('export.alumno.actividades', $alumno->id) }}"
                                       class="btn btn-danger btn-sm me-1 text-white"
                                       title="Imprimir actividades">
                                        <i class="bi bi-printer"></i> Imprimir
                                    </a>
                                    @else
                                    <button class="btn btn-outline-secondary btn-sm me-1 text-white" disabled title="Sin actividades para imprimir">
                                        <i class="bi bi-printer"></i> Imprimir
                                    </button>
                                    @endif

                                    <!-- Botón ELIMINAR -->
                                    <form action="{{ route('alumnos.destroy', $alumno->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-dark btn-sm text-white"
                                                onclick="return confirm('¿Estás seguro de eliminar al alumno {{ $alumno->nombre_completo }}?')"
                                                title="Eliminar alumno">
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

            <!-- Paginación -->
            @if($alumnos->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-muted">
                    Mostrando {{ $alumnos->firstItem() }} - {{ $alumnos->lastItem() }} de {{ $alumnos->total() }} alumnos
                </div>
                <div>
                    {{ $alumnos->links() }}
                </div>
            </div>
            @endif

        @else
            <div class="text-center py-5">
                <div class="mb-3">
                    <i class="bi bi-people display-1 text-muted"></i>
                </div>
                <h4 class="text-muted">No hay alumnos registrados</h4>
                <p class="text-muted">Comienza agregando el primer alumno al sistema.</p>
                <a href="{{ route('alumnos.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Agregar Primer Alumno
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
    .btn-group .btn {
        border-radius: 0.375rem;
        margin: 0 2px;
        font-size: 0.875rem;
        font-weight: 500;
    }
    .btn-group .btn:first-child {
        border-top-left-radius: 0.375rem;
        border-bottom-left-radius: 0.375rem;
    }
    .btn-group .btn:last-child {
        border-top-right-radius: 0.375rem;
        border-bottom-right-radius: 0.375rem;
    }
    .table th {
        background-color: #2e7d32;
        color: white;
        font-weight: 600;
    }
</style>
@endpush
