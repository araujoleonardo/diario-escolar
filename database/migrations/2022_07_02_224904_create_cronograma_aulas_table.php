<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCronogramaAulasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cronograma_aulas', function (Blueprint $table) {
            $table->id();
            $table->time('hora_inicio');
            $table->time('hora_final');
            $table->string('segunda');
            $table->string('terca');
            $table->string('quarta');
            $table->string('quinta');
            $table->string('sexta');
            $table->foreignId('turma_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cronograma_aulas');
    }
}
