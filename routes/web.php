<?php

use App\Models\Disciplina;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\OAuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Dashboard\AulaController;
use App\Http\Controllers\Dashboard\HomeController;
use App\Http\Controllers\Dashboard\NotaController;
use App\Http\Controllers\Dashboard\AlunoController;
use App\Http\Controllers\Dashboard\FaltaController;
use App\Http\Controllers\Dashboard\TurmaController;
use App\Http\Controllers\Dashboard\MeusDadosController;
use App\Http\Controllers\Dashboard\ProfessorController;
use App\Http\Controllers\Dashboard\DisciplinaController;
use App\Http\Controllers\Dashboard\DatasProvasController;
use App\Http\Controllers\Dashboard\EscolaPeriodoController;
use App\Http\Controllers\Dashboard\DadosDoSistemaController;
use App\Http\Controllers\Dashboard\CompletarPerfilController;
use App\Http\Controllers\Dashboard\CronogramaAulasController;
use App\Http\Controllers\InicioController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [InicioController::class, 'index'])->name('inicio');

// Autenticação
Auth::routes();
Route::get('/registro-sec-academica', [RegisterController::class, 'registroSecAcademica'])->name('registro-sec-academica');
Route::post('/registro-sec-academica', [RegisterController::class, 'registroSecAcademicaStore'])->name('registro-sec-academica');
Route::get('/auth/redirect/{provider}', [OAuthController::class, 'redirect'])->name('oauth.redirect');
Route::get('/auth/callback/{provider}', [OAuthController::class, 'callback'])->name('oauth.callback');

// Painel de controle
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Meus dados
Route::get('meus-dados', [MeusDadosController::class, 'index'])->name('meus-dados');
Route::put('meus-dados/modificar-senha', [MeusDadosController::class, 'modificarSenha'])->name('meus-dados.modificar-senha');
Route::put('meus-dados/{perfil}', [MeusDadosController::class, 'atualizarDados'])->name('meus-dados.atualizar');

// Alunos
Route::get('alunos', [AlunoController::class, 'index'])->name('alunos.index');
Route::get('alunos/cadastar', [AlunoController::class, 'cadastrar'])->name('alunos.cadastrar');
Route::post('alunos/cadastar', [AlunoController::class, 'cadastrarStore'])->name('alunos.cadastrar');
Route::get('alunos/visualizar/{aluno}', [AlunoController::class, 'visualizar'])->name('alunos.visualizar');
Route::get('alunos/editar/{aluno}', [AlunoController::class, 'editar'])->name('alunos.editar');
Route::put('alunos/atualizar/{aluno}', [AlunoController::class, 'atualizar'])->name('alunos.atualizar');
Route::put('alunos/modificar-senha/{aluno}', [AlunoController::class, 'modificarSenha'])->name('alunos.modificar-senha');
Route::get('alunos/deletar/{aluno}', [AlunoController::class, 'confirmarDeletar'])->name('alunos.deletar');
Route::delete('alunos/deletar/{aluno}', [AlunoController::class, 'deletar'])->name('alunos.deletar');
Route::get('alunos/faltas/{aluno}', [AlunoController::class, 'visualizarFaltas'])->name('alunos.faltas-aluno');
Route::get('alunos/expotar-faltas-do-aluno/{aluno}', [AlunoController::class, 'exportarRelatorioFaltasAluno'])->name('alunos.expotar-faltas-aluno');

// Disciplinas
Route::get('disciplinas', [DisciplinaController::class, 'index'])->name('disciplinas.index');
Route::post('disciplinas', [DisciplinaController::class, 'disciplinaStore'])->name('disciplinas.store');
Route::get('disciplinas/editar/{disciplina}', [DisciplinaController::class, 'editar'])->name('disciplinas.editar');
Route::put('disciplinas/{disciplina}', [DisciplinaController::class, 'disciplinaUpdate'])->name('disciplinas.update');
Route::get('disciplinas/deletar/{disciplina}', [DisciplinaController::class, 'confirmarDeletar'])->name('disciplinas.deletar');
Route::delete('disciplinas/deletar/{disciplina}', [DisciplinaController::class, 'deletar'])->name('disciplinas.deletar');

// Professores
Route::get('professores', [ProfessorController::class, 'index'])->name('professores.index');
Route::get('professores/cadastar', [ProfessorController::class, 'cadastrar'])->name('professores.cadastrar');
Route::post('professores/cadastar', [ProfessorController::class, 'cadastrarStore'])->name('professores.cadastrar');
Route::get('professores/editar/{professor}', [ProfessorController::class, 'editar'])->name('professores.editar');
Route::put('professores/atualizar/{professor}', [ProfessorController::class, 'atualizar'])->name('professores.atualizar');
Route::put('professores/modificar-senha/{professor}', [ProfessorController::class, 'modificarSenha'])->name('professores.modificar-senha');
Route::get('professores/deletar/{professor}', [ProfessorController::class, 'confirmarDeletar'])->name('professores.deletar');
Route::delete('professores/deletar/{professor}', [ProfessorController::class, 'deletar'])->name('professores.deletar');

// Turmas
Route::get('turmas', [TurmaController::class, 'index'])->name('turmas.index');
Route::get('turmas/adicionar', [TurmaController::class, 'adicionar'])->name('turmas.adicionar');
Route::post('turmas/adicionar', [TurmaController::class, 'adicionarStore'])->name('turmas.adicionar');
Route::get('turmas/editar/{turma}',  [TurmaController::class, 'editar'])->name('turmas.editar');
Route::put('turmas/atualizar/{turma}',  [TurmaController::class, 'atualizar'])->name('turmas.atualizar');
Route::get('turmas/deletar/{turma}', [TurmaController::class, 'confirmarDeletar'])->name('turmas.deletar');
Route::delete('turmas/deletar/{turma}', [TurmaController::class, 'deletar'])->name('turmas.deletar');

// Aulas
Route::get('aulas', [AulaController::class, 'index'])->name('aulas.index');
Route::get('aulas/consultar-aulas', [AulaController::class, 'consultarAulas'])->name('aulas.consultar-aulas');
Route::get('aulas/registrar-aula', [AulaController::class, 'registrarAula'])->name('aulas.registrar-aula');
Route::post('aulas/registrar-aula', [AulaController::class, 'registrarAulaStore'])->name('aulas.registrar-aula');

// Faltas
Route::get('faltas', [FaltaController::class, 'index'])->name('faltas.index');
Route::get('faltas/registrar-chamada/turma/{turma}', [FaltaController::class, 'registrarChamada'])->name('faltas.registrar-chamada');
Route::post('faltas/registrar-faltas/turma/{turma}', [FaltaController::class, 'registrarFaltasStore'])->name('faltas.registrar-faltas');
Route::get('faltas/consultar-faltas', [FaltaController::class, 'consultarFaltas'])->name('faltas.consultar-faltas');
Route::get('faltas/visualizar-chamada/turma/{turma}/{data}', [FaltaController::class, 'visualizarChamada'])->name('faltas.visualizar-chamada');
Route::get('faltas/exportar-chamada/turma/{turma}/{data}', [FaltaController::class, 'exportarChamadaPDF'])->name('faltas.exportar-chamada');

// Notas
Route::get('notas/consultar-notas', [NotaController::class, 'index'])->name('notas.consultar-notas');
Route::get('notas/consultar-notas-da-turma', [NotaController::class, 'consultarNotasTurma'])->name('notas.consultar-notas-turma');
Route::get('notas/aplicar-notas', [NotaController::class, 'aplicarNotas'])->name('notas.aplicar-notas');
Route::get('notas/aplicar-notas-aos-alunos', [NotaController::class, 'aplicarNotasAlunos'])->name('notas.aplicar-notas-alunos');
Route::post('notas/salvar-nota-do-aluno', [NotaController::class, 'salvarNotaAluno'])->name('notas.salvar-nota-aluno');
Route::get('notas/minhas-notas', [NotaController::class, 'minhasNotas'])->name('notas.minhas-notas');
Route::get('notas/exportar-notas/{turma}/{disciplina}', [NotaController::class, 'exportarNotasExcel'])->name('notas.exportar-notas');

// Período Escolar
Route::get('periodo-escolar', [EscolaPeriodoController::class, 'index'])->name('periodo-escolar');
Route::post('periodo-escolar', [EscolaPeriodoController::class, 'periodoStore'])->name('periodo-escolar.store');
Route::get('periodo-escolar/editar/{escolar_periodo}', [EscolaPeriodoController::class, 'periodoEditar'])->name('periodo-escolar.editar');
Route::put('periodo-escolar/atualizar/{escolar_periodo}', [EscolaPeriodoController::class, 'periodoAtualizar'])->name('periodo-escolar.atualizar');
Route::get('periodo-escolar/deletar/{escolar_periodo}', [EscolaPeriodoController::class, 'confirmarDeletar'])->name('periodo-escolar.deletar');
Route::delete('periodo-escolar/deletar/{escolar_periodo}', [EscolaPeriodoController::class, 'deletar'])->name('periodo-escolar.deletar');

// Dados dos Sistema
Route::get('dados-do-sistema', [DadosDoSistemaController::class, 'index'])->name('dados-do-sistema');

// Cronograma de Aulas
Route::get('cronograma-de-aulas/selecionar-turma', [CronogramaAulasController::class, 'index'])->name('cronograma-de-aulas.selecionar-turma');
Route::get('cronograma-de-aulas/turma', [CronogramaAulasController::class, 'cronogramaAulasTurma'])->name('cronograma-de-aulas.turma');
Route::get('cronograma-de-aulas/turma/{turma}/editar', [CronogramaAulasController::class, 'editar'])->name('cronograma-de-aulas.editar');
Route::post('cronograma-de-aulas/turma/{turma}/criar-ou-atualizar', [CronogramaAulasController::class, 'criarOuAtualizar'])->name('cronograma-de-aulas.criar-ou-atualizar');

// Datas Provas
Route::get('datas-de-provas/selecionar-turma-e-disciplina', [DatasProvasController::class, 'index'])->name('datas-de-provas.selecionar-turma-disciplina');
Route::get('datas-de-provas/visualizar', [DatasProvasController::class, 'visualizarDatasProvas'])->name('datas-de-provas.visualizar');
Route::get('datas-de-provas/adicionar/{turma}/{disciplina}', [DatasProvasController::class, 'adicionar'])->name('datas-de-provas.adicionar');
Route::post('datas-de-provas/adicionar/{turma}/{disciplina}', [DatasProvasController::class, 'store'])->name('datas-de-provas.adicionar');
Route::delete('datas-de-provas/deletar/{datas_prova}', [DatasProvasController::class, 'delete'])->name('datas-de-provas.deletar');

// Completar Perfil
Route::get('completar-perfil', [CompletarPerfilController::class, 'completarPefil'])->name('completar-perfil');
Route::post('completar-perfil/salvar-dados', [CompletarPerfilController::class, 'salvarDados'])->name('completar-perfil.salvar-dados');
