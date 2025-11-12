<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Listado de Inscripciones</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            color: #2c3e50;
            margin-bottom: 5px;
            font-size: 24px;
        }
        .header .date {
            color: #7f8c8d;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 10px;
        }
        th {
            background-color: #34495e;
            color: white;
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }
        td {
            padding: 6px;
            border-bottom: 1px solid #ddd;
            border: 1px solid #ddd;
        }
        .total {
            margin-top: 15px;
            font-weight: bold;
            color: #2c3e50;
            text-align: right;
            font-size: 12px;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 10px;
            color: #7f8c8d;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Listado de Inscripciones</h1>
        <div class="date">Generado el: {{ date('d/m/Y H:i') }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Alumno</th>
                <th>Actividad</th>
                <th>Fecha de Inscripción</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inscripciones as $inscripcion)
            <tr>
                <td>{{ $inscripcion->alumno->nombre_completo ?? ($inscripcion->alumno->nombre . ' ' . $inscripcion->alumno->apellido) }}</td>
                <td>{{ $inscripcion->actividad->nombre }}</td>
                <td>{{ \Carbon\Carbon::parse($inscripcion->fecha_inscripcion)->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">
        Total de inscripciones: {{ $inscripciones->count() }}
    </div>

    <div class="footer">
        Sistema de Gestión de Actividades Extraescolares - {{ date('Y') }}
    </div>
</body>
</html>
