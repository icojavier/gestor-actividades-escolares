<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use App\Models\Alumno;
use App\Models\Inscripcion;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PdfExportController extends Controller
{
    // Método existente para exportar todas las actividades
    public function exportAllActividades()
    {
        $actividades = Actividad::withCount('alumnos')->get();
        $pdf = Pdf::loadView('pdf.all-actividades', compact('actividades'));
        return $pdf->download('lista-actividades-completa.pdf');
    }

    // Método existente para exportar alumnos de una actividad específica
    public function exportActividadAlumnos($id)
    {
        $actividad = Actividad::with('alumnos')->findOrFail($id);
        $pdf = Pdf::loadView('pdf.actividad-alumnos', compact('actividad'));
        return $pdf->download("alumnos-{$actividad->nombre}.pdf");
    }

    // Método existente para exportar todos los alumnos
    public function exportAllAlumnos()
    {
        $alumnos = Alumno::withCount('actividades')->get();
        $pdf = Pdf::loadView('pdf.all-alumnos', compact('alumnos'));
        return $pdf->download('lista-alumnos-completa.pdf');
    }

    public function exportAlumnoActividades($id)
    {
        try {
            $alumno = Alumno::with('actividades')->findOrFail($id);
            $pdf = Pdf::loadView('pdf.alumno-actividades', compact('alumno'));
            return $pdf->download("actividades-{$alumno->nombre_completo}.pdf");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al generar el PDF: ' . $e->getMessage());
        }
    }
}
