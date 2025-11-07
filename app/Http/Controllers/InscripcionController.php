<?php

namespace App\Http\Controllers;

use App\Models\Inscripcion;
use App\Models\Alumno;
use App\Models\Actividad;
use Illuminate\Http\Request;

class InscripcionController extends Controller
{
    public function create()
    {
        $alumnos = Alumno::all();
        $actividades = Actividad::all();
        $inscripciones = Inscripcion::with(['alumno', 'actividad'])->latest()->get();
        
        return view('inscripciones.create', compact('alumnos', 'actividades', 'inscripciones'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'alumno_id' => 'required|exists:alumnos,id',
            'actividad_id' => 'required|exists:actividades,id',
        ]);

        // Verificar si ya existe la inscripción
        $existeInscripcion = Inscripcion::where('alumno_id', $request->alumno_id)
            ->where('actividad_id', $request->actividad_id)
            ->exists();

        if ($existeInscripcion) {
            return redirect()->back()
                ->with('error', 'El alumno ya está inscrito en esta actividad.');
        }

        Inscripcion::create($request->all());

        return redirect()->route('inscripciones.create')
            ->with('success', 'Inscripción creada correctamente.');
    }

    public function destroy(Inscripcion $inscripcion)
    {
        $inscripcion->delete();

        return redirect()->back()
            ->with('success', 'Inscripción eliminada correctamente.');
    }
}