<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Todos los Alumnos</title>
    <style>
        body { 
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header { 
            text-align: center; 
            margin-bottom: 20px;
            border-bottom: 2px solid #34495e;
            padding-bottom: 10px;
        }
        .title { 
            color: #2c3e50; 
            font-size: 20px; 
            margin-bottom: 5px;
        }
        .subtitle { 
            color: #7f8c8d; 
            font-size: 14px;
        }
        .alumnos-table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 20px;
            font-size: 10px;
        }
        .alumnos-table th { 
            background-color: #34495e; 
            color: white; 
            padding: 8px; 
            text-align: left;
            border: 1px solid #ddd;
        }
        .alumnos-table td { 
            padding: 6px; 
            border: 1px solid #ddd;
            vertical-align: top;
        }
        .alumnos-table tr:nth-child(even) { 
            background-color: #f8f9fa; 
        }
        .actividades-list {
            margin: 0;
            padding-left: 12px;
        }
        .actividades-list li {
            margin-bottom: 2px;
            font-size: 9px;
        }
        .no-actividades {
            color: #7f8c8d;
            font-style: italic;
            font-size: 9px;
        }
        .footer { 
            margin-top: 20px; 
            text-align: center; 
            color: #7f8c8d; 
            font-size: 10px;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .summary { 
            background-color: #f8f9fa; 
            padding: 10px; 
            margin-bottom: 15px; 
            border-radius: 5px;
            font-size: 11px;
        }
        .count-badge {
            background-color: #3498db;
            color: white;
            padding: 2px 6px;
            border-radius: 10px;
            font-size: 9px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">Reporte de Todos los Alumnos</div>
        <div class="subtitle">Lista Completa con Actividades Inscritas</div>
    </div>

    <div class="summary">
        <strong>Total de Alumnos:</strong> {{ $alumnos->count() }} | 
        <strong>Total de Inscripciones:</strong> {{ $alumnos->sum('actividades_count') }} |
        <strong>Alumnos con actividades:</strong> {{ $alumnos->where('actividades_count', '>', 0)->count() }} |
        <strong>Alumnos sin actividades:</strong> {{ $alumnos->where('actividades_count', 0)->count() }}
    </div>

    <table class="alumnos-table">
        <thead>
            <tr>
                <th width="5%">#</th>
                <th width="25%">Nombre Completo</th>
                <th width="15%">Curso Académico</th>
                <th width="8%">Edad</th>
                <th width="47%">Actividades Inscritas</th>
            </tr>
        </thead>
        <tbody>
            @foreach($alumnos as $index => $alumno)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>
                    <strong>{{ $alumno->nombre_completo }}</strong>
                </td>
                <td>{{ $alumno->curso_academico }}</td>
                <td style="text-align: center;">{{ $alumno->edad }} años</td>
                <td>
                    @if($alumno->actividades_count > 0)
                        <ul class="actividades-list">
                            @foreach($alumno->actividades as $actividad)
                            <li>
                                <strong>{{ $actividad->nombre }}</strong> 
                                - {{ $actividad->dia_semana }} 
                                ({{ $actividad->hora_inicio->format('H:i') }}-{{ $actividad->hora_finalizacion->format('H:i') }})
                            </li>
                            @endforeach
                        </ul>
                    @else
                        <span class="no-actividades">No inscrito en actividades</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Generado el {{ now()->format('d/m/Y H:i') }} | Gestor de Actividades Escolares
    </div>
</body>
</html>