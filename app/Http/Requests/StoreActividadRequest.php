<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class StoreActividadRequest extends FormRequest
{
    public function rules()
    {
        return [
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'dia_semana' => 'required|string',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_finalizacion' => [
                'required',
                'date_format:H:i',
                function ($attribute, $value, $fail) {
                    $horaInicio = $this->input('hora_inicio');
                    $horaFin = $value;
                    
                                  
                    $inicio = Carbon::createFromFormat('H:i', $horaInicio);
                    $fin = Carbon::createFromFormat('H:i', $horaFin);
                    
                    // Validar que la hora fin sea posterior
                    if ($fin->lt($inicio)) {
                        $fail('La hora de finalización debe ser posterior a la hora de inicio.');
                    }
                    
                    // Manejar actividades que cruzan la medianoche
                    if ($fin->lt($inicio)) {
                        $fin->addDay();
                    }

                    // Calcular diferencia en minutos
                    $diferenciaMinutos = $inicio->diffInMinutes($fin);
                    
                    // Validar duración mínima de 45 minutos
                    if ($diferenciaMinutos < 45) {
                        $fail('La actividad debe durar al menos 45 minutos.');
                    }
                },
            ],
        ];
    }
}