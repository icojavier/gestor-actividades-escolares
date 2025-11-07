<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Alumnos Inscritos - {{ $actividad->nombre }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 30px; }
        .title { color: #2c3e50; font-size: 24px; margin-bottom: 10px; }
        .subtitle { color: #7f8c8d; font-size: 16px; }
        .info-table { width: 100%; margin-bottom: 20px; border-collapse: collapse; }
        .info-table td { padding: 8px; border: 1px solid #ddd; }
        .info-table .label { background-color: #f8f9fa; font-weight: bold; width: 30%; }
        .alumnos-table { width: 100%; border-collapse: collapse; }
        .alumnos-table th { background-color: #34495e; color: white; padding: 12px; text-align: left; }
        .alumnos-table td { padding: 10px; border: 1px solid #ddd; }
        .alumnos-table tr:nth-child(even) { background-color: #f8f9fa; }
        .no-data { text-align: center; color: #7f8c8d; padding: 20px; }
        .footer { margin-top: 30px; text-align: center; color: #7f8c8d; font-size: 12px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">Lista de Alumnos Inscritos</div>
        <div class="subtitle">{{ $actividad->nombre }}</div>
    </div>

    <table class="info-table">
        <tr>
            <td class="label">Descripción:</td>
            <td>{{ $actividad->descripcion }}</td>
        </tr>
        <tr>
            <td class="label">Día:</td>
            <td>{{ $actividad->dia_semana }}</td>
        </tr>
        <tr>
            <td class="label">Horario:</td>
            <td>{{ $actividad->hora_inicio->format('H:i') }} - {{ $actividad->hora_finalizacion->format('H:i') }}</td>
        </tr>
        <tr>
            <td class="label">Total Alumnos:</td>
            <td>{{ $actividad->alumnos->count() }}</td>
        </tr>
    </table>

    @if($actividad->alumnos->count() > 0)
        <table class="alumnos-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre Completo</th>
                    <th>Curso Académico</th>
                    <th>Edad</th>
                </tr>
            </thead>
            <tbody>
                @foreach($actividad->alumnos as $index => $alumno)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $alumno->nombre_completo }}</td>
                    <td>{{ $alumno->curso_academico }}</td>
                    <td>{{ $alumno->edad }} años</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="no-data">
            No hay alumnos inscritos en esta actividad.
        </div>
    @endif

    <div class="footer">
        Generado el {{ now()->format('d/m/Y H:i') }} | Gestor de Actividades Escolares
    </div>
</body>
</html>