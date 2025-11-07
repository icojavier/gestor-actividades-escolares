<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_inscripciones_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('inscripciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alumno_id')->constrained('alumnos')->onDelete('cascade');
            $table->foreignId('actividad_id')->constrained('actividades')->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['alumno_id', 'actividad_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('inscripciones');
    }
};