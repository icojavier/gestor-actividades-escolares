<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscripcion extends Model
{
    use HasFactory;

    // ESPECIFICAR EXPLÍCITAMENTE EL NOMBRE DE LA TABLA
    protected $table = 'inscripciones';

    protected $fillable = [
        'alumno_id',
        'actividad_id'
    ];

    public function alumno()
    {
        return $this->belongsTo(Alumno::class);
    }

    public function actividad()
    {
        return $this->belongsTo(Actividad::class);
    }
}