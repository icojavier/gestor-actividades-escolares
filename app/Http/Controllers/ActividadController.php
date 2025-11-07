<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use App\Http\Requests\StoreActividadRequest;
use App\Http\Requests\UpdateActividadRequest;
use Illuminate\Http\Request;

class ActividadController extends Controller
{
    public function index(Request $request)
    {
        $query = Actividad::withCount('alumnos');
        
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('nombre', 'LIKE', "%{$search}%")
                ->orWhere('descripcion', 'LIKE', "%{$search}%")
                ->orWhere('dia_semana', 'LIKE', "%{$search}%");
        }
        
        $actividades = $query->get();
        
        return view('actividades.index', compact('actividades'));
    }


    public function create()
    {
        return view('actividades.create');
    }

    public function store(StoreActividadRequest $request)
    {
        Actividad::create($request->validated());

        return redirect()->route('actividades.index')
            ->with('success', 'Actividad creada correctamente.');
    }

    public function show($id)
    {
        $actividad = Actividad::withCount('alumnos')->with('alumnos')->findOrFail($id);
        return view('actividades.show', compact('actividad'));
    }

    public function edit($id)
    {
        $actividad = Actividad::findOrFail($id);
        return view('actividades.edit', compact('actividad'));
    }

    public function update(UpdateActividadRequest $request, $id)
    {
        $actividad = Actividad::findOrFail($id);
        $actividad->update($request->validated());

        return redirect()->route('actividades.index')
            ->with('success', 'Actividad actualizada correctamente.');
    }

    public function destroy($id)
    {
        $actividad = Actividad::withCount('alumnos')->findOrFail($id);
        
        if ($actividad->alumnos_count > 0) {
            return redirect()->route('actividades.index')
                ->with('error', 'No se puede eliminar la actividad porque tiene alumnos inscritos.');
        }

        $actividad->delete();

        return redirect()->route('actividades.index')
            ->with('success', 'Actividad eliminada correctamente.');
    }

    public function showAlumnos($id)
    {
        $actividad = Actividad::with('alumnos')->findOrFail($id);
        return view('actividades.lista-alumnos', compact('actividad'));
    }
}