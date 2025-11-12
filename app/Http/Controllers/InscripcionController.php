<?php

namespace App\Http\Controllers;

use App\Models\Inscripcion;
use App\Models\Alumno;
use App\Models\Actividad;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class InscripcionController extends Controller
{
    public function index(Request $request)
    {
        $query = Inscripcion::with(['alumno', 'actividad']);

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('alumno', function($q) use ($search) {
                $q->where('nombre_completo', 'LIKE', "%{$search}%");
            })->orWhereHas('actividad', function($q) use ($search) {
                $q->where('nombre', 'LIKE', "%{$search}%");
            });
        }

        $inscripciones = $query->latest()->get();

        return view('inscripciones.index', compact('inscripciones'));
    }

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

        // Crear la inscripción
        Inscripcion::create([
            'alumno_id' => $request->alumno_id,
            'actividad_id' => $request->actividad_id,
            'fecha_inscripcion' => now(),
        ]);

        // ✅ Asegúrate de que redirija al listado
        return redirect()->route('inscripciones.index')
            ->with('success', 'Inscripción creada correctamente.');
    }

    public function show($id)
    {
        $inscripcion = Inscripcion::with(['alumno', 'actividad'])->findOrFail($id);
        return view('inscripciones.show', compact('inscripcion'));
    }

    public function destroy($id)
    {
        try {
            // Buscar la inscripción
            $inscripcion = Inscripcion::with(['alumno', 'actividad'])->findOrFail($id);

            // Guardar info para mensaje
            $alumnoNombre = $inscripcion->alumno->nombre . ' ' . $inscripcion->alumno->apellido;
            $actividadNombre = $inscripcion->actividad->nombre;

            // Eliminar
            $inscripcion->delete();

            return redirect()->route('inscripciones.index')
                ->with('success', "✅ {$alumnoNombre} desinscrito de {$actividadNombre} correctamente.");

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('inscripciones.index')
                ->with('error', '❌ No se encontró la inscripción.');
        } catch (\Exception $e) {
            return redirect()->route('inscripciones.index')
                ->with('error', '❌ Error: ' . $e->getMessage());
        }
    }

    /**
     * Exportar inscripciones a PDF
     */
    public function exportPdf()
    {
        $inscripciones = Inscripcion::with(['alumno', 'actividad'])
            ->latest()
            ->get();

        $pdf = Pdf::loadView('pdf.inscripciones', compact('inscripciones'));
        return $pdf->download('inscripciones-' . date('Y-m-d') . '.pdf');
    }
}
