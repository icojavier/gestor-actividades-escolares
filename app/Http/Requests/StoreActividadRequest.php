<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreActividadRequest extends FormRequest
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
            'nombre.required' => 'El nombre de la actividad es obligatorio.',
            'descripcion.required' => 'La descripción es obligatoria.',
            'dia_semana.required' => 'El día de la semana es obligatorio.',
            'hora_inicio.required' => 'La hora de inicio es obligatoria.',
            'hora_finalizacion.required' => 'La hora de finalización es obligatoria.',
            'hora_finalizacion.after' => 'La hora de finalización debe ser posterior a la hora de inicio.',
        ];
    }
}