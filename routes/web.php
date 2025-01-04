<?php

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
use App\Http\Controllers\CidadeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrdemController;
use Illuminate\Support\Facades\Route;
use App\Events\EventReminderBroadcast;



Route::middleware(['auth'])->group(function () {
    Route::get('/notifications', [NotificationController::class, 'getNotifications'])->middleware('auth');
    Route::get('/test-notification', function () {
        $user = \App\Models\User::find(1); // Substitua pelo ID de um usuário existente
        $eventData = [
            'title' => 'Licenciamento',
            'date' => '2025-01-04 13:52:00',
            'category' => 'bg-warning',
        ];
    
        if ($user) {
            $user->notify(new \App\Notifications\EventCreatedNotification($eventData));
            return 'Notificação enviada!';
        }
    
        return 'Usuário não encontrado.';
    });
    
    //USUARIOS
    /* Route::delete('/users', [UserController::class, 'deleteAll'])->name('users.delete'); */
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

    
    Route::put('/calendar/update/{id}', [CalendarController::class, 'update']);
    Route::put('/calendar/move/{id}', [CalendarController::class, 'update']);
    Route::delete('/calendar/delete/{id}', [CalendarController::class, 'destroy'])->name('calendar.destroy');
    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');
    Route::get('/calendar/events', [CalendarController::class, 'getEvents']);
    Route::post('/calendar', [CalendarController::class, 'store']);

    
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

    Route::get('/relatorio-ordens', [RelatoriosController::class, 'gerarRelatorioOrdens'])->name('relatorio-ordens');
    Route::get('/relatorio-clientes', [RelatoriosController::class, 'gerarRelatorioClientes'])->name('relatorio-clientes');
    Route::get('/relatorio-veiculos', [RelatoriosController::class, 'gerarRelatorioVeiculos'])->name('relatorio-veiculos');
    Route::get('/relatorio-procuracoes', [RelatoriosController::class, 'gerarRelatorioProc'])->name('relatorio-procuracoes');


    Route::get('/upload', function () {
        return view('upload'); // Retorna a view do formulário de upload
    })->name('upload.form'); // Nomeie a rota para o formulário de upload
    
    Route::get('/upload', function () {
        return view('upload'); // Sua página de upload
    })->name('upload.form'); // Nomeia a rota para o formulário de upload
    
    Route::post('/upload', [PdfController::class, 'uploadPdf'])->name('upload.pdf'); // Rota para o processamento do PDF
    Route::post('/show-text', [PdfController::class, 'showExtractedText']); // Rota para exibir o texto extraído
    
    Route::get('/cidades/{id}', [CidadeController::class, 'show'])->name('cidades.show');
    Route::put('/cidades/{id}', [CidadeController::class, 'update'])->name('cidades.update');
    Route::delete('/cidades/{id}', [CidadeController::class, 'destroy'])->name('cidades.destroy');
    Route::post('/cidades', [CidadeController::class, 'store'])->name('cidades.store');
    Route::get('/cidades', [CidadeController::class, 'index'])->name('cidades.index');

    Route::post('/pagamentos', [PaymentController::class, 'createPayment'])->name('pagamentos.store');
    Route::get('/pagamentos', [PaymentController::class, 'index'])->name('pagamentos.index');

    Route::get('/ordensdeservicos/buscarservicos', [OrdemController::class, 'buscarServicos'])->name('ordensdeservicos.buscarservicos');
    Route::get('/ordensdeservicos/buscar', [OrdemController::class, 'buscarClientes'])->name('ordensdeservicos.buscar');
    Route::get('/ordensdeservicos', [OrdemController::class, 'index'])->name('ordensdeservicos.index');
    
    Route::get('/ordem-servico/{id}/rel-ordem', [OrdemController::class, 'gerarPDFOrdemServico'])->name('rel-ordem');
    Route::delete('/ordensdeservicos/{id}', [OrdemController::class, 'destroy'])->name('ordensdeservicos.destroy');
    Route::get('/ordensdeservicos/{id}/marcar-pago', [OrdemController::class, 'marcarpago'])->name('ordensdeservicos.marcarpago');
    Route::put('/ordensdeservicos/{id}', [OrdemController::class, 'update'])->name('ordensdeservicos.update');
    Route::get('/ordensdeservicos/{id}/edit', [OrdemController::class, 'edit'])->name('ordensdeservicos.edit');
    Route::get('/ordensdeservicos', [OrdemController::class, 'index'])->name('ordensdeservicos.index');
    Route::get('/ordensdeservicos/create', [OrdemController::class, 'create'])->name('ordensdeservicos.create');
    Route::post('/ordensdeservicos', [OrdemController::class, 'store'])->name('ordensdeservicos.store');
    Route::get('/ordensdeservicos/{id}', [OrdemController::class, 'show'])->name('ordensdeservicos.show');

    Route::resource('ordensdeservicos', OrdemController::class);
    
});


Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [PasswordResetController::class, 'reset'])->name('password.update');


Route::post('/registerCompany', [TenantController::class, 'store'])->name('register.store');
Route::get('/registerCompany/create', [TenantController::class, 'create'])->name('register.create');
Route::get('/registerCompany', [TenantController::class, 'index'])->name('site.index');

Route::get('/', function () {
    return view('site.index');
});

require __DIR__.'/auth.php';