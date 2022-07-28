<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notas', function (Blueprint $table) {
            $table->id();
            $table->decimal('nota', 4, 2);
            $table->foreignId('aluno_id')->constrained()->onDelete('cascade');
            $table->foreignId('turma_id')->constrained()->onDelete('cascade');
            $table->foreignId('disciplina_id')->constrained()->onDelete('cascade');
            $table->foreignId('escola_periodo_id')->constrained()->onDelete('cascade');
            $table->foreignId('professor_id')->constrained('professores')->onDelete('cascade'); // Professor responsável por aplicar a nota
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
        Schema::dropIfExists('notas');
    }
}
