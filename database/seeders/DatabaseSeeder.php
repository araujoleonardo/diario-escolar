<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        \App\Models\User::factory()->create([
            'email' => 'adm@teste.com',
            'user_profile' => 'sec_academica',
        ]);


        // Turma
        $turmaA = \App\Models\Turma::factory()->create([
            'nome' => '1º ano A',
            'turno' => 'manhã'
        ]);
        \App\Models\Turma::factory()->create([
            'nome' => '1º ano B',
            'turno' => 'manhã'
        ]);
        \App\Models\Turma::factory()->create([
            'nome' => '1º ano C',
            'turno' => 'manhã'
        ]);
        \App\Models\Turma::factory()->create([
            'nome' => '1º ano A',
            'turno' => 'tarde'
        ]);

        // Disciplinas
        $disciplina1 = \App\Models\Disciplina::factory()->create([
            'nome' => 'Português',
        ]);
        $disciplina2 =  \App\Models\Disciplina::factory()->create([
            'nome' => 'Matemática',
        ]);

        // Alunos
        $userAluno1 = \App\Models\User::factory()->create([
            'user_profile' => 'aluno',
        ]);
        $userAluno2 = \App\Models\User::factory()->create([
            'user_profile' => 'aluno',
        ]);
        \App\Models\Aluno::factory()->create([
            'dt_nascimento' => '2000-01-01',
            'telefone' => '(99) 99999-9999',
            'user_id' => $userAluno1->id,
            'sexo' => 'masculino',
            'turma_id' => $turmaA->id
        ]);
        \App\Models\Aluno::factory()->create([
            'dt_nascimento' => '2020-01-01',
            'telefone' => '(99) 99999-9999',
            'user_id' => $userAluno2->id,
            'sexo' => 'masculino',
            'turma_id' => $turmaA->id
        ]);

        for ($i = 0; $i < 30; $i++) {
            $alunoX = \App\Models\User::factory()->create([
                'user_profile' => 'aluno',
            ]);
            \App\Models\Aluno::factory()->create([
                'dt_nascimento' => '2000-01-01',
                'telefone' => '(99) 99999-9999',
                'user_id' => $alunoX->id,
                'turma_id' => $turmaA->id,
                'sexo' => 'masculino',
                'created_at' => date('Y-m-d H:i', strtotime(' - ' . rand(0, 12) . ' months'))
            ]);
        }

        // Professores
        $userProfessor1 = \App\Models\User::factory()->create([
            'user_profile' => 'professor',
            'email' => 'prof@teste.com'
        ]);
        $professor1 = \App\Models\Professor::factory()->create([
            'telefone' => '(99) 99999-9999',
            'user_id' => $userProfessor1->id,
        ]);
        \App\Models\AlocacaoProfessorTurma::factory()->create([
            'turma_id' => $turmaA->id,
            'professor_id' => $professor1->id,
        ]);
        \App\Models\AlocacaoProfessorDisciplina::factory()->create([
            'disciplina_id' => $disciplina1->id,
            'professor_id' => $professor1->id,
        ]);
        \App\Models\AlocacaoProfessorDisciplina::factory()->create([
            'disciplina_id' => $disciplina2->id,
            'professor_id' => $professor1->id,
        ]);

        // Periódo Escolar
        \App\Models\EscolaPeriodo::factory()->create([
            'nome' => '1° Bimestre',
            'data_inicio' => date('Y-m-d'),
            'data_final' => date('Y-m-d', strtotime('+ 2 months')),
        ]);
        \App\Models\EscolaPeriodo::factory()->create([
            'nome' => '2° Bimestre',
            'data_inicio' => date('Y-m-d', strtotime('+ 2 months')),
            'data_final' => date('Y-m-d', strtotime('+ 4 months')),
        ]);
    }
}
