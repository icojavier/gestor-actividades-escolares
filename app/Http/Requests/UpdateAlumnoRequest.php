<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAlumnoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nombre_completo' => 'required|string|max:255',
            'curso_academico' => 'required|string',
            'edad' => 'required|integer|min:6|max:18',
        ];
    }
}