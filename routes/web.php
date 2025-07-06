<?php

use App\Http\Controllers\AssinaturaController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\CidadeController;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\ConfiguracoesController;
use App\Http\Controllers\ContatoController;
use App\Http\Controllers\DashController;
use App\Http\Controllers\DocumentosController;
use App\Http\Controllers\EstoqueController;
use App\Http\Controllers\ModeloProcuracoesController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrdemController;
use App\Http\Controllers\OutorgadoController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\ProcuracaoController;
use App\Http\Controllers\RelatoriosController;
use App\Http\Controllers\ServicosController;
use App\Http\Controllers\TextoInicioController;
use App\Http\Controllers\TextoPoderesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VeiculoController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\AnuncioController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\FornecedorController;

use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
use App\Http\Livewire\Chat;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Events\NewMessage;
use Illuminate\Support\Facades\Broadcast;

Route::middleware(['auth'])->group(function () {

    Broadcast::routes(['middleware' => ['auth:sanctum']]);

// routes/web.php
Route::post('/chat/mark-as-read', [ChatController::class, 'markAsRead']);

    Route::post('/chat', [ChatController::class, 'createOrGetChat'])->middleware('auth:sanctum');
    Route::post('/chat/get-chat', [ChatController::class, 'createOrGetChat']);
    

    Route::get('/chat/{user}/messages', [ChatController::class, 'getMessages']);
    Route::get('/chat/messages/{chatId}', [ChatController::class, 'getMessages']);

    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    
    Route::get('/chat/{recipientId}', [ChatController::class, 'getChat']);


    Route::post('/perfil/excluir', [PerfilController::class, 'deleteFiles']);
    Route::post('/perfil/excluir-pasta', [PerfilController::class, 'deleteFolders']);


    Route::get('/assinatura-expirada', function () {
        return view('assinatura.expirada');
    })->name('assinatura.expirada');

    Route::get('/check-payment-status', function (Request $request) {
        $user = Auth::user();

        if (! $user) {
            Log::error('Usuário não autenticado ao verificar pagamento.');

            return response()->json(['status' => 'unauthorized'], 401);
        }

        $pedido = \App\Models\Assinatura::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->first();

        if (! $pedido) {
            Log::error("Nenhum pedido encontrado para o usuário ID {$user->id}");

            return response()->json(['status' => 'no_order_found']);
        }

        return response()->json(['status' => $pedido->status]);
    });

    Route::post('/checkout', [PaymentController::class, 'selecionarPlano'])->name('checkout');
    Route::get('/pagamento', [PaymentController::class, 'paginaPagamento'])->name('pagamento.index');

    Route::get('/assinatura', [AssinaturaController::class, 'index'])->name('assinatura.index');

    Route::get('/produtos', [ItemController::class, 'index'])->name('produtos.index');
    Route::post('/produtos', [ItemController::class, 'store'])->name('produtos.store');

    Route::get('/planos', [PaymentController::class, 'index'])->name('planos.index');
    // Route::get('/pedidos/create', [PedidoController::class, 'create'])->name('pedidos.create');
    // Route::post('/pedidos', [PedidoController::class, 'store'])->name('pedidos.store');

    Route::get('/pagamento-confirmado', function () {
        return view('pagamentos.sucesso'); // Retorna a view correta
    })->name('pagamento.confirmado');

    // Rota para a página de falha (quando o pagamento falhar)
    Route::get('/pagamento-falha', [PaymentController::class, 'paymentFailure'])->name('pagamentos.falha');

    // Rota para a página pendente (quando o pagamento ficar pendente)
    Route::get('/pagamento-pendente', [PaymentController::class, 'paymentPending'])->name('pagamentos.pendente');

    Route::post('/notifications/mark-as-read', [NotificationController::class, 'markAsRead'])->middleware('auth');

    Route::get('/notifications', [NotificationController::class, 'getNotifications'])->middleware('auth');
    // USUARIOS
    /* Route::delete('/users', [UserController::class, 'deleteAll'])->name('users.delete'); */
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');


    Route::post('/upload/temp', [AnuncioController::class, 'temp'])->name('upload.temp');


    Route::put('/anuncios/desarquivar/{id}', [AnuncioController::class, 'desarquivar'])->name('anuncios.desarquivar');
    Route::put('/anuncios/arquivar/{id}', [AnuncioController::class, 'arquivar'])->name('anuncios.arquivar');

    Route::delete('/anuncios/{id}', [AnuncioController::class, 'destroy'])->name('anuncios.destroy');
    Route::put('/anuncios/{id}', [AnuncioController::class, 'update'])->name('anuncios.update');
    Route::get('/anuncios/{id}/edit', [AnuncioController::class, 'edit'])->name('anuncios.edit');
    Route::get('/anuncios', [AnuncioController::class, 'index'])->name('anuncios.index');
    Route::get('/anuncios/create', [AnuncioController::class, 'create'])->name('anuncios.create');
    Route::post('/anuncios', [AnuncioController::class, 'store'])->name('anuncios.store');
    Route::get('/anuncios/{id}', [AnuncioController::class, 'show'])->name('anuncios.show');


    // DASHBOARD
    Route::get('/dashboard', [DashController::class, 'index'])->name('dashboard.index');

    // PERFIL
    Route::put('/perfil/{id}', [PerfilController::class, 'update'])->name('perfil.update');
    Route::get('/perfil/{id}/edit', [PerfilController::class, 'edit'])->name('perfil.edit');
    Route::get('/perfil', [PerfilController::class, 'index'])->name('perfil.index');

    // DOCUMENTOS
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

    Route::post('/outorgados/store-or-update', [ConfiguracoesController::class, 'storeOrUpdate'])->name('outorgados.storeOrUpdate');
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
    Route::get('/outorgados', [OutorgadoController::class, 'index'])->name('outorgados.index');

    Route::get('/poderes/{id}', [TextoPoderesController::class, 'show'])->name('poderes.show');
    Route::delete('/poderes/{id}', [TextoPoderesController::class, 'destroy'])->name('poderes.destroy');
    Route::put('/poderes/{id}', [TextoPoderesController::class, 'update'])->name('poderes.update');
    Route::post('/poderes', [TextoPoderesController::class, 'store'])->name('poderes.store');

    Route::get('/textoinicial/{id}', [TextoInicioController::class, 'show'])->name('textoinicial.show');
    Route::delete('/textoinicial/{id}', [TextoInicioController::class, 'destroy'])->name('textoinicial.destroy');
    Route::put('/textoinicial/{id}', [TextoInicioController::class, 'update'])->name('textoinicial.update');
    Route::post('/textoinicial', [TextoInicioController::class, 'store'])->name('textoinicial.store');

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

    Route::get('/cidades/{id}', [CidadeController::class, 'show'])->name('cidades.show');
    Route::put('/cidades/{id}', [CidadeController::class, 'update'])->name('cidades.update');
    Route::delete('/cidades/{id}', [CidadeController::class, 'destroy'])->name('cidades.destroy');
    Route::post('/cidades', [CidadeController::class, 'store'])->name('cidades.store');
    Route::get('/cidades', [CidadeController::class, 'index'])->name('cidades.index');

    Route::get('/ordensdeservicos/buscarservicos', [OrdemController::class, 'buscarServicos'])->name('ordensdeservicos.buscarservicos');
    Route::get('/ordensdeservicos/buscar', [OrdemController::class, 'buscarClientes'])->name('ordensdeservicos.buscar');
    Route::get('/ordensdeservicos', [OrdemController::class, 'index'])->name('ordensdeservicos.index');


    Route::get('/ajuda', function () {
        return view('ajuda.index'); // Retorna a view ajuda.blade.php
    })->name('ajuda.index');

    // Route::get('/ordem-servico/{id}/rel-ordem', [OrdemController::class, 'gerarPDFOrdemServico'])->name('rel-ordem');
    // Route::delete('/ordensdeservicos/{id}', [OrdemController::class, 'destroy'])->name('ordensdeservicos.destroy');
    // Route::get('/ordensdeservicos/{id}/marcar-pago', [OrdemController::class, 'marcarpago'])->name('ordensdeservicos.marcarpago');
    // Route::put('/ordensdeservicos/{id}', [OrdemController::class, 'update'])->name('ordensdeservicos.update');
    // Route::get('/ordensdeservicos/{id}/edit', [OrdemController::class, 'edit'])->name('ordensdeservicos.edit');
    // Route::get('/ordensdeservicos', [OrdemController::class, 'index'])->name('ordensdeservicos.index');
    // Route::get('/ordensdeservicos/create', [OrdemController::class, 'create'])->name('ordensdeservicos.create');
    // Route::post('/ordensdeservicos', [OrdemController::class, 'store'])->name('ordensdeservicos.store');
    // Route::get('/ordensdeservicos/{id}', [OrdemController::class, 'show'])->name('ordensdeservicos.show');

    // Route::resource('ordensdeservicos', OrdemController::class);

    // DOC RAPIDO

    // Route::get('/estoque/create-atpve', [EstoqueController::class, 'createAtpve'])->name('estoque.create-atpve');

    // Route::get('/estoque/{id}', [EstoqueController::class, 'show'])->name('estoque.show');
    // Route::put('/estoque/{id}', [EstoqueController::class, 'update'])->name('estoque.update');
    // Route::delete('/estoque/{id}', [EstoqueController::class, 'destroy'])->name('estoque.destroy');
    // Route::get('/estoque/create', [EstoqueController::class, 'create'])->name('estoque.create');
    // Route::post('/estoque/store-atpve/{id}', [EstoqueController::class, 'storeAtpve'])->name('estoque.store_atpve');

    // Route::post('/estoque', [EstoqueController::class, 'store'])->name('estoque.store');
    // Route::get('/estoque', [EstoqueController::class, 'index'])->name('estoque.index');
Route::get('/consulta-cnpj/{cnpj}', [FornecedorController::class, 'consultarCnpj']);

    Route::get('/fornecedores/create', [FornecedorController::class, 'create'])->name('fornecedores.create');
Route::post('/fornecedores', [FornecedorController::class, 'store'])->name('fornecedores.store');
Route::get('/fornecedores', [FornecedorController::class, 'index'])->name('fornecedores.index');

    Route::delete('/veiculos/enviar_email/{id}', [VeiculoController::class, 'enviarEmail'])->name('veiculos.enviar_email');

    Route::delete('/veiculos/excluir_atpve_assinado/{id}', [VeiculoController::class, 'destroyAtpveAssinado'])->name('veiculos.excluir_atpve_assinado');
    Route::delete('/veiculos/excluir_proc_assinado/{id}', [VeiculoController::class, 'destroyProcAssinado'])->name('veiculos.excluir_proc_assinado');
    Route::delete('/veiculos/excluir_atpve/{id}', [VeiculoController::class, 'destroyAtpve'])->name('veiculos.excluir_atpve');
    Route::delete('/veiculos/excluir_proc/{id}', [VeiculoController::class, 'destroyProc'])->name('veiculos.excluir_proc');
    Route::delete('/veiculos/excluir_doc/{id}', [VeiculoController::class, 'destroyDoc'])->name('veiculos.excluir_doc');

    Route::post('/veiculos/store-proc/{id}', [VeiculoController::class, 'storeProc'])->name('veiculos.store-proc');
    Route::post('/veiculos/store-atpve/{id}', [VeiculoController::class, 'storeAtpve'])->name('veiculos.store-atpve');
    // Route::get('/veiculos/create-atpve', [VeiculoController::class, 'createAtpve'])->name('veiculos.create-atpve');

    Route::put('/veiculos/desarquivar/{id}', [VeiculoController::class, 'desarquivar'])->name('veiculos.desarquivar');
    Route::put('/veiculos/arquivar/{id}', [VeiculoController::class, 'arquivar'])->name('veiculos.arquivar');
    Route::delete('/veiculos/{id}', [VeiculoController::class, 'destroy'])->name('veiculos.destroy');

    Route::put('/veiculos/update/{id}', [VeiculoController::class, 'update'])->name('veiculos.update');
    Route::get('/veiculos/edit/{id}', [VeiculoController::class, 'edit'])->name('veiculos.edit');
    Route::get('/veiculos', [VeiculoController::class, 'index'])->name('veiculos.index');
    Route::get('/veiculos/arquivados', [VeiculoController::class, 'indexArquivados'])->name('veiculos.arquivados');
    Route::get('/veiculos/create-proc-manual', [VeiculoController::class, 'createProcManual'])->name('veiculos.create-proc-manual');

    Route::get('/veiculos/create', [VeiculoController::class, 'create'])->name('veiculos.create');
    Route::post('/veiculos/store-proc-manual', [VeiculoController::class, 'storeProcManual'])->name('veiculos.store-proc-manual');
    Route::post('/veiculos', [VeiculoController::class, 'store'])->name('veiculos.store');
    Route::get('/veiculos/show/{id}', [VeiculoController::class, 'show'])->name('veiculos.show');

    Route::get('/modeloprocs/{id}', [ModeloProcuracoesController::class, 'show'])->name('modeloprocs.show');
    Route::put('/modeloprocs/{id}', [ModeloProcuracoesController::class, 'update'])->name('modeloprocs.update');
    Route::post('/modeloprocs', [ModeloProcuracoesController::class, 'store'])->name('modeloprocs.store');

    Route::get('/modeloprocuracoes/create', [ModeloProcuracoesController::class, 'create'])->name('modeloprocuracoes.create');
    Route::post('/modeloprocuracoes/store', [ModeloProcuracoesController::class, 'store'])->name('modeloprocuracoes.store');
    Route::get('/modeloprocuracoes/select/{id}', [ModeloProcuracoesController::class, 'select'])->name('modeloprocuracoes.select');
    Route::post('/modeloprocuracoes/confirm/{id}', [ModeloProcuracoesController::class, 'confirm'])->name('modeloprocuracoes.confirm');

});

Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [PasswordResetController::class, 'reset'])->name('password.update');

Route::post('/enviar-contato', [ContatoController::class, 'enviarEmail'])->name('contato.enviar');

Route::get('/', [SiteController::class, 'index'])->name('site.index');

// Route::get('/', function () {
//     return view('site.index');
// });

require __DIR__.'/auth.php';
