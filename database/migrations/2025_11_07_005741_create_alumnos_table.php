<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_alumnos_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('alumnos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_completo');
            $table->enum('curso_academico', [
                '1º Primaria', '2º Primaria', '3º Primaria', '4º Primaria', 
                '5º Primaria', '6º Primaria', '1º ESO', '2º ESO', 
                '3º ESO', '4º ESO', '1º Bachillerato', '2º Bachillerato'
            ]);
            $table->integer('edad');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('alumnos');
    }
};