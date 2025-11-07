<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Actividades del Alumno - {{ $alumno->nombre_completo }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #34495e; padding-bottom: 10px; }
        .title { color: #2c3e50; font-size: 18px; margin-bottom: 5px; }
        .subtitle { color: #7f8c8d; font-size: 14px; }
        .info-table { width: 100%; margin-bottom: 20px; border-collapse: collapse; font-size: 11px; }
        .info-table td { padding: 6px; border: 1px solid #ddd; }
        .info-table .label { background-color: #f8f9fa; font-weight: bold; width: 25%; }
        .actividades-table { width: 100%; border-collapse: collapse; font-size: 10px; }
        .actividades-table th { background-color: #34495e; color: white; padding: 8px; text-align: left; border: 1px solid #ddd; }
        .actividades-table td { padding: 6px; border: 1px solid #ddd; }
        .actividades-table tr:nth-child(even) { background-color: #f8f9fa; }
        .no-data { text-align: center; color: #7f8c8d; padding: 30px; font-size: 12px; }
        .footer { margin-top: 20px; text-align: center; color: #7f8c8d; font-size: 10px; border-top: 1px solid #ddd; padding-top: 10px; }
        .descripcion { font-size: 10px; color: #666; margin-top: 2px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">Actividades Inscritas</div>
        <div class="subtitle">{{ $alumno->nombre_completo }}</div>
    </div>

    <table class="info-table">
        <tr>
            <td class="label">Curso Académico:</td>
            <td>{{ $alumno->curso_academico }}</td>
        </tr>
        <tr>
            <td class="label">Edad:</td>
            <td>{{ $alumno->edad }} años</td>
        </tr>
        <tr>
            <td class="label">Total Actividades:</td>
            <td>
                <strong>{{ $alumno->actividades->count() }}</strong>
                @if($alumno->actividades->count() > 0)
                    <span style="color: #27ae60; margin-left: 10px;">
                        ({{ $alumno->actividades->groupBy('dia_semana')->count() }} días diferentes)
                    </span>
                @endif
            </td>
        </tr>
    </table>

    @if($alumno->actividades->count() > 0)
        <table class="actividades-table">
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th width="25%">Actividad</th>
                    <th width="40%">Descripción</th>
                    <th width="10%">Día</th>
                    <th width="20%">Horario</th>
                </tr>
            </thead>
            <tbody>
                @foreach($alumno->actividades as $index => $actividad)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <strong>{{ $actividad->nombre }}</strong>
                    </td>
                    <td>
                        <div class="descripcion">
                            {{ Str::limit($actividad->descripcion, 80) }}
                        </div>
                    </td>
                    <td>{{ $actividad->dia_semana }}</td>
                    <td>{{ $actividad->hora_inicio->format('H:i') }} - {{ $actividad->hora_finalizacion->format('H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <!-- Resumen por días -->
        <div style="margin-top: 15px; padding: 10px; background-color: #f8f9fa; border-radius: 5px; font-size: 10px;">
            <strong>Resumen por días:</strong>
            @php
                $actividadesPorDia = $alumno->actividades->groupBy('dia_semana');
            @endphp
            @foreach($actividadesPorDia as $dia => $actividadesDia)
                {{ $dia }} ({{ $actividadesDia->count() }}){{ !$loop->last ? ' | ' : '' }}
            @endforeach
        </div>
    @else
        <div class="no-data">
            <strong>El alumno no está inscrito en ninguna actividad.</strong><br>
            Puede inscribirse en actividades desde el sistema de gestión.
        </div>
    @endif

    <div class="footer">
        Generado el {{ now()->format('d/m/Y H:i') }} | Gestor de Actividades Escolares
    </div>
</body>
</html>