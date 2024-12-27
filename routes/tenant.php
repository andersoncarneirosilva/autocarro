<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

use App\Http\Controllers\PerfilController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DocumentosController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\DashController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DocVeiculoController;
use App\Http\Controllers\ProcuracaoController;
use App\Http\Controllers\ConfiguracoesController;
use App\Http\Controllers\OutorgadoController;
use App\Http\Controllers\TextoPoderesController;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\ServicosController;
use App\Http\Controllers\RelatoriosController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\OcrController;
/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
   
    require __DIR__.'/auth.php';

    

    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');

    //DASHBOARD
    Route::get('/dashboard', [DashController::class, 'index'])->name('dashboard.index');

    //PERFIL
    Route::put('/perfil/{id}', [PerfilController::class, 'update'])->name('perfil.update');
    Route::get('/perfil/{id}/edit', [PerfilController::class, 'edit'])->name('perfil.edit');
    Route::get('/perfil', [PerfilController::class, 'index'])->name('perfil.index');


    //DOCUMENTOS
    Route::post('documentos/gerarProc/{id}/{doc}', [DocumentosController::class, 'gerarProc'])->name('documentos.gerarProc');
    Route::get('/documentos/{id}', [DocumentosController::class, 'show'])->name('documentos.show');
    Route::delete('/documentos/{id}', [DocumentosController::class, 'destroy'])->name('documentos.destroy');
    Route::get('/documentos', [DocumentosController::class, 'index'])->name('documentos.index');
    Route::post('/documentos', [DocumentosController::class, 'store'])->name('documentos.store');

    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');

    
    Route::delete('/procuracoes/{id}', [ProcuracaoController::class, 'destroy'])->name('procuracoes.destroy');
    Route::get('/procuracoes/create', [ProcuracaoController::class, 'create'])->name('procuracoes.create');
    Route::get('/procuracoes', [ProcuracaoController::class, 'index'])->name('procuracoes.index');
    Route::post('/procuracoes', [ProcuracaoController::class, 'store'])->name('procuracoes.store');

    Route::get('/configuracoes/{id}', [ConfiguracoesController::class, 'show'])->name('configuracoes.show');
    Route::delete('/configuracoes/{id}', [ConfiguracoesController::class, 'destroy'])->name('configuracoes.destroy');
    Route::put('/configuracoes/{id}', [ConfiguracoesController::class, 'update'])->name('configuracoes.update');
    Route::get('/configuracoes/create', [ConfiguracoesController::class, 'create'])->name('configuracoes.create');
    Route::get('/configuracoes', [ConfiguracoesController::class, 'index'])->name('configuracoes.index');
    Route::post('/configuracoes', [ConfiguracoesController::class, 'store'])->name('configuracoes.store');
    Route::post('/configuracoes/gerarProc/{id}', [ConfiguracoesController::class, 'gerarProc'])->name('configuracoes.gerarProc');

    Route::get('/outorgados/{id}', [OutorgadoController::class, 'show'])->name('outorgados.show');
    Route::put('/outorgados/{id}', [OutorgadoController::class, 'update'])->name('outorgados.update');
    Route::delete('/outorgados/{id}', [OutorgadoController::class, 'destroy'])->name('outorgados.destroy');
    Route::post('/outorgados', [OutorgadoController::class, 'store'])->name('outorgados.store');

    Route::get('/poderes/{id}', [TextoPoderesController::class, 'show'])->name('poderes.show');
    Route::put('/poderes/{id}', [TextoPoderesController::class, 'update'])->name('poderes.update');
    Route::delete('/poderes/{id}', [TextoPoderesController::class, 'destroy'])->name('poderes.destroy');
    Route::post('/poderes', [TextoPoderesController::class, 'store'])->name('poderes.store');

    Route::put('/clientes/{id}', [ClientesController::class, 'update'])->name('clientes.update');
    Route::delete('/clientes/{id}', [ClientesController::class, 'destroy'])->name('clientes.destroy');
    Route::post('/clientes', [ClientesController::class, 'store'])->name('clientes.store');
    Route::get('/clientes/create', [ClientesController::class, 'create'])->name('clientes.create');
    Route::get('/clientes/{id}/edit', [ClientesController::class, 'edit'])->name('clientes.edit');
    Route::get('/clientes', [ClientesController::class, 'index'])->name('clientes.index');
    Route::get('/buscar-clientes', [ClientesController::class, 'buscarClientes']);
    Route::get('/clientes/{id}', [ClientesController::class, 'show'])->name('clientes.show');

    Route::delete('/servicos/{id}', [ServicosController::class, 'destroy'])->name('servicos.destroy');
    Route::post('/servicos', [ServicosController::class, 'store'])->name('servicos.store');
    Route::get('/servicos', [ServicosController::class, 'index'])->name('servicos.index');

    Route::POST('/rel-procs', [RelatoriosController::class, 'gerarPdfProcs'])->name('rel-procs');
    Route::POST('/rel-clientes', [RelatoriosController::class, 'gerarPdfClientes'])->name('rel-clientes');
    Route::POST('/rel-veiculos', [RelatoriosController::class, 'gerarPdfVeiculos'])->name('rel-veiculos');




    Route::post('/relatorios', [RelatoriosController::class, 'gerarRelatoriosSelect'])->name('relatorio.gerar');

    Route::get('/relatorios', [RelatoriosController::class, 'index'])->name('relatorios.index');
    Route::get('/relatorios/clientes/exportar-pdf', [RelatoriosController::class, 'exportarPdf'])->name('relatorios.clientes.pdf');

    Route::get('/relatorio-clientes', [RelatoriosController::class, 'gerarRelatorioClientes'])->name('relatorio-clientes');
    Route::get('/relatorio-veiculos', [RelatoriosController::class, 'gerarRelatorioVeiculos'])->name('relatorio-veiculos');
    Route::get('/relatorio-procuracoes', [RelatoriosController::class, 'gerarRelatorioProc'])->name('relatorio-procuracoes');

    
});

Route::get('/', function () {
    return view('site.index');
});