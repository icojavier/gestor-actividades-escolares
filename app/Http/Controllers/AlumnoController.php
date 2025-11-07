<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Http\Requests\StoreAlumnoRequest;
use App\Http\Requests\UpdateAlumnoRequest;
use Illuminate\Http\Request;

class AlumnoController extends Controller
{
    public function index(Request $request)
    {
        // Cargar alumnos con sus actividades
        $alumnos = Alumno::withCount('actividades')
                    ->with(['actividades' => function($query) {
                        $query->select('actividades.id', 'actividades.nombre', 'actividades.dia_semana');
                    }])
                    ->get();
        
        return view('alumnos.index', compact('alumnos'));
    }

    public function create()
    {
        $cursos = [
            '1º Primaria', '2º Primaria', '3º Primaria', '4º Primaria', 
            '5º Primaria', '6º Primaria', '1º ESO', '2º ESO', 
            '3º ESO', '4º ESO', '1º Bachillerato', '2º Bachillerato'
        ];
        
        return view('alumnos.create', compact('cursos'));
    }

    public function store(StoreAlumnoRequest $request)
    {
        Alumno::create($request->validated());

        return redirect()->route('alumnos.index')
            ->with('success', 'Alumno creado correctamente.');
    }

    public function show($id)
    {
        $alumno = Alumno::withCount('actividades')->with('actividades')->findOrFail($id);
        return view('alumnos.show', compact('alumno'));
    }

    public function edit($id)
    {
        $alumno = Alumno::findOrFail($id);
        $cursos = [
            '1º Primaria', '2º Primaria', '3º Primaria', '4º Primaria', 
            '5º Primaria', '6º Primaria', '1º ESO', '2º ESO', 
            '3º ESO', '4º ESO', '1º Bachillerato', '2º Bachillerato'
        ];
        
        return view('alumnos.edit', compact('alumno', 'cursos'));
    }

    public function update(UpdateAlumnoRequest $request, $id)
    {
        $alumno = Alumno::findOrFail($id);
        $alumno->update($request->validated());

        return redirect()->route('alumnos.index')
            ->with('success', 'Alumno actualizado correctamente.');
    }

    public function destroy($id)
    {
        $alumno = Alumno::withCount('actividades')->findOrFail($id);

        if ($alumno->actividades_count > 0) {
            return redirect()->route('alumnos.index')
                ->with('error', 'No se puede eliminar el alumno porque está inscrito en actividades.');
        }

        $alumno->delete();

        return redirect()->route('alumnos.index')
            ->with('success', 'Alumno eliminado correctamente.');
    }
}