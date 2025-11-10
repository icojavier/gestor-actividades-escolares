<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateActividadRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

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
                'after:hora_inicio',
                function ($attribute, $value, $fail) {
                    $horaInicio = \Carbon\Carbon::createFromFormat('H:i', $this->hora_inicio);
                    $horaFin = \Carbon\Carbon::createFromFormat('H:i', $value);

                    $diferenciaMinutos = $horaInicio->diffInMinutes($horaFin);

                    if ($diferenciaMinutos < 45) {
                        $fail('La hora de finalización debe ser al menos 45 minutos después de la hora de inicio.');
                    }
                },
            ],
        ];
    }

    public function messages()
    {
        return [
            'nombre.required' => 'El nombre de la actividad es obligatorio.',
            'descripcion.required' => 'La descripción es obligatoria.',
            'dia_semana.required' => 'El día de la semana es obligatorio.',
            'hora_inicio.required' => 'La hora de inicio es obligatoria.',
            'hora_inicio.date_format' => 'El formato de la hora de inicio debe ser HH:MM.',
            'hora_finalizacion.required' => 'La hora de finalización es obligatoria.',
            'hora_finalizacion.date_format' => 'El formato de la hora de finalización debe ser HH:MM.',
            'hora_finalizacion.after' => 'La hora de finalización debe ser posterior a la hora de inicio.',
        ];
    }
}
