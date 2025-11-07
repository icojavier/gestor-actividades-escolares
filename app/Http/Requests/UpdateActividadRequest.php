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
            'dia_semana' => 'required|in:Lunes,Martes,Miércoles,Jueves,Viernes,Sábado',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_finalizacion' => 'required|date_format:H:i|after:hora_inicio',
        ];
    }

    public function messages()
    {
        return [
            'hora_finalizacion.after' => 'La hora de finalización debe ser posterior a la hora de inicio.',
        ];
    }
}