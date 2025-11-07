<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PdfExportController extends Controller
{
    public function exportActividadAlumnos($actividadId)
    {
        return "PDF para actividad ID: " . $actividadId;
    }

    public function exportAllActividades()
    {
        return "PDF para todas las actividades";
    }
}