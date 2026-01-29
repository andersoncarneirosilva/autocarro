<?php

use App\Http\Controllers\AssinaturaController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\CidadeController;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\ConfiguracoesController;
use App\Http\Controllers\ContatoController;
use App\Http\Controllers\DashController;
// use App\Http\Controllers\DocumentosController;
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
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\PixController;
use App\Http\Controllers\LojaController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\RevendaController;
use App\Http\Controllers\RevendaPublicaController;
use App\Http\Controllers\ModeloProcuracaoController;
use App\Http\Controllers\PartiularController;
use App\Http\Controllers\MultaController;
use App\Http\Controllers\SolicitacaoController;

use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
use App\Http\Livewire\Chat;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Events\NewMessage;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Mail;

Route::get('/teste-email', function () {
    try {
        Mail::raw('Teste de configuração SMTP Zoho Alcecar', function ($message) {
            $message->from('suporte@alcecar.com.br', 'Alcecar') // TEM QUE SER O MESMO DO .ENV
                    ->to('seu-email-pessoal@gmail.com') // Coloque seu Gmail aqui
                    ->subject('Teste de Conexão');
        });
        return "E-mail enviado!";
    } catch (\Exception $e) {
        return "Erro ao enviar: " . $e->getMessage();
    }
});

Route::middleware(['auth', 'trial'])->group(function () {

    Broadcast::routes(['middleware' => ['auth:sanctum']]);

    Route::get('/particulares/create', [ParticularController::class, 'create'])->name('particulares.create');
    Route::post('/particulares/store', [ParticularController::class, 'store'])->name('particulares.store');
    Route::get('/particulares/dashboard', [ParticularController::class, 'index'])->name('particulares.index');
    Route::delete('/particulares/destroy/{id}', [ParticularController::class, 'destroy'])->name('particulares.destroy');

    // Listagem de todas as revendas

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

    Route::post('/create-pix-payment', [PaymentController::class, 'createPixPayment']);
    
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

    // DASHBOARD
    Route::get('/dashboard', [DashController::class, 'index'])->name('dashboard.index');

    // PERFIL
    Route::put('/perfil/revenda/update', [PerfilController::class, 'updateRevenda'])->name('perfil.revenda.update');
    Route::put('/perfil/{id}', [PerfilController::class, 'update'])->name('perfil.update');
    Route::get('/perfil/{id}/edit', [PerfilController::class, 'edit'])->name('perfil.edit');
    Route::get('/perfil', [PerfilController::class, 'index'])->name('perfil.index');


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


    Route::get('/modeloprocs/{id}', [ModeloProcuracoesController::class, 'show'])->name('modeloprocs.show');
    Route::put('/modeloprocs/{id}', [ModeloProcuracoesController::class, 'update'])->name('modeloprocs.update');
    Route::post('/modeloprocs', [ModeloProcuracoesController::class, 'store'])->name('modeloprocs.store');

    Route::get('/modeloprocuracoes/create', [ModeloProcuracoesController::class, 'create'])->name('modeloprocuracoes.create');
    Route::post('/modeloprocuracoes/store', [ModeloProcuracoesController::class, 'store'])->name('modeloprocuracoes.store');
    Route::get('/modeloprocuracoes/select/{id}', [ModeloProcuracoesController::class, 'select'])->name('modeloprocuracoes.select');
    Route::post('/modeloprocuracoes/confirm/{id}', [ModeloProcuracoesController::class, 'confirm'])->name('modeloprocuracoes.confirm');

    // ROTA PARA A PÁGINA DE CONFIGURAÇÕES (Index e Salvar Modelo)
Route::post('/modelo-procuracoes/store', [ModeloProcuracaoController::class, 'store'])->name('modeloprocuracao.store');
Route::get('/modeloprocs/{id}', [ModeloProcuracaoController::class, 'show'])->name('modeloprocuracoes.show');

Route::prefix('configuracoes')->group(function () {
    // Página Principal de Configurações
    Route::get('/', [ConfiguracoesController::class, 'index'])->name('configuracoes.index');
    
    // --- MÓDULO: PROCURAÇÃO ---
    Route::post('/procuracao/salvar', [ConfiguracoesController::class, 'saveProcuracao'])->name('configuracoes.procuracao.save');
    Route::get('/procuracao/detalhes/{id}', [ConfiguracoesController::class, 'showProcuracao'])->name('configuracoes.procuracao.show');
    Route::delete('/procuracao/excluir/{id}', [ConfiguracoesController::class, 'deleteProcuracao'])->name('configuracoes.procuracao.delete');
    Route::post('/procuracao/gerar/{id}', [ConfiguracoesController::class, 'gerarProc'])->name('configuracoes.gerarProc');

    // --- MÓDULO: SOLICITAÇÃO ATPVe ---
    // Designer / Index da Solicitação
    Route::get('/solicitacao', [ConfiguracoesController::class, 'indexAtpve'])->name('configuracoes.solicitacao.indexAtpve');
    // Salvar o conteúdo do Designer
    Route::post('/solicitacao/salvar', [ConfiguracoesController::class, 'saveAtpve'])->name('configuracoes.solicitacao.save');
});


///////////////////////////////
    //                          //
    //          VEICULOS        //
    //                          //
    //////////////////////////////
    Route::post('/veiculos/cadastro-rapido', [VeiculoController::class, 'cadastroRapido'])->name('veiculos.cadastro-rapido');
    // Rota para exibir o formulário de cadastro manual
    Route::get('/veiculos/cadastro-manual', [VeiculoController::class, 'cadastroManual'])->name('veiculos.cadastro-manual');

    // Rota para processar o envio do formulário (POST)
    Route::post('/veiculos/cadastro-manual/store', [VeiculoController::class, 'storeManual'])->name('veiculos.store-manual');

    Route::get('/veiculos/vendidos', [VeiculoController::class, 'indexVendidos'])->name('veiculos.vendidos');
    Route::get('/veiculos/arquivados', [VeiculoController::class, 'indexArquivados'])->name('veiculos.arquivados');
    Route::get('/veiculos/create', [VeiculoController::class, 'create'])->name('veiculos.create');
    Route::post('/veiculos', [VeiculoController::class, 'store'])->name('veiculos.store');

    // --- 2. ROTAS COM AÇÕES ESPECÍFICAS ---
    Route::put('/veiculos/desarquivar/{id}', [VeiculoController::class, 'desarquivar'])->name('veiculos.desarquivar');
    Route::put('/veiculos/arquivar/{id}', [VeiculoController::class, 'arquivar'])->name('veiculos.arquivar');

    // 2. AGORA coloque a sua rota (específica por ter o sufixo /update-info-basica)
    // Adicione esta linha junto com as outras rotas de anúncios
    Route::put('/veiculos/update-info/{id}', [VeiculoController::class, 'updateInfo'])->name('veiculos.update-info');
    Route::post('/veiculos/{id}/foto-principal/{index}', [VeiculoController::class, 'setMainFoto'])->name('veiculos.setMainFoto');
    Route::patch('/veiculos/{id}/remover-publicacao', [VeiculoController::class, 'removerPublicacao'])->name('veiculos.remover');
    Route::patch('/veiculos/{id}/publicar', [VeiculoController::class, 'publicar'])->name('veiculos.publicar');
    Route::put('/veiculos/{id}/upload-fotos', [VeiculoController::class, 'uploadFotos'])->name('veiculos.uploadFotos');
    Route::delete('/veiculos/{id}/foto/{index}', [VeiculoController::class, 'deleteFoto'])->name('veiculos.deleteFoto');
    Route::put('/veiculos/{id}/update-descricao', [VeiculoController::class, 'updateDescricao'])->name('veiculos.updateDescricao');
    Route::put('/veiculos/{id}/update-adicionais', [VeiculoController::class, 'updateAdicionais'])->name('veiculos.updateAdicionais');
    Route::put('/veiculos/{id}/update-modificacoes', [VeiculoController::class, 'updateModificacoes'])->name('veiculos.updateModificacoes');
    Route::put('/veiculos/{id}/update-opcionais', [VeiculoController::class, 'updateOpcionais'])->name('veiculos.updateOpcionais');
    Route::put('/veiculos/{id}/update-precos', [VeiculoController::class, 'updatePrecos'])->name('veiculos.updatePrecos');
    Route::put('/veiculos/{id}/update-info-basica', [VeiculoController::class, 'updateInfoBasica'])->name('veiculos.updateInfoBasica');


    Route::get('/veiculos', [VeiculoController::class, 'index'])->name('veiculos.index');
    Route::get('/veiculos/{id}', [VeiculoController::class, 'show'])->name('veiculos.show');
    Route::delete('/veiculos/{id}', [VeiculoController::class, 'destroy'])->name('veiculos.destroy');
    
    Route::prefix('documentos')->group(function () {
        Route::post('/gerar-procuracao/{veiculo_id}', [DocumentoController::class, 'gerarProcuracao'])
            ->name('documentos.gerar.procuracao');

        Route::get('/gerar-atpve/{veiculo_id}', [DocumentoController::class, 'gerarAtpve'])
            ->name('documentos.gerar.atpve');
            
        Route::post('/upload/{veiculo_id}', [DocumentoController::class, 'store'])
            ->name('documentos.upload');
    });


    Route::patch('/multas/{id}/pagar', [MultaController::class, 'marcarComoPago'])->name('multas.pagar');
    // Rota Resource (Index, Create, Store, Show, Edit, Update, Destroy)
    Route::resource('multas', MultaController::class);

    // Rota específica para atualização de status (Pendente/Pago/Recurso)
    Route::patch('multas/{id}/status', [MultaController::class, 'updateStatus'])->name('multas.updateStatus');

    Route::post('/veiculos/{id}/vender', [VeiculoController::class, 'vender'])->name('veiculos.vender');
    // Rota para listar multas de um veículo específico (útil para a aba do veículo)
    Route::get('veiculos/{veiculo}/multas', [MultaController::class, 'porVeiculo'])->name('multas.veiculo');

});

Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [PasswordResetController::class, 'reset'])->name('password.update');

Route::post('/enviar-contato', [ContatoController::class, 'enviarEmail'])->name('contato.enviar');

Route::get('/', [LojaController::class, 'index'])->name('site.index');

require __DIR__.'/auth.php';
