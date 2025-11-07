<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Todas las Actividades</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 30px; }
        .title { color: #2c3e50; font-size: 24px; margin-bottom: 10px; }
        .actividades-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .actividades-table th { background-color: #34495e; color: white; padding: 12px; text-align: left; }
        .actividades-table td { padding: 10px; border: 1px solid #ddd; }
        .actividades-table tr:nth-child(even) { background-color: #f8f9fa; }
        .count { text-align: center; font-weight: bold; }
        .footer { margin-top: 30px; text-align: center; color: #7f8c8d; font-size: 12px; }
        .summary { background-color: #f8f9fa; padding: 15px; margin-bottom: 20px; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">Reporte de Todas las Actividades</div>
        <div class="subtitle">Resumen General</div>
    </div>

    <div class="summary">
        <strong>Total de Actividades:</strong> {{ $actividades->count() }}<br>
        <strong>Total de Inscripciones:</strong> {{ $actividades->sum('alumnos_count') }}
    </div>

    <table class="actividades-table">
        <thead>
            <tr>
                <th>Actividad</th>
                <th>Descripción</th>
                <th>Día</th>
                <th>Horario</th>
                <th>Alumnos Inscritos</th>
            </tr>
        </thead>
        <tbody>
            @foreach($actividades as $actividad)
            <tr>
                <td>{{ $actividad->nombre }}</td>
                <td>{{ Str::limit($actividad->descripcion, 50) }}</td>
                <td>{{ $actividad->dia_semana }}</td>
                <td>{{ $actividad->hora_inicio->format('H:i') }} - {{ $actividad->hora_finalizacion->format('H:i') }}</td>
                <td class="count">{{ $actividad->alumnos_count }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Generado el {{ now()->format('d/m/Y H:i') }} | Gestor de Actividades Escolares
    </div>
</body>
</html>